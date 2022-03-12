<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Masters\Phase;
use Illuminate\Http\Request;

class PhaseController extends Controller
{
    public function index()
    {
        return Phase::all();
    }
}
