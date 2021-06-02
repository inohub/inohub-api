<?php


namespace App\Services\AdataDetail;


use App\Models\User\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class AdataDetailFetchDataService
{
    private string $token;

    /**
     * AdataDetailCreateTokenService constructor.
     *
     * @param  string  $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * @return array
     */
    public function run()
    {
//        $client = new Client();
//
//        $request = $client->request('GET',
//            'https://api.adata.kz/api/individual/info/check/'.config('adata.token').'?token='.$this->token);
//
//        $response = $request->getBody()->getContents();
        $response = [
            'success' => true,
            'data' => [
                'basic' => [
                    'iin' => '00081234567',
                    'rnn' => '123456789',
                    'name' => 'Abukalip Kolakov'
                ],
                'reliability' => [
                    'ban_leaving' => false,
                    'enforcement_debt' => false,
                    'terrorist' => true,
                    'pedophile' => false,
                    'alimony_payer' => false,
                    'seized_property' => true,
                    'ban_notarius_actions' => false
                ],
                'litigation' => [
                    'total_civil_count' => rand(1,4),
                    'total_criminal_count'=> rand(0,3),
                    'total_administrative_count' => rand(0,1)
                ]
            ]
        ];

        if (!$response['success']) {
            Log::error(json_encode($response));
            throw new \Exception('Error occurred while fetching data from adata');
        }

        return $response['data'];
    }
}
