<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class DashboardController extends Controller
{
    public function index()
    {
        // Obtener posts con su usuario, ordenados por más recientes
        $posts = Post::with('user')
            ->latest('id') // más limpio que orderBy
            ->get();

        return view('user.dashboard', [
            'posts' => $posts
        ]);
    }
}