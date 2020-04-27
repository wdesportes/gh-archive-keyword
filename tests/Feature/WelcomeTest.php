<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Test the the welcome page works
     *
     * @return void
     */
    public function testWelcomePage(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test the the search page works
     *
     * @return void
     */
    public function testSearchPage(): void
    {
        $response = $this->get('/search');

        $response->assertStatus(200);
    }

    /**
     * Test the the search page works with query params
     *
     * @return void
     */
    public function testSearchPageParams(): void
    {
        $response = $this->get('/search?searchDate=2020-04-26&searchTerm=l');

        $response->assertStatus(200);
    }
}
