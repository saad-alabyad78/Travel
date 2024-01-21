<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourFilterRequest;
use App\Http\Resources\TourResource;

use App\Models\Travel;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index(Travel $travel , TourFilterRequest $request)
    {
        return $request->validated();
        $tours =
        $travel->tours()
               ->when($request->dateFrom , function ($query) use ($request){
                    $query->where('starting_date' , '>=' , $request->dateFrom);
                })
               ->when($request->dateTo , function ($query) use ($request){
                    $query->where('ending_date' , '<=' , $request->dateTo);
                })
                ->when($request->priceFrom , function ($query) use ($request){
                    $query->where('price' , '>=' , $request->priceFrom * 100);
                })
                ->when($request->priceTo , function ($query) use ($request){
                    $query->where('price' , '<=' , $request->priceTo * 100);
                })

                ->when($request->sortOrder and $request->sortBy , function ($query) use ($request){
                    $query->OrderBy($request->sortBy , $request->sortOrder);
                })
               ->OrderBy('starting_date')
               ->paginate();

        return TourResource::collection($tours);
    }
}
