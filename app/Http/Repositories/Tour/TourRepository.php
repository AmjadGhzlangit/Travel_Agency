<?php

namespace App\Http\Repositories\Tour;

use App\Http\Repositories\BaseRepository;
use App\Models\Tour;
use Illuminate\Database\Eloquent\Model;

class TourRepository extends BaseRepository
{
    public function __construct(Tour $model)
    {
        parent::__construct($model);
    }

    public function store($data): Tour|Model
    {
        $tour = parent::store($data);
        $tour->save();
        $tour->refresh();

        return $tour;
    }

    public function update(Tour|Model $tour, $data): Tour|Model
    {
        $tourUpdated = parent::update($tour, $data);
        $tourUpdated->refresh();

        return $tourUpdated;
    }

    public function delete(Tour|Model $tour): bool
    {
        return $tour->delete();
    }
}
