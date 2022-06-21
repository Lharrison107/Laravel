@extends('layouts.app')

@section('title', 'Create A Post')

@section('content')
  <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('posts.partials.form')
    <div><input type="submit" value="{{ __('Create!') }}" class="btn btn-primary btn-block"></div>
  </form>
@endsection