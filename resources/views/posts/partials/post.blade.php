<div class="row">
    <div class="col-8">
        @forelse ($posts as $key => $post)
            <div>
                <h3>
                    @if ($post->trashed())
                        <del>
                    @endif
                    <a class="{{ $post->trashed() ? 'text-muted' : '' }}" href="{{ route('posts.show', ['post' => $post->id]) }}">
                        {{ $post->title }}
                    </a>
                    @if ($post->trashed())
                        </del>
                    @endif
                </h3>

                <x-updated :date="$post->created_at" :name="$post->user->name"/>

                @if($post->comments_count)
                    <p class="d-inline-flex p-2">{{ $post->comments_count }} comments</p>
                @else
                    <p> No comments yet!</p>
                @endif
                <div class="d-flex flex-row">          
                    @can('update-post', $post)
                        <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Edit</a>
                    @endcan
                    @if (!$post->trashed())
                        @can('delete-post', $post)
                            <form action="{{ route('posts.destroy', ['post' => $post-> id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="Delete!" class="btn btn-primary">
                            </form> 
                        @endcan 
                    @endif  
                </div>  
            </div>
        @empty
            No posts found!
        @endforelse
    </div>
    <div class="col-4">
        <div class="container">
            <div class="row">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title">Biggest Topic</h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            What's the gosip about? 
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

            <div class="row mt-4">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title">Most Active</h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            Whos got the most to say?
                        </h6>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($mostActive as $user)
                            <li class="list-group-item">
                                {{ $user->name }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="row mt-4">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title">Most Active Last Month</h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            who had the most to say last month? 
                        </h6>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($mostActiveLastMonth as $user)
                            <li class="list-group-item">
                                {{ $user->name }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>   
