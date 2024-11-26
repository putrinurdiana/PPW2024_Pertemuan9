<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// memanggil code 
use App\Models\Buku;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    public function index (){
        $data_buku = Buku::all();
        // Kirim data ke view
        return view('buku.index', compact('data_buku'));

    }
    public function create() {
        $data_buku = Buku::all();

        return view('buku.create', compact('data_buku'));
    }
    public function store(Request $request){
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'tgl_terbit' => 'required|date',
            'photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048', // Validasi ukuran dan format file
        ]);

        if ($request->hasFile('photo')) {
            $filenameWithExt = $request->file(key: 'photo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filenameSimpan = $filename . '_' . time() . '.' . $extension;
            $path = $request->file('photo')->storeAs('photos', $filenameSimpan, 'public');
        }
    

        $buku = new Buku();
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;
        $buku->photo = $path ?? null;

        $buku->save();
        return redirect('/buku');
    }
    public function destroy($id) {
        $buku = Buku::find($id);
        $buku->delete();

        return redirect('/buku');
    }
    public function edit($id) {
        // menggunakan model bukuk mencari kolom di database yang memiliki id sesuai dengan nilai $id
        $buku = Buku::find($id);
        // fungsi compact untuk mengirim data buku ke view
        return view('/buku.edit', compact('buku'));
    }
    public function update(Request $request, $id)
{
    $buku = Buku::findOrFail($id);
    
    $buku->judul = $request->judul;
    $buku->penulis = $request->penulis;
    $buku->harga = $request->harga;
    $buku->tgl_terbit = $request->tgl_terbit;

    if ($request->hasFile('photo')) {
        // Delete old photo if it exists
        if ($buku->photo && file_exists(public_path('storage/'.$buku->photo))) {
            unlink(public_path('storage/'.$buku->photo));
        }

        // Store new photo
        $filenameWithExt = $request->file(key: 'photo')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('photo')->getClientOriginalExtension();
        $filenameSimpan = $filename . '_' . time() . '.' . $extension;
        $buku->photo = $request->file('photo')->storeAs('photos', $filenameSimpan, 'public');
    }

    $buku->save();

    return redirect()->route('buku.index')->with('success', 'Buku updated successfully');
}

    
    
    
}
