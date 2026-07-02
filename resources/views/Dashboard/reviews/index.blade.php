@extends('layout.app')

@section('title') index @endsection

@section('content')
@include('inc.message')
<div class="text-center my-3">
  <a href="{{route('Dashboard.reviews.create')}}" class="btn btn-success">Add review</a>
</div> 

<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">patient</th>
      <th scope="col">doctor</th>
      <th scope="col">rating</th>
      <th scope="col">comment</th>
      <th scope="col">action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($reviews as $review)
    <tr>
      <th scope="row">{{$review->id}}</th>
      <td>{{$review->user->name}}</td>
      <td>{{$review->doctor->user->name}}</td>
      <td>{{$review->rating}}</td>
      <td>{{$review->comment}}</td>
      <td>
        <a href="{{route('Dashboard.reviews.edit',$review->id)}}" class="btn btn-info">Edit</a>
      <form style="display:inline;" method="POST" action="{{route('Dashboard.reviews.destroy',$review->id)}}">
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
   {{ $reviews->links() }}
</div>

@endsection