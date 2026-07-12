<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::query()
            ->orderBy('is_admin', 'desc')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.users.index', [
            'pageTitle' => 'إدارة المدراء والمستخدمين',
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create', [
            'pageTitle' => 'إضافة مدير / مستخدم جديد'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'is_admin' => ['boolean']
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['is_admin'] = $request->has('is_admin');

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'تم إنشاء الحساب بنجاح.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'pageTitle' => 'تعديل الحساب',
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'is_admin' => ['boolean']
        ];

        // Prevent taking admin privileges away from oneself
        if ($user->id === auth()->id() && !$request->has('is_admin')) {
            return back()->with('error', 'لا يمكنك إزالة صلاحيات الإدارة من حسابك الخاص.');
        }

        $data = $request->validate($rules);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['is_admin'] = $request->has('is_admin');

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'تم تحديث الحساب بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'لا يمكنك حذف حسابك الخاص.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'تم حذف الحساب بنجاح.');
    }
}
