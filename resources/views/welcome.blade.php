@extends('layouts.master')

@section('title')
    Welcome!
@endsection

@section('content')
    @include('includes.messages')
    <div class="row">
        <div class="col-md-6">
            <h3>Crea Utente</h3>
            <form action="{{ route('signup') }}" method="post">
                <div class="form-group ">
                    <label for="email">Email</label>
                    <input   class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{Request::old('email')}}"/>
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input   class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{Request::old('name')}}"/>
                </div>
                 <div class="form-group">
                    <label for="password">Password</label>
                    <input   class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" value="{{Request::old('password')}}"/>
                </div>
                <button type="submit" class="btn btn-primary">Crea Utente & Login</button>
            <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
        </div>

        <div class="col-md-6">
            <h3>Sign In</h3>
            <form action="{{route('signin')}}" method="post">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input   class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{Request::old('email')}}"/>
                </div>
                 <div class="form-group">
                    <label for="password">Password</label>
                    <input   class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" value="{{Request::old('password')}}"/>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
        </div>
    </div>
@endsection