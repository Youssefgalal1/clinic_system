@extends('layout.app')

@section('title') index @endsection

@section('content')
@include('inc.message')
<div class="text-center my-3">
  <a href="{{route('Dashboard.clinics.create')}}" class="btn btn-success">Add clinic</a>
</div> 

<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">address</th>
      <th scope="col">city</th>
      <th scope="col">phone</th>
      <th scope="col">description</th>
      <th scope="col">action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($clinics as $clinic)
    <tr>
      <th scope="row">{{$clinic->id}}</th>
      <td>{{$clinic->name}}</td>
      <td>{{$clinic->address}}</td>
      <td>{{$clinic->city}}</td>
      <td>{{$clinic->phone}}</td>
      <td>{{ Str::limit($clinic->description, 50, '...') }}</td>
      <td>
        <div class="d-flex">
        <a href="{{route('Dashboard.clinics.show',$clinic->id)}}" class="btn btn-primary">View</a>
        <a href="{{route('Dashboard.clinics.edit',$clinic->id)}}" class="btn btn-info">Edit</a>
      <form style="display:inline;" method="POST" action="{{route('Dashboard.clinics.destroy',$clinic->id)}}">
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
   {{ $clinics->links() }}
</div>

@endsection