<?php

namespace App\Services\Contracts;


use App\Models\Stock;

interface StockService
{
    public function all();

    public function create(Stock $stock);
}
