<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donate\Donate;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    const WEEK_DAYS = [
        1 => 'Пн',
        2 => 'Вт',
        3 => 'Ср',
        4 => 'Чт',
        5 => 'Пт',
        6 => 'Сб',
        7 => 'Вс'
    ];

    public function getUsersCardDetails()
    {
        $result = [];

        $data = User::where('created_at', '>', Carbon::now()->subWeek())
            ->select('created_at', DB::raw('count(*) as total'))
            ->groupBy('id')
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->created_at)->format('N');
            });

        foreach ($data as $key => $value) {
            $result[self::WEEK_DAYS[$key]] = count($value);
        }
        return $this->response($result);
    }

    public function getTopInvestor()
    {
        $user = User::withSum('donations', 'amount')
            ->get()
            ->sortBy('donations_sum_count')
            ->first();

        $user->profile;

        return $this->response($user);
    }
}
