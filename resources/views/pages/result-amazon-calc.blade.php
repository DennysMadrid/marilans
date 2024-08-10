@extends('layouts.app')

@section('content')
    <div class="container">
    <pre>{{ print_r($productDetails, true) }}</pre>      
    </div>
@endsection
