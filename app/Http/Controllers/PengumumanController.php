<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Pengumuman;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class PengumumanController extends Controller
{
    public $pathThumbnail;
    public $pathLampiran;

    public function __construct()
    {
        // Path Thumbnail Pengumuman
        $this->pathThumbnail = public_path('/assets/images/thumbnail/pengumuman');

        // Path Lampiran Pengumuman
        $this->pathLampiran = public_path('assets/files/pengumuman');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel.pengumuman');
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
                'judulPengumuman'   => 'required',
                'tglPengumuman'     => 'required',
                'detailPengumuman'  => 'required',
                'thumbPengumuman'   => 'required|image|mimes:jpg,png,jpeg|file|max:2048',
                'lampPengumuman'    => 'max:10000'
            ],
            [
                'judulPengumuman.required'  => 'Judul Pengumuman Harus Diisi',
                'tglPengumuman.required'    => 'Tanggal Pengumuman Belum Dipilih',
                'detailPengumuman.required' => 'Detail Pengumuman Belum Diisi',
                'thumbPengumuman.required'  => 'Thumbnail Pengumuman Belum Dipilih',
                'thumbPengumuman.image'     => 'Thumbnail Pengumuman Harus Berbentuk File Gambar',
                'thumbPengumuman.mimes'     => 'Ekstensi Yang Diijinkan Harus *.png, *.jpg, *.jpeg',
                'thumbPengumuman.max'       => 'Ukuran File Tidak Boleh Lebih dari 2 MB',
                'lampPengumuman.max'        => 'Ukuran File Tidak Boleh Lebih dari 10 MB'
            ]
        );

        // Proses Thumbnail Pengumuman
        if (!File::isDirectory($this->pathThumbnail)) {
            // Buat Folder untuk Menyimpan Thumbnail Pengumuman
            File::makeDirectory($this->pathThumbnail, 0777, true, true);
        }

        $thumbPengumuman = $request->file('thumbPengumuman');
        if ($request->hasFile('thumbPengumuman')) {
            $fileThumb = Carbon::now()->timestamp . '_' . uniqid() . '.' . $thumbPengumuman->getClientOriginalExtension();
            Image::make($thumbPengumuman)->save($this->pathThumbnail . '/' . $fileThumb);
        } else {
            $fileThumb = '';
        }
        // Akhir Proses Thumbnail Pengumuman

        // Proses Lampiran Pengumuman
        if (!File::isDirectory($this->pathLampiran)) {
            // Buat Folder untuk Menyimpan Lampiran Pengumuman
            File::makeDirectory($this->pathLampiran, 0777, true, true);
        }

        $lampPengumuman = [];
        $lampiran_pengumuman = $request->file('lampPengumuman');

        if ($request->hasFile('lampPengumuman')) {
            foreach ($lampiran_pengumuman as $lampiran) {
                $fileLampiran = Carbon::now()->timestamp . '_' . uniqid() . '.' . $lampiran->getClientOriginalExtension();
                array_push($lampPengumuman, $fileLampiran);
                $lampiran->move($this->pathLampiran . '/', $fileLampiran);
            }
        } 
        // else 
        // {
        //     $lampPengumuman = '';
        // }
        // Akhir Proses Lampiran Pengumuman
         
        // Proses Nama File Lampiran
        $namaFile         = [];
        $namaFileLampiran = $request->namaLampPengumuman;

        if (empty($namaFileLampiran)) {
            foreach ($namaFileLampiran as $nama_file) {
                array_push($namaFile, ucwords($nama_file));
            }
        } else {
            foreach ($lampPengumuman as $nama_file) {
                array_push($namaFile, $nama_file);
            }
        }
        // Akhir Proses Nama File Lampiran

        $pengumuman                          = new Pengumuman;
        $pengumuman->judul_pengumuman        = strtoupper(strip_tags($request->judulPengumuman));
        $pengumuman->judul_seo               = Str::slug(strip_tags($request->judulPengumuman));
        $pengumuman->tgl_pengumuman          = $request->tglPengumuman;
        $pengumuman->detail_pengumuman       = $request->detailPengumuman;
        $pengumuman->thumbnail_pengumuman    = $fileThumb;
        $pengumuman->nama_file_lampiran      = $namaFile;
        $pengumuman->lampiran_pengumuman     = $lampPengumuman;
        $pengumuman->user_id                = Auth::user()->id;
        $pengumuman->save();

        return redirect('/panel/pengumuman')->with('sukses', 'Data Pengumuman Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $announcements = Pengumuman::with('user')->find($id);
        return response()->json($announcements);
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
    public function destroy(Request $request)
    {
        $id = $request->idDelete;

        $announcement = Pengumuman::find($id);

        // Hapus File Thumbnail Pengumuman
        File::delete($this->pathThumbnail . '/' . $announcement->thumbnail_pengumuman);

        // Hapus File Lampiran Pengumuman
        if ($announcement->lampiran_pengumuman) {
            foreach ($announcement->lampiran_pengumuman as $lampiran) {
                File::delete($this->pathLampiran . '/' . $lampiran);
            }
        }

        $announcement->delete();

        return redirect('/panel/pengumuman')->with('sukses', 'Pengumuman Berhasil Dihapus');
    }

    public function data(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'tgl_pengumuman',
            2 => 'judul_pengumuman',
            3 => 'detail_pengumuman'
        );

        $totalData = Pengumuman::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $announcements = Pengumuman::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = implode('* ', explode(' ', $request->input('search.value'))) . '*';

            $announcements = Pengumuman::whereRaw("MATCH (judul_pengumuman) AGAINST(? IN BOOLEAN MODE)", array($search))
                ->orWhereRaw("MATCH (detail_pengumuman) AGAINST(? IN BOOLEAN MODE)", array($search))
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Pengumuman::whereRaw("MATCH (judul_pengumuman) AGAINST(? IN BOOLEAN MODE)", array($search))
                ->orWhereRaw("MATCH (detail_pengumuman) AGAINST(? IN BOOLEAN MODE)", array($search))
                ->count();
        }

        $data = array();
        if (!empty($announcements)) {
            foreach ($announcements as $announcement) {
                $nestedData['id'] = $announcement->id;
                $nestedData['tgl_pengumuman'] = tanggal_indo($announcement->tgl_pengumuman);
                $nestedData['judul_pengumuman'] = $announcement->judul_pengumuman;
                $nestedData['detail_pengumuman'] = Str::words(strip_tags($announcement->detail_pengumuman), $words = 10, $end = ' .....');
                $nestedData['action'] = "<div class='btn-group mb-3' role='group' aria-label='Basic example'>
                                            <button type='button' class='btn btn-sm btn-primary' onClick='editPengumuman(" . $announcement->id . ")' title='Edit Data Pengumuman'><i class='fas fa-edit'></i></button>
                                            <button type='button' class='btn btn-sm btn-info' onClick='lihatPengumuman(" . $announcement->id . ")' title='Lihat Data Pengumuman'><i class='fas fa-eye'></i></button>
                                            <button type='button' class='btn btn-sm btn-danger' onClick='hapusPengumuman(" . $announcement->id . ")' title='Hapus Data Pengumuman'><i class='fas fa-trash-alt'></i></button>
                                        </div>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }
}
