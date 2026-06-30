<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PatientReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PatientReportController extends Controller
{
    public function index()
    {
        $reports = PatientReport::query()
            ->with('uploader')
            ->latest()
            ->paginate(20);

        return view('admin.reports.index', [
            'pageTitle' => 'إدارة تقارير المرضى',
            'reports' => $reports,
            'tableHeaders' => ['اسم المريض', 'البريد', 'الجوال', 'عنوان التقرير', 'النوع', 'التاريخ', 'إجراءات'],
        ]);
    }

    public function create()
    {
        return view('admin.reports.create', ['pageTitle' => 'رفع تقرير جديد']);
    }

    public function store(Request $request)
    {
        $data = $this->validateReport($request);

        if ($request->hasFile('file')) {
            \App\Services\UploadValidationService::validate($request->file('file'), ['pdf', 'jpg', 'jpeg', 'png'], 'file');
            $file = $request->file('file');
            $extension = strtolower(pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));
            $filename = \Illuminate\Support\Str::random(40) . '.' . $extension;
            
            $directory = storage_path('app/private/reports');
            if (! File::isDirectory($directory)) {
                File::makeDirectory($directory, 0755, true);
            }
            $file->move($directory, $filename);
            
            $data['file_path'] = 'reports/' . $filename;
            $data['file_type'] = $extension;
        }

        $data['uploaded_by'] = Auth::id();

        PatientReport::query()->create($data);

        return redirect()
            ->route('admin.reports.index')
            ->with('success', 'تم رفع التقرير بنجاح.');
    }

    public function show(PatientReport $report)
    {
        $report->load('uploader');

        return view('admin.reports.show', [
            'pageTitle' => 'تفاصيل التقرير',
            'report' => $report,
        ]);
    }

    public function edit(PatientReport $report)
    {
        return view('admin.reports.edit', [
            'pageTitle' => 'تعديل التقرير',
            'report' => $report,
        ]);
    }

    public function update(Request $request, PatientReport $report)
    {
        $data = $this->validateReport($request, isUpdate: true);

        if ($request->hasFile('file')) {
            \App\Services\UploadValidationService::validate($request->file('file'), ['pdf', 'jpg', 'jpeg', 'png'], 'file');
            // Delete old file
            if ($report->file_path) {
                $oldPath = storage_path('app/private/' . $report->file_path);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }
            $file = $request->file('file');
            $extension = strtolower(pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));
            $filename = \Illuminate\Support\Str::random(40) . '.' . $extension;
            
            $directory = storage_path('app/private/reports');
            if (! File::isDirectory($directory)) {
                File::makeDirectory($directory, 0755, true);
            }
            $file->move($directory, $filename);
            
            $data['file_path'] = 'reports/' . $filename;
            $data['file_type'] = $extension;
        }

        $report->update($data);

        return redirect()
            ->route('admin.reports.index')
            ->with('success', 'تم تحديث التقرير بنجاح.');
    }

    public function destroy(PatientReport $report)
    {
        if ($report->file_path) {
            $path = storage_path('app/private/' . $report->file_path);
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $report->delete();

        return redirect()
            ->route('admin.reports.index')
            ->with('success', 'تم حذف التقرير بنجاح.');
    }

    protected function validateReport(Request $request, bool $isUpdate = false): array
    {
        $fileRule = $isUpdate ? 'nullable' : 'required';

        return $request->validate([
            'patient_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^\+?[0-9]{8,15}$/'],
            'title' => ['required', 'string', 'max:255'],
            'file' => [$fileRule, 'file', 'max:10240'],
            'notes' => ['nullable', 'string'],
        ], [
            'patient_name.required' => 'اسم المريض مطلوب.',
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'phone.required' => 'رقم الجوال مطلوب.',
            'phone.regex' => 'صيغة رقم الجوال غير صحيحة. يجب أن يكون رقماً صحيحاً (وقد يبدأ بـ +).',
            'title.required' => 'عنوان التقرير مطلوب.',
            'file.required' => 'ملف التقرير مطلوب.',
            'file.max' => 'الحد الأقصى لحجم الملف 10 ميجابايت.',
        ]);
    }
}
