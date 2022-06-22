@extends('layouts.app')

@section('content')
<h1>{{ __('messages.welcome') }}</h1>

<p>{{ __('messages.example_with_value', ['name' => 'Lyric']) }}</p>

<p>Using JSON: {{ __('Welcome to Laravel!') }}</p>
<p>Using JSON: {{ __('Hello :name', ['name' => 'Lyric']) }}</p>

<p>This is the content of the main page!</p>
@endsection 