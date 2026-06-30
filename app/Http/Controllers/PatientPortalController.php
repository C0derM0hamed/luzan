<?php

namespace App\Http\Controllers;

use App\Models\PatientReport;
use App\Services\Otp\OtpServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PatientPortalController extends Controller
{
    public function __construct(private OtpServiceInterface $otpService) {}

    public function showLoginForm()
    {
        return view('pages.reports.login');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'يرجى إدخال بريد إلكتروني صحيح.',
        ]);

        $email = $request->input('email');

        // Check if any reports exist for this email
        $hasReports = PatientReport::query()->where('email', $email)->exists();

        if (! $hasReports) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'لا توجد تقارير مرتبطة بهذا البريد الإلكتروني.']);
        }

        $this->otpService->send($email);

        session(['otp_email' => $email]);

        return redirect()
            ->route('reports.verify')
            ->with('success', 'تم إرسال رمز التحقق إلى بريدك الإلكتروني.');
    }

    public function showVerifyForm()
    {
        if (! session('otp_email')) {
            return redirect()->route('reports.login');
        }

        return view('pages.reports.verify', [
            'email' => session('otp_email'),
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ], [
            'code.required' => 'رمز التحقق مطلوب.',
            'code.size' => 'رمز التحقق يجب أن يكون 6 أرقام.',
        ]);

        $email = session('otp_email');

        if (! $email) {
            return redirect()->route('reports.login');
        }

        $verified = $this->otpService->verify($email, $request->input('code'));

        if (! $verified) {
            return back()->withErrors(['code' => 'رمز التحقق غير صحيح أو منتهي الصلاحية.']);
        }

        session(['verified_email' => $email]);
        session()->forget('otp_email');

        return redirect()->route('reports.list');
    }

    public function reports()
    {
        $email = session('verified_email');

        if (! $email) {
            return redirect()->route('reports.login');
        }

        $reports = PatientReport::query()
            ->forEmail($email)
            ->latest()
            ->get();

        return view('pages.reports.index', [
            'reports' => $reports,
            'email' => $email,
        ]);
    }

    public function downloadReport(PatientReport $report)
    {
        $email = session('verified_email');

        if (! $email || $report->email !== $email) {
            abort(403, 'غير مصرح لك بالوصول إلى هذا التقرير.');
        }

        $path = storage_path('app/private/' . $report->file_path);

        if (! File::exists($path)) {
            abort(404, 'الملف غير موجود.');
        }

        $extension = strtolower($report->file_type);
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
        ];
        
        $mime = $mimeTypes[$extension] ?? 'application/octet-stream';

        return response()->streamDownload(function () use ($path) {
            readfile($path);
        }, $report->title . '.' . $report->file_type, [
            'Content-Type' => $mime
        ]);
    }
}
