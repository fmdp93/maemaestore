@extends('layouts.app')

@section('title')
    {{ $item_code }}
@endsection


@section('infile_style')
    {{-- <link rel="stylesheet" href="css/app.css"> --}}
@endsection

@section('content')
    <div style="text-align: center; width: auto">
        <img src="data:image/png;base64,@php
            echo base64_encode($barcode_img);
        @endphp">
        <br>
        <span>{{ $item_code }}</span>
    </div>
@endsection
