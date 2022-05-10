@extends('layouts.app')

@section('content')
    <h1>Create Car</h1>
    <form action="/learning/cars" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Car name" class="form-control mb-3">
        <input type="text" name="founded" placeholder="Year Founded" class="form-control mb-3">
        <input type="text" name="description" placeholder="Description" class="form-control mb-3">
        <input type="submit" name="submit" value="Add Car" class="btn btn-primary">
    </form>
@endsection