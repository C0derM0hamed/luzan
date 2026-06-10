@extends('layouts.admin')

@section('page-title', $pageTitle)

@section('content')
    <form action="{{ route('admin.branches.store') }}" method="POST" class="max-w-2xl space-y-4 rounded-xl border border-border bg-white p-6 shadow-sm">
        @csrf
        @include('admin.branches._form')
        <button type="submit" class="rounded bg-primary px-6 py-2 font-semibold text-white hover:bg-primary-dark">{{ $saveLabel }}</button>
    </form>
@endsection
