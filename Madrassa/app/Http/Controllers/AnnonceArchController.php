<?php

namespace App\Http\Controllers;

use App\Models\AnnonceArch;
use Illuminate\Http\Request;

class AnnonceArchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAll()
    {
        $data = DB::table('annonce_arches')->where('state','valide')->get();
        return (new BaseController)->sendResponse(
                                      response()->json($data),
                                      'All Annonces');
    }
    public function indexSelf(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'user_id' => 'required',
        ]);
        if ($validator->fails())
        {
            return (new BaseController)->sendError("Please validate errors", $validator->errors());
        }
        else
        {
            $data = DB::table('annonce_arches')->where('user_id',$request->input('user_id'))
                                             ->where('state','valide')
                                             ->get();
            return (new BaseController)->sendResponse(
                                            response()->json($data),
                                            'Self Declarations');
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
     * @param  \App\Models\AnnonceArch  $annonceArch
     * @return \Illuminate\Http\Response
     */
    public function show(AnnonceArch $annonceArch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AnnonceArch  $annonceArch
     * @return \Illuminate\Http\Response
     */
    public function edit(AnnonceArch $annonceArch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AnnonceArch  $annonceArch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AnnonceArch $annonceArch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AnnonceArch  $annonceArch
     * @return \Illuminate\Http\Response
     */
    public function destroy(AnnonceArch $annonceArch)
    {
        //
    }
}
