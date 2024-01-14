<?php

namespace App\Http\Controllers;

use App\Http\Middleware\UserComment;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostDetailResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        
        // BISA DENGAN CARA JSON BISA JUGA DENGAN PAKAI RESOURCE
        // return response()->json([
            //     'tes' => $posts
            // ]);
            $posts = Post::all();
            
            // loadMissing(writer:id, username) itu cuma buat memfilter doang jadi kepanggil id sama username
        return PostResource::collection($posts->loadMissing(['authorPost:id,username', 'postComment:user_id,post_id,comment_content']));
    }

    public function showAuthor($id)
    {
        $authorPost = Post::with('authorPost')->findOrFail($id);
        
        return new PostResource($authorPost->loadMissing(['authorPost:id,username', 'postComment:user_id,post_id,comment_content']));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);
        
        // mencegah undefined jika tidak upload image
        $image = null;
        if ($request->file) {
            // disini kita mengupload image
            $filename =  $this->generateRandomString();
            // extension fungsi untuk image (jpg, png, dll)
            $extension = $request->file->extension();
            // agar image bisa masuk ke database kita tulis syntax ini
            $image = $filename.'.'.$extension;
            Storage::putFileAs('image', $request->file, $filename.'.'.$extension);
        }
        
        $request['image'] = $image;
        $request['author'] = Auth::user()->id;
        $post = Post::create($request->all());
        
        return new PostResource($post->loadMissing(['authorPost:id,username']));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post = Post::findOrFail($id);
        $post->update($request->all());

        return new PostDetailResource($post);
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return new PostDetailResource($post);
    }

    // generate random string untuk file image
    function generateRandomString($length = 40) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
