<?php

namespace App\Http\Controllers\Dashboard;


use App\Http\Controllers\Dashboard\Controller;
use App\Http\Requests\StoreDoctorScheduleRequest;
use App\Http\Requests\UpdateDoctorScheduleRequest;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;

class DoctorScheduleController extends Controller
{
    public function index(Request $request)
        {
            
        $query = DoctorSchedule::query();

        if ($request->filled('clinic')) {
         $query->whereHas('clinic', function ($q) use ($request) {
         $q->where('name', 'like', '%' . $request->clinic . '%');
         });
        }
       if($request->filled('day')){
        $query->where('day',$request->query('day'));
       }
       if($request->filled('search')){
        $query->where('name','like','%'.$request->query('search').'%');
       }
       if($request->filled('sort')){
        $query->orderBy($request->query('sort') ?? 'id');
       }
       $schedules = $query->paginate(10);
        return response()->json(['message'=>'data retrived successfuly',
       'data'=>$schedules]);
    }


    public function store(StoreDoctorScheduleRequest $request)
    {
        // validate the data
        $validated = $request->validated();
        // store the data
        $data = DoctorSchedule::create($validated);
        return response()->json([
        'message'=>'data stored successfuly',    
        'data'=> $data]);
    }


    public function update(UpdateDoctorScheduleRequest $request,DoctorSchedule $schedule)
    {
        // validate the data
        $validated = $request->validated();
        // update the data
        $schedule->update($validated);
        return response()->json([
        'message'=>'data updated successfuly',    
        'data'=> $schedule]);
    }

    public function destroy(string $id)
    {
        // delete the data
        DoctorSchedule::where('id', $id)->delete();
        // redirect to index
        return response()->json(['message'=>'data deleted successfuly',]);
    }
}
