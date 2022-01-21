<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\PostContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Collections\PostCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PostController extends BaseController
{

    protected $itemRepository;

    /**
     * PostController constructor.
     * @param $itemRepository
     */
    public function __construct(PostContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @return PostCollection
     */
    public function index()
    {
        $items = $this->itemRepository->listItemsWith(['image']);

        return new PostCollection($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'image' => 'required',
        ]);

        $params = $request->except('_token');

        $item = $this->itemRepository->createItem($params);

        return $this->responseCreatedJson();

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $params = $request->except('_token');

        $item = $this->itemRepository->updateItem($params);

        return $this->responseUpdatedJson();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $item = $this->itemRepository->deleteItem($id);

        return $this->responseUpdatedJson();
    }

}
