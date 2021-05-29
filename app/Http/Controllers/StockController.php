<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Services\Contracts\StockService;
use Illuminate\Http\Request;

class StockController extends BaseController
{
    private StockService $stockSv;

    /**
     * StockController constructor.
     *
     * @param  StockService  $stockSv
     */
    public function __construct(StockService $stockSv)
    {
        $this->stockSv = $stockSv;
    }

    public function fetchAll()
    {
        return $this->stockSv->all();
    }

    public function create(Request $request)
    {
        return $this->stockSv->create($this->jsonToObject($request, Stock::class));
    }
}
