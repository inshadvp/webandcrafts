<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>All Cars</title>
</head> 
<body>
     @foreach ($cars as $car)
         <p><a href="/cars/{{ $car->model }}">{{ $car->model }}</a></p>
     @endforeach
</body>
</html>