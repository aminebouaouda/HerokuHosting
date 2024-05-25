@if($user)
    <h1>Hello, {{ $user->firstname }}!</h1>
    <p>Welcome to our platform.</p>
@else
    <p>Unable to retrieve user information.</p>
@endif
