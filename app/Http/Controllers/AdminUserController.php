<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    /**
     * 1. List All Users
     */
    public function index()
    {
        $users = User::with('caregivers')
            ->orderBy('created_at', 'desc')
            ->paginate(25);
        $caregivers = User::where('role', 'caregiver')
            ->where('is_active', 1)
            ->get();

        return view('admin.users-index', compact('users', 'caregivers'));
    }

    /**
     * 2. Show Create User Form
     */
    public function create()
    {
        $caregivers = User::where('role', 'caregiver')
            ->where('is_active', 1)
            ->get();

        return view('admin.create-user', compact('caregivers'));
    }

    /**
     * 3. Store New User
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],

        'email' => [
            'required',
            'string',
            'email:rfc,dns',
            'max:255',
            'unique:users',
        ],

        'password' => [
            'required',
            'string',
            'min:8',
            'confirmed',
        ],

        'role' => ['required', 'in:student,admin,teacher,caregiver'],

        'caregiver_id' => [
            'nullable',
            Rule::exists('users', 'id')
                ->where('role', 'caregiver')
                ->where('is_active', 1),
        ],
    ]);

    $user = User::create([
        'name'                  => $request->name,
        'email'                 => $request->email,
        'password'              => Hash::make($request->password),
        'role'                  => $request->role,
        'failed_login_attempts' => 0,
        'is_locked'             => false,
    ]);

    // Attach caregiver if student
    if ($user->role === 'student' && $request->filled('caregiver_id')) {
        $user->caregivers()->sync([$request->caregiver_id]);
    }

    return redirect()
        ->route('admin.users.index')
        ->with('success', 'User created successfully!');
    }

    /**
     * 4. Show Edit Form
     */
    public function edit($id)
    {
        $user = User::with('caregivers')->findOrFail($id);

        $caregivers = User::where('role', 'caregiver')
            ->where('is_active', 1)
            ->get();

        $currentCaregiver = null;

        if ($user->role === 'student') {
            $currentCaregiver = $user->caregivers()->first();
        }

        return view('admin.edit-user', [
            'user' => $user,
            'caregivers' => $caregivers,
            'currentCaregiver' => $currentCaregiver,
        ]);
    }

    /**
     * 5. Update User
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'role'  => ['required', 'in:student,admin,teacher,caregiver'],
            'caregiver_id' => [
                'nullable',
                Rule::exists('users', 'id')
                    ->where('role', 'caregiver')
                    ->where('is_active', 1) 
            ],
            'is_active' => ['nullable', 'boolean'], // 
        ]);

        $user->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            'is_active' => $request->has('is_active') ? $request->is_active : $user->is_active,
        ]);

        /**
         * If caregiver is DEACTIVATED → remove all students
         */
        if ($user->role === 'caregiver' && $user->is_active == 0) {
            $user->students()->detach();
        }

        /**
         * If role is student → sync caregiver
         */
        if ($request->role === 'student') {

            $user->caregivers()->sync(
                $request->filled('caregiver_id')
                    ? [$request->caregiver_id]
                    : []
            );

        } else {
            // If role changed from student → remove relation
            $user->caregivers()->detach();
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    /**
     * 6. Assign Caregiver
     */
    public function assignCaregiver(Request $request, $id)
    {
        $request->validate([
            'caregiver_id' => [
                'nullable',
                Rule::exists('users', 'id')
                    ->where('role', 'caregiver')
                    ->where('is_active', 1) 
            ],
        ]);

        $student = User::findOrFail($id);

        if ($student->role !== 'student') {
            return back()->with('error', 'Only students can be assigned caregivers.');
        }
        if ($request->filled('caregiver_id')) {
            $caregiver = User::find($request->caregiver_id);

            if (!$caregiver || !$caregiver->is_active) {
                return back()->with('error', 'Cannot assign an inactive caregiver.');
            }
        }

        $student->caregivers()->sync(
            $request->filled('caregiver_id')
                ? [$request->caregiver_id]
                : []
        );

        return back()->with('success', 'Caregiver assigned successfully!');
    }

    /**
     * 7. Delete User
     */
    public function destroy($id)
    {
        if (auth()->id() == $id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user = User::findOrFail($id);

        $user->caregivers()->detach();
        $user->students()->detach();

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }

    /**
     * 8. Unlock User
     */
    public function unlock($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'failed_login_attempts' => 0,
            'is_locked'             => false,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User account unlocked successfully!');
    }
}