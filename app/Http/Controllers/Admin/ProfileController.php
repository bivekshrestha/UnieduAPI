<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Admin;
use App\Models\Image;
use App\Models\User;
use App\Traits\ImageUploadAble;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

class ProfileController extends BaseController
{
    use ImageUploadAble;

    /**
     * @param $id
     * @return JsonResponse
     */
    public function index($id)
    {
        $user = User::with(['admin', 'image'])->where('id', $id)->first();

        return $this->responseJson(true, 200, $user);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->update($request->only('first_name', 'last_name'));

        $data = $request->admin;

        $admin = Admin::findOrFail($data['id']);
        $admin->update($data);

        return $this->responseUpdatedJson();

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function image(Request $request)
    {
        $user = User::with('image')->findOrFail($request->id);

        if ($request->has('image') && ($request['image'] instanceof UploadedFile)) {

            if ($user->image != null) {
                $this->deleteImage($user->image->path);
                $user->image()->delete();
            }

            $imagePath = $this->uploadImage($request['image'], 'images/avatars/', 200, 200);
            $image = new Image(['path' => $imagePath]);
            $user->image()->save($image);
        }

        return $this->responseUpdatedJson();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function changePassword(Request $request)
    {
        $user = User::findOrFail($request->id);

        if (Hash::check($request->old, $user->password)) {
            $user->update([
                'password' => bcrypt($request->new)
            ]);
        } else {
            return response()->json([
                'success' => false,
                'errors' => 'The Old Password does not match'
            ], 422);
        }

        return $this->responseUpdatedJson();
    }
}
