<?php

namespace App\Http\Controllers;

use App\Models\PictureDecArch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\BaseController;
use Validator;

class PictureDecArchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexIdDec(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'id_declaration' => 'required'
        ]);

        if ($validator->fails())
        {
            return (new BaseController)->sendError('Please validate your errors',$validator->errors());
        }
        else{

            $data = DB::table('picture_dec_arches')->where('id_dec',$request->input('id_declaration'))->get();
            if ($data != null)
            {
                return response()->json($data);
            }
            else
            {
                return reponse()->json('no pictures');
            }
        }
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
     * @param  \App\Models\PictureDecArch  $pictureDecArch
     * @return \Illuminate\Http\Response
     */
    public function show(PictureDecArch $pictureDecArch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PictureDecArch  $pictureDecArch
     * @return \Illuminate\Http\Response
     */
    public function edit(PictureDecArch $pictureDecArch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PictureDecArch  $pictureDecArch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PictureDecArch $pictureDecArch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PictureDecArch  $pictureDecArch
     * @return \Illuminate\Http\Response
     */
    public function destroy(PictureDecArch $pictureDecArch)
    {
        //
    }
}
