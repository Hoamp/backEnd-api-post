<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{

    // untuk halaman utama / index
    public function index()
    {
        // ambil semua data post
        $posts = Post::all();

        // kembalikan response
        return response()->json([
            'success' => true,
            'message' => 'All data posts',
            'data' => $posts
        ], 200);
    }

    // ambil post berdasarkan id
    public function show(Post $post)
    {
        // kembalikan post sesuai dengan id
        return response()->json([
            'success' => true,
            'message' => 'Data post',
            'data' => $post
        ], 200);
    }

    // untuk create post
    public function store(Request $request)
    {
        // validasi inputan user
        $validatedData = Validator::make($request->all(), [
            'title' => 'required',
            'author' => 'required',
            'description' => 'required',
            'tags' => 'required',
        ]);

        // jika gagal
        if ($validatedData->fails()) {
            // kembalikan pesan gagals
            return response()->json($validatedData->errors());
        }

        // buat postingan baru
        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'author' => $request->author,
            'tags' => $request->tags
        ]);

        // jika berhasil
        if ($post) {
            // kembalikan response berhasil
            return response()->json([
                'success' => true,
                'message' => 'Successfully added new post',
                'data' => $post
            ], 201);
        } else {
            // kembalikan pesan gagal
            return response()->json([
                'success' => false,
                'message' => 'New post cannot be added',
            ], 400);
        }
    }

    // untuk update post
    public function update(Request $request, Post $post)
    {
        // validasi inputan user
        $validatedData = Validator::make($request->all(), [
            'title' => 'required',
            'author' => 'required',
            'description' => 'required',
            'tags' => 'required',
        ]);

        // jika gagal
        if ($validatedData->fails()) {
            // kembalikan pesan gagals
            return response()->json($validatedData->errors());
        }

        // update data lama menjadi baru
        $newPost = $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'author' => $request->author,
            'tags' => $request->tags,
            'updated_at' => Carbon::now()
        ]);

        // jika berhasil
        if ($newPost) {
            // kembalikan response berhasil
            return response()->json([
                'success' => true,
                'message' => 'Updated post successfully',
                'data' => $newPost
            ], 201);
        } else {
            // kembalikan pesan gagal
            return response()->json([
                'success' => false,
                'message' => 'Post cannot be updated',
            ], 400);
        }
    }

    // delete post
    public function destroy(Post $post)
    {
        // hapus postingan berdasarkan id
        $deletePost = $post->delete();

        // jika berhasil
        if ($deletePost) {
            // kembalikan pesan berhasil
            return response()->json([
                'success' => true,
                'message' => 'Post deleted successfully'
            ], 200);
        } else {
            // kembalikan pesan gagal
            return response()->json([
                'success' => false,
                'message' => 'Post cannot deleted'
            ], 400);
        }
    }
}
