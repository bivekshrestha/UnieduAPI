<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\ProgramContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Collections\ProgramCollection;
use App\Imports\ProgramImport;
use App\Models\Partners\Intake;
use App\Models\Partners\Program;
use App\Models\Partners\Subject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class ProgramController extends BaseController
{

    protected $itemRepository;

    /**
     * ProgramController constructor.
     * @param $itemRepository
     */
    public function __construct(ProgramContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @return ProgramCollection
     */
    public function index()
    {
        $items = $this->itemRepository->listItemsWith(['subject', 'institution', 'intakes']);

        return new ProgramCollection($items);
    }

    public function get($id)
    {
        $items = Program::withFormatIntakes($id);

        return new ProgramCollection($items);
    }

    /**
     * @return ProgramCollection
     */
    public function getSelect()
    {
        $items = $this->itemRepository->listItemsForSelect();

        return new ProgramCollection($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $params = $request->except('_token');

        $item = $this->itemRepository->createItem($params);

        return $this->responseCreatedJson();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function file(Request $request)
    {
        $file = $request->file('programs');
        $institution_id = (int)$request->input('institution_id');

        $collection = Excel::toCollection(new ProgramImport(), $file);
        $temp = $collection[0];
        $programs = $temp->filter(function ($item) use ($institution_id) {
            if ($item['name'] != null) {
                $item['institution_id'] = $institution_id;

                $subject = Subject::firstOrCreate(
                    ['name' => $item['subject']]
                );
                $item['subject_id'] = $subject->id;
                unset($item['subject']);

                $item['duration'] = Str::of($item['duration'])->trim()->lower();

                $data = explode(',', $item['intakes']);
                $intakes = [];
                foreach ($data as $value) {
                    $intake = Intake::firstOrCreate(['label' => $value]);
                    array_push($intakes, $intake->id);
                }
                $item['intakes'] = $intakes;

                return $item;
            }
        });

        foreach ($programs as $program) {
            $program = $program->toArray();
            $item = $this->itemRepository->createItem($program);
        }

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
