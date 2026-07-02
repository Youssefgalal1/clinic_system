<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        .active{
          font-weight: bold;
        }
    </style>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Blog</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item @if(request()->is('/')) active @endif">
          <a class="nav-link" aria-current="page" href="">Home</a>
        </li>
        <li class="nav-item @if(request()->is('users*')) active @endif">
          <a class="nav-link" aria-current="page" href="{{route('Dashboard.users.index')}}">All users</a>
        </li>
        <li class="nav-item @if(request()->is('doctors*')) active @endif">
          <a class="nav-link" aria-current="page" href="{{route('Dashboard.doctors.index')}}">All doctors</a>
        </li>
        <li class="nav-item @if(request()->is('clinics*')) active @endif">
          <a class="nav-link" aria-current="page" href="{{route('Dashboard.clinics.index')}}">All clinics</a>
        </li>
        <li class="nav-item @if(request()->is('specializations*')) active @endif">
          <a class="nav-link" aria-current="page" href="{{route('Dashboard.specializations.index')}}">specializations</a>
        </li>
        <li class="nav-item @if(request()->is('doctor_schedules*')) active @endif">
          <a class="nav-link" aria-current="page" href="{{route('Dashboard.doctor_schedules.index')}}">doctor_schedules</a>
        </li>
        <li class="nav-item @if(request()->is('appointments*')) active @endif">
          <a class="nav-link" aria-current="page" href="{{route('Dashboard.appointments.index')}}">appointments</a>
        </li>
        <li class="nav-item @if(request()->is('reviews*')) active @endif">
          <a class="nav-link" aria-current="page" href="{{route('Dashboard.reviews.index')}}">reviews</a>
        </li>
      </ul>
  </div>
  </div>
</nav> 

<div class="container">

@yield('content')

</div>
<!--  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>