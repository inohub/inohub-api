<?php


namespace App\Services\AdataDetail;


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
        $client = new Client();

        $request = $client->request('GET',
            'https://api.adata.kz/api/individual/info/check/'.config('adata.token').'?token='.$this->token);

        $response = json_decode($request->getBody()->getContents(), true);

        if (!$response['success']) {
            Log::error(json_encode($response));
            throw new \Exception('Error occurred while fetching data from adata');
        }

        return $response['data'];
    }
}
