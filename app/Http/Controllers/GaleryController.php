<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class GaleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = array(
            'id' => 'posts',
            'menu' => 'Gallery',
            'galleries' => Post::where('picture', '!=', '')->whereNotNull('picture')->orderBy('created_at', 'desc')->paginate(30)
        );
        return view('gallery.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999'
        ]);
    
        if ($request->hasFile('picture')) {
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();
            $basename = uniqid() . '_' . time();
            $smallFilename = "small_{$basename}.{$extension}";
            $mediumFilename = "medium_{$basename}.{$extension}";
            $largeFilename = "large_{$basename}.{$extension}";
            $filenameSimpan = "{$basename}.{$extension}";
            $path = $request->file('picture')->storeAs('posts_image', $filenameSimpan);
        } else {
            $filenameSimpan = 'noimage.png';
        }
    
        // dd($request->input());
        $post = new Post;
        $post->picture = $filenameSimpan;
        $post->tittle = $request->input('title');
        $post->description = $request->input('description');
        $post->save();
    
        return redirect('gallery')->with('success', 'Berhasil menambahkan data baru');
    }
                


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gallery = Post::findOrFail($id);
    return view('gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999'
        ]);
    
        $gallery = Post::findOrFail($id);
    
        // Update picture if a new one is uploaded
        if ($request->hasFile('picture')) {
            // Delete the old image if it exists
            if ($gallery->picture && $gallery->picture != 'noimage.png') {
                Storage::delete('public/posts_image/' . $gallery->picture);
            }
    
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();
            $filenameSimpan = uniqid() . '_' . time() . '.' . $extension;
            $request->file('picture')->storeAs('posts_image', $filenameSimpan);
    
            $gallery->picture = $filenameSimpan;
        }
    
        // Update other fields
        $gallery->tittle = $request->input('title');
        $gallery->description = $request->input('description');
        $gallery->save();
    
        return redirect()->route('gallery.index')->with('success', 'Gambar berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gallery = Post::findOrFail($id);

    // Hapus gambar dari penyimpanan
    if ($gallery->picture && $gallery->picture != 'noimage.png') {
        Storage::delete('public/posts_image/' . $gallery->picture);
    }

    // Hapus data dari database
    $gallery->delete();

    return redirect()->route('gallery.index')->with('success', 'Gambar berhasil dihapus');
    }
}
