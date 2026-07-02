@extends('layout.app')
@section('title') Create   @endsection('title')  

@section('content')

<!-- Create Post Form -->
<div class="col-6 mx-auto">
<form  method="POST" action="{{route('Dashboard.users.store')}}" class="form border p-3" >
@csrf
@include('inc.message')
  <div class="mb-3">
    <label class="form-label">name</label>
    <input name="name" type="text" class="form-control" value="{{old('name')}}">
  </div>
  <div class="mb-3">
    <label class="form-label">email</label>
    <input name="email" type="email" class="form-control" value="{{old('email')}}">
  </div>
  <div class="mb-3">
    <label class="form-label">password</label>
    <input name="password" type="password" class="form-control">
  </div>
  <div class="mb-3">
    <label class="form-label">confirm password</label>
    <input name="password_confirmation" type="password" class="form-control">
  </div>
  <div class="mb-3">
    <label class="form-label">phone</label>
    <input name="phone" type="tel" pattern="^01[0125][0-9]{8}$" placeholder="01xxxxxxxxx" maxlength="11" class="form-control" value="{{old('phone')}}">
  </div>
  <div class="mb-3">
    <label class="form-label">gender</label>
    <select name="gender" class="form-control">
        <option value="male" {{ old("gender") == 'male' ? 'selected' : '' }}>male</option>
        <option  value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>female</option>
        <!-- @if(old('user_type') == 'admin' ) selected @endif  -->       
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">birth_date</label>
    <input name="birth_date" type="date" class="form-control" value="{{old('birth_date')}}">
  </div>
  <div class="mb-3">
    <label class="form-label">role</label>
    <select name="role" class="form-control">
        <option value="patient">patient</option>
        <option  value="doctor">doctor</option>
        <option  value="admin">admin</option>
        <!-- @if(old('user_type') == 'admin' ) selected @endif  -->       
    </select>
  </div>
    <button type="submit" class="btn btn-success form-control">ADD</button>
</form>
</div>

@endsection