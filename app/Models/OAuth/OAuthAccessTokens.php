<?php

namespace App\Models\OAuth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class OAuthAccessTokens extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $oauthAccessTokensTable = 'oauth_access_tokens';

    /**
     * @param array $data
     */
    public function addOAuthAccessToken(array $data)
    {
        DB::table($this->oauthAccessTokensTable)
            ->insert($data);
    }

    /**
     * @return int
     */
    public function checkRecords()
    {
        return DB::table($this->oauthAccessTokensTable)
            ->count();
    }

    /**
     * @return Model|null|object|static
     */
    public function getOAuthTokens()
    {
        return DB::table($this->oauthAccessTokensTable)
            ->select('access_token', 'refresh_token', 'expires_at')
            ->where('client_id', Config::get('constants.client_id'))
            ->first();
    }

    /**
     * @param array $data
     */
    public function updateOAuthTokens(array $data)
    {
        DB::table($this->oauthAccessTokensTable)
            ->where('client_id', Config::get('constants.client_id'))
            ->update($data);
    }
}
