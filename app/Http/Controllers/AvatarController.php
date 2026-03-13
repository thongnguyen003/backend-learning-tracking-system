<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AvatarController extends Controller
{
    public function updateAvatar(Request $request, $role, $id)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid avatar URL',
                'errors' => $validator->errors(),
            ], 422);
        }

        $avatarUrl = $request->input('avatar');

        // Tùy role bạn lưu avatar vào bảng tương ứng, ví dụ:
        if ($role === 'student') {
            $model = \App\Models\Student::find($id);
        } elseif ($role === 'teacher') {
            $model = \App\Models\Teacher::find($id);
        } else {
            return response()->json(['message' => 'Invalid role'], 400);
        }

        if (!$model) {
            return response()->json(['message' => ucfirst($role) . ' not found'], 404);
        }

        $model->avatar = $avatarUrl;
        $model->save();

        return response()->json([
            'message' => 'Avatar updated successfully',
            'avatar' => $avatarUrl,
        ]);
    }
}
