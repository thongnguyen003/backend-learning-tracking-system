<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;  // Import model Student
use App\Services\StudentService;
class StudentController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $student = $this->studentService->findById($id);
        return response()->json($student);
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
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    protected $studentService;
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
    // }    
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
  public function updateProfile(Request $request, $id)
{
    $data = $request->validate([
        'student_name' => 'required|string|max:50',
        'day_of_birth' => 'nullable|date',
        'gender' => 'required|in:male,female,other',
        'hometown' => 'nullable|string|max:255',
        'phone_number' => 'nullable|string|max:255',
        'email' => 'required|email|max:255',
        'password' => 'nullable|string|min:6', // Cho phép nullable
        'class_id' => 'required|exists:classes,id',
    ]);

    try {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']); // Hash mật khẩu
        }
        $student = $this->studentService->updateStudentProfile($id, $data);
        return response()->json(['message' => 'Student profile updated successfully', 'data' => $student], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 500);
    }
}
    public function showStudentsByClassId($classId)
    {
        $students = $this->studentService->getStudentsByClassId($classId);
        
        return $students; // Trả về danh sách sinh viên dưới dạng JSON
    }

}
