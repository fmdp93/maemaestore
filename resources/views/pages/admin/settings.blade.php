@extends('layouts.app')

@section('admin_content')
    <div class="row px-xl-5 mb-xl-3">
        @include('layouts.heading')
        <div class="col-12 mt-5">
            <h3>Backup Database</h3>
            <a href="{{ route('backup_db') }}" class="btn btn-success py-3 px-4 text-white">
                <i class="fa-solid fa-database"></i> Backup Database
            </a>
        </div>
        <div class="col-12 col-xl-3 mt-5">
            <h3>Restore Database</h3>
            <form action="{{ route('restore_db') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @error('database')
                    @include('components.error-message')
                @enderror
                <label for="database">Select Database (.sql)</label>
                <input type="file" class="form-control" id="database" name="database" accept=".sql">
                <input type="submit" value="Restore Database" class="btn mt-3">
            </form>
        </div>
    </div>
@endsection

@section('content')
    @include('components.admin.content')
@endsection
