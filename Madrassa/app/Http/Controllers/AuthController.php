<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\DB;
use Symfony\Component\VarDumper\Cloner\Data;
use App\Http\Controllers\BaseController;
use Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate(
            [
                'name' => 'required',
                'email' => 'required',
                'role' => 'required',
                'password' => 'required',
            ]
        );

        $user = User::create(
            [
                'name' => $fields['name'],
                'email' => $fields['email'],
                'role' => $fields['role'],
                'password' => bcrypt($fields['password']),
            ]
        );

        $token = $user->createToken('MyAppTest')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 201);
    }


    public function login(Request $request)
    {
        $fields = $request->validate(
            [
                'email' => 'required',
                'password' => 'required',
            ]

        );

        $user = User::where('email', $fields['email'])->first();
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response(['message' => 'Bad creds',], 401);
        }

        $token = $user->createToken('MyAppTest')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 201);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }

    public function sendCode(Request $request)
    {
        $code = generatePIN();
        $email = $request->all()['email'];
        //send email with verification code
        Mail::to($email)->send(new VerificationMail($code));
        return ['code' => $code];
    }

    public function getUsers()
    {
        $data = User::all();
        return $data;
    }

    public function getResponsables()
    {
        $data = DB::select('select * from users where role != \'simple\' ', [1]);
        return $data;
    }
    public function deleteUser(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'id' => 'required'
        ]);

        if ($validator->fails())
        {
            return (new BaseController)->sendError('Please validate your errors',$validator->errors());
        }
        else
        {
            $usr = DB::table('users')->where('id',$request->input('id'))->get('can_delete');
            $can_delet = json_decode($usr);
            $can_delet = $can_delet[0]['can_delete'];
            if ($can_delet == true)
            {
                $instruction = DB::table('users')->where('id',$request->input('id'))->delete();
                if ($instruction != 1)
                {
                    return response()->json('not deleted');
                }
                else
                {
                    return (new BaseController)->sendResponse(["id" => $request->input('id')], 'user deleted successfully');
                }

            }
        }
    }
}

function generatePIN($digits = 4)
{
    $i = 0; //counter
    $pin = ""; //our default pin is blank.
    while ($i < $digits) {
        //generate a random number between 0 and 9.
        $pin .= mt_rand(0, 9);
        $i++;
    }
    return strval($pin);
}
