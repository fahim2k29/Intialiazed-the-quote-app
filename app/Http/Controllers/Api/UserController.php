<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{


    public function getAccessToken(Request $request)
    {
        $validator = $this->checkUserValidators($request->all());
        if ($validator->fails()){
            return response()->json([
                'errors' => $validator->errors(),
            ],422);
        }

        DB::beginTransaction();
        try {
            $apiUser = User::query()->where('email',$request->email)->first();
            @$checkPassword = Hash::check($request->password, $apiUser->user->password);
                if ($apiUser && $checkPassword == true){
                    $emailName = explode('@',$request->email)[0];
                    $plainToken =Str::random(8).$emailName.Str::random(8).'@'.$apiUser->user->id;
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

    protected function checkUserValidators(array $data)
    {
        $rules = [
            'email'          => 'required',
            'password'       => 'required',
        ];

        $messages = [
            'email.required'    => 'ইমেইল তথ্যটি আবশ্যক।',
            'password.required' => 'পাসওয়ার্ড তথ্যটি আবশ্যক।',
        ];

        return Validator::make($data,$rules,$messages);
    }



    public function index()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
