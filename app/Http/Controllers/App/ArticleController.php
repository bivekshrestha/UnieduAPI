<?php

namespace App\Http\Controllers\App;

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
        $items = $this->itemRepository->listItems();

        return new ArticleCollection($items);
    }

}
