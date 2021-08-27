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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
                $nestedData['isi_artikel'] = Str::words(strip_tags($announcement->detail_pengumuman), $words = 10, $end = ' .....');
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
