<?php

namespace App\Http\Controllers\Ports;

use App\Http\Controllers\Controller;
use App\Models\OAuth\OAuthAccessTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class PortsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getAllPorts()
    {
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
            $url = Config::get('constants.url') . '/api/ports';
            $response = $client->request('GET', $url, $configuration);
            $responseBody = json_decode($response->getBody()->getContents());

            $ports = !empty($responseBody->ports) ? $responseBody->ports : [];

            return view('ports.ports', ['responseBody' => $ports]);
        } catch (RequestException $e) {
            return redirect('/');
        }
    }
}
