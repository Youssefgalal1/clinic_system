@extends('layout.app')
@section('title') Create   @endsection('title')  

@section('content')

<!-- Create Post Form -->
<div class="col-6 mx-auto">
<form  method="POST" action="{{route('Dashboard.doctors.store')}}" class="form border p-3" >
@csrf
@include('inc.message')
  <div class="mb-3">
    <label class="form-label">name</label>
    <select name="user_id" class="form-control">
      @foreach ($users as $user)
        <option value="{{$user->id}}" {{ old("user_id") ==  $user->id  ? 'selected' : '' }}>{{ $user->name }}</option>
        <!-- @if(old('user_type') == 'admin' ) selected @endif  --> 
      @endforeach   
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">specialization</label>
    <select name="specialization_id" class="form-control">
      @foreach ($specializations as $specialization)
        <option value="{{$specialization->id}}" {{ old("specialization_id") ==  $specialization->id  ? 'selected' : '' }}>{{ $specialization->name }}</option>
      @endforeach   
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">title</label>
    <select name="title" class="form-control">
      <option value="Dr." {{ old("title") ==  "Dr."  ? 'selected' : '' }}>Dr.</option>
      <option value="Prof." {{ old("title") ==  "Prof."  ? 'selected' : '' }}>Prof.</option>
      <option value="Consultant" {{ old("title") ==  "Consultant"  ? 'selected' : '' }}>Consultant</option>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">fees</label>
    <input name="fees" type="number" class="form-control" value="{{old('fees')}}">
  </div>
  <div class="mb-3">
    <label class="form-label">experience_years</label>
    <input name="experience_years" type="number" class="form-control" value="{{old('experience_years')}}">
  </div>
  <div class="mb-3">
    <label class="form-label">bio</label>
    <textarea name="bio" class="form-control" rows="4">{{ old('bio') }}</textarea>
  </div>
    <button type="submit" class="btn btn-success form-control">ADD</button>
</form>
</div>

@endsection