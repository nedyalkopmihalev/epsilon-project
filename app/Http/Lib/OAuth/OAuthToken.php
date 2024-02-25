<?php
namespace App\Http\Lib\OAuth;

use App\Models\OAuth\OAuthAccessTokens;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class OAuthToken
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function accessToken()
    {
        $configuration = [
            'form_params' => [
                'grant_type' => Config::get('constants.client_credentials'),
                'client_id' => Config::get('constants.client_id'),
                'client_secret' => Config::get('constants.client_secret'),
            ],
            'headers' => [
                'Accept' => Config::get('constants.accept')
            ]
        ];

        try {
            $client = new Client();
            $url = Config::get('constants.url') . '/api/oauth2/access-token';
            $response = $client->request('POST', $url, $configuration);
            $responseBody = json_decode($response->getBody()->getContents());

            $oAuthAccessTokensModel = new OAuthAccessTokens();

            if (empty($oAuthAccessTokensModel->checkRecords())) {
                $data = [
                    'client_id' => Config::get('constants.client_id'),
                    'client_secret' => Config::get('constants.client_secret'),
                    'access_token' => $responseBody->access_token,
                    'refresh_token' => $responseBody->refresh_token,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'expires_at' => Carbon::parse(Carbon::now())->addSeconds($responseBody->expires_in)
                ];

                $oAuthAccessTokensModel->addOAuthAccessToken($data);
            }

            return response()->json($responseBody, 200);
        } catch (RequestException $e) {
            return response()->json($e->getResponse()->getStatusCode() . ': ' . $e->getMessage(), 400);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshToken()
    {
        $oAuthAccessTokensModel = new OAuthAccessTokens();
        $getOAuthTokens = $oAuthAccessTokensModel->getOAuthTokens();

        $configuration = [
            'form_params' => [
                'grant_type' => Config::get('constants.refresh_token'),
                'refresh_token' => $getOAuthTokens->refresh_token,
                'client_id' => Config::get('constants.client_id'),
                'client_secret' => Config::get('constants.client_secret'),
            ],
            'headers' => [
                'Accept' => Config::get('constants.accept')
            ]
        ];

        try {
            $client = new Client();
            $url = Config::get('constants.url') . '/api/oauth2/refresh-token';
            $response = $client->request('POST', $url, $configuration);
            $responseBody = json_decode($response->getBody()->getContents());

            $data = [
                'access_token' => $responseBody->access_token,
                'refresh_token' => $responseBody->refresh_token,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'expires_at' => Carbon::parse(Carbon::now())->addSeconds($responseBody->expires_in)
            ];

            $oAuthAccessTokensModel->updateOAuthTokens($data);

            return response()->json($responseBody, 200);
        } catch (RequestException $e) {
            return response()->json($e->getResponse()->getStatusCode() . ': ' . $e->getMessage(), 400);
        }
    }
}