<?php

namespace App\Http\Controllers\Dashboard;


use App\Http\Controllers\Dashboard\Controller;
use App\Http\Requests\StoreClinicRequest;
use App\Http\Requests\UpdateClinicRequest;
use App\Models\Clinic;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    public function index(Request $request)
        {
       $query = Clinic::query()->with([
        'doctors',
        'appointments'
       ]);
       if($request->filled('address')){
        $query->where('address',$request->query('address'));
       }
       if($request->filled('search')){
        $query->where('address','like','%'.$request->query('search').'%');
       }
       if($request->filled('sort')){
        $query->orderBy($request->query('sort') ?? 'id');
       }
       $clinics = $query->paginate(10);
       return response()->json([
        'message'=>'data retrived successfuly',
        'data'=>$clinics
       ]);
    }

    public function show(Clinic $clinic)
    {
         // get single clinic with its relations by load instead of with([])
        $clinic->load(['doctors', 'appointments']);
        // send data to view
       return response()->json([
        'message'=>'data retrived successfuly',
        'data'=>$clinic
       ]);
    }

    public function store(StoreClinicRequest $request)
    {
        // validate the data
        $validated = $request->validated();
        // store the data
        $data = Clinic::create($validated);
       return response()->json([
        'message'=>'data stored successfuly',
        'data'=>$data
       ]);
    }

    public function update(UpdateClinicRequest $request,Clinic $clinic)
    {
        // validate the data
        $validated = $request->validated();
        // update the data
        $clinic->update($validated);
       return response()->json([
        'message'=>'data updated successfuly',
        'data'=>$clinic
       ]);
    }

    public function destroy(string $id)
    {
        // delete the data
        Clinic::where('id', $id)->delete();
       return response()->json(['message'=>'data deleted successfuly',]);
    }
}
