<?php


namespace App\Services\AdataDetail;


use App\Models\User\User;
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
                'pedophil' => 'yes',
                'pidor' => 'yes'
            ]
        ];

        if (!$response['success']) {
            Log::error(json_encode($response));
            throw new \Exception('Error occurred while fetching data from adata');
        }

        return $response['data'];
    }
}
