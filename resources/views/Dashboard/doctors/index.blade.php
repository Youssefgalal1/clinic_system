@extends('layout.app')

@section('title') index @endsection

@section('content')
@include('inc.message')
<div class="text-center my-3">
  <a href="{{route('Dashboard.doctors.create')}}" class="btn btn-success">Add doctor</a>
</div> 

<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">specialization</th>
      <th scope="col">title</th>
      <th scope="col">bio</th>
      <th scope="col">fees</th>
      <th scope="col">experience_years</th>
      <th scope="col">rating</th>
      <th scope="col">action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($doctors as $doctor)
    <tr>
      <th scope="row">{{$doctor->id}}</th>
      <td>{{$doctor->user->name}}</td>
      <td>{{$doctor->specialization->name}}</td>
      <td>{{$doctor->title}}</td>
      <td>{{ Str::limit($doctor->bio, 50, '...') }}</td>
      <td>{{$doctor->fees}}</td>
      <td>{{$doctor->experience_years}}</td>
      <td>{{$doctor->rating}}</td>      
      <td>
        <div class="d-flex">
        <a href="{{route('Dashboard.doctors.show',$doctor->id)}}" class="btn btn-primary">show</a>
        <a href="{{route('Dashboard.doctors.edit',$doctor->id)}}" class="btn btn-info">Edit</a>
      <form style="display:inline;" method="POST" action="{{route('Dashboard.doctors.destroy',$doctor->id)}}">
        @csrf
        @method("DELETE")
        <button onclick="confirm('do you want to delete?')" class="btn btn-danger">Delete</button>
      </form>
      </div>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

<div>
   {{ $doctors->links() }}
</div>

@endsection