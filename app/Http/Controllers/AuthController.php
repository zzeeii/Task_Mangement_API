<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    /**
     * AuthController constructor.
     * Apply middleware and inject the AuthService.
     * 
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        // Allow login without authentication, restrict register to admin
        $this->middleware('auth:api', ['except' => ['login']]);
        $this->authService = $authService;
    }

    /**
     * Handle user login.
     * 
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            // Use the AuthService to handle login logic
            $credentials = $request->only('email', 'password');
            $response = $this->authService->login($credentials);

            return response()->json($response);

        } catch (\Exception $e) {
            // Handle login exceptions
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], $e->getCode() ?: 401);
        }
    }

    /**
     * Handle user registration, restricted to admins.
     * 
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        try {
            // Use the AuthService to handle registration logic
            $response = $this->authService->register($request->all());
            return response()->json($response);

        } catch (\Exception $e) {
            // Handle registration exceptions
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], $e->getCode() ?: 500);
        }
    }

    /**
     * Handle user logout.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        // Use the AuthService to handle logout
        $response = $this->authService->logout();
        return response()->json($response);
    }

    /**
     * Refresh the JWT token for the user.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        // Use the AuthService to refresh the token
        $response = $this->authService->refresh();
        return response()->json($response);
    }
}
