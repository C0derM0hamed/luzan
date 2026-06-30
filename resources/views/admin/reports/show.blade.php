@extends('layouts.admin')

@section('page-title', $pageTitle)

@section('content')
    <div class="max-w-3xl rounded-xl border border-border bg-white p-6 shadow-sm">
        <dl class="grid gap-6 sm:grid-cols-2">
            <div>
                <dt class="text-xs font-semibold text-muted">اسم المريض</dt>
                <dd class="mt-1 text-sm font-medium text-[#222]">{{ $report->patient_name }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold text-muted">عنوان التقرير</dt>
                <dd class="mt-1 text-sm font-medium text-[#222]">{{ $report->title }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold text-muted">البريد الإلكتروني</dt>
                <dd class="mt-1 text-sm font-medium text-[#222]" dir="ltr">{{ $report->email }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold text-muted">رقم الجوال</dt>
                <dd class="mt-1 text-sm font-medium text-[#222]" dir="ltr">{{ $report->phone }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold text-muted">نوع الملف</dt>
                <dd class="mt-1 text-sm font-medium text-[#222] uppercase">{{ $report->file_type }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold text-muted">تاريخ الرفع</dt>
                <dd class="mt-1 text-sm font-medium text-[#222]" dir="ltr">{{ $report->created_at->format('Y-m-d H:i:s') }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold text-muted">تم الرفع بواسطة</dt>
                <dd class="mt-1 text-sm font-medium text-[#222]">{{ $report->uploader->name }}</dd>
            </div>
            <div class="sm:col-span-2">
                <dt class="text-xs font-semibold text-muted">ملاحظات</dt>
                <dd class="mt-1 text-sm text-[#222]">{{ $report->notes ?: '—' }}</dd>
            </div>
        </dl>
        
        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('reports.download', $report) }}" class="rounded bg-primary px-4 py-2 text-sm font-semibold text-white hover:bg-primary-dark shadow-md" target="_blank">تحميل / عرض الملف</a>
            <a href="{{ route('admin.reports.edit', $report) }}" class="rounded bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-200">تعديل التقرير</a>
            <a href="{{ route('admin.reports.index') }}" class="rounded border border-border px-4 py-2 text-sm hover:bg-surface">الرجوع للقائمة</a>
        </div>
    </div>
@endsection
