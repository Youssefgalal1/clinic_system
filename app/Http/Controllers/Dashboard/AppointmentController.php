<?php

namespace App\Http\Controllers\Dashboard;


use App\Http\Controllers\Dashboard\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\User;
use App\Services\AppointmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Traits\apiResponse;


class AppointmentController extends Controller
{
    use apiResponse;
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
       return $this->apiResponse($appointments, 'data retrived successfuly');
    }

    public function store(StoreAppointmentRequest $request , AppointmentService $service)
    {
        // validate the data
        $validated = $request->validated();
        // store the data
        $data = $service->create($validated);
        return $this->apiResponse($data, 'data stored successfuly');
    }

    public function update(UpdateAppointmentRequest $request,Appointment $appointment , AppointmentService $service)
    {
        // validate the data
        $validated = $request->validated();
        // update the data 
        $appointment=$service->update($appointment,$validated);
        return $this->apiResponse($appointment, 'data updated successfuly');
    }

    public function destroy(string $id)
    {
        // delete the data
        Appointment::where('id', $id)->delete();
       return $this->apiResponse(null, 'data deleted successfuly');
    }

    public function confirm(Appointment $appointment,AppointmentService $service)
    {
        $this->authorize('confirm',$appointment);
        return $this->apiResponse($service->confirm($appointment), 'Appointment confirmed');
    }

    public function complete(Appointment $appointment,AppointmentService $service)
    {
        $this->authorize('complete',$appointment);
        return $this->apiResponse($service->complete($appointment), 'Appointment completed');
    }

    public function cancel(Appointment $appointment,AppointmentService $service)
    {
        $this->authorize('cancel',$appointment);
        return $this->apiResponse($service->cancel($appointment), 'Appointment canceled');
    }
}