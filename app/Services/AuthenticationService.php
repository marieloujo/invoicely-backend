<?php

namespace App\Services;

use App\Services\Interfaces\AuthenticationServiceInterface;
use App\Traits\AuthentificableTrait;
use App\Traits\JsonResponseTrait;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\RefreshTokenRepository;

class AuthenticationService implements AuthenticationServiceInterface
{
    use JsonResponseTrait, AuthentificableTrait;

    /**
     * Authenticate user
     *
     * @param string $email
     * @param string $password
     * @param boolean $remember
     * @return void
     */
    public function createAccessToken(string $email, string $password, bool $remember = false)
    {
        $authenticated = auth()->attempt(["email" => $email, "password" => $password], $remember);

        if (!$authenticated) throw new AuthenticationException("Invalid password or email");

        $user = Auth::user();

        return $this->success("Successful login", [
            "access_token" => $user->createToken('MyApp')-> accessToken,
            "user" => $user
        ]);
    }

    /**
     * Refresh the access token using the refesh token
     *
     * @param string $refresh_token
     * @return JsonResponse
     */
    public function refreshAccessToken(string $refresh_token): JsonResponse
    {
        $body = $this->buildOauthRequestData(refresh_token: $refresh_token);

        $tokenData = $this->createTokenByCredentials($body);

        return $this->success(message: "Token refreshed", response: json_decode($tokenData->getContent()), code: $tokenData->getStatusCode());
    }

    /**
     * Logout current session
     *
     * @return JsonResponse
     */
    public function revokeAccessToken() : JsonResponse
    {
        $token = auth()->user()->token();

        $token->revoke();
        $token->delete();

        $refreshTokenRepository = app(RefreshTokenRepository::class);
        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($token->id);

        return $this->success('Successfully logged out');
    }

    /**
     * Get authenticated user info
     */
    public function getAuthenticatedUser(): JsonResponse
    {
        if (!auth()->check()) throw new AuthenticationException();

        return $this->success(response: auth()->user());
    }


    /**
     * Authenticate user
     *
     * @param string $email
     * @param string $password
     * @return JsonResponse
     */
    private function authenticate(string $email, string $password): JsonResponse
    {
        $body = $this->buildOauthRequestData($email, $password);

        $tokenData = $this->createTokenByCredentials($body);

        $accessToken = json_decode($tokenData->getContent());

        return $this->success(message: "Successful login", response: $accessToken, code: $tokenData->getStatusCode());
    }


}
