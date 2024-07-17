<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use Validator;

class AnnonceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAll()
    {
        $data = DB::table('annonces')->where('state','valide')->get();
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
            $data = DB::table('annonce')->where('user_id',$request->input('user_id'))
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
        $input = $request->all();
        //$id = Auth::user()->id();
        $validator = Validator::make($input,[
            'name' => 'required',
            'description' => 'required',
            'date' => 'required',
            'user_id' => 'required'
        ]);
        if ($validator->fails()){
            return (new BaseController)->sendError("Please validate errors", $validator->errors());
        }
        else{
            $data = [
                        'id_annonce' => DB::table('annonces')->max('id_annonce') + 1,
                        'user_id'=> $request->input('user_id'),
                        'name' => $request->input('name'),
                        'description' => $request->input('description'),
                        'date' => $request->input('date'),
            ];
            $isrt = DB::table('annonces')->insert($data);
            if ($isrt == 1)
            {
                return (new BaseController)->sendResponse($data,'annonce created successfully');

                //can't delete user
                $it = DB::table('users')->where('id',$request->input('user_id'))
                                        ->update(["can_delete" => false]);

            }
            else
            {
                return (new BaseController)->sendResponse($data,'Error : annonce not created');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Annonce  $annonce
     * @return \Illuminate\Http\Response
     */
    public function show(Annonce $annonce)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Annonce  $annonce
     * @return \Illuminate\Http\Response
     */
    public function edit(Annonce $annonce)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Annonce  $annonce
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'id_annonce' => 'required',
            'name' => 'required',
            'description' => 'required',
            'date' => 'required'
        ]);
        if ($validator->fails()){
            return (new BaseController)->sendError("Please validate errors", $validator->errors());
        }
        else{
            $data = [
                        'name' => $request->input('titre'),
                        'description' => $request->input('description'),
                        'date' => $request->input('lieu')
            ];
            $isrt = DB::table('annonces')->where('id_annonce',$request->input('id_annonce'))->update($data);

            if ($isrt == 1)
            {
                return (new BaseController)->sendResponse(response()->json($data),'annonce updated successfully');
            }
            else
            {
                return (new BaseController)->sendResponse(response()->json($data),'Error : annonce not exist');
            }
        }

    }


    public function updateState(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'id_annonce' => 'required',
            'state' => 'required'
        ]);
        if ($validator->fails()){
            return (new BaseController)->sendError("Please validate errors", $validator->errors());
        }
        else{
            $data = [
                        'state' => $request->input('state')
            ];
            $isrt = DB::table('annonces')->where('id_annonce',$request->input('id_annonce'))->update($data);
            if ($isrt == 1)
            {
                return (new BaseController)->sendResponse(response()->json($data),'annonce state updated successfully');
            }
            else
            {
                return (new BaseController)->sendResponse(response()->json($data),'Error : annonce not exist');
            }
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Annonce  $annonce
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'id_annonce' => 'required',
        ]);
        if ($validator->fails()){
            return (new BaseController)->sendError("Please validate errors", $validator->errors());
        }
        else{
            $dec = DB::table('annonces')->where('id_annonce',$request->input('id_annonce'))->get();
            $dec = json_decode($dec,true);

            if ($dec[0]['state'] == "en_cour")
            {
                return response()->json('On peux pas supprimer la procedure est encour');
            }
            else
            {

                 //insert into table archive

                //insert annonce
                $data = [
                    'id_annonce' => DB::table('annonce_arches')->max('id_annonce') + 1,
                    'user_id'=> $dec[0]['user_id'],
                    'name' => $dec[0]['name'],
                    'description' => $dec[0]['description'],
                    'date' => $dec[0]['date'],
                    'state' => $dec[0]['state']
                ];
                $isrt = DB::table('annonce_arches')->insert($data);

                if ($isrt == 0)
                {
                    return response()->json("declaration not iserted");
                }


                //insert pictures

                $pictures = DB::table('picture_anns')->where('id_annonce',$request->input('id_annonce'))->get();
                $picture1 = json_decode($pictures,true);
                $i = 0;
                foreach ($pictures as $picture)
                {

                    $pic = [
                        'id_annonce' => $picture1[$i]['id_annonce'],
                        'picture' => $picture1[$i]['picture']
                    ];

                    $isrt1 = DB::table('picture_ann_arches')->insert($pic);

                    if ($isrt1 == 0)
                    {
                        return response()->json("picture not iserted");
                    }

                    $i++;
                }



                //delete from current table
                $dlt = DB::table('annonces')->where('id_annonce',$request->input('id_annonce'))->delete();
                if ($dlt == 1)
                {
                    return (new BaseController)->sendResponse(response()->json(["id_annonce" => $request->input('id_annonce')]),'annonce deleted successfully');
                }
                else
                {
                    return (new BaseController)->sendResponse($data,'annonce not exist');
                }
            }

        }

    }
}
