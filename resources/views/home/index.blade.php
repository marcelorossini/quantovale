<!DOCTYPE html>
<html lang="en">
    <head>
    </head>
    <body>
 		{!! Form::open(['url' => route('postSearch')]) !!}
		    {!! Form::text('product',"keyword") !!}
		    {!! Form::submit('Click Me!') !!}
		{!! Form::close() !!}
 		@yield('content')
    </body>
</html>
