<?php

namespace App\Http\Controllers\Dashboard;


use App\Http\Controllers\Dashboard\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
        {
        // get appointments with its relations by with([])
       $query = Appointment::query()->with([
        'user',
        'doctor',
        'clinic'
       ]);
       if($request->filled('status')){
        $query->where('status',$request->query('status'));
       }
       if($request->filled('search')){
        $query->where('appointment_date','like','%'.$request->query('search').'%');
       }
       if($request->filled('sort')){
        $query->orderBy($request->query('sort') ?? 'id');
       }
       $appointments = $query->paginate(10);
       return response()->json([
        'message'=>'data retrived successfuly',
        'data'=>$appointments
       ]);
    }

    public function store(StoreAppointmentRequest $request)
    {
        // validate the data
        $validated = $request->validated();
        // store the data
        $data = Appointment::create($validated);
       return response()->json([
        'message'=>'data stored successfuly',
        'data'=>$data
       ]);
    }

    public function update(UpdateAppointmentRequest $request,Appointment $appointment)
    {
        // validate the data
        $validated = $request->validated();
        // update the data
        $appointment->update($validated);
       return response()->json([
        'message'=>'data updated successfuly',
        'data'=>$appointment
       ]);
    }

    public function destroy(string $id)
    {
        // delete the data
        Appointment::where('id', $id)->delete();
       return response()->json(['message'=>'data deleted successfuly']);
    }
}