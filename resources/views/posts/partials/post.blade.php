<div class="row">
    <div class="col-8">
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
            @can('update-post', $post)
                <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Edit</a>
            @endcan

            @can('delete-post', $post)
                <form action="{{ route('posts.destroy', ['post' => $post-> id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="Delete!" class="btn btn-primary">
                </form> 
            @endcan
            
        </div> 
    </div>
    <div class="col-4">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Most Commented</h5>
                <h6 class="card-subtitle mb-2 text-muted">
                    What people are currently talking about
                </h6>
            </div>
            <ul class="list-group list-group-flush">
                @foreach ($mostCommented as $post)
                    <li class="list-group-item">
                        <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                            {{ $post->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>   
</div>