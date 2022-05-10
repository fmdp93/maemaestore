@php
use App\Http\Controllers\AccountsController;
@endphp
@extends('layouts.app')

@section('header_scripts')
    <script src="{{ asset('js/scope/search.js') }}" defer></script>
@endsection

@section('admin_content')
    <div class="row px-xl-5">
        @include('layouts.heading')
        <div class="col-xl-3">
            <div class="row">
                <div class="col-12">
                    <a href="{{ action([AccountsController::class, 'addCashier']) }}"
                        class="btn btn-success mb-xl-3 text-primary"><i class="fa fa-plus-circle"></i> Add Cashier</a>
                    <a href="{{ action([AccountsController::class, 'editAccount']) }}"
                        class="btn btn-success mb-xl-3 text-primary"><i class="fa fa-plus-circle"></i> Edit Details</a>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <table id="products_list" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Username</th>
                        <th scope="col">Contact</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Age</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($accounts as $account)
                        <tr>
                            <td>{{ $account->id }}</td>
                            <td>{{ $account->username }}</td>
                            <td>{{ $account->contact_num }}</td>
                            <td>{{ $account->first_name }}</td>
                            <td>{{ $account->last_name }}</td>
                            <td>{{ $account->age }}</td>
                            <td class="delete-cell">
                                <form action="{{ action([AccountsController::class, 'deleteCashier']) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="page" value="{{ $accounts->currentPage() }}">
                                    <input type="hidden" value="{{ $account->id }}" name="user_id">
                                    <button type="submit" class="border-0 bg-transparent">
                                        <i class="fa-solid fa-trash-can text-danger fa-2x" title="Delete Cashier"></i>
                                    </button>
                                </form>
                            </td>
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
