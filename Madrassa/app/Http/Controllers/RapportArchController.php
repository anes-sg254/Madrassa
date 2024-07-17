<?php

namespace App\Http\Controllers;

use App\Models\RapportArch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use Validator;


class RapportArchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'id_declaration' => 'required',
        ]);

        if ($validator->fails())
        {
            return (new BaseController)->sendError('Please validate your errors',$validator->errors());
        }
        else{

            $data = DB::table('rapport_arches')->where('id_declaration',$request->input('id_declaration'))->get();
            if ($data != null)
            {
                return response()->json($data);
            }
            else
            {
                return reponse()->json('no rapport');
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
     * @param  \App\Models\RapportArch  $rapportArch
     * @return \Illuminate\Http\Response
     */
    public function show(RapportArch $rapportArch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RapportArch  $rapportArch
     * @return \Illuminate\Http\Response
     */
    public function edit(RapportArch $rapportArch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RapportArch  $rapportArch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RapportArch $rapportArch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RapportArch  $rapportArch
     * @return \Illuminate\Http\Response
     */
    public function destroy(RapportArch $rapportArch)
    {
        //
    }
}
