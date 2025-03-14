<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserApiController extends Controller
{
    public function getUser($id = null)
    {
        if ($id == '') {
            $users = User::get();
            return response()->json(['users' => $users], 200);
        } else {
            $users = User::find($id);
            return response()->json(['users' => $users], 200);
        }
    }

    // post API for add single user
    public function addUser(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
            ];

            $customMessage = [
                'name.required' => 'Name is required',
                'email.required' => 'Email is required',
                'email.email' => 'Email must be a valid email',
                'password.required' => 'Password is required',
            ];

            $validator = Validator::make($data, $rules, $customMessage);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->save();
            $message = "User Successfully Created";
            return response()->json(['message' => $message], 201);
        }
    }

    // post API for  add multiple users
    public function addMultipleUsers(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'users.*.name' => 'required',
                'users.*.email' => 'required|email|unique:users',
                'users.*.password' => 'required',
            ];

            $customMessage = [
                'users.*.name.required' => 'Name is required',
                'users.*.email.required' => 'Email is required',
                'users.*.email.email' => 'Email must be a valid email',
                'users.*.password.required' => 'Password is required',
            ];

            $validator = Validator::make($data, $rules, $customMessage);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            foreach ($data['users'] as $value) {
                $user = new User();
                $user->name = $value['name'];
                $user->email = $value['email'];
                $user->password = bcrypt($value['password']);
                $user->save();
                $message = "User Successfully Created";
            }
            return response()->json(['message' => $message], 201);
        }
    }

    // put API for update user details
    public function updateUser(Request $request, $id)
    {
        if ($request->isMethod('put')) {
            $data = $request->all();

            $rules = [
                'name' => 'required',
                'password' => 'required',
            ];

            $customMessage = [
                'name.required' => 'Name is required',
                'password.required' => 'Password is required',
            ];

            $validator = Validator::make($data, $rules, $customMessage);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $user = User::findOrFail($id);
            $user->name = $data['name'];
            $user->password = bcrypt($data['password']);
            $user->save();
            $message = "User Successfully Updated";
            return response()->json(['message' => $message], 202);
        }
    }

    // patch API for update user details
    public function updateSingleUser(Request $request, $id)
    {
        if ($request->isMethod('patch')) {
            $data = $request->all();

            $rules = [
                'name' => 'required',
            ];

            $customMessage = [
                'name.required' => 'Name is required',
            ];

            $validator = Validator::make($data, $rules, $customMessage);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $user = User::findOrFail($id);
            $user->name = $data['name'];
            $user->save();
            $message = "User Successfully Updated";
            return response()->json(['message' => $message], 202);
        }
    }

    // delete API for delete single user
    public function deleteSingleUser($id = null)
    {
        User::findOrFail($id)->delete();
        $message = "User Successfully Deleted";
        return response()->json(['message' => $message], 200);
    }

    // delete API for delete single user with JSON
    public function deleteSingleJsonUser(Request $request)
    {
        if ($request->isMethod('delete')) {
            $data = $request->all();
            User::where('id', $data['id'])->delete();
            $message = "User Successfully Deleted";
            return response()->json(['message' => $message], 200);
        }
    }

    // delete API for delete multiple users
    public function deleteMultipleUser($ids)
    {
        $ids = explode(',', $ids);
        User::whereIn('id', $ids)->delete();
        $message = "User Successfully Deleted";
        return response()->json(['message' => $message], 200);
    }

    // delete API for delete multiple users with JSON
    public function deleteMultipleJsonUser(Request $request)
    {
        if ($request->isMethod('delete')) {
            $data = $request->all();
            User::whereIn('id', $data['ids'])->delete();
            $message = "User Successfully Deleted";
            return response()->json(['message' => $message], 200);
        }
    }

    // register user using passport
    public function registerUserUsingPassport(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
            ];

            $customMessage = [
                'name.required' => 'Name is required',
                'email.required' => 'Email is required',
                'email.email' => 'Email must be a valid email',
                'password.required' => 'Password is required',
            ];

            $validator = Validator::make($data, $rules, $customMessage);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->save();

            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                $user = User::where('email', $data['email'])->first();
                $access_token = $user->createToken($data['email'])->accessToken;
                User::where('email', $data['email'])->update(['access_token' => $access_token]);
                $message = "User Successfully Register";
                return response()->json(['message' => $message, 'access_token' => $access_token], 201);
            } else {
                $message = "Opps! Something went wrong";
                return response()->json(['message' => $message], 422);
            }
        }
    }

    // login user using passport
    public function loginUserUsingPassport(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'email' => 'required|email|exists:users',
                'password' => 'required',
            ];

            $customMessage = [
                'email.required' => 'Email is required',
                'email.email' => 'Email must be a valid email',
                'email.exists' => 'Email does not exist',
                'password.required' => 'Password is required',
            ];

            $validator = Validator::make($data, $rules, $customMessage);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                $user = User::where('email', $data['email'])->first();
                $access_token = $user->createToken($data['email'])->accessToken;
                User::where('email', $data['email'])->update(['access_token' => $access_token]);
                $message = "User Successfully Login";
                return response()->json(['message' => $message, 'access_token' => $access_token], 201);
            } else {
                $message = "Invalid Email or Password";
                return response()->json(['message' => $message], 422);
            }
        }
    }
}
