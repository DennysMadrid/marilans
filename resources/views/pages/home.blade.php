@extends('layouts.app')

@section('content')
    <header class="masthead">
        <div class="container">
            <div class="masthead-subheading">Welcome To Marilans!</div>
            <div class="masthead-heading text-uppercase">It's Nice To Meet You</div>
            <form action="{{ route('amazon.price') }}" method="post">
                @csrf
                <input class="form-control form-control-lg" name="url" type="text" placeholder="http://amazon.com/product/1">
                <button type="submit" class="mt-3 btn btn-primary btn-xl text-uppercase text-dark" href="#services">Buscar desde Amazon</button>
            </form>            
        </div>
    </header>
@endsection
