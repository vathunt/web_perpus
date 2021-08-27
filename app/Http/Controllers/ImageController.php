<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('image');
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
        if($request->hasFile('profile_image')) {
            //get filename with extension
            $filenamewithextension = $request->file('profile_image')->getClientOriginalName();
     
            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
     
            //get file extension
            $extension = $request->file('profile_image')->getClientOriginalExtension();
     
            //filename to store
            $filenametostore = $filename.'_'.time().'.'.$extension;
     
            //Upload File
            $request->file('profile_image')->storeAs('public/profile_images', $filenametostore);
     
            if(!file_exists(public_path('storage/profile_images/crop'))) {
                mkdir(public_path('storage/profile_images/crop'), 0755);
            }
     
            // crop image
            $img = Image::make(public_path('storage/profile_images/'.$filenametostore));
            $croppath = public_path('storage/profile_images/crop/'.$filenametostore);
     
            $img->crop($request->input('w'), $request->input('h'), $request->input('x1'), $request->input('y1'));
            $img->save($croppath);
     
            // you can save crop image path below in database
            $path = asset('storage/profile_images/crop/'.$filenametostore);
     
            return redirect('image')->with(['success' => "Image cropped successfully.", 'path' => $path]);
        }
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