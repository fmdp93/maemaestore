@extends('layouts.app')

@section('content')
  <a href="{{ url('/learning/cars/create') }}">Add car</a>
    @foreach ($cars as $car)
      <h2>{{ $car->name }}</h2>
      <b>Founded: {{ $car->founded }}</b>        
      <p>{{ $car->description }}</p>
    @endforeach
@endsection