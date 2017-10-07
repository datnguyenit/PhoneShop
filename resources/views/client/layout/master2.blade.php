<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <base href="{{asset('')}}">
        <title>DIDONGANHEM</title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="CSS/style.css">
        <link rel="stylesheet" href="CSS/product.css">
        <link rel="stylesheet" href="css/client.css">
    </head>
    <body>
        @yield('content')	

        <script src = "Javascript/jquery-3.1.1.min.js"></script>
        <script src = "bootstrap/js/bootstrap.min.js "></script>
        <script src = "js/jquery.validate.min.js"></script>
        <script src = "js/client.js"></script>
        @yield('script')
        
    </body>
</html>