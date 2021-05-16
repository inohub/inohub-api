<?php

namespace App\Services\Donate;

use App\Components\Request\DataTransfer;
use App\Models\Donate\Donate;

/**
 * Class DonateCreateService
 * @property Donate       $donate
 * @property DataTransfer $request
 * @package App\Services\Donate
 */
class DonateCreateService
{
    private Donate $donate;
    private DataTransfer $request;

    /**
     * DonateCreateService constructor.
     *
     * @param Donate       $donate
     * @param DataTransfer $request
     */
    public function __construct(Donate $donate, DataTransfer $request)
    {
        $this->donate = $donate;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $this->donate->startup_id = $this->request->post('startup_id');
        $this->donate->amount = $this->request->post('amount');

        return $this->donate->save(); //TODO: нужно реализовать снятие денег с карты
    }
}
