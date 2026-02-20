<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ApiTokenMiddleware;

class ApiTokenMiddlewareTest extends TestCase
{
    /** @test */
    public function it_allows_request_with_correct_token()
    {
        Route::middleware(ApiTokenMiddleware::class)->get('/test-middleware', function () {
            return response()->json(['message' => 'Passed']);
        });

        $response = $this->getJson('/test-middleware', [
            'Authorization' => 'Bearer ' . config('app.api_token')
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Passed']);
    }

    /** @test */
    public function it_blocks_request_without_token()
    {
        Route::middleware(ApiTokenMiddleware::class)->get('/test-middleware', function () {
            return response()->json(['message' => 'Passed']);
        });

        $response = $this->getJson('/test-middleware');

        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthorized']);
    }

    /** @test */
    public function it_blocks_request_with_incorrect_token()
    {
        Route::middleware(ApiTokenMiddleware::class)->get('/test-middleware', function () {
            return response()->json(['message' => 'Passed']);
        });

        $response = $this->getJson('/test-middleware', [
            'Authorization' => 'Bearer wrongtoken'
        ]);

        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthorized']);
    }
}
