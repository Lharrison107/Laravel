@extends('layouts.app')

@section('content')
<h1>Contacts Page</h1>
<p>Phone: (803) 867-5309</p>
<p>Name: Stacies Mom</p>

@can('home.secret')
    <p>
        <a href="{{ route('home.secret') }}">
            click here to go to the secret page
        </a>   
    </p>
@endcan
@endsection