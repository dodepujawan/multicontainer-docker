<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required',
            'content' => 'nullable',
        ]);

        $post = Post::create($request->only('title', 'content'));

        // Return JSON response untuk print
        return response()->json([
            'success' => true,
            'message' => 'Post created successfully',
            'print_data' => $this->generatePrintData($post)
        ]);
    }

    private function generatePrintData($post){
        $tanggal = now()->format('d/m/Y H:i:s');

        $printContent = "";
        $printContent .= "TEST CETAK\n";
        $printContent .= $tanggal . "\n";
        $printContent .= "------------------------\n";
        $printContent .= $post->title . "\n";
        $printContent .= "------------------------\n";
        $printContent .= $post->content . "\n";
        $printContent .= "------------------------\n";

        return $printContent;
    }


    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'nullable',
        ]);

        $post->update($request->only('title', 'content'));

        return redirect()->route('posts.index')->with('success', 'Post updated.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted.');
    }

    public function print()
    {
        return view('print.print');
    }

    public function getRawPrint(){
        // Contoh data ESC/POS sederhana (tes)
        $esc = "\x1B@\n";
        $esc .= "TEST PRINT\n";
        $esc .= "------------\n";
        $esc .= "Hello JSPrintManager!\n";
        $esc .= "\n\n\n";
        // Konversi ke binary response
        return response($esc)
            ->header('Content-Type', 'application/octet-stream');
    }

}
