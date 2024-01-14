<?php

namespace App\Http\Middleware;

use App\Models\Post;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserPosting
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userid = Auth::user();
        $postid = Post::findorFail($request->id);

        // mencegah agar user tidak dpt update postingan yang bukan miliknya
        if ($userid->id != $postid->author) {
            return response()->json(['message' => 'data not found'], 404);
        }
        return $next($request);
    }
}
