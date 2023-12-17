<?php

namespace App\Http\Controllers\Graph;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GraphController extends Controller
{
    public function index(){
        $devices = auth()->user()?->devices()->get();
        return view('graphs.index', compact('devices'));
    }
}
