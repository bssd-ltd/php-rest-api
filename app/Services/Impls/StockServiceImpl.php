<?php
/**
 * _short_description_
 *
 * _long_description_
 *
 * PHP version 7.4
 *
 * @version 1.0
 * @since 1.0 _short_description_
 */

namespace App\Services\Impls;


use App\Models\Stock;
use App\Repositories\StockRepository;
use App\Services\Contracts\StockService;

class StockServiceImpl implements StockService
{

    private StockRepository $stockRepo;

    /**
     * StockServiceImpl constructor.
     *
     * @param  StockRepository  $stockRepo
     */

    public function __construct(StockRepository $stockRepo)
    {
        $this->stockRepo = $stockRepo;
    }

    public function all()
    {
        return $this->stockRepo->all();
    }


    public function create(Stock $stock)
    {
        return $this->stockRepo->create($stock->toArray());
    }
}
