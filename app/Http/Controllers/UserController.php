<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Login; 
use Illuminate\Support\Facades\Validator; 

class UserController extends Controller
{
    //
    public function index() {
        return User::all();
    }

    public function show($id) {
        return User::findOrFail($id);
    }
    
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->only([
            'name',
            'email',
            'age',
            'gender',
            'address',
        ]);

        $user->update($data);

        return response()->json(['message' => 'Cập nhật thành công', 'user' => $user]);
    }

    public function destroy($id) {
        User::destroy($id);
        return response()->json(['message' => 'User deleted']);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login_id' => 'required|exists:login,id',
            'name' => 'required',
            'age' => 'required|integer|min:0',
            'gender' => 'required',
            'email' => 'required|email|unique:users'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Tạo user
        $user = User::create([
            'name' => $request->name,
            'age' => $request->age,
            'gender' => $request->gender,
            'email' => $request->email
        ]);

        // Gán user_id vào login
        $login = Login::find($request->login_id);
        $login->user_id = $user->id;
        $login->save();

        return response()->json([
            'message' => 'Thêm thông tin cá nhân thành công',
            'user' => $user,
            'login' => $login
        ], 200);
    }
}
