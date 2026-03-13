<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminTeacherService;
use App\Services\Admin\AdminStudentService;
use App\Services\Admin\AdminService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AdminUserController extends Controller
{
    protected $teacherService;
    protected $studentService;
    protected $adminService;

    public function __construct(
        AdminTeacherService $teacherService,
        AdminStudentService $studentService,
        AdminService $adminService
    ) {
        $this->teacherService = $teacherService;
        $this->studentService = $studentService;
        $this->adminService = $adminService;
    }

    /**
     * Display a listing of all users (students, teachers, admins).
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $search = $request->query('search', '');

            $students = $this->studentService->getAll($search)->map(function ($user) {
                return array_merge($user->toArray(), ['role' => 'student']);
            });
            $teachers = $this->teacherService->getAll($search)->map(function ($user) {
                $userArray = $user->toArray();
                if (isset($userArray['teacher_name'])) {
                    $userArray['name'] = $userArray['teacher_name'];
                    unset($userArray['teacher_name']);
                }
                return array_merge($userArray, ['role' => 'teacher']);
            });
            $admins = $this->adminService->getAll($search)->map(function ($user) {
                return array_merge($user->toArray(), ['role' => 'admin']);
            });

            $users = $students->merge($teachers)->merge($admins)->values();

            return response()->json([
                'message' => 'Users retrieved successfully.',
                'users' => $users,
                'total' => $users->count(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving user list: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get only students.
     */
    public function getStudents(Request $request): JsonResponse
    {
        try {
            $search = $request->query('search', '');

            $students = $this->studentService->getAll($search)->map(function ($user) {
                return array_merge($user->toArray(), ['role' => 'student']);
            });

            return response()->json([
                'message' => 'Students retrieved successfully.',
                'students' => $students,
                'total' => $students->count(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving student list: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get only teachers.
     */
    public function getTeachers(Request $request): JsonResponse
    {
        try {
            $search = $request->query('search', '');

            $teachers = $this->teacherService->getAll($search)->map(function ($user) {
                $userArray = $user->toArray();
                if (isset($userArray['teacher_name'])) {
                    $userArray['name'] = $userArray['teacher_name'];
                    unset($userArray['teacher_name']);
                }
                return array_merge($userArray, ['role' => 'teacher']);
            });

            return response()->json([
                'message' => 'Teachers retrieved successfully.',
                'teachers' => $teachers,
                'total' => $teachers->count(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving teacher list: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get only admins.
     */
    public function getAdmins(Request $request): JsonResponse
    {
        try {
            $search = $request->query('search', '');

            $admins = $this->adminService->getAll($search)->map(function ($user) {
                return array_merge($user->toArray(), ['role' => 'admin']);
            });

            return response()->json([
                'message' => 'Admins retrieved successfully.',
                'admins' => $admins,
                'total' => $admins->count(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving admin list: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Add multiple users (students, teachers, or admins).
     */
    public function addUsers(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'users' => 'required|array',
                'users.*.name' => 'required|string|max:255',
                'users.*.email' => 'required|email',
                'users.*.password' => 'required|string|min:6',
                'users.*.role' => 'required|in:student,teacher,admin',
                'users.*.class_id' => 'nullable|integer|exists:classes,id',
            ]);

            $createdUsers = [];
            $errors = [];

            DB::beginTransaction();
            try {
                foreach ($data['users'] as $user) {
                    // Check if role is student then class_id is required
                    if ($user['role'] === 'student' && !isset($user['class_id'])) {
                        $errors[] = "class_id is required for student with email {$user['email']}.";
                        continue;
                    }

                    // For teachers, map 'name' to 'teacher_name' in the database
                    if ($user['role'] === 'teacher') {
                        $user['teacher_name'] = $user['name'];
                        unset($user['name']);
                    }

                    try {
                        if ($user['role'] === 'student') {
                            if (\App\Models\Student::where('email', $user['email'])->exists()) {
                                $errors[] = "Email {$user['email']} is already used by a student.";
                                continue;
                            }
                            $createdUsers = array_merge($createdUsers, $this->studentService->createMultiple([$user]));
                        } elseif ($user['role'] === 'teacher') {
                            if (\App\Models\Teacher::where('email', $user['email'])->exists()) {
                                $errors[] = "Email {$user['email']} is already used by a teacher.";
                                continue;
                            }
                            $createdUsers = array_merge($createdUsers, $this->teacherService->createMultiple([$user]));
                        } elseif ($user['role'] === 'admin') {
                            if (\App\Models\Admin::where('email', $user['email'])->exists()) {
                                $errors[] = "Email {$user['email']} is already used by an admin.";
                                continue;
                            }
                            $createdUsers = array_merge($createdUsers, $this->adminService->createMultiple([$user]));
                        }
                    } catch (\Exception $e) {
                        $errors[] = "Could not create user {$user['email']}: {$e->getMessage()}";
                    }
                }

                if (empty($errors)) {
                    DB::commit();
                    return response()->json([
                        'message' => "Successfully added " . count($createdUsers) . " user accounts!",
                        'created' => count($createdUsers),
                    ], 201);
                } else {
                    DB::rollBack();
                    return response()->json([
                        'message' => 'Some users could not be added.',
                        'errors' => $errors,
                        'created' => count($createdUsers),
                    ], 207);
                }
            } catch (\Exception $e) {
                DB::rollBack();
                $errors[] = "Transaction failed: {$e->getMessage()}";
                return response()->json([
                    'message' => 'Some users could not be added.',
                    'errors' => $errors,
                    'created' => count($createdUsers),
                ], 207);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Invalid input data.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Server error when adding users: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update a single user by ID and role.
     */
    public function updateUser(Request $request, int $id): JsonResponse
    {
        try {
            $data = $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email',
                'password' => 'sometimes|string|min:6',
                'role' => 'required|in:student,teacher,admin',
                'class_id' => 'nullable|integer|exists:classes,id',
            ]);

            $updatedUser = null;

            if ($data['role'] === 'student') {
                if (isset($data['name'])) {
                    $data['student_name'] = $data['name'];  // đổi key thành tên cột đúng
                    unset($data['name']);
                }
                $updatedUser = $this->studentService->update($id, $data);

            } elseif ($data['role'] === 'teacher') {
                if (isset($data['name'])) {
                    $data['teacher_name'] = $data['name'];
                    unset($data['name']);
                }
                $updatedUser = $this->teacherService->update($id, $data);

            } elseif ($data['role'] === 'admin') {
                if (isset($data['name'])) {
                    $data['admin_name'] = $data['name'];
                    unset($data['name']);
                }
                $updatedUser = $this->adminService->update($id, $data);
            }

            return response()->json([
                'message' => 'User updated successfully.',
                'user' => $updatedUser,
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Invalid input data.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Server error when updating user: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a single user by ID and role.
     */
    public function deleteUser(Request $request, int $id): JsonResponse
    {
        try {
            $data = $request->validate([
                'role' => 'required|in:student,teacher,admin',
            ]);

            $service = null;
            $user = null;

            if ($data['role'] === 'student') {
                $service = $this->studentService;
                $user = $service->getById($id);
            } elseif ($data['role'] === 'teacher') {
                $service = $this->teacherService;
                $user = $service->getById($id);
            } elseif ($data['role'] === 'admin') {
                $service = $this->adminService;
                $user = $service->getById($id);
            }

            if (!$user) {
                return response()->json([
                    'message' => "User with ID {$id} and role {$data['role']} not found.",
                ], 404);
            }

            $service->delete($id);

            return response()->json([
                'message' => 'User deleted successfully.',
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Invalid input data.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error deleting user: ' . $e->getMessage(),
            ], 500);
        }
    }
}