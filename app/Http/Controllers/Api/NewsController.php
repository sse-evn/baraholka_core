<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsController extends Controller
{
// NewsController.php
public function index()
{
    return response()->json(\App\Models\News::where('is_published', true)->get());
}}
