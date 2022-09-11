<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function getAccessToken(Request $request)
    {
        $request->validate([
            'email'    => 'required',
            'password' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $apiUser = User::query()->where('email',$request->email)->first();
            @$checkPassword = Hash::check($request->password, $apiUser->password);
            if ($apiUser && $checkPassword == true){
                $emailName = explode('@',$request->email)[0];
                $plainToken =Str::random(8).$emailName.Str::random(8).'@'.$apiUser->id;
                $hashedToken = Hash::make($plainToken);
                $apiUser->access_token = $hashedToken;
                $apiUser->save();
                DB::commit();
                return response()->json([
                    'message' => 'Please Store this below TOKEN to use later along with API calls',
                    'Your token: ' => $hashedToken,
                ],201);
            } else{
                return response()->json(['message'=>'You are not a valid user. Check your Email or Password'],406);
            }
        }
        catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'errors'  => $e->getMessage(),
            ], 422);
        }
    }

    /*protected function checkUserValidators(array $data)
    {
        $rules = [
            'email'          => 'required',
            'password'       => 'required',
        ];

        $messages = [
            'email.required'    => 'ইমেইল তথ্যটি আবশ্যক।',
            'password.required' => 'পাসওয়ার্ড তথ্যটি আবশ্যক।',
        ];

        return validator::make($data,$rules,$messages);
    }*/

}
