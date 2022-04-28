@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')
{{-- @each('posts.partials.post', $posts, 'post') --}}
{{-- @each does not inharet the variables liek include does but include cant be out of the loop --}}
    
{{-- @break ($key == 2) --}}
{{-- @continue ($key == 1) --}}
    @include('posts.partials.post', [])

@endsection