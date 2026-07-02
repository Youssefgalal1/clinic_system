<?php

namespace App\Http\Controllers\Dashboard;


use App\Http\Controllers\Dashboard\Controller;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Doctor;
use App\Models\Review;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(Request $request)
     {
    //    $query = Doctor::query();
        $query = Doctor::query()->with([
            'specialization',
            'user',
            'reviews',
            'schedules'
        ]);
       if ($request->filled('specialization')) {
         $query->whereHas('specialization', function ($q) use ($request) {
         $q->where('name', 'like', '%' . $request->specialization . '%');
         });
       }
       if($request->filled('rating')){
        $query->where('rating',$request->query('rating'));
       }
       if($request->filled('search')){
        $query->where('name','like','%'.$request->query('search').'%');
       }
       if($request->filled('sort')){
        $query->orderBy($request->query('sort') ?? 'id');
       }
       $doctors = $query->paginate(10)->withQueryString();
       return response(['message'=>'date retrived succcessfuly',
       'date'=>$doctors]);
    }

    public function show(Doctor $doctor)
    {
        return response()->json([
        'message'=>'user retrived successfuly', 
        'data'=>$doctor]);
    }


    public function store(StoreDoctorRequest $request)
    {
        // validate the data
        $validated = $request->validated();
        // store the data
        $data = Doctor::create($validated);
        // redirect to index
        return response()->json([
        'message'=>'data stored successfuly',    
        'user'=>$data]);
    }

    public function update(UpdateDoctorRequest $request,Doctor $doctor)
    {
        // validate the data
        $validated = $request->validated();
        // update the data
        $doctor->update($validated);
        // redirect to index
        return response()->json([
        'message'=>'data updated successfuly',    
        'user'=>$doctor]);
    }

    public function destroy(string $id)
    {
        // delete the data
        Doctor::where('id', $id)->delete();
        // redirect to index
        return response()->json(['message'=>'data deleted successfuly']);
    }
}
