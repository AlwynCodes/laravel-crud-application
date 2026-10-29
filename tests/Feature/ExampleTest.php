<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_the_home_page_redirects_to_login(): void
    {
        $this->get('/')->assertRedirect('/login');
    }

    public function test_the_health_check_endpoint_responds(): void
    {
        $this->get('/up')->assertOk();
    }
}
