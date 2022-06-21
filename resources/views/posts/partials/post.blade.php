<div class="row">
    <div class="col-8">
    @forelse ($posts as $post)
        <p>
            <h3>
                @if($post->trashed())
                    <del>
                @endif
                <a class="{{ $post->trashed() ? 'text-muted' : '' }}"
                    href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
                @if($post->trashed())
                    </del>
                @endif
            </h3>

            <x-updated :date="$post->created_at" :userId="$post->user->id" :name="$post->user->name" />

            <x-tags :tags="$post->tags" />

            <p>
                {{ trans_choice('messages.comments', $post->comments_count) }}
            </p>

            <div class="d-flex flex-row">
                @auth
                    @can('update', $post)
                        <a href="{{ route('posts.edit', ['post' => $post->id]) }}"
                            class="btn btn-primary">
                            {{ __('Edit') }}
                        </a>
                    @endcan
                @endauth

                {{-- @cannot('delete', $post)
                    <p>You can't delete this post</p>
                @endcannot --}}

                @auth
                    @if(!$post->trashed())
                        @can('delete', $post)
                            <form method="POST" class="fm-inline"
                                action="{{ route('posts.destroy', ['post' => $post->id]) }}">
                                @csrf
                                @method('DELETE')

                                <input type="submit" value="{{ __('Delete!') }}" class="btn btn-primary"/>
                            </form>
                        @endcan
                    @endif
                @endauth
            </div>
        </p>
    @empty
        <p>{{ __('No blog posts yet!') }}</p>
    @endforelse
    </div>
    <div class="col-4">
        @include('posts.partials.activity')
    </div>
</div>    
