<?php

namespace Tests\Feature;

use App\Models\Travel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TravelPaginationTest extends TestCase
{
    use RefreshDatabase;

    public function test_travels_list_returns_pagination_correctly(): void
    {
        Travel::factory(16)->create([
            'name'=>'is public' ,
            'is_public' => true,
        ]);

        Travel::factory(16)->create([
            'name' => 'is not public' ,
            'is_public' => false,
        ]);

        $response = $this->get('api/travels');

        $response->assertStatus(200);
        $response->assertJsonCount(15 , 'data');
        $response->assertJsonPath('meta.last_page' , 2);

        for($i=0 ; $i<15 ; $i++){
            $response->assertJsonPath('data.' . $i . '.name' , 'is public');
        }

        $this->assertDatabaseCount('travels' , 32);
    }
}
