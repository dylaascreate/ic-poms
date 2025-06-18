<?php

// namespace App\Http\Controllers;

// // Import necessary classes
// use Illuminate\Support\Facades\Auth; // For authentication
// use App\Models\Order; // Order model

// /**
//  * UserDashboardController
//  *
//  * This controller handles the logic for displaying and managing the user dashboard.
//  * It utilizes Laravel's authentication system via the Auth facade to access
//  * and manage the currently authenticated user's data and permissions.
//  *
//  * @package App\Http\Controllers
//  */
// class UserDashboardController extends Controller
// {
//     /**
//      * Display the user dashboard.
//      *
//      * @return \Illuminate\View\View
//      */
//     public function index()
//     {
//         // Get the currently logged-in user
//         $user = Auth::user();

//         // Get all orders that belong to the user
//         $orders = Order::where('user_id', $user->id)->get();

//         // Count total number of orders
//         $totalOrder = $orders->count();

//         // Count orders with status 'Waiting'
//         $waiting = $orders->where('status', 'Waiting')->count();

//         // Count orders with status 'Printing'
//         $printing = $orders->where('status', 'Printing')->count();

//         // Count orders with status 'Ready'
//         $readyPickup = $orders->where('status', 'Ready')->count();

//         // Count orders with status 'Picked Up'
//         $pickedUp = $orders->where('status', 'Picked Up')->count();

//         // Return the dashboard view with the orders and counts
//         return view('dashboard', compact(
//             'orders',
//             'totalOrder',
//             'waiting',
//             'printing',
//             'readyPickup',
//             'pickedUp'
//         ));
//     }
// }

