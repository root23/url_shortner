 <!DOCTYPE html>
 <html>
 <head>
 	<title>URL shortener</title>
 	<meta charset="utf-8">
 	<link rel="stylesheet" type="text/css" href="{{ URL::to('css/app.css') }}">
 </head>
 <body>
 	<div class="container">
 		<h1 class="title">Сокращение ссылок</h1>

 		@if ($errors->has('url'))
 			<p>{{ $errors->first('url') }}</p>
 		@endif

 		@if (Session::has('global'))
 			<p>{!! Session::get('global') !!}</p>
 		@endif

 		<form action="{{ URL::action('LinkController@make') }}" method="post">
 			{{ csrf_field() }}
 			<input type="url" name="url" placeholder="Ссылка" autocomplete="off">
 			<input type="submit" value="Сократить" name="">
 		</form>
 	</div>
 </body>
 </html>