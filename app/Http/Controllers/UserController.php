<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;


class UserController extends Controller
{
    // 👤 Get the logged-in user's profile
    public function profile(Request $request): JsonResponse
    {
        $user = $request->user()->load('vipLevel');


        return response()->json([
            'username' => $user->username,
            'phone_number' => $user->phone_number,
            'invitation_code' => $user->invitation_code,
            'referrer_id' => $user->referrer_id,
            'language' => $user->language,
            'balance' => $user->balance,
            'created_at' => $user->created_at,
            'vip_level' => $user->vipLevel,
        ]);
    }

    // 🤝 List of users referred by the logged-in user
    public function myReferrals()
    {
        $user = auth()->user();

        $referrals = $user->referrals()->select('id', 'username', 'phone_number', 'created_at')->get();

        return response()->json([
            'total_referrals' => $referrals->count(),
            'referrals' => $referrals,
        ]);
    
    }



}
