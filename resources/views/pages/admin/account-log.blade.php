@php
use App\Http\Controllers\LogManagerController;
@endphp

@extends('layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('header_scripts')
    <script src="{{ asset('js/scope/search.js') }}" defer></script>
    <script src="{{ asset('js/scope/log-manager.js') }}" defer></script>    
@endsection

@section('admin_content')
    <div class="row vh-100">
        <div class="col-xl-12 px-xl-5">
            @include('layouts.heading')
            <table id="accounts" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Username</th>
                        <th scope="col">Date</th>
                        <th scope="col">Access</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($accounts as $account)
                        <tr>
                            <td>{{ $account->username }}</td>
                            <td>{{ date('F j, Y H:i:s', strtotime($account->date_and_time)) }}</td>
                            <td>{{ $account->access }}</td>
                            <td>{{ $account->action_name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div id="pages">
                {{ $accounts->links() }}
            </div>
            @empty($accounts)
                @include('layouts.empty-table')
            @endempty

        </div>
    </div>
@endsection

@section('content')
    @include('components.admin.content')
@endsection
