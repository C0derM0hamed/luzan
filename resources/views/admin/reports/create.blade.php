@extends('layouts.admin')

@section('page-title', $pageTitle)

@section('content')
    <form action="{{ route('admin.reports.store') }}" method="POST" enctype="multipart/form-data" class="max-w-2xl space-y-4 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        @csrf
        @include('admin.reports._form')
        <button type="submit" class="rounded-xl bg-primary px-6 py-2.5 font-bold text-white hover:bg-primary-dark transition-colors">{{ $saveLabel }}</button>
    </form>
@endsection
