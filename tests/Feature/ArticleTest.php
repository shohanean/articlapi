<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }
    public function test_get_all_article()
    {
        $token = "1|GX2SwO8Y5QX3BdBbRronfccYRYJtAbNm4sOCMT7m";
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/article')
        ->assertStatus(200)
            ->assertJsonStructure(
                [
                    [
                        "id",
                        "user_id",
                        "title",
                        "description",
                        "created_at",
                        "updated_at",
                    ]
                ]
            );
    }
}
