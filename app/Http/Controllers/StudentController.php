<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;  // Import model Student
use App\Services\StudentService;
class StudentController extends Controller
{
    // protected $studentService;
    // public function changePassword(Request $request)
    // {
    //     // Lấy người dùng đã đăng nhập
    //     $user = Auth::user(); // Giả sử Auth đã được cấu hình để xác thực người dùng

    //     // Kiểm tra mật khẩu hiện tại
    //     if (!Hash::check($request->current_password, $user->password)) {
    //         return response()->json(['error' => 'Mật khẩu hiện tại không chính xác'], 400);
    //     }

    //     // Kiểm tra mật khẩu mới
    //     $request->validate([
    //         'new_password' => 'required|min:8|confirmed', // Mật khẩu mới phải có ít nhất 8 ký tự và khớp với mật khẩu xác nhận
    //     ]);

    //     // Cập nhật mật khẩu mới
    //     $user->password = Hash::make($request->new_password);
    //     $user->save();  // Lưu thay đổi vào cơ sở dữ liệu

    //     return response()->json(['message' => 'Mật khẩu đã được thay đổi thành công'], 200);
    // // }
    // public function __construct(StudentService $studentService)
    // {
    //     $this->studentService = $studentService;
    // }
    // public function changePassword(Request $request, $id)
    // {
    //     $id = (int) $id; // Lấy ID từ URL
    //     $data = $request->all();

    //     try {
    //         if (!$id) {
    //             return response()->json(['error' => 'Student ID is missing'], 400);
    //         }

    //         return $this->studentService->changePassword($id, $data);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 400);
    //     }
    // }

    protected $studentService;
    
    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }
    public function changePassword(Request $request, $id)
    {
        $id = (int) $id; // Lấy ID từ URL
        $data = $request->all();

        try {
            if (!$id) {
                return response()->json(['error' => 'Student ID is missing'], 400);
            }

            return $this->studentService->changePassword($id, $data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
