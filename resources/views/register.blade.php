@extends('layouts.app')
@section('title', 'Register')
@section('content')
  <h1>Register Page</h1>

    <form action="/attempt_register" method="post">
        @csrf 
        <label for="name">Name: </label>
        <input type="text" name="name" value="" /> <br /> <br />
        <label for="email">Email: </label>
        <input type="text" name="email" value="" /> <br /> <br />
        <label for="password">Password: </label>
        <input type="password" name="password" value="" /> <br /> <br />
        <input type="submit" value="Register" />
    </form>
@endsection

