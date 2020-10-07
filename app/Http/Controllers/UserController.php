<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


use App\Models\User;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response()->json(User::paginate(10),200);
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
                
        $validatedData = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users|max:100',
            'password' => 'required',
        ]);
        
        $dataReturn = Array();
        
        try{
            $user = new User();
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->password = Hash::make($validatedData['password']);
            $user->save();
            
            $dataReturn["message"] = "Success";
        }catch(\Exception $e){ 
            $dataReturn["message"] =  $e->getMessage();
        }
        return response()->json($dataReturn, 200);
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
        return response()->json(User::find($id));
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
                
        $validator = Validator::make($request->all(), [
            'name'  => 'required|max:100',
            'email' => [
                'required',
                'max:100',
                'email',                
                Rule::unique('users')->ignore($id),
            ],
        ]);
        
        if ($validator->fails()) { 
            $dataReturn["message"] = "The given data was invalid.";
            $dataReturn["errors"] = $validator->messages();
            return response()->json($dataReturn, 422); 
        }
        
        $dataReturn = Array();
        try{
            $user = User::find($id);
            if($user->count() > 0){
                $user->update(Array(
                    'name' => $request->name,
                    'email' => $request->email
                ));
            } 
            
            $dataReturn["message"] = "Success";
        }catch(\Exception $e){ 
            $dataReturn["message"] =  $e->getMessage();
        }
        return response()->json($dataReturn, 200);
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
        $dataReturn = Array();
        try{
            $user = User::find($id);
            $user->delete(); 
            
            $dataReturn["message"] = "Success";
        }catch(\Exception $e){ 
            $dataReturn["message"] =  $e->getMessage();
        }
        
        return response()->json($dataReturn, 200);
    }
}
