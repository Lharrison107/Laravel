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

                <x-tags :tags="$post->tags" />

                @if($post->comments_count)
                    <p class="d-inline-flex p-2">{{ $post->comments_count }} comments</p>
                @else
                    <p> No comments yet!</p>
                @endif
                <div class="d-flex flex-row">  
                    @auth
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
                    @endauth        
                
                </div>  
            </div>
        @empty
            No posts found!
        @endforelse
    </div>
    <div class="col-4">
        @include('posts.partials.activity')
    </div>
</div>
