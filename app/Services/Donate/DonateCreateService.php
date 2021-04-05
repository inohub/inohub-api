<?php

namespace App\Services\Donate;

use App\Models\Donate\Donate;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * Class DonateCreateService
 * @property Donate  $donate
 * @property Request $request
 * @package App\Services\Donate
 */
class DonateCreateService
{
    private Donate $donate;
    private Request $request;

    /**
     * DonateCreateService constructor.
     *
     * @param Donate  $donate
     * @param Request $request
     */
    public function __construct(Donate $donate, Request $request)
    {
        $this->donate = $donate;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $data = $this->request->post();

        $this->donate->startup_id = Arr::get($data, 'startup_id');
        $this->donate->amount = Arr::get($data, 'amount');

        return $this->donate->save(); //TODO: нужно реализовать снятие денег с карты
    }
}
