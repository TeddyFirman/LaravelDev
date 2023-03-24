<?php

namespace Tests\Feature;

use App\Category as AppCategory;
use App\Models\Category;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Response;

class CategoryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    use RefreshDatabase, WithFaker, WithoutMiddleware;



    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function test_category_listing()
    {

        $response = $this->get('/api/categories');

        $response->assertStatus(200);
    }

    public function test_category_create()
    {
        factory(AppCategory::class)->make();

        $response = $this->post('/api/categories/', [
            'name' => 'apple',
            'is_publish' => 1
        ]);


        $response->assertStatus(302);

        $this->assertDatabaseHas('categories', [
            'name' => 'apple',
            'is_publish' => 1
        ]);
    }

    public function test_can_update_category()
    {

        $data = [
            'name' => 'Jeruk',
            'is_publish' => 1,
        ];


        $categories = AppCategory::create($data);


        $datas = [
            'name' => 'Es Jeruk',
            'is_publish' => 0,
        ];


        $response = $this->json('PUT', '/api/categories/' . $categories->id, $datas);


        $response->assertStatus(302);


        $this->assertDatabaseHas('categories', $data);
    }

    public function test_can_delete_category()
    {

        $response = $this->delete('/api/categories/{category}');

        $response->assertStatus(302);
    }
}
