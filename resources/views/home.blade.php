@extends('layouts.app')

@section('content')

    <div class="container mx-auto py-6">
        <h1 class="text-4xl">Tap Medical Demo</h1>
        <h3 class="text-xl">Written by Colby Garland</h3>

        <div class="lg:flex flex-wrap mt-4">
            <div class="lg:w-1/2">
                <h2 class="text-2xl mb-4">Find an Appointment</h2>
                <form method="POST" action="{{ route('find_appointments') }}">
                    @csrf
                    <div class="mb-6">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="doctor">Select a Doctor</label>
                        <select id="doctor" class="block w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" name="doctor_id">
                            <option disabled>Select a Doctor</option>
                            @foreach(\App\Doctor::get() as $doctor)
                                <option @if(Session::has('doctor_id') && Session::get('doctor_id') == $doctor->id) selected="selected" @endif  value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-6">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="date">Select a Date</label>
                        <input id="date" type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="date" required value="@if(Session::has('date')){{ Session::get('date') }}@endif"/>
                    </div>
                    <div class="mb-6">
                        <button type="submit" class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                    </div>
                </form>
            </div>
            <div class="lg:w-1/2 lg:pl-10">
                @if(Session::has('warning'))
                    <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4 mb-6" role="alert">
                        <p class="font-bold">Attention!</p>
                        <p>{{ Session::get('warning') }}</p>
                    </div>
                @else
                    @if(Session::has('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                            <p class="font-bold">Success!</p>
                            <p>{{ Session::get('success') }}</p>
                        </div>
                        @foreach(Session::get('appointments') as $appointment)
                            <div class="mb-3">
                                <p>Date: {{ $appointment->start_date }}</p>
                                <p>Start time: {{ $appointment->start_time }}</p>
                                <p>Specialty Name: {{ $appointment->specialty_name }}</p>
                                <p>Status: {{ $appointment->status }}</p>
                            </div>
                        @endforeach
                    @endif
                @endif
            </div>
        </div>


    </div>

@endsection
