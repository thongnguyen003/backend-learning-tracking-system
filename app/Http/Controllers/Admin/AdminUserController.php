<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminTeacherService;
use App\Services\Admin\AdminStudentService;
use App\Services\Admin\AdminService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
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
            Log::error('Error retrieving users: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error: ' . $e->getMessage(),
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
            Log::error('Error retrieving students: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error: ' . $e->getMessage(),
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
            Log::error('Error retrieving teachers: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error: ' . $e->getMessage(),
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
            Log::error('Error retrieving admins: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error: ' . $e->getMessage(),
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
                'users.*.subject_id' => 'nullable|integer|exists:subjects,id',
                'users.*.gender' => 'nullable|in:male,female,other',
            ]);

            $createdUsers = [];
            $errors = [];

            DB::beginTransaction();
            try {
                foreach ($data['users'] as $user) {
                    Log::info('Processing user:', $user);

                    // Kiểm tra nếu role là student thì bắt buộc phải có class_id
                    if ($user['role'] === 'student' && !isset($user['class_id'])) {
                        $errors[] = "class_id is required for student {$user['email']}.";
                        continue;
                    }

                    // Kiểm tra nếu role là teacher thì bắt buộc phải có subject_id và gender
                    if ($user['role'] === 'teacher') {
                        if (!isset($user['subject_id'])) {
                            $errors[] = "subject_id is required for teacher {$user['email']}.";
                            continue;
                        }
                        if (!isset($user['gender'])) {
                            $errors[] = "gender is required for teacher {$user['email']}.";
                            continue;
                        }
                        $user['teacher_name'] = $user['name'];
                        unset($user['name']);
                    }

                    try {
                        if ($user['role'] === 'student') {
                            if (\App\Models\Student::where('email', $user['email'])->exists()) {
                                $errors[] = "Email {$user['email']} already exists for a student.";
                                continue;
                            }
                            $createdUsers = array_merge($createdUsers, $this->studentService->createMultiple([$user]));
                        } elseif ($user['role'] === 'teacher') {
                            if (\App\Models\Teacher::where('email', $user['email'])->exists()) {
                                $errors[] = "Email {$user['email']} already exists for a teacher.";
                                continue;
                            }
                            $createdUsers = array_merge($createdUsers, $this->teacherService->createMultiple([$user]));
                        } elseif ($user['role'] === 'admin') {
                            if (\App\Models\Admin::where('email', $user['email'])->exists()) {
                                $errors[] = "Email {$user['email']} already exists for an admin.";
                                continue;
                            }
                            $createdUsers = array_merge($createdUsers, $this->adminService->createMultiple([$user]));
                        }
                    } catch (\Exception $e) {
                        Log::error("Failed to create user {$user['email']}: {$e->getMessage()}");
                        $errors[] = "Failed to create user {$user['email']}: {$e->getMessage()}";
                    }
                }

                if (empty($errors)) {
                    DB::commit();
                    Log::info('Successfully created users:', ['count' => count($createdUsers)]);
                    return response()->json([
                        'message' => "Successfully added " . count($createdUsers) . " user accounts!",
                        'created' => count($createdUsers),
                    ], 201);
                } else {
                    DB::rollBack();
                    Log::warning('Some users could not be added:', $errors);
                    return response()->json([
                        'message' => 'Some users could not be added.',
                        'errors' => $errors,
                        'created' => count($createdUsers),
                    ], 207);
                }
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Transaction failed: ' . $e->getMessage());
                $errors[] = "Transaction failed: {$e->getMessage()}";
                return response()->json([
                    'message' => 'Some users could not be added.',
                    'errors' => $errors,
                    'created' => count($createdUsers),
                ], 207);
            }
        } catch (\Exception $e) {
            Log::error('Error adding users: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error: ' . $e->getMessage(),
            ], 400);
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
                'subject_id' => 'nullable|integer|exists:subjects,id',
                'gender' => 'nullable|in:male,female,other',
            ]);

            // Kiểm tra nếu role là student thì bắt buộc có class_id
            if ($data['role'] === 'student' && !isset($data['class_id'])) {
                return response()->json([
                    'message' => 'class_id is required for students.',
                ], 422);
            }

            // Kiểm tra nếu role là teacher thì bắt buộc có subject_id và gender
            if ($data['role'] === 'teacher') {
                if (!isset($data['subject_id'])) {
                    return response()->json([
                        'message' => 'subject_id is required for teachers.',
                    ], 422);
                }
                if (!isset($data['gender'])) {
                    return response()->json([
                        'message' => 'gender is required for teachers.',
                    ], 422);
                }
                if (isset($data['name'])) {
                    $data['teacher_name'] = $data['name'];
                    unset($data['name']);
                }
            }

            $user = null;
            $service = null;

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

            if (isset($data['email']) && $data['email'] !== $user->email) {
                $modelClass = $data['role'] === 'student' ? \App\Models\Student::class :
                    ($data['role'] === 'teacher' ? \App\Models\Teacher::class : \App\Models\Admin::class);
                if ($modelClass::where('email', $data['email'])->exists()) {
                    return response()->json([
                        'message' => "Email {$data['email']} already exists for a {$data['role']}.",
                    ], 422);
                }
            }

            $updatedUser = $service->update($id, $data);

            // Map 'teacher_name' back to 'name' in response
            if ($data['role'] === 'teacher' && isset($updatedUser->teacher_name)) {
                $updatedUser->name = $updatedUser->teacher_name;
                unset($updatedUser->teacher_name);
            }

            return response()->json([
                'message' => 'User updated successfully.',
                'user' => $updatedUser,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error: ' . $e->getMessage(),
            ], 400);
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
        } catch (\Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error: ' . $e->getMessage(),
            ], 400);
        }
    }
}