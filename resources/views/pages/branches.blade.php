@extends('layouts.app')

@section('title', 'فروعنا')

@section('content')
<section class="bg-slate-50 py-20">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">
        @include('components.branches-section')
    </div>
</section>
@endsection
