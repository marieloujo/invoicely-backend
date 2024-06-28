<?php

namespace App\Http\Controllers\APIs\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Response;

class RegisterController extends Controller
{
    use JsonResponseTrait;

    public function __invoke(RegisterRequest $request)
    {
        $user = User::create($request->validated());

        return $this->success("User registered successfully", $user, Response::HTTP_CREATED);
    }

}
