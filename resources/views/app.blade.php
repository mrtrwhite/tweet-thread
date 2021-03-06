<!DOCTYPE html>
<html>
	<head>
		<title>Tweet Thread</title>
		<meta name="description" content="Create a tweet chain from a single block of text."/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link href="https://fonts.googleapis.com/css?family=Roboto|Roboto+Slab" rel="stylesheet">
		<link rel="stylesheet" href="/css/style.min.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.1/knockout-min.js"></script>
	</head>
	<body>
		<header class="header align-center full">
			<h1 class="h1">Tweet Thread</h1>
			<p class="intro full">Chain tweets from a single paragraph.</p>
		</header>
		@yield('content')
		<footer class="footer align-center full">
			&#xa9;{{ date('Y') }} Tweet Thread was made by <a href="http://twitter.com/mrtrwhite" class="white">Tim White</a>
		</footer>
		<script src="/js/bundle.min.js"></script>
	</body>
</html>
