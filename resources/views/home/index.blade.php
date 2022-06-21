@extends('layouts.app')

@section('content')
<h1>Welcome to Laravel!</h1>
<h1>{{ __('messa') }}</h1>

<p>{{ __('messages.example_with_value', ['name' => 'Lyric']) }}</p>

<p>{{ trans_choice('messages.plural', 0, ['a' => 1]) }}</p>
<p>{{ trans_choice('messages.plural', 1, ['a' => 1]) }}</p>
<p>{{ trans_choice('messages.plural', 2, ['a' => 1]) }}</p>

<p>Using JSON: {{ __('Welcome to Laravel!') }}</p>
<p>Using JSON: {{ __('Hello :name', ['name' => 'Lyric']) }}</p>

<p>This is the content of the main page!</p>
@endsection 