@extends('layouts.app')

@section('content')

    <div class="container mx-auto py-6">
        <h1 class="text-4xl">Tap Medical Demo</h1>
        <h3 class="text-xl">Written by Colby Garland</h3>

        <doctor-dropdown
            doctors="{{ \App\Doctor::get() }}"
        />
    </div>

@endsection
