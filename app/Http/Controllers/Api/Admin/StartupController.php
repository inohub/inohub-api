<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Startup\Startup;
use App\Services\AdataDetail\AdataDetailFetchDataService;
use Illuminate\Http\Request;

class StartupController extends Controller
{
    public function toApprove()
    {
        $startups = Startup::toApprove()
            ->with('owner.profile:id,user_id,first_name,last_name')
            ->get();

        return $this->response($startups);
    }

    public function show(Startup $startup)
    {
        $adataDetail = $startup->owner->adataDetails()->latest('checked_at')->first();

        $startup->texts;

        if ($adataDetail && $data = (new AdataDetailFetchDataService($adataDetail->token))->run()) {
            $startup->adata = $data;
        }

        return $startup;
    }

    public function approve(Startup $startup)
    {
        $startup->is_approved = true;
        $startup->approved_at = now();
        $startup->save();

        return $this->response($startup);
    }

    public function cancel(Startup $startup, Request $request)
    {
        $startup->cancellation_reason = $request['cancellation_reason'];
        $startup->save();

        return $this->response($startup);
    }
}
