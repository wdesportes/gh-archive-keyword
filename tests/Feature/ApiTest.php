<?php

namespace Tests\Feature;

use Tests\TestCase;

final class ApiTest extends TestCase
{
    /**
     * Test that the search API works
     *
     * @return void
     */
    public function testSearchApiInvalid(): void
    {
        $response = $this->getJson('/api/search/stats');
        $response->assertStatus(422);
    }

    /**
     * Test that the search API works with query params
     *
     * @return void
     */
    public function testSearchApiParam(): void
    {
        $response = $this->getJson('/api/search/stats?searchDate=2030-04-26');
        $response->assertStatus(200);
        $response->assertExactJson([
            'commentsPoints' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            'commitsPoints' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            'pullsPoints' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
        ]);
    }

    /**
     * Test that the search API works with query params
     *
     * @return void
     */
    public function testSearchApiParams(): void
    {
        $response = $this->getJson('/api/search/stats?searchDate=2030-04-26&searchTerm=l');
        $response->assertStatus(200);
        $response->assertExactJson([
            'commentsPoints' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            'commitsPoints' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            'pullsPoints' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
        ]);
    }
}
