@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="row">
        <div class="col-8">
            @if ($post->image)
                <div style="background-image: url('{{ $post->image->url() }}'); min-height: 500px; color: white; text-align: center; background-attachment: fixed; ">
                    <h1 style="padding-top: 100px; text-shadow: 1px 2px #000">
            @else

                <h1>

            @endif

                {{ $post->title }}
                <x-badge :show="now()->diffInMinutes($post->created_at) < 20">
                    New Blog Post!
                </x-badge>

            @if ($post->image)

                    </h1>
                </div>
                
            @else

                 </h1>

            @endif

           

            <p> {{ $post->content }} </p>

            {{-- <img src="{{ $post->image->url() }}" /> --}}
            {{-- @dump( $post->image->url()) --}}

            <x-updated :date="$post->created_at" :name="$post->user->name"/>
            <x-updated :date="$post->updated_at">
                Updated 
            </x-updated>

            <x-tags :tags="$post->tags" />
            
            <p>Currently Read By {{ $counter }} People</p>

            <h4>Comments</h4>

            @include('comments.partials.form')

            @forelse($post->comments as $comment)
                <p>{{ $comment->content }}</p>
            <x-updated :date="$comment->created_at" :name="$comment->user->name" />
            @empty
                <p> No comments yet!</p>
            @endforelse
        </div>
        <div class="col-4">
            @include('posts.partials.activity')
        </div>
    </div>
    <!-- @isset($post['has_comments'])
        <div>The post has some comments.... using isset</div>
    @endisset -->
@endsection