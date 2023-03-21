<?php

namespace Tests\Feature;

use App\Category as AppCategory;
use App\Models\Category;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;

class CategoryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    use RefreshDatabase, WithFaker, WithoutMiddleware;

    public function testGetCategories()
    {
        // create some categories
        AppCategory::factory()->count(5)->create();

        // make request to /api/categories
        $response = $this->get('/api/categories');

        // assert response status code is 200
        $response->assertStatus(Response::HTTP_OK);

        // assert response contains 5 categories
        $this->assertCount(5, json_decode($response->getContent())->data);
    }

    public function testCreateCategory()
    {
        // set category data
        $categoryData = [
            'name' => 'Test Category',
            'is_publish' => true
        ];

        // make request to /api/categories with POST method
        $response = $this->post('/api/categories', $categoryData);

        // assert response status code is 201
        $response->assertStatus(Response::HTTP_CREATED);

        // assert response contains created category
        $this->assertJsonStringEqualsJsonString(json_encode(['data' => $categoryData]), $response->getContent());
    }

    public function testUpdateCategory()
    {
        // create a category
        $category = AppCategory::factory()->create();

        // set updated category data
        $updatedCategoryData = [
            'name' => 'Updated Test Category',
            'is_publish' => false
        ];

        // make request to /api/categories/{id} with PUT method
        $response = $this->put("/api/categories/{$category->id}", $updatedCategoryData);

        // assert response status code is 200
        $response->assertStatus(Response::HTTP_OK);

        // assert response contains updated category
        $this->assertJsonStringEqualsJsonString(json_encode(['data' => $updatedCategoryData]), $response->getContent());
    }

    public function testDeleteCategory()
    {
        // create a category
        $category = AppCategory::factory()->create();

        // make request to /api/categories/{id} with DELETE method
        $response = $this->delete("/api/categories/{$category->id}");

        // assert response status code is 204
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
