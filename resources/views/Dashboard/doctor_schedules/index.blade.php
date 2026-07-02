@extends('layout.app')

@section('title') index @endsection

@section('content')
@include('inc.message')
<div class="text-center my-3">
  <a href="{{route('Dashboard.doctor_schedules.create')}}" class="btn btn-success">Add schedule</a>
</div> 

<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">clinic</th>
      <th scope="col">day</th>
      <th scope="col">start_time</th>
      <th scope="col">end_tyme</th>
      <th scope="col">action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($schedules as $schedule)
    <tr>
      <th scope="row">{{$schedule->id}}</th>
      <td>{{$schedule->doctor->user->name}}</td>
      <td>{{$schedule->clinic->name}}</td>
      <td>{{$schedule->day}}</td>
      <td>{{$schedule->start_time}}</td>
      <td>{{$schedule->end_time}}</td>
      <td>
        <a href="{{route('Dashboard.doctor_schedules.edit',$schedule->id)}}" class="btn btn-info">Edit</a>
      <form style="display:inline;" method="POST" action="{{route('Dashboard.doctor_schedules.destroy',$schedule->id)}}">
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
   {{ $schedules->links() }}
</div>

@endsection