<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RipRepositoryInterface;
use Carbon\Carbon;
use App\Rip;
use Illuminate\Database\Eloquent\Model;

class RipRepository implements RipRepositoryInterface
{

    public function store(int $id): void
    {
        $rip = new Rip;
        $rip->user_id = $id;
        $rip->rip_date = Carbon::now();
        $rip->save();
    }

    public function delete(int $id): Model
    {
        $rip = Rip::where('user_id', $id)->firstOrFail();

        $rip->delete();

        return $rip;
    }
}