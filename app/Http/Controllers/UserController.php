<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //

    public function self()
    {
        $user = User::find(auth()->user()->id);
        $token = $user->createToken('authToken')->accessToken;
        return response(['user' => $user, 'access_token' => $token]);
    }

    public function index()
    {
        return view('users');
    }
    public function login(Request $request)
    {
        // return $request;
        $login = $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();

        // return $user;
        if (!Auth::attempt($login)) {
            return response(['message' => 'login Credentials are incorrect'], 401);
        }
        $token = $user->createToken('authToken')->accessToken;
        return response(['user' => Auth::user(), 'access_token' => $token]);
    }

    public function addRegister(Request $request) {
        $data = new User;

        $data->stud_no = $request->stud_no;
        $data->last_name = $request->last_name;
        $data->first_name = $request->first_name;
        $data->mid_name = $request->mid_name;
        $data->suffix = $request->suffix;
        $data->program = $request->program;
        $data->dobirth = $request->dobirth;
        $data->sex = $request->sex;
        $data->brgy = $request->brgy;
        $data->town = $request->town;
        $data->province = $request->province;
        $data->parent_first = $request->parent_first;
        $data->parent_last = $request->parent_last;
        $data->parent_mid = $request->parent_mid;
        $data->save();

        return $data;
    }

    public function displayStudent(){
        $data = User::where('user_type', 0)->get();
        return $data;
    }

    public function displaySubjects(){
        $data = User::with('record')->get();
        return $data;
    }

    public function editStudent($id, Request $request) {
        $data = User::find($id);

        $data->stud_no = $request->stud_no;
        $data->last_name = $request->last_name;
        $data->first_name = $request->first_name;
        $data->mid_name = $request->mid_name;
        $data->suffix = $request->suffix;
        $data->program = $request->program;
        $data->dobirth = $request->dobirth;
        $data->sex = $request->sex;
        $data->brgy = $request->brgy;
        $data->town = $request->town;
        $data->province = $request->province;
        $data->parent_first = $request->parent_first;
        $data->parent_last = $request->parent_last;
        $data->parent_mid = $request->parent_mid;
        $data->save();

        return $data;
    }

    public function deleteStudent($id){
        $data = User::where('id', $id)->delete();
        return $data;
    }

}
