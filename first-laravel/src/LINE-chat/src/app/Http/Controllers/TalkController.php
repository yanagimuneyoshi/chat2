<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TalkController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'TalkController is working!']);
    }
}
