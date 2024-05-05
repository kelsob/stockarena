<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Optionally create a default token upon registration
        $token = $user->createToken('Personal Access Token')->accessToken;

        return response()->json(['user' => $user, 'token' => $token], 201);
    }

    /**
     * Authenticate user and return a token.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Credentials do not match'], 401);
        }

        $token = $user->createToken('Personal Access Token')->accessToken;

        return response()->json(['token' => $token]);
    }

    /**
     * Display the user's profile.
     */
    public function show(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Display the user's stock portfolio.
     */
    public function stocks(Request $request)
    {
        $user = $request->user();
        $stocks = $user->stocks()->with('pivot')->get();
        return response()->json($stocks);
    }

    /**
     * Display the user's transaction history.
     */
    public function transactions(Request $request)
    {
        $user = $request->user();
        $transactions = $user->transactions()->get();
        return response()->json($transactions);
    }
}