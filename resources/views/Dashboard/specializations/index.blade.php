@extends('layout.app')

@section('title') index @endsection

@section('content')
@include('inc.message')
<div class="text-center my-3">
  <a href="{{route('Dashboard.specializations.create')}}" class="btn btn-success">Add specialization</a>
</div> 

<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">image</th>
      <th scope="col">action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($specializations as $specialization)
    <tr>
      <th scope="row">{{$specialization->id}}</th>
      <td>{{$specialization->name}}</td>
      <td>
        <img src="{{asset($specialization->image())}}" height="150" width="150" alt="">
      </td>
      <td>
        <a href="{{route('Dashboard.specializations.edit',$specialization->id)}}" class="btn btn-info">Edit</a>
      <form style="display:inline;" method="POST" action="{{route('Dashboard.specializations.destroy',$specialization->id)}}">
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
   {{ $specializations->links() }}
</div>

@endsection