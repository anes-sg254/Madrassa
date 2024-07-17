<?php

namespace App\Http\Controllers;

use App\Models\Rapport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use Validator;

class RapportController extends Controller
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

            $data = DB::table('rapports')->where('id_declaration',$request->input('id_declaration'))->get();
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
        $input = $request->all();
        $validator = Validator::make($input,[
            'id_declaration' => 'required'
        ]);

        if ($validator->fails())
        {
            return (new BaseController)->sendError('Please validate your errors',$validator->errors());
        }
        else
        {

            $file = $request->file('file');
            if ($request->hasFile('file'))
            {

                $new_name = time().'.'.$file->getClientOriginalExtension();
                $data = [
                    'id_rapport' => DB::table('rapports')->max('id_rapport') + 1,
                    'id_declaration' => $request->input('id_declaration'),
                    'file' => $new_name
                ];



                $inst = DB::table('rapports')->where('id_declaration',$request->input('id_declaration'))->insert($data);

                if ($inst == 1)
                {
                    $file->move(public_path('/uploads/rapports'),$new_name);
                    return (new BaseController)->sendResponse(response()->json($data),'uploaded rapport successfully');
                }
                else
                {
                    return response()->json('no inserted');
                }

            }
            else
            {
                return response()->json('rapport null');
            }
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rapport  $rapport
     * @return \Illuminate\Http\Response
     */
    public function show(Rapport $rapport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rapport  $rapport
     * @return \Illuminate\Http\Response
     */
    public function edit(Rapport $rapport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rapport  $rapport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'id_declaration' => 'required',
            'file1' => 'required'
        ]);

        if ($validator->fails())
        {
            return (new BaseController)->sendError('Please validate your errors',$validator->errors());
        }
        else
        {
            $pic= DB::table('rapports') ->where('id_declaration',$request->input('id_declaration'))
                                            ->where('file',''.$request->input('file1'))
                                            ->get();
            if ($pic != null)
            {
                if ($request->hasfile('file'))
                {
                    $destination = 'uploads/rapports/'.$request->input('file1');
                    if (File::exists($destination))
                    {
                        $file = $request->file('file');
                        $extension = $file->getClientOriginalExtension();
                        $filename = time().'.'.$extension;

                        $data = [
                            "id_declaration" => $request->input('id_declaration'),
                            "file" => $filename
                        ];
                        $inst = DB::table('rapports')->where('id_declaration',$request->input('id_declaration'))
                                                            ->where('file',$request->input('file1'))
                                                            ->update($data);
                        if ($inst == 1)
                        {
                            File::delete($destination);
                            $file->move(public_path('/uploads/rapports'),$filename);
                            return (new BaseController)->sendResponse(response()->json($data),'updated rapport successfully');
                        }
                        else
                        {
                            return response()->json('no inserted');
                        }
                    }
                    else
                    {
                        return response()->json('rapport not exists');
                    }
                }
                else
                {
                    return response()->json('please select a rapport');
                }
            }
            else
            {
                return response()->json('new rapport not exists');
            }
        }
    }



    public function updateState(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'id_declaration' => 'required',
            'file1' => 'required',
            'new_state' => 'required'
        ]);

        if ($validator->fails())
        {
            return (new BaseController)->sendError('Please validate your errors',$validator->errors());
        }
        else
        {
            $data = [
                        "id_declaration" => $request->input('id_declaration'),
                        "file" => $request->input('file1'),
                        "state" => $request->input('new_state')
                    ];

            $inst = DB::table('rapports')->where('id_declaration',$request->input('id_declaration'))
                                        ->where('file',$request->input('file1'))
                                        ->update($data);
            if ($inst == 1)
            {
                return (new BaseController)->sendResponse(response()->json($data),'state updated successfully');
            }
            else
            {
                return response()->json('state not updated');
            }

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rapport  $rapport
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'id_declaration' => 'required',
            'file' => 'required'
        ]);

        if ($validator->fails())
        {
            return (new BaseController)->sendError('Please validate your errors',$validator->errors());
        }
        else
        {
            $inst = DB::table('rapports')->where('id_declaration',$request->input('id_declaration'))
                                    ->where('file',$request->input('file'))
                                    ->get();

            if ($inst != null)
            {
                $destination = 'uploads/rapports/'.$request->input('file');
                if (File::exists($destination))
                {
                    $it = DB::table('rapports')->where('id_declaration',$request->input('id_declaration'))
                                                    ->where('file',$request->input('file'))
                                                    ->delete();
                    if ($it == 1)
                    {
                        File::delete($destination);
                        return (new BaseController)->sendResponse(response()->json($inst),'deleted rapport successfully');

                    }
                    else
                    {
                        return response()->json('rapport not delete from DB');
                    }
                }
                else
                {
                    return response()->json('rapport not exists in file');
                }
            }
            else
            {
                return response()->json('rapport not exists');
            }

        }

    }
}
