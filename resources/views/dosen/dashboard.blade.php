{{-- resources/views/dosen/dashboard.blade.php --}}
@extends('layouts.app')
@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold">👨‍🏫 Dosen Dashboard</h1>
        <p>Kelas: {{ $classes->count() }}</p>
    </div>
</div>
@endsection