@extends("layouts.app")
@vite(['resources/js/auth/login.js'])
@section("title", "Login")
@section("content")

<form class="form-cont" method="POST" action="{{route("login.post")}}">
	@csrf
	<div class="mb-3">
		<label for="exampleInputEmail1" class="form-label">Email address</label>
		<input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
		<div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
		@if ($errors->has("email"))
			<div id="emailHelp" class="form-text text-danger">Email required</div>
		@endif
	</div>

	<div class="mb-3">
		<label for="exampleInputPassword1" class="form-label">Password</label>
		<input type="password" class="form-control" id="exampleInputPassword1" name="password">
		@if ($errors->has("password"))
			<div id="emailHelp" class="form-text text-danger">Password required</div>
		@endif
	</div>

	<div class="mb-3 form-check">
		<input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember">
		<label class="form-check-label" for="exampleCheck1">Remember me</label>
	</div>

	<button type="submit" class="btn">Submit</button>
</form>
@endsection