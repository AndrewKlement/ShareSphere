@extends("layouts.app")
@vite(['resources/js/auth/register.js'])
@section("title", "Register")
@section("content")


<form class="form-cont" method="POST" action="{{route("register.post")}}">
    @csrf
    <div class="mb-3">
        <label for="exampleInputName1" class="form-label">Name</label>
        <input type="text" class="form-control" id="exampleInputName1c" aria-describedby="nameHelp" name="name">
        @if ($errors->has("name"))
            <div id="nameHelp" class="form-text text-danger">Name required</div>
        @endif
    </div>  

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        @if ($errors->has("email"))
            <div id="emailHelp" class="form-text text-danger">{{$errors->first("email")}}</div>
        @endif
    </div>

    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1" name="password">
        @if ($errors->has("password"))
            <div id="nameHelp" class="form-text text-danger">Password required</div>
        @endif
    </div>

    <button type="submit" class="btn">Submit</button>
</form>
@endsection