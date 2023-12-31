<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/login",
     *      operationId="login",
     *      tags={"Authentication"},
     *      summary="Login a user",
     *      description="Authenticate a user and generate access token for him",
     *
     *      @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *            required={"email", "password"},
     *
     *            @OA\Property(property="email", type="string", format="string", example="johndoe@example.com"),
     *            @OA\Property(property="password", type="password", format="string", example="password"),
     *         ),
     *      ),
     *
     *     @OA\Response(
     *          response=200, description="Success",
     *
     *          @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Successfully logged in!"),
     *             @OA\Property(property="user",type="object"),
     *             @OA\Property(property="token",type="string", example="2|DNxr1sIi7FkZE1OoYyS11n0XTJXs69DaM5qqxY22039c70df")
     *          )
     *       ),
     *
     *      @OA\Response(
     *          response=422, description="Unprocessable Content",
     *       )
     *  )
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->validated('email'), 'password' => $request->validated('password')])) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'message' => 'Successfully logged in!',
                'user' => $user,
                'token' => $token,
            ]);
        }

        return response()->json(['message' => 'The credentials you provided are not correct. Please try again.']);
    }

    /**
     * @OA\Post(
     *    path="/logout",
     *    operationId="logout",
     *    tags={"Logout"},
     *    summary="Logout a user",
     *    description="Logout a user and destroy their access token",
     *    security={
     *     {"sanctum": {}},
     *    },
     *
     *    @OA\Response(
     *        response=200,
     *        description="Success",
     *    ),
     *    @OA\Response(
     *        response=401,
     *        description="Unauthorized",
     *    ),
     *  ),
     * )
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
