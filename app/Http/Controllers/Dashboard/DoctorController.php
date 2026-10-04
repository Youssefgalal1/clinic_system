<?php

namespace App\Http\Controllers\Dashboard;


use App\Http\Controllers\Dashboard\Controller;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use App\Models\Review;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\apiResponse;

class DoctorController extends Controller
{
    use apiResponse;
    public function index(Request $request)
     {
        $this->authorize('viewAny',Doctor::class);
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
       return $this->apiResponse(DoctorResource::collection($doctors), 'data retrived successfuly');
    }

    public function show(Doctor $doctor)
    {
        $this->authorize('view',$doctor);
        return $this->apiResponse(new DoctorResource($doctor), 'doctor retrived successfuly');
    }


    public function store(StoreDoctorRequest $request)
    {
        $this->authorize('create',Doctor::class);
        // validate the data
        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('doctors', 'public');
            $validated['image'] = $path;
        }
        // store the data
        $data = Doctor::create($validated);
        // redirect to index
        return $this->apiResponse(new DoctorResource($data), 'data stored successfuly');
    }

    public function update(UpdateDoctorRequest $request,Doctor $doctor)
    {
        $this->authorize('update',$doctor);
        // validate the data
        $validated = $request->validated();
        if ($request->hasFile('image')) {
        Storage::disk('public')->delete($doctor->image);
        $path = $request->file('image')->store('doctors', 'public');
        $validated['image'] = $path;
}
        // update the data
        $doctor->update($validated);
        return $this->apiResponse(new DoctorResource($doctor), 'data updated successfuly');
    }

    public function destroy(string $id)
    {
        $doctor = Doctor::findOrFail($id);
        $this->authorize('delete',$doctor);
        // delete the data
        $doctor->delete();
        // redirect to index
        return $this->apiResponse(null, 'data deleted successfuly');
    }
}
