<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use RuntimeException;

trait AuthentificableTrait
{

    /**
     * Build request data for oauth
     *
     * @param User $user
     * @param string $refresh_token
     * @return array
     */
    public function buildOauthRequestData(string $username = null, string $password = null, string $refresh_token = null): array
    {
        if (is_null($refresh_token)) {

            return [
                'grant_type' => 'password',
                'client_id' => config('passport.personal_access_client.id'),
                'client_secret' => config('passport.personal_access_client.secret'),
                'username' => $username,
                'password' => $password,
                'scope' => ''
            ];

        }

        return [
            'refresh_token' => $refresh_token,
            'client_id'     => config('passport.personal_access_client.id'),
            'client_secret' => config('passport.personal_access_client.secret'),
            'grant_type' => 'refresh_token',
        ];

    }


    /**
     * Generate authenticate token
     *
     * @return mixed
     */
    public function createTokenByCredentials(array $body)
    {
        try {

            $authenticate = Request::create('/oauth/token', 'POST', $body);
            $response = app()->handle($authenticate); // authenticated user token access

            return $response;

        } catch (\Throwable $th) {
            throw new RuntimeException($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, $th);
        }
    }

}
