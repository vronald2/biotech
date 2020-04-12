<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProductTest extends TestCase
{

    use RefreshDatabase;

    public function testProductList()
    {

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get('/product');

        $response->assertSee("Új termék");

    }

    public function testProductCreatePageIsLoaded()
    {

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get('/product/create');

        $response->assertSee("product-form-component");

    }

    public function testCreateNewProductWithValidData()
    {

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/product', [
            'name_en' => 'Angol név',
            'file' => UploadedFile::fake()->image('test.jpg'),
            'name_hu' => 'Magyar név',
            'tags' => 'tag1,tag2,tag3',
            'publish_start' => '2020-01-17',
            'publish_end' => '2020-12-30',
            'description_en' => 'lorem ipsum angol',
            'description_hu' => 'lorem ipsum magyar',
            'price_en' => 211,
            'price_hu' => 100
        ]);


        $response->assertStatus(200);
    }


    public function testCreateNewProductWithInvalidValidDataNoImage()
    {

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/product', [
            'name_en' => 'Angol név',
            //'file' => UploadedFile::fake()->image('test.jpg'),
            'name_hu' => 'Magyar név',
            'tags' => 'tag1,tag2,tag3',
            'publish_start' => '2020-01-17',
            'publish_end' => '2020-12-30',
            'description_en' => 'lorem ipsum angol',
            'description_hu' => 'lorem ipsum magyar',
            'price_en' => 211,
            'price_hu' => 100
        ]);


        $response->assertStatus(422);
    }


    public function testCreateNewProductInvalidPublishStart()
    {

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/product', [
            'name_en' => 'Angol név',
            'file' => UploadedFile::fake()->image('test.jpg'),
            'name_hu' => 'Magyar név',
            'tags' => 'tag1,tag2,tag3',
            // 'publish_start' => '2020-12-30',
            'publish_end' => '2020-12-30',
            'description_en' => 'lorem ipsum angol',
            'description_hu' => 'lorem ipsum magyar',
            'price_en' => 211,
            'price_hu' => 100
        ]);


        $response->assertStatus(422);
    }


    public function testCreateNewProductInvalidPrice()
    {

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/product', [
            'name_en' => 'Angol név',
            'file' => UploadedFile::fake()->image('test.jpg'),
            'name_hu' => 'Magyar név',
            'tags' => 'tag1,tag2,tag3',
            // 'publish_start' => '2020-12-30',
            'publish_end' => '2020-12-30',
            'description_en' => 'lorem ipsum angol',
            'description_hu' => 'lorem ipsum magyar',
            'price_en' => 'string',
            'price_hu' => 100
        ]);


        $response->assertStatus(422);
    }
}
