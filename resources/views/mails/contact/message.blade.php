<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nouveau message à partir du site</title>
</head>
<body>
    <p>Nouveau message de {{ $firstname }} {{ $lastname }} ({{ $email }}) : </p>
    <p>{!! $text !!}</p>
</body>
</html>
