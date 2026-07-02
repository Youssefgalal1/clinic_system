@extends('layout.app')

@section('title') index @endsection

@section('content')
@include('inc.message')
<div class="text-center my-3">
  <a href="{{route('Dashboard.appointments.create')}}" class="btn btn-success">Add appointment</a>
</div> 

<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">patient</th>
      <th scope="col">doctor</th>
      <th scope="col">clinic</th>
      <th scope="col">appointment_date</th>
      <th scope="col">status</th>
      <th scope="col">action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($appointments as $appointment)
    <tr>
      <th scope="row">{{$appointment->id}}</th>
      <td>{{$appointment->user->name}}</td>
      <td>{{$appointment->doctor->user->name}}</td>
      <td>{{$appointment->clinic->name}}</td>
      <td>{{$appointment->appointment_date}}</td>
      <td>{!!$appointment->status()!!}</td>
      <td>
        <a href="{{route('Dashboard.appointments.edit',$appointment->id)}}" class="btn btn-info">Edit</a>
      <form style="display:inline;" method="POST" action="{{route('Dashboard.appointments.destroy',$appointment->id)}}">
        @csrf
        @method("DELETE")
        <button onclick="confirm('do you want to delete?')" class="btn btn-danger">Delete</button>
      </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

<div>
   {{ $appointments->links() }}
</div>

@endsection