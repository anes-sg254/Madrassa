<?php

namespace App\Http\Controllers;

use App\Models\PictureAnnArch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\BaseController;
use Validator;

class PictureAnnArchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexIdAnn(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'id_annonce' => 'required'
        ]);

        if ($validator->fails())
        {
            return (new BaseController)->sendError('Please validate your errors',$validator->errors());
        }
        else{

            $data = DB::table('picture_ann_arches')->where('id_annonce',$request->input('id_annonce'))->get();
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
     * @param  \App\Models\PictureAnnArch  $pictureAnnArch
     * @return \Illuminate\Http\Response
     */
    public function show(PictureAnnArch $pictureAnnArch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PictureAnnArch  $pictureAnnArch
     * @return \Illuminate\Http\Response
     */
    public function edit(PictureAnnArch $pictureAnnArch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PictureAnnArch  $pictureAnnArch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PictureAnnArch $pictureAnnArch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PictureAnnArch  $pictureAnnArch
     * @return \Illuminate\Http\Response
     */
    public function destroy(PictureAnnArch $pictureAnnArch)
    {
        //
    }
}
