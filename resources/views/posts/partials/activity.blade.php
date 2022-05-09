<div class="container">
    <div class="row">
            <x-cards 
                :title="'Biggest Topic'" 
                :subtitle="'Whats the gosip about?'">
                @slot('items')
                    @foreach ($mostCommented as $post)
                        <li class="list-group-item">
                            <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                                {{ $post->title }}
                            </a>
                        </li>
                    @endforeach
                @endslot
            </x-cards>            
    </div>

    <div class="row mt-4">
        <x-cards 
            :title="'Most Active'" 
            :subtitle="'Whos got the most to say?'"
            :items="collect($mostBlogPosts)->pluck('name')" 
        />
    </div>

    <div class="row mt-4">
        <x-cards 
            :title="'Most Active Last Month'" 
            :subtitle="'Who had the most to say?'" 
            :items="collect($mostBlogPostsLastMonth)->pluck('name')" 
        />
    </div>
</div> 