<div class="d-flex flex-column mb-3 align-items-baseline d-flex ">
    <h3>
        <a href="{{ route('posts.show', ['post' => $post->id]) }}">
            {{ $post->title }}
        </a>
    </h3>

    <p class="text-muted">
        Added {{ $post->created_at->diffForHumans() }}
    </br>
        By {{ $post->user->name }}
    </p>

    @if($post->comments_count)
        <p class="d-inline-flex p-2">{{ $post->comments_count }} comments</p>
    @else
        <p> No comments yet!</p>
    @endif
</div>

<div class="d-flex flex-row mb-3">
    <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Edit</a>
    <form action="{{ route('posts.destroy', ['post' => $post-> id]) }}" method="POST">
        @csrf
        @method('DELETE')
        <input type="submit" value="Delete!" class="btn btn-primary">
    </form>
</div>