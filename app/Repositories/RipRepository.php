<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RipRepositoryInterface;
use Carbon\Carbon;
use App\Rip;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class RipRepository implements RipRepositoryInterface
{

    public function store(int $userId): void
    {
        $rip = new Rip;
        $rip->user_id = $userId;
        $rip->rip_date = Carbon::now();
        $rip->save();
    }

    public function delete(int $userId): void
    {
        $rip = Rip::where('user_id', $userId)->firstOrFail();

        if ($rip instanceof Model) {
            try {
                $rip->delete();
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }
    }

    public function getAll(): array
    {
        return Rip::all()->toArray();
    }
}