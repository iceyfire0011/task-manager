<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Requests\Auth\AuthRegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(AuthRegisterRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $user = new User();
            $user->name = $request->input('name');
            $user->password = Hash::make($request->input('password'));
            $user->email = $request->email;
            $user->save();

            $token = auth()->login($user);

            DB::commit();

            return $this->getTokenResponse('authToken', $token);
        } catch (Exception $e) {
            DB::rollback();
            return $this->getErrorBag('', 500, $e->getMessage());
        }
    }


    public function login(AuthLoginRequest $request): JsonResponse
    {
        $credentials = $request->only(['email', 'phone_number', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return $this->getErrorBag('Invalid', 422, 'Credentials do not match');
        }

        return $this->getTokenResponse('authToken', $token);
    }


    public function logout(): JsonResponse
    {
        $user = auth()->user();

        if (is_null($user)) {
            abort(401, 'User is not authorized or is already logged out');
        }

        auth()->logout();
        return $this->getSuccessBag('logout success', 200);
    }


}
