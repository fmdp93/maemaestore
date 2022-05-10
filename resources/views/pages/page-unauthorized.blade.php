@extends('layouts.app')

@section('title')
    Page Unauthorized
@endsection

@section($user_content)
    <div class="align-items-center d-flex h-50 justify-content-center w-50">
        <h1>Page Unauthorized</h1>
    </div>
@endsection

@section('content')
    @include($components_user_content)
@endsection
