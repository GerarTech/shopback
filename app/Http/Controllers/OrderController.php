<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        $user = $request->user();

        // Check daily limit (based on VIP level)
        $todayOrders = $user->orders()->whereDate('created_at', today())->count();
        $maxTasks = $user->vipLevel->max_tasks;

        if ($todayOrders >= $maxTasks) {
            return response()->json(['message' => 'Daily order limit reached'], 403);
        }

         $request->validate([
            'product_name' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
        ]);

        // Example profit calculation
        $amount = $request->input('amount');
        $profitRate = $user->vipLevel->profit_rate;
        $profit = ($amount * $profitRate) / 100;

        $order = $user->orders()->create([
            'product_name' => $request->input('product_name'),
            'amount' => $amount,
            'profit' => $profit,
            'status' => 'completed',
        ]);


        // Optionally update user balance
        $user->balance += $profit;
        $user->save();

        return response()->json(['message' => 'Order placed', 'order' => $order, 'remaining_orders' => $maxTasks - $todayOrders - 1]);
    }

    public function myOrders()
    {
        $orders = auth()->user()->orders()->latest()->get();
        return response()->json($orders);
    }

    public function orderStatus()
    {
        $user = auth()->user();
        $done = $user->orders()->whereDate('created_at', today())->count();
        $max = $user->vipLevel->max_tasks;

        return response()->json([
            'done_today' => $done,
            'remaining' => $max - $done,
            'max_allowed' => $max
        ]);
    }



}
