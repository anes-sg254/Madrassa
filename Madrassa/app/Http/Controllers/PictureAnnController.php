<?php

namespace App\Http\Controllers;

use App\Models\PictureAnn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\BaseController;
use Validator;

class PictureAnnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexIdAnn()
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

            $data = DB::table('picture_anns')->where('id_annonce',$request->input('id_annonce'))->get();
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
        $input = $request->all();
        $validator = Validator::make($input,[
            'id_annonce' => 'required'

        ]);

        if ($validator->fails())
        {
            return (new BaseController)->sendError('Please validate your errors',$validator->errors());
        }
        else
        {

            $image = $request->file('image');
            if ($request->hasFile('image'))
            {

                $new_name = time().'.'.$image->getClientOriginalExtension();
                $data = [
                    'id_annonce' => $request->input('id_annonce'),
                    'picture' => $new_name
                ];

                $inst = DB::table('picture_anns')->where('id_annonce',$request->input('id_annonce'))->insert($data);

                if ($inst == 1)
                {
                    $image->move(public_path('/uploads/images'),$new_name);
                    return (new BaseController)->sendResponse(response()->json($data),'uploaded picture successfully');
                }
                else
                {
                    return response()->json('no inserted');
                }
            }
            else
            {
                return response()->json('image null');
            }

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PictureAnn  $pictureAnn
     * @return \Illuminate\Http\Response
     */
    public function show(PictureAnn $pictureAnn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PictureAnn  $pictureAnn
     * @return \Illuminate\Http\Response
     */
    public function edit(PictureAnn $pictureAnn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PictureAnn  $pictureAnn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PictureAnn $pictureAnn)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'id_annonce' => 'required',
            'picture' => 'required'
        ]);

        if ($validator->fails())
        {
            return (new BaseController)->sendError('Please validate your errors',$validator->errors());
        }
        else
        {
            $pic= DB::table('picture_anns') ->where('id_annonce',$request->input('id_annonce'))
                                            ->where('picture',''.$request->input('picture'))
                                            ->get();
            if ($pic != null)
            {
                if ($request->hasfile('image'))
                {
                    $destination = 'uploads/images/'.$request->input('picture');
                    if (File::exists($destination))
                    {
                        $file = $request->file('image');
                        $extension = $file->getClientOriginalExtension();
                        $filename = time().'.'.$extension;

                        $data = [
                            "id_annonce" => $request->input('id_annonce'),
                            "picture" => $filename
                        ];
                        $inst = DB::table('picture_anns')->where('id_annonce',$request->input('id_annonce'))
                                                            ->where('picture',$request->input('picture'))
                                                            ->update($data);
                        if ($inst == 1)
                        {
                            File::delete($destination);
                            $file->move(public_path('/uploads/images'),$filename);
                            return (new BaseController)->sendResponse(response()->json($data),'updated picture successfully');
                        }
                        else
                        {
                            return response()->json('no inserted');
                        }
                    }
                    else
                    {
                        return response()->json('picture not exists');
                    }
                }
                else
                {
                    return response()->json('please select a picture');
                }
            }
            else
            {
                return response()->json('new picture not exists');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PictureAnn  $pictureAnn
     * @return \Illuminate\Http\Response
     */
    public function destroy(PictureAnn $pictureAnn)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'id_annonce' => 'required',
            'picture' => 'required'
        ]);

        if ($validator->fails())
        {
            return (new BaseController)->sendError('Please validate your errors',$validator->errors());
        }
        else
        {
            $inst = DB::table('picture_anns')->where('id_annonce',$request->input('id_annonce'))
                                    ->where('picture',$request->input('picture'))
                                    ->get();

            if ($inst != null)
            {
                $destination = 'uploads/images/'.$request->input('picture');
                if (File::exists($destination))
                {
                    $it = DB::table('picture_anns')->where('id_annonce',$request->input('id_annonce'))
                                                    ->where('picture',$request->input('picture'))
                                                    ->delete();
                    if ($it == 1)
                    {
                        File::delete($destination);
                        return (new BaseController)->sendResponse(response()->json($inst),'deleted picture successfully');

                    }
                    else
                    {
                        return response()->json('picture not delete from DB');
                    }
                }
                else
                {
                    return response()->json('picture not exists in file');
                }
            }
            else
            {
                return response()->json('picture not exists');
            }

        }


    }
}
