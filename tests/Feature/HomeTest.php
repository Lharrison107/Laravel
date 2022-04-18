<?php

namespace Tests\Feature;


use Tests\TestCase;

class HomeTest extends TestCase
{
    public function testHomePageWorkingCorrectly()
    {
        $response = $this->get('/');

        $response->assertSeeText('Welcome To Laravel');
        $response->assertSeeText('this is an intro into laravel 8');
    }

    public function testContactPageIsWorkingCorrectly ()
    {
        $response = $this->get('/contact');

        $response->assertSeeText('Contacts Page');
        $response->assertSeeText('Phone: (803) 867-5309');
        $response->assertSeeText('Name: Stacies Mom');
    }
}
