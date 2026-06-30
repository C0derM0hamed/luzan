<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PatientReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            $file = $request->file('file');
            $data['file_path'] = $file->store('reports', 'private');
            $data['file_type'] = strtolower($file->getClientOriginalExtension());
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
            // Delete old file
            if ($report->file_path && Storage::disk('private')->exists($report->file_path)) {
                Storage::disk('private')->delete($report->file_path);
            }
            $file = $request->file('file');
            $data['file_path'] = $file->store('reports', 'private');
            $data['file_type'] = strtolower($file->getClientOriginalExtension());
        }

        $report->update($data);

        return redirect()
            ->route('admin.reports.index')
            ->with('success', 'تم تحديث التقرير بنجاح.');
    }

    public function destroy(PatientReport $report)
    {
        if ($report->file_path && Storage::disk('private')->exists($report->file_path)) {
            Storage::disk('private')->delete($report->file_path);
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
            'file' => [$fileRule, 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            'notes' => ['nullable', 'string'],
        ], [
            'patient_name.required' => 'اسم المريض مطلوب.',
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'phone.required' => 'رقم الجوال مطلوب.',
            'phone.regex' => 'صيغة رقم الجوال غير صحيحة. يجب أن يكون رقماً صحيحاً (وقد يبدأ بـ +).',
            'title.required' => 'عنوان التقرير مطلوب.',
            'file.required' => 'ملف التقرير مطلوب.',
            'file.mimes' => 'يجب أن يكون الملف بصيغة PDF أو JPG أو PNG.',
            'file.max' => 'الحد الأقصى لحجم الملف 10 ميجابايت.',
        ]);
    }
}
