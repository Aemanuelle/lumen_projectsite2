<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use DB;

Class UserController extends Controller {
    use ApiResponser;

    private $request;

    public function __construct(Request $request){
        $this->request = $request;
    }

    public function getUsers()
    {
        $users = DB::connection('mysql')
        ->select("Select * from tbluser");
       
        //return response()->json($users, 200);
        return $this->successResponse($users);
    }

    public function index()
    {
        $users = User::all();
        return $this->successResponse($users);
    }

    public function add (Request $request)
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        $this->validate($request, $rules);
        $user = User::create($request->all());
        return $this->successResponse($user, Response::HTTP_CREATED);
    }

    public function show ($id)
    {
        //$user = User::findOrFail($id);
        $user = User::where('userId', $id)->first();
        if($user){
            return $this->successResponse($user);
        }
        {
            return $this->errorResponse('User ID Does Not Exists', Response::HTTP_NOT_FOUND);
        }
       
    }

    public function update (Request $request, $id)
    {
        //wla sa koy rules

        $user = User::findOrFail($id);
        //$user = User::where('userId',$id)->first();
        //if($user){
            $user->fill($request->all());
            if ($user->isClean()){
          //      return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE);
            }
            $user->save();
            return $this->successResponse($user);
        //}
        //{
            return $this->errorResponse('User ID Does Not Exists', Response::HTTP_NOT_FOUND);
        //}
    }

    public function delete ($id)
    {
        $user = User::findOrFail($id);
            $user->delete();
            return $this->successResponse($user);
    }
}   