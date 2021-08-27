<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Artikel;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ArtikelController extends Controller
{
    public $pathThumbnail;

    public function __construct()
    {
        $this->pathThumbnail = public_path('/assets/images/thumbnail/artikel');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel.artikel');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'judulArtikel'  => 'required',
                'tglArtikel'    => 'required',
                'isiArtikel'    => 'required',
                'thumbArtikel'  => 'required|image|mimes:jpg,png,jpeg|file|max:2048'
            ],
            [
                'judulArtikel.required'     => 'Judul Artikel Harus Diisi',
                'tglArtikel.required'       => 'Tanggal Artikel Harus Diisi',
                'isiArtikel.required'       => 'Isi Artikel Harus Diisi',
                'thumbArtikel.required'     => 'Thumbnail Artikel Belum Dipilih',
                'thumbArtikel.image'        => 'Thumbnail Artikel Harus Berbentuk File Gambar',
                'thumbArtikel.mimes'        => 'Ekstensi yang Diijinkan *.jpg, *.png atau *.jpeg',
                'thumbArtikel.max'          => 'Ukuran Maksimal 2 MB'
            ]
        );

        // Proses Thumbnail Artikel
        if (!File::isDirectory($this->pathThumbnail)) {
            // Buat Folder Thumbnail Artikel
            File::makeDirectory($this->pathThumbnail, 0777, true, true);
        }

        $thumbArtikel = $request->file('thumbArtikel');
        if ($request->hasFile('thumbArtikel')) {
            $fileThumb = Carbon::now()->timestamp . '_' . uniqid() . '.' . $thumbArtikel->getClientOriginalExtension();
            Image::make($thumbArtikel)->save($this->pathThumbnail . '/' . $fileThumb);
        } else {
            $fileThumb = '';
        }
        // Akhir Proses Thumbnail Artikel
        
        $article = new Artikel;
        $article->judul_artikel = strtoupper(strip_tags($request->judulArtikel));
        $article->judul_seo     = Str::slug(strip_tags($request->judulArtikel));
        $article->tgl_artikel   = $request->tglArtikel;
        $article->tag           = $request->tagArtikel;
        $article->isi_artikel   = $request->isiArtikel;
        $article->thumbnail_artikel = $fileThumb;
        $article->user_id       = Auth::user()->id;
        $article->save();

        return redirect('/panel/artikel')->with('sukses', 'Data Artikel Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Artikel::with('user')->find($id);
        return response()->json($article);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate(
            $request,
            [
                'judulEdit'     => 'required',
                'tglEdit'       => 'required',
                'thumbEdit'     => 'image|mimes:jpg,png,jpeg|file|max:2048',
                'isiEdit'       => 'required'
            ],
            [
                'judulEdit.required'     => 'Judul Artikel Harus Diisi',
                'tglArtikel.required'    => 'Tanggal Artikel Harus Diisi',
                'thumbEdit.image'        => 'Thumbnail Artikel Harus Berbentuk File Gambar',
                'thumbEdit.mimes'        => 'Ekstensi yang Diijinkan *.jpg, *.png atau *.jpeg',
                'thumbEdit.max'          => 'Ukuran Maksimal 2 MB',
                'isiEdit.required'       => 'Isi Artikel Harus Diisi'
            ]
        );

        // Proses Thumbnail Artikel
        if (!File::isDirectory($this->pathThumbnail)) {
            File::makeDirectory($this->pathThumbnail, 0777, true, true);
        }

        $thumbArtikel = $request->file('thumbEdit');
        if ($request->hasFile('thumbEdit')) {
            $fileThumb = Carbon::now()->timestamp . '_' . uniqid() . '.' . $thumbArtikel->getClientOriginalExtension();
            Image::make($thumbArtikel)->save($this->pathThumbnail . '/' . $fileThumb);
        } else {
            $fileThumb = '';
        }

        $article = Artikel::find($request->idEdit);

        // Jika Thumbnail Diubah
        if ($thumbArtikel) {
            File::delete($this->pathThumbnail . '/' . $article->thumbnail_artikel);

            $article->thumbnail_artikel = $fileThumb;
        }

        $article->judul_artikel = strtoupper(strip_tags($request->judulEdit));
        $article->judul_seo     = Str::slug(strip_tags($request->judulEdit));
        $article->tgl_artikel   = $request->tglEdit;
        $article->isi_artikel   = $request->isiEdit;
        $article->user_id       = Auth::user()->id;
        $article->update();

        return redirect('/panel/artikel')->with('sukses', 'Data Artikel Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->idDelete;
        $article = Artikel::find($id);

        File::delete($this->pathThumbnail . '/' . $article->thumbnail_artikel);

        $article->delete();

        return redirect('/panel/artikel')->with('sukses', 'Data Artikel Berhasil Dihapus');
    }

    public function data(Request $request) {
        $columns = array(
            0 => 'id',
            1 => 'tgl_artikel',
            2 => 'judul_artikel',
            3 => 'isi_artikel' 
        );

        $totalData = Artikel::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $articles = Artikel::offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
        } else {
            $search = implode('* ', explode(' ', $request->input('search.value'))) . '*';

            $articles = Artikel::whereRaw("MATCH(judul_artikel) AGAINST(? IN BOOLEAN MODE)", array($search))
                ->orWhereRaw("MATCH(tag) AGAINST(? IN BOOLEAN MODE)", array($search))
                ->orWhereRaw("MATCH(isi_artikel) AGAINST(? IN BOOLEAN MODE)", array($search))
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Artikel::whereRaw("MATCH(judul_artikel) AGAINST(? IN BOOLEAN MODE)", array($search))
                ->orWhereRaw("MATCH(tag) AGAINST(? IN BOOLEAN MODE)", array($search))
                ->orWhereRaw("MATCH(isi_artikel) AGAINST(? IN BOOLEAN MODE)", array($search))
                ->count();
        }

        $data = array();
        if (!empty($articles)) {
            foreach ($articles as $article) {
                $nestedData['id'] = $article->id;
                $nestedData['tgl_artikel'] = tanggal_indo($article->tgl_artikel);
                $nestedData['judul_artikel'] = $article->judul_artikel;
                $nestedData['isi_artikel'] = Str::words(strip_tags($article->isi_artikel), $words = 10, $end = ' .....');
                $nestedData['action'] = "<div class='btn-group mb-3' role='group' aria-label='Basic example'>
                                        <button type='button' class='btn btn-sm btn-primary' onClick='editArtikel(" . $article->id . ")' title='Edit Data Artikel'><i class='fas fa-edit'></i></button>
                                        <button type='button' class='btn btn-sm btn-info' onClick='lihatArtikel(" . $article->id . ")' title='Lihat Data Artikel'><i class='fas fa-eye'></i></button>
                                        <button type='button' class='btn btn-sm btn-danger' onClick='hapusArtikel(" . $article->id . ")' title='Hapus Data Artikel'><i class='fas fa-trash-alt'></i></button>
                                    </div>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"              => intval($request->input('draw')),
            "recordsTotal"      => intval($totalData),
            "recordsFiltered"   => intval($totalFiltered),
            "data"              => $data
        );

        echo json_encode($json_data);
    }
}
