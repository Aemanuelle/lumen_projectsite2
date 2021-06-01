<?php

namespace App\Http\Controllers;

use App\Models\UserJob;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use DB;

class UserJobController extends Controller {

    use ApiResponser;

    private $request;

    public function __construct(Request $request){
        $this->request = $request;  
    }

    public function index()
    {
       $usersjob = UserJob::all();
       return $this->successResponse($usersjob);
    }

    public function add (Request $request)
    {
            $rules = [
                'username' => 'required|max:20',
                'password' => 'required|max:20',
                'jobid' => 'required|numeric|min:1|not_in:0',
            ];
            $this->validate($request,$rules);

            $userjob = UserJob::findOrFail($request->jobid);

            $user = User::create($request->all());
            return $this->successResponse($user, Response::HTTP_CREATED);
    }

    public function show ($id)
    {
       $userjob = UserJob::findOrFail($id);
       return $this->successResponse($userjob); 
    }

    public function update (Request $request, $id)
    {
       $rules = [
           'username' =>'max:20',
           'password' =>'max:20',
           'jobid' => 'required|numeric|min:1|not_in:0',
       ];
       $this->validate($request, $rules);
       $userjob = UserJob::findOrFail($request->jobid);
       $user = User::findOrFail($id);
       $user->fill($request->all());

       if ($user->isClean()){
           return $this->errorResponse('At least one value must change',
           Response::HTTP_UNPROCESSABLE_ENTITY);
       }

       $user->save();
       return $this->successResponse($user);
    }

    public function delete ($id)
    {
       
    }

}

