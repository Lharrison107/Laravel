@extends('layouts.app')

@section('content')
<h1>{{ __('Contact Page') }}</h1>
<p>{{ __('Phone:') }} (803) 867-5309</p>
<p>{{ __('Name:') }} {{ __('Stacy\'s Mom') }}</p>

@can('home.secret')
    <p>
        <a href="{{ route('home.secret') }}">
            {{ __('click here to go to the secret page') }}
        </a>   
    </p>
@endcan
@endsection