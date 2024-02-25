<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Models\OAuth\OAuthAccessTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ServicesController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getService(Request $request)
    {
        $serviceId = (int) $request->serviceId;
        $oauthAccessTokens = new OAuthAccessTokens();
        $getOAuthToken = $oauthAccessTokens->getOAuthTokens();

        try {
            $configuration = [
                'form_params' => [
                    'grant_type' => Config::get('constants.client_credentials'),
                    'client_id' => Config::get('constants.client_id'),
                    'client_secret' => Config::get('constants.client_secret')
                ],
                'headers' => [
                    'Accept' => Config::get('constants.accept'),
                    'Authorization' => 'Bearer ' . $getOAuthToken->access_token
                ]
            ];

            $client = new Client();
            $url = Config::get('constants.url') . '/api/services/' . $serviceId . '/service';
            $response = $client->request('GET', $url, $configuration);
            $responseBody = json_decode($response->getBody()->getContents());

            return view('services.services', ['responseBody' => $responseBody]);
        } catch (RequestException $e) {
            return redirect('/');
        }
    }
}
