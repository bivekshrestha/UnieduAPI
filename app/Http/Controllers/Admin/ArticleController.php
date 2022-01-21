<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\ArticleContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Collections\ArticleCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ArticleController extends BaseController
{

    protected $itemRepository;

    /**
     * ArticleController constructor.
     * @param $itemRepository
     */
    public function __construct(ArticleContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @return ArticleCollection
     */
    public function index()
    {
        $items = $this->itemRepository->listItemsWith(['category']);

        return new ArticleCollection($items);
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
        $params = $request->except('_token', 'category');

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
