<?php

namespace App\Http\Controllers;

use App\Http\Resources\S1\User\UserCollection;
use App\Http\Resources\S1\User\UserSingleResource;
use App\Models\User;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = User::latest('id')->paginate($request->query('page',15));
        // $user = $user->paginate($request->page,$request->per_page);
        return response()->json(
            [
                'user'=> $user,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs['uuid'] = Uuid::uuid4();
        $inputs['name'] = $request->name;
        $inputs['email'] = $request->email;
        $inputs['sex'] = $request->sex;
        $inputs['phone']=$request->phone;
        $inputs['password'] =$request->password;

        $user = User::create($inputs);
        if ($user) {
        return response()->json([
            // 'user'=> $user,
            'message'=>'insert successfully'
            ]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // return new UserSingleResource($user);
        // return new UserCollection($user);
        return new UserSingleResource($user);
        // return $user;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,User $user)
    {   
        $inputs['uuid'] = Uuid::uuid4();
        $inputs['name'] = $request->name;
        $inputs['email'] = $request->email;
        $inputs['sex'] = $request->sex;
        $inputs['phone']=$request->phone;

        if( $user ){
            $user = $user->update($inputs);
            return response()->json([
                'user'=> $user,
                'message'=>'update successfully'
            ]);
        }else{
            return response()->json([
                'message'=>'data not found'
            ]);
        }
    }
    public function updateByUUID(Request $request, $uuid){


        $user = User::where('uuid','=',$uuid)->get()->first();

        // return response()->json([
        //     'data'=>"Ok"
        // ]);


        $inputs['name'] = $request->name;
        $inputs['email'] = $request->email;
        $inputs['sex'] = $request->sex;
        $inputs['phone'] = $request->phone;
        if($user){
            $user->update($inputs);
            return response()->json([
                'message'=>"update by UUID Successfully"
            ]); 
        }else{
            return response()->json([
                'message'=>"data UUID not found"
            ]); 
        }
    }

    public function deleteByUUID(Request $request, $uuid){
        // return "Delete deleteByUUID";
        // return [
        //     'data'=>$user
        // ];
        $user = User::where('uuid','=',$uuid)->get()->first();
        if($user){
            $user->delete();
            return response()->json([
                'message'=>"delete by UUID Successfully"
            ]); 
        }else{
            return response()->json([
                'message'=>"data UUID not found"
            ]); 
        }
    }
    public function destroy(string $id, User $user)
    {
        $user = $user->delete();
        if($user){
            return response()->json([
                'message'=>"delete Successfully"
            ]); 
        }
    }
}