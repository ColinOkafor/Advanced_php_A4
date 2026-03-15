@extends('layouts.app')
@section('title', 'Login')
@section('content')
    
    <form action="/attempt_login" method="post">
        @csrf 
        <label for="email">Email: </label>
        <input type="text" name="email" value="" /> <br /> <br />
        <label for="password">Password: </label>
        <input type="text" name="password" value="" /> <br /> <br />
        <input type="submit" value="Login" />
    </form>

    <br />
    @if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
@endsection

