<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class DashboardController extends Controller
{
    public function index()
    {
        // 🔥 incluir likes también
        $posts = Post::with(['user', 'likes'])
            ->latest('id')
            ->get();

        return view('user.dashboard', [
            'posts' => $posts
        ]);
    }
}