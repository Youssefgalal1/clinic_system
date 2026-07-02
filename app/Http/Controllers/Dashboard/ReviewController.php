<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Http\Requests\UpdateRewiewRequest;
use App\Models\Doctor;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
       {
       $query = Review::query();
       if($request->filled('rating')){
        $query->where('rating',$request->query('rating'));
       }
       if($request->filled('search')){
        $query->where('name','like','%'.$request->query('search').'%');
       }
       if($request->filled('sort')){
        $query->orderBy($request->query('sort') ?? 'id');
       }
       $reviews = $query->paginate(10);
       return response()->json(['message'=>'data retrived successfuly',
       'data'=>$reviews
       ]);
    }

    public function store(StoreReviewRequest $request)
    {
        // validate the data
        $review = $request->validated();
        // store the data
        $data = Review::create($review);
        // redirect to index
        return response()->json([
            'message'=>'data stored successfuly',
            'data'=>$data
        ]);
    }


    public function update(UpdateRewiewRequest $request,Review $review)
    {
        // validate the data
        $validated = $request->validated();
        // update the data
        $review->update($validated);
        // redirect to index
        return response()->json([
            'message'=>'data updated successfuly',
            'data'=>$review
        ]);
    }

    public function destroy(string $id)
    {
        // delete the data
        Review::where('id', $id)->delete();
        // redirect to index
        return response()->json([
            'message'=>'data deleted successfuly'
        ]);
    }
}
