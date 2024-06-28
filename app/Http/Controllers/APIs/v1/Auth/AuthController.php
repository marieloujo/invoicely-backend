<?php

namespace App\Http\Controllers\APIs\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\Interfaces\AuthenticationServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    /**
     * @var authService
     */
    private $authService;

    /**
     * Instantiate a new RegisterController instance.
     *
     * @param AuthenticationServiceInterface $authenticateServiceInterface
     */
    public function __construct(AuthenticationServiceInterface $authenticateServiceInterface)
    {
        $this->authService = $authenticateServiceInterface;
    }


    /**
     * log user in
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return $this->authService->createAccessToken($request->email, $request->password, $request->remember ?? false);
    }

    /**
     * Refresh the access token
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function refreshToken(Request $request): JsonResponse
    {
        $request->validate(['refresh_token' => 'required']);

        return $this->authService->refreshToken($request->refresh_token);
    }

    /**
     * Get authenticate user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function user(Request $request): JsonResponse
    {
        return $this->authService->getAuthenticatedUser($request);
    }


    /**
     * Logout
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        return $this->authService->logout();
    }

}
