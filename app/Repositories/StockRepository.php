<?php

namespace App\Repositories;

use App\Models\Stock;
use Orkhanahmadov\EloquentRepository\EloquentRepository;

class StockRepository extends EloquentRepository
{
    protected $entity = Stock::class;
}
