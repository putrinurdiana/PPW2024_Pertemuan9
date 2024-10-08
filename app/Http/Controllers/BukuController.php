<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// memanggil code 
use App\Models\Buku;

class BukuController extends Controller
{
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
        $buku = new Buku();
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;
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
    public function update(Request $request, $id) {
        $buku = Buku::find($id);

        // Update field yang ada berdasarkan input dari form
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;
 
        $buku->save();

        return redirect('/buku');
    }
    
    
}
