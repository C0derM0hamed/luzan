<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin(SettingService $settings)
    {
        return view('admin.auth.login', [
            'pageTitle' => 'تسجيل الدخول',
            'clinicName' => $settings->get('clinic_name', 'مجمع لوزان التخصصي الطبي'),
            'loginTitle' => 'لوحة تحكم مجمع لوزان',
            'emailLabel' => 'البريد الإلكتروني',
            'passwordLabel' => 'كلمة المرور',
            'rememberLabel' => 'تذكرني',
            'submitLabel' => 'دخول',
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'يرجى إدخال بريد إلكتروني صالح.',
            'password.required' => 'كلمة المرور مطلوبة.',
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'بيانات الدخول غير صحيحة.',
            ]);
        }

        $request->session()->regenerate();

        if (! Auth::user()->is_admin) {
            Auth::logout();

            throw ValidationException::withMessages([
                'email' => 'ليس لديك صلاحية الدخول إلى لوحة التحكم.',
            ]);
        }

        return redirect()
            ->intended(route('admin.dashboard'))
            ->with('success', 'مرحباً بك في لوحة التحكم.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('admin.login')
            ->with('success', 'تم تسجيل الخروج بنجاح.');
    }

    public function showForgotPassword(SettingService $settings)
    {
        return view('admin.auth.forgot-password', [
            'pageTitle' => 'استعادة كلمة المرور',
            'clinicName' => $settings->get('clinic_name', 'مجمع لوزان التخصصي الطبي'),
            'resetTitle' => 'استعادة كلمة المرور للوحة التحكم',
            'identityLabel' => 'البريد الإلكتروني أو رقم الهاتف المسجل',
            'submitLabel' => 'إرسال كلمة المرور المؤقتة',
            'backToLoginLabel' => 'العودة لتسجيل الدخول',
        ]);
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'identity' => ['required', 'string'],
        ], [
            'identity.required' => 'حقل البريد الإلكتروني أو رقم الهاتف مطلوب.',
        ]);

        $identity = $request->input('identity');

        $user = \App\Models\User::query()
            ->where('is_admin', true)
            ->where(function ($query) use ($identity) {
                $query->where('email', $identity)->orWhere('phone', $identity);
            })
            ->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'identity' => 'البريد الإلكتروني أو رقم الهاتف غير مسجل لدينا.',
            ]);
        }

        // Generate temporary password
        $tempPassword = 'Luzan@' . rand(10000, 99999);
        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($tempPassword),
        ]);

        try {
            \Illuminate\Support\Facades\Mail::raw("أهلاً بك {$user->name}.\nتمت إعادة تعيين كلمة المرور الخاصة بك بنجاح.\n\nكلمة المرور المؤقتة الجديدة هي: {$tempPassword}\n\nيرجى تسجيل الدخول باستخدام هذه الكلمة وتغييرها فوراً من لوحة التحكم.", function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('إعادة تعيين كلمة المرور - لوحة تحكم لوزان');
            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to send reset password mail: " . $e->getMessage());
        }

        return redirect()
            ->route('admin.login')
            ->with('success', "تمت إعادة تعيين كلمة المرور بنجاح وإرسالها إلى البريد الإلكتروني المسجل. (للتجربة: كلمة المرور المؤقتة هي: {$tempPassword})");
    }

    public function editProfile()
    {
        return view('admin.auth.profile', [
            'pageTitle' => 'إعدادات الحساب',
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'حقل الاسم مطلوب.',
            'email.required' => 'حقل البريد الإلكتروني مطلوب.',
            'email.email' => 'يرجى إدخال بريد إلكتروني صالح.',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',
            'current_password.required_with' => 'يجب إدخال كلمة المرور الحالية لتغيير كلمة المرور الجديدة.',
            'current_password.current_password' => 'كلمة المرور الحالية غير صحيحة.',
            'password.min' => 'يجب ألا تقل كلمة المرور الجديدة عن 8 أحرف.',
            'password.confirmed' => 'تأكيد كلمة المرور الجديدة غير متطابق.',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->input('password'));
        }

        $user->save();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'تم تحديث بيانات الحساب بنجاح.');
    }
}
