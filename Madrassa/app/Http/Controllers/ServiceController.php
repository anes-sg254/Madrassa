<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use Validator;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_all()
    {
        $data = DB::table('services')->get();
        if ($data == null)
        {
            return response()->json(["Empety" => "la table est vide"]);
        }
        else
        {
            return response()->json($data);
        }
    }

    public function index(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,["id_service" => "required"]);
        if ($validator->fails())
        {
            return (new BaseController)->sendError('Please validate your errors',$validator->errors());
        }
        else
        {
            $data = DB::table('services')->where('id_service',$request->input('id_service'))->get();
            if ($data == null)
            {
                return response()->json(["Empety" => "la table est vide"]);
            }
            else
            {
                return response()->json($data);
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

        $input = $request->all();
        $validator = Validator::make($input,[
            'id_categorie' => 'required',
            'name' => 'required',
            'description' => 'required',
            'phone' => 'required',
            'addresse' => 'required'
        ]);
        if ($validator->fails())
        {
            return (new BaseController)->sendError('Please validate your errors',$validator->errors());
        }
        else
        {
            $data = [
                'id_categorie' => $request->input('id_categorie'),
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'phone' => $request->input('phone'),
                'addresse' => $request->input('addresse')
            ];
            $instruction = DB::table('services')->insert($data);


            if ($instruction != 1)
            {
                return response()->json("Service not inserted");
            }
            else
            {
                return (new BaseController)->sendResponse($data,'Service inserted successfully');
            }


        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'id_service' => 'required',
            'id_categorie' => 'required',
            'name' => 'required',
            'description' => 'required',
            'phone' => 'required',
            'addresse' => 'required'
        ]);
        if ($validator->fails())
        {
            return (new BaseController)->sendError('Please validate your errors',$validator->errors());
        }
        else
        {
            $data = [
                'id_categorie' => $request->input('id_categorie'),
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'phone' => $request->input('phone'),
                'addresse' => $request->input('addresse')
            ];
            $instruction = DB::table('services')->where('id_service',$request->input('id_service'))->update($data);


            if ($instruction != 1)
            {
                return response()->json("Service not updated");
            }
            else
            {
                return (new BaseController)->sendResponse($data,'Service updated successfully');
            }
        }

    }



    public function destroy(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'id_service' => 'required'
        ]);
        if ($validator->fails())
        {
            return (new BaseController)->sendError('Please validate your errors',$validator->errors());
        }
        else
        {
            $instruction = DB::table('services')->where('id_service',$request->input('id_service'))->delete();

            if ($instruction != 1)
            {
                return response()->json("Service not deleted");
            }
            else
            {
                return (new BaseController)->sendResponse(['id_service' => $request->input('id_service')],'Service deleted successfully');
            }
        }

    }

}
