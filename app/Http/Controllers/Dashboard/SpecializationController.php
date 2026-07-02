<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\Controller;
use App\Http\Requests\StoreSpecializationRequest;
use App\Http\Requests\UpdateSpecializationRequest;
use App\Models\Specialization;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
class SpecializationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Specialization::query();
       if($request->filled('search')){
        $query->where('name','like','%'.$request->query('search').'%');
       }
       if($request->filled('sort')){
        $query->orderBy($request->query('sort') ?? 'id');
       }
       $specializations = $query->paginate(5);
       return response()->json(['message'=>'data retirived successfuly','data'=>$specializations],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSpecializationRequest $request)
    {
        //vlaidate the data
       $specialization = $request->validated(); 
        $image = $request->file('image')->store('public');
        //store the data
        $specialization['image'] = $image;
        Specialization::create($specialization);
        //redirect to index
        return response()->json([
        'message'=>'data stored successfuly',    
        'data'=>$specialization]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Specialization $specialization)
    {
       return response()->json(['data'=>$specialization]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSpecializationRequest $request, string $id)
    {
        //vlaidate date
        $old_specialization = Specialization::findOrFail($id);
        $specialization = $request->validated(); 
        $old_image = $old_specialization->image;
        if($request->hasFile('image')){
            $new_image = $request->file('image')->store('public');
            File::delete($old_image);
            $specialization['image'] = $new_image;
            }
        //update data
        Specialization::where('id',$id)->update($specialization);
        //redirect to index
        return response()->json([
        'message'=>'data updated successfuly',    
        'data'=>$specialization]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Specialization::where('id',$id)->delete();
        //redirect to index
        return response()->json(['message'=>'data deleted succcess']);
    }
}
