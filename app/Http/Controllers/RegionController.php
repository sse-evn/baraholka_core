<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function set(Request $request)
    {
        $request->validate(['region_id' => 'nullable|exists:regions,id']);
        session(['region_id' => $request->region_id]);
        return back();
    }
}