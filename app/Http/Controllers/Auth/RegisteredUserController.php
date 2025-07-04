<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
//use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    /* public function store(Request $request): Response
     {
         $request->validate([
             'name' => ['required', 'string', 'max:255'],
             'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
             'password' => ['required', 'confirmed', Rules\Password::defaults()],
         ]);

         $user = User::create([
             'name' => $request->name,
             'email' => $request->email,
             'password' => Hash::make($request->string('password')),
         ]);

         event(new Registered($user));

         Auth::login($user);

         return response()->json(['message' => 'User registered successfully'], 201);

     }

         */
    public function store(Request $request): JsonResponse
    {
        // $request->validate([
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        //     'password' => ['required', 'confirmed', Rules\Password::defaults()],
        // ]);

        $request->validate([
            'username' => 'required|string|unique:users,username',
            'phone_number' => 'required|string|unique:users,phone_number',
            'password' => 'required|string|min:8|confirmed',
            'withdrawal_password' => 'required|string|min:4',
            'invitation_code' => 'nullable|string',
            'language' => 'nullable|string|in:en,ar,fr',
        ]);

        $referrer = null;
        if ($request->filled('invitation_code')) {
            $referrer = User::where('invitation_code', $request->invitation_code)->first();
        }

        //     // $user = User::create([
        //     //     'name' => $request->name,
        //     //     'email' => $request->email,
        //     //     'password' => Hash::make($request->string('password')),
        //     // ]);

        $user = User::create([
            'username' => $request->username,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'withdrawal_password' => Hash::make($request->withdrawal_password),
            'invitation_code' => Str::random(8),
            'referrer_id' => optional($referrer)->id,
            'language' => $request->language ?? 'en',
            'vip_level_id' => 1,
            'balance' => 0,
        ]);

        event(new Registered($user));
        Auth::login($user);
        // return response()->json(['message' => 'User registered successfully'], 201);
        return response()->json([
            'message' => 'User registered successfully',
            'referral_link' => "https://shopify-clone-orpin.vercel.app/register?ref={$user->invitation_code}"
        ], 201);

    }


    public function login(Request $request): JsonResponse
    {
        // $request->validate([
        //     'email' => 'required|email',
        //     'password' => 'required',
        // ]);

        $request->validate([
            'phone_number' => 'required|string',
            'password' => 'required|string',
        ]);


        // $user = User::where('email', $request->email)->first();
        $user = User::where('phone_number', $request->phone_number)->first();


        // if (!$user || !Hash::check($request->password, $user->password)) {
        //     return response()->json(['message' => 'Invalid credentials'], 401);
        // }
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials.'
            ], 401);
        }


        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful.',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);

    }

}

