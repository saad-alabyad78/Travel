<?php

namespace Tests\Feature;

use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TourPaginationTest extends TestCase
{
    use RefreshDatabase ;

    public function test_tours_return_with_same_travel()
    {
        $travel = Travel::factory(2)->create() ;

        $tours = Tour::factory(5)->create([ 'travel_id' => $travel[0]->id]) ;
                 Tour::factory(5)->create() ;

        $response = $this->get('api/travels/'.$travel[0]->slug.'/tours') ;

        $response->assertStatus(200);
        $response->assertJsonCount(5 , 'data');
        $response->assertJsonPath('meta.last_page' , 1);

        for($i=0 ;$i<5 ;++$i){
            $response->assertJsonPath('data.'. $i . '.travel_id'  , $travel[0]->id) ;
        }

        $this->assertDatabaseCount('travels' , 2 + 5 + 5);
        $this->assertDatabaseCount('tours'   , 5 + 5);
    }
}
