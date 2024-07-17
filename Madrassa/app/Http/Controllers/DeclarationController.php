<?php

namespace App\Http\Controllers;

use App\Models\Declaration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use Validator;


class DeclarationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAll()
    {
        $data = DB::table('declarations')->where('state','valide')->get();
        return (new BaseController)->sendResponse(
                                      response()->json($data),
                                      'All Declarations');
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
            $data = DB::table('declarations')->where('user_id',$request->input('user_id'))
                                             ->where('state','valide')
                                             ->get();
            return (new BaseController)->sendResponse(
                                            response()->json($data),
                                            'Self Declarations');
        }
    }


    public function index_service(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'service' => 'required',
        ]);
        if ($validator->fails()){
            return (new BaseController)->sendError("Please validate errors", $validator->errors());
        }
        else
        {
        $data = DB::table('declarations')->where('service',$request->input('service'))
                                         ->where('state','valide')
                                         ->get();
        return (new BaseController)->sendResponse(
                                      DeclarationResources::collection($data),
                                      'service Declarations');
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
            'titre' => 'required',
            'description' => 'required',
            'lieu' => 'required',
            'idCategorie' => 'required',
            'user_id' => 'required'
        ]);
        if ($validator->fails()){
            return (new BaseController)->sendError("Please validate errors", $validator->errors());
        }
        else{
            $data = [
                        'id_declaration' => DB::table('declarations')->max('id_declaration') + 1,
                        'user_id'=> $request->input('user_id'),
                        'titre' => $request->input('titre'),
                        'description' => $request->input('description'),
                        'lieu' => $request->input('lieu'),
                        'idCategorie' => $request->input('idCategorie'),
            ];
            $isrt = DB::table('declarations')->insert($data);
            if ($isrt == 1)
            {
                return (new BaseController)->sendResponse($data,'declaration created successfully');

                //can't delete user
                $it = DB::table('users')->where('id',$request->input('user_id'))
                                        ->update(["can_delete" => false]);

            }
            else
            {
                return (new BaseController)->sendResponse($data,'Error : declaration not created');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Declaration  $declaration
     * @return \Illuminate\Http\Response
     */
    public function show(Declaration $declaration)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Declaration  $declaration
     * @return \Illuminate\Http\Response
     */
    public function edit(Declaration $declaration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Declaration  $declaration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'id_declaration' => 'required',
            'titre' => 'required',
            'description' => 'required',
            'lieu' => 'required',
            'idCategorie' => 'required'
        ]);
        if ($validator->fails()){
            return (new BaseController)->sendError("Please validate errors", $validator->errors());
        }
        else{
            $data = [
                        'titre' => $request->input('titre'),
                        'description' => $request->input('description'),
                        'lieu' => $request->input('lieu'),
                        'idCategorie' => $request->input('idCategorie')
            ];
            $isrt = DB::table('declarations')->where('id_declaration',$request->input('id_declaration'))->update($data);

            if ($isrt == 1)
            {
                return (new BaseController)->sendResponse(response()->json($data),'declaration updated successfully');
            }
            else
            {
                return (new BaseController)->sendResponse(response()->json($data),'Error : declaration not exist');
            }
        }
    }


    public function updateState(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'id_declaration' => 'required',
            'state' => 'required'
        ]);
        if ($validator->fails()){
            return (new BaseController)->sendError("Please validate errors", $validator->errors());
        }
        else{
            $data = [
                        'state' => $request->input('state')
            ];
            $isrt = DB::table('declarations')->where('id_declaration',$request->input('id_declaration'))->update($data);
            if ($isrt == 1)
            {
                return (new BaseController)->sendResponse(response()->json($data),'declaration state updated successfully');
            }
            else
            {
                return (new BaseController)->sendResponse(response()->json($data),'Error : declaration not exist');
            }
        }
    }


    public function attacheService(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'id_declaration' => 'required',
            'service' => 'required'
        ]);
        if ($validator->fails()){
            return (new BaseController)->sendError("Please validate errors", $validator->errors());
        }
        else{
            $data = [
                        'service' => $request->input('service')
            ];
            $isrt = DB::table('declarations')->where('id_declaration',$request->input('id_declaration'))->update($data);
            if ($isrt == 1)
            {
                return (new BaseController)->sendResponse(response()->json($data),'declaration service updated successfully');
            }
            else
            {
                return (new BaseController)->sendResponse(response()->json($data),'Error : declaration not exist');
            }}
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Declaration  $declaration
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'id_declaration' => 'required',
        ]);
        if ($validator->fails()){
            return (new BaseController)->sendError("Please validate errors", $validator->errors());
        }
        else{
            $dec = DB::table('declarations')->where('id_declaration',$request->input('id_declaration'))->get();
            $dec = json_decode($dec,true);
            $dec1 = $dec[0]['state'];
            if ($dec1 == "en_cour")
            {
                return response()->json('On peux pas supprimer la procedure de réglage est encour');
            }
            else
            {
                //insert into table archive

                //insert declaration
                $data = [
                    'id_declaration' => DB::table('declaration_arches')->max('id_declaration') + 1,
                    'user_id'=> $dec[0]['user_id'],
                    'titre' => $dec[0]['titre'],
                    'description' => $dec[0]['description'],
                    'lieu' => $dec[0]['lieu'],
                    'idCategorie' => $dec[0]['idCategorie']
                ];
                $isrt = DB::table('declaration_arches')->insert($data);

                if ($isrt == 0)
                {
                    return response()->json("declaration not iserted");
                }


                //insert pictures

                $pictures = DB::table('picture_decs')->where('id_dec',$request->input('id_declaration'))->get();
                $picture1 = json_decode($pictures,true);
                $i = 0;
                foreach ($pictures as $picture)
                {

                    $pic = [
                        'id_dec' => $picture1[$i]['id_dec'],
                        'picture' => $picture1[$i]['picture']
                    ];

                    $isrt1 = DB::table('picture_dec_arches')->insert($pic);

                    if ($isrt1 == 0)
                    {
                        return response()->json("picture not iserted");
                    }

                    $i++;
                }


                //insert rapport
                $rapports = DB::table('rapports')->where('id_declaration',$request->input('id_declaration'))->get();
                $rapport = json_decode($rapports,true);
                $rap = [
                    'id_rapport' => $rapport[0]['id_rapport'],
                    'id_declaration' => $rapport[0]['id_declaration'],
                    'file' => $rapport[0]['file'],
                    'state' => $rapport[0]['state']
                ];
                $isrt2 = DB::table('rapport_arches')->insert($rap);
                if ($isrt2 == 0)
                {
                    return response()->json("rapport not iserted");
                }







                //delete from current table
                $dlt = DB::table('declarations')->where('id_declaration',$request->input('id_declaration'))->delete();
                if ($dlt == 1)
                {
                    return (new BaseController)->sendResponse(response()->json(["id_declaration" => $request->input('id_declaration')]),'declaration deleted successfully');
                }
                else
                {
                    return (new BaseController)->sendResponse(new DeclarationResources($data),'declaration not exist');
                }
            }

        }
    }
}
