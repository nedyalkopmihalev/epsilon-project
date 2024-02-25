<?php

namespace App\Http\Controllers\Network;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Lib\OAuth\OAuthToken;
use App\Models\OAuth\OAuthAccessTokens;
use Carbon\Carbon;

class NetworkController extends Controller
{
    /**
     * @var OAuthToken
     */
    private $OAuthToken;

    /**
     * NetworkController constructor.
     * @param OAuthToken $OAuthToken
     */
    public function __construct(OAuthToken $OAuthToken)
    {
        $this->OAuthToken = $OAuthToken;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $oauthAccessTokens = new OAuthAccessTokens();

        if (empty($oauthAccessTokens->checkRecords())) {
            $this->OAuthToken->accessToken();
        }

        $getOAuthTokens = $oauthAccessTokens->getOAuthTokens();

        if (!empty($getOAuthTokens)) {
            if (strtotime($getOAuthTokens->expires_at) <= strtotime(Carbon::now())) {
                $this->OAuthToken->refreshToken();
            }
        }

        return view('network.index');
    }
}
