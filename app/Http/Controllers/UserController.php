<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Login; 
use Illuminate\Support\Facades\Validator; 

class UserController extends Controller
{
    public function index() {
        return User::all();
    }

    public function show($id) {
        return User::findOrFail($id);
    }
    
    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    // Lấy các trường cho phép update
    $fields = ['name', 'email', 'age', 'gender', 'address'];
    $updateData = [];
    foreach ($fields as $field) {
        // Chỉ thêm vào updateData nếu field có trong request
        if ($request->has($field)) {
            $updateData[$field] = $request->$field;
        }
    }

    // Nếu không có trường nào để update thì trả về lỗi
    if (empty($updateData)) {
        return response()->json(['message' => 'Không có dữ liệu cập nhật'], 400);
    }

    $user->update($updateData);

    return response()->json(['message' => 'Cập nhật thành công', 'user' => $user]);
}

    public function destroy($id)
{
    $user = User::findOrFail($id);
    \DB::transaction(function() use ($user) {
        if ($user->login) {
            $user->login->delete();
        }
        $user->delete();
    });
    return response()->json(['message' => 'User deleted successfully']);
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
            'email' => $request->email,
            'login_id' => $request->login_id
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
