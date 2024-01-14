<?php

namespace App\Http\Middleware;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserComment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userid = Auth::user();
        $commentid = Comment::findorFail($request->id);

        if ($userid->id != $commentid->user_id) {
            return response()->json(['message' => 'data not found'], 404);
        }

        return $next($request);
    }
}
