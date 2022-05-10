@php
use App\Http\Controllers\ProductsController;
@endphp

@extends('layouts.app')

@section('heading_before')
    <a href="{{ action([ProductsController::class, 'addProduct']) }}" class="btn btn-success mb-xl-3 text-primary">
        <i class="fa fa-circle-left"></i> Go back to add to product
    </a>
    <div class="row">
        <div class="col-auto">
            @error('category_id')
                @include('components.error-message')
            @enderror
        </div>
    </div>
@endsection

@section('admin_content')
    <div class="row px-xl-5">
        @include('layouts.heading')
        <div class="col-xl-3">
            <form action="{{ url('/category/add') }}" method="POST" class="mt-xl-3">
                @csrf
                @error('name')
                    @include('components.error-message')
                @enderror
                <label for="name">Category Name</label>
                <input name="name" id="name" class="form-control form-control-xl mb-xl-3" type="text" aria-label="name">
                <input type="submit" value="Add Category" class="btn btn-primary">
            </form>
        </div>
        <div class="col-xl-4">
            <table id="categories_list" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $cat)
                        <tr>
                            <td>{{ $cat->name }}</td>
                            <td>
                                <form action="{{ url('/category/delete') }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" value="{{ $cat->id }}" name="category_id">
                                    <button type="submit" class="border-0 bg-transparent">
                                        <i class="fa-solid fa-trash-can text-danger fa-2x" title="Delete Category"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $categories->links() }}
            @empty(count($categories))
                @include('layouts.empty-table')
            @endempty
        </div>
    </div>
@endsection

@section('content')
    @include('components.admin.content')
@endsection
