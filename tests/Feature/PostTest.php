<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{   
    use RefreshDatabase;

    public function testNoBlogPostsWhenNothingInDatabase()
    {
        $response = $this->get('/posts');

        $response->assertSeeText('No posts found!');
    }

    Public function testSeeOneBlogPostWhenThereIsNoComments()
    {
        $post = $this->createDummyBlogPost();

        $response = $this->get('/posts');

        $response->assertSeeText('New title');
        $response->assertSeeText('No comments yet!');

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New title',
        ]);
    }

    Public function testSeeOneBlogPostWithComments()
    {
        $post = $this->createDummyBlogPost();

        Comment::factory(4)->create([
            'blog_post_id' => $post->id,
        ]);

        $response = $this->get('/posts');

        $response->assertSeeText('4 comments');
    }


    public function testStoreValid() 
    {
        // $user = $this->user();

        $params = [
            'title' => 'Valid title',
            'content' => 'At least 10 characters'
        ];

        $this->post('/posts', $params)
            ->assertStatus(302);  

    }

    // public function testStoreInvalid()
    // {
    //     $params = [
    //         'title' => 'x',
    //         'content' => 'x'
    //     ]; 

    //     $this->post('/posts', $params)
    //         ->assertStatus(302)
    //         ->assertSessionHas('errors');

    //     $messages = session('errors')->getMessages();

    //     $this->assertEquals($messages['title'][0], 'The title must be at least 5 characters.');
    //     $this->assertEquals($messages['content'][0], 'The content must be at least 10 characters.');
    // }

    // public function testUpdateInvalid() 
    // {
    //     $post = $this->createDummyBlogPost();

    //     $this->assertDatabaseHas('blog_posts', $post->toArray());

    //     $params = [
    //         'title' => 'this is going to be an invalid very very very very very very very very very very very very very very very long title',
    //         'content' => 'Content has changed!'
    //     ]; 

        
    //     $this->post('/posts', $params)
    //         ->assertStatus(302)
    //         ->assertSessionHas('errors');

    //     $messages = session('errors')->getMessages();

    //     $this->assertEquals($messages['title'][0], 'The title may not be greater than 100 characters.');

    //     $this->assertDatabaseHas('blog_posts', $post->toArray());
    //     $this->assertDatabaseMissing('blog_posts', [
    //         'title' => 'A new named title'
    //     ]);
    // }

    // public function testUpdateValid() 
    // {
    //     $post = $this->createDummyBlogPost();

    //     $this->assertDatabaseHas('blog_posts', $post->toArray());

    //     $params = [
    //         'title' => 'A new named title',
    //         'content' => 'Content has changed!'
    //     ]; 

    //     $this->put("/posts/{$post->id}", $params)
    //         ->assertStatus(302)
    //         ->assertSessionHas('status');

    //     $this->assertEquals(session('status'), 'Blog post was updated!!!');

    //     $this->assertDatabaseMissing('blog_posts', $post->toArray());
    //     $this->assertDatabaseHas('blog_posts', [
    //         'title' => 'A new named title'
    //     ]);
    // }

    // public function testDelete()
    // {
    //     $post = $this->createDummyBlogPost();

    //     $this->assertDatabaseHas('blog_posts', $post->toArray());
        
    //     $this->delete("/posts/{$post->id}")
    //         ->assertStatus(302)
    //         ->assertSessionHas('status');

    //     $this->assertEquals(session('status'), 'Blog post was deleted!');

    //     $this->assertDatabaseMissing('blog_posts', $post->toArray());
       
    // }

    private function createDummyBlogPost(): BlogPost
    {
        // $post = new BlogPost();
        // $post->title = 'New title';
        // $post->content = 'Content of the blog post';
        // $post->save();

        return BlogPost::factory()->published()->create();
        // return $post;
    }
}
