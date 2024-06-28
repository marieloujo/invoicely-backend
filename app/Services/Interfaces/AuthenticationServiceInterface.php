<?php

namespace App\Services\Interfaces;

use Illuminate\Http\JsonResponse;

/**
* Interface AuthenticationServiceInterface
* @package App\Services\Interfaces
*/
interface AuthenticationServiceInterface
{

    /**
     * Authenticate user
     *
     * @param string $username
     * @param string $password
     * @param boolean $remember
     * @return void
     */
    public function createAccessToken(string $username, string $password, bool $remember = false);

    /**
     * Refresh the access token using the refesh token
     *
     * @param string $refresh_token
     * @return JsonResponse
     */
    public function refreshAccessToken(string $refresh_token): JsonResponse;

    /**
     * Logout current session
     *
     * @return JsonResponse
     */
    public function revokeAccessToken() : JsonResponse;

    /**
     * Get authenticated user info
     */
    public function getAuthenticatedUser(): JsonResponse;

}
