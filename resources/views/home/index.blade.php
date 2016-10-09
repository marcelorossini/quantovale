<!DOCTYPE html>
<html lang="en">
    <head>
    </head>
    <body> 
 		{!! Form::open(['url' => 'foo/bar']) !!}
		    {!! Form::text('username') !!}
		    {!! Form::submit('Click Me!') !!}
		{!! Form::close() !!}
 		@yield('content')    
    </body>
</html>
