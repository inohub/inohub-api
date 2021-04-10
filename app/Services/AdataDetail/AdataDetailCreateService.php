<?php


namespace App\Services\AdataDetail;


use App\Models\AdataDetail\AdataDetail;
use App\Models\User\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class AdataDetailCreateService
{
    private User $user;

    /**
     * AdataDetailCreateTokenService constructor.
     *
     * @param  User  $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $iin = $this->user->profile->iin;

        if ($iin == null) {
            throw new \Exception('That user does not have an iin');
        }

//        $client = new Client();
//
//        $request = $client->request('GET',
//            'https://api.adata.kz/api/individual/info/'.config('adata.token').'?iinBin='.$iin);
//
//        $response = $request->getBody()->getContents();
        $response = [
          'token'
        ];

        if (!isset($response['token'])) {
            Log::error(json_encode($response));
            throw new \Exception('Error occurred while fetching data from adata');
        }

        $adataDetail = new AdataDetail();

        $adataDetail->user_id = $this->user->id;
        $adataDetail->token = $response['token'];
        $adataDetail->checked_at = now();

        return $adataDetail->save();
    }
}
