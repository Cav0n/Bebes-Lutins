<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{

    public function upload(){
        header('Content-type: application/json');
        echo json_encode( ['uploaded' => true, 'url' => 'https://www.bebes-lutins.fr/'], JSON_PRETTY_PRINT);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $file = $request['file'];
        
        $fileName = uniqid();
        $fileExtension = $file->getClientOriginalExtension();
        $destinationPath = public_path('/images/tmp');

        $newfile = $fileName.'.'.$fileExtension;
        
        $upload_success = $request['file']->move($destinationPath, $newfile);

        if( $upload_success ) {
            $response = ['filename' => $newfile, 'message' => 'success', 'code' => 200];
            return response($response);
        } else {
            return response()->json('Erreur', 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if($request['path'] != null){
            unlink(public_path($request['path']).$request['image']);
        } else { unlink(public_path('/images/tmp/').$request['image']); }
    }
}
