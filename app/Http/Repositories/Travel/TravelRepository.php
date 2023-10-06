<?php

namespace App\Http\Repositories\Travel;

use App\Http\Repositories\BaseRepository;
use App\Models\Travel;
use Illuminate\Database\Eloquent\Model;

class TravelRepository extends BaseRepository
{
    public function __construct(Travel $model)
    {
        parent::__construct($model);
    }

    public function store($data): Travel|Model
    {
        $travel = parent::store($data);
        $travel->save();
        $travel->refresh();

        return $travel;
    }

    public function update(Travel|Model $travel, $data): Travel|Model
    {
        $travelUpdate = parent::update($travel, $data);
        $travelUpdate->refresh();

        return $travelUpdate;
    }
}
