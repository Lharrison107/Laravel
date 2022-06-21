<div class="container">
    <div class="row">
            <x-cards 
                :title="__('Most Commented')" 
                :subtitle="__('What people are currently talking about')">
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
            :title="__('Most Active')" 
            :subtitle="__('Writers with most posts written')"
            :items="collect($mostBlogPosts)->pluck('name')" 
        />
    </div>

    <div class="row mt-4">
        <x-cards 
            :title="__('Most Active Last Month')" 
            :subtitle="__('Users with most posts written in the month')" 
            :items="collect($mostBlogPostsLastMonth)->pluck('name')" 
        />
    </div>
</div> 