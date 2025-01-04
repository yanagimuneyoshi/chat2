<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'FriendController is working!']);
    }
}
