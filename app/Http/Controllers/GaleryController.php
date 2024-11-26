<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class GaleryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/gallery",
     *     tags={"Gallery"},
     *     summary="Fetch gallery posts",
     *     description="Menampilkan daftar postingan dengan gambar",
     *     operationId="getGallery",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil menampilkan data",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Judul Postingan"),
     *                 @OA\Property(property="picture", type="string", example="url_gambar.jpg")
     *             )
     *         )
     *     )
     * )
     */
    public function api()
    {
        $galleries = Post::where('picture', '!=', '')
            ->whereNotNull('picture')
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return response()->json([
            'status' => 'success',
            'data' => $galleries
        ]);
    }

    public function index()
    {
        $data = array(
            'id' => 'posts',
            'menu' => 'Gallery',
            'galleries' => Post::where('picture', '!=', '')->whereNotNull('picture')->orderBy('created_at', 'desc')->paginate(30)
        );
        return view('gallery.index')->with($data);
    }

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
    
        // Handle image upload if present
        if ($request->hasFile('picture')) {
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();
            $basename = uniqid() . '_' . time();
            $filenameSimpan = "{$basename}.{$extension}";
            $path = $request->file('picture')->storeAs('public/posts_image', $filenameSimpan); // Store in storage/app/public
        } else {
            $filenameSimpan = 'noimage.png'; // Default image if no file uploaded
        }
    
        // Create new post
        $post = new Post;
        $post->picture = $filenameSimpan;
        $post->title = $request->input('title'); // Fixed typo
        $post->description = $request->input('description');
        $post->save();
    
        return redirect('gallery')->with('success', 'Berhasil menambahkan data baru');
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
    
            // Save the new picture
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();
            $filenameSimpan = uniqid() . '_' . time() . '.' . $extension;
            $request->file('picture')->storeAs('public/posts_image', $filenameSimpan);
    
            $gallery->picture = $filenameSimpan;
        }
    
        // Update other fields
        $gallery->title = $request->input('title'); // Fixed typo
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
