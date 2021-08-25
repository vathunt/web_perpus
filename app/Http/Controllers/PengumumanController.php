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

        $namaFile         = [];
        $namaFileLampiran = $request->namaLampPengumuman;

        if ($request->hasFile('lampPengumuman')) {
            for ($i = 0; $i < count($lampiran_pengumuman); $i++) { 
                $fileLampiran = Carbon::now()->timestamp . '_' . uniqid() . '.' . $lampiran_pengumuman[$i]->getClientOriginalExtension();
                array_push($lampPengumuman, $fileLampiran);
                $lampiran_pengumuman[$i]->move($this->pathLampiran . '/', $fileLampiran);

                if (!empty($namaFileLampiran[$i])) {
                    array_push($namaFile, ucwords($namaFileLampiran[$i]));
                } else {
                    array_push($namaFile, $fileLampiran);
                }
            }
        }
        // else 
        // {
        //     $lampPengumuman = '';
        // }
        // Akhir Proses Lampiran Pengumuman
        
        // Proses Nama File Lampiran
        // $namaFile         = [];
        // $namaFileLampiran = $request->namaLampPengumuman;

        // foreach ($namaFileLampiran as $nama_file) {
        //     array_push($namaFile, ucwords($nama_file));
        // }
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
    public function update(Request $request)
    {
        $this->validate(
            $request,
            [
                'judulEdit'   => 'required',
                'tglEdit'     => 'required',
                'detailEdit'  => 'required',
                'thumbEdit'   => 'image|mimes:jpg,png,jpeg|file|max:2048',
                'lampEdit'    => 'max:10000'
            ],
            [
                'judulEdit.required'  => 'Judul Pengumuman Harus Diisi',
                'tglEdit.required'    => 'Tanggal Pengumuman Belum Dipilih',
                'detailEdit.required' => 'Detail Pengumuman Belum Diisi',
                'thumbEdit.image'     => 'Thumbnail Pengumuman Harus Berbentuk File Gambar',
                'thumbEdit.mimes'     => 'Ekstensi Yang Diijinkan Harus *.png, *.jpg, *.jpeg',
                'thumbEdit.max'       => 'Ukuran File Tidak Boleh Lebih dari 2 MB',
                'lampEdit.max'        => 'Ukuran File Tidak Boleh Lebih dari 10 MB'
            ]
        );

        // Proses Thumbnail Pengumuman
        if (!File::isDirectory($this->pathThumbnail)) {
            // Buat Folder untuk Menyimpan Thumbnail Pengumuman
            File::makeDirectory($this->pathThumbnail, 0777, true, true);
        }

        $thumbPengumuman = $request->file('thumbEdit');
        if ($request->hasFile('thumbEdit')) {
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
        $lampiran_pengumuman = $request->file('lampEdit');

        $namaFile         = [];
        $namaFileLampiran = $request->namaLampEdit;

        if ($request->hasFile('lampEdit')) {
            for ($i = 0; $i < count($lampiran_pengumuman); $i++) { 
                $fileLampiran = Carbon::now()->timestamp . '_' . uniqid() . '.' . $lampiran_pengumuman[$i]->getClientOriginalExtension();
                array_push($lampPengumuman, $fileLampiran);
                $lampiran_pengumuman[$i]->move($this->pathLampiran . '/', $fileLampiran);

                if (!empty($namaFileLampiran[$i])) {
                    array_push($namaFile, ucwords($namaFileLampiran[$i]));
                } else {
                    array_push($namaFile, $fileLampiran);
                }
            }
        }
        // Akhir Proses Lampiran Pengumuman

        $pengumuman = Pengumuman::find(request('idEdit'));

        // Jika thumbnail pengumuman diubah
        if ($thumbPengumuman) {
            // Hapus File Thumbnail Pengumuman
			File::delete($this->pathThumbnail . '/' . $pengumuman->thumbnail_pengumuman);

            $pengumuman->thumbnail_pengumuman = $fileThumb;
        }
        // Akhir jika thumbnail pengumuman diubah

        // Jika lampiran pengumuman diubah
        if ($lampiran_pengumuman) {
            // Hapus File Lampiran Pengumuman
            foreach ($pengumuman->lampiran_pengumuman as $lampiran) {
                File::delete($this->pathLampiran . '/' . $lampiran);
            }

            $pengumuman->lampiran_pengumuman = $lampPengumuman;
            $pengumuman->nama_file_lampiran = $namaFile;
        }
        // Akhir jika lampiran pengumuman diubah

        $pengumuman->judul_pengumuman        = strtoupper(strip_tags($request->judulEdit));
        $pengumuman->judul_seo               = Str::slug(strip_tags($request->judulEdit));
        $pengumuman->tgl_pengumuman          = $request->tglEdit;
        $pengumuman->detail_pengumuman       = $request->detailEdit;
        $pengumuman->user_id                 = Auth::user()->id;
        $pengumuman->update();

        return redirect('/panel/pengumuman')->with('sukses', 'Data Pengumuman Berhasil Diubah');
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

    public function upload_image(Request $request) {
        // Allowed extentions.
        $allowedExts = array("gif", "jpeg", "jpg", "png");

        // Get filename.
        $temp = explode(".", $_FILES["image_param"]["name"]);

        // Get extension.
        $extension = end($temp);

        // An image check is being done in the editor but it is best to
        // check that again on the server side.
        // Do not use $_FILES["file"]["type"] as it can be easily forged.
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES["image_param"]["tmp_name"]);

        if ((($mime == "image/gif")
        || ($mime == "image/jpeg")
        || ($mime == "image/pjpeg")
        || ($mime == "image/x-png")
        || ($mime == "image/png"))
        && in_array($extension, $allowedExts)) {
            // Generate new random name.
            $name = sha1(microtime()) . "." . $extension;

            // Save file in the uploads folder.
            move_uploaded_file($_FILES["image_param"]["tmp_name"], getcwd() . "/assets/images/" . $name);

            // Check server protocol and load resources accordingly.
            if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] != "off") {
                $protocol = "https://";
            } else {
                $protocol = "http://";
            }

            // Generate response.
            $response = new \StdClass;
            $response->link = $protocol.$_SERVER["HTTP_HOST"].dirname($_SERVER["PHP_SELF"]). "/assets/images/" . $name;
            echo stripslashes(json_encode($response));
        }
    }

    public function remove_image(Request $request) {
        // Get src
        $src = explode('/', $request->src);
        $file = end($src);

        // Check if file exists
        if (file_exists(getcwd() . "/assets/images/" . $file)) {
            // Delete file
            unlink(getcwd() . "/assets/images/" . $file);
        }
    }
}