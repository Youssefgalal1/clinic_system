@extends('layout.app')

@section('title') index @endsection

@section('content')
@include('inc.message')
<div class="text-center my-3">
  <a href="{{route('Dashboard.users.create')}}" class="btn btn-success">Add user</a>
</div> 

<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">phone</th>
      <th scope="col">gender</th>
      <th scope="col">Birth_date</th>
      <th scope="col">role</th>
      <th scope="col">action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($users as $user)
    <tr>
      <th scope="row">{{$user->id}}</th>
      <td>{{$user->name}}</td>
      <td>{{$user->email}}</td>
      <td>{{$user->phone}}</td>
      <td>{!!$user->gender()!!}</td>
      <td>{{$user->birth_date}}</td>
      <td>{!!$user->role()!!}</td>
      <td>
        <a href="{{route('Dashboard.users.edit',$user->id)}}" class="btn btn-info">Edit</a>
      <form style="display:inline;" method="POST" action="{{route('Dashboard.users.destroy',$user->id)}}">
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
   {{ $users->links() }}
</div>

@endsection