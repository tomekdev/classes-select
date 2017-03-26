<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPW</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdn.rawgit.com/FezVrasta/bootstrap-material-design/4aad2fe4/dist/css/bootstrap-material-design.min.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/FezVrasta/bootstrap-material-design/4aad2fe4/dist/css/ripples.min.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/FezVrasta/dropdown.js/5583fb6f/jquery.dropdown.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
</head>

<body>

    @yield('navbar')
    
    <div class="container-fluid">
        <div class="row">
            @if (Session::has('error'))
            <div class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{Session::get('error')}}</strong>
            </div>
            @endif 
            @if (Session::has('info'))
            <div class="alert alert-dismissible alert-info">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{Session::get('info')}}</strong>
            </div>
            @endif 
            @if (Session::has('success'))
            <div class="alert alert-dismissible alert-success">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{Session::get('success')}}</strong>
            </div>
            @endif 
        </div>
    </div>
    
    @yield('content')

    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="https://cdn.rawgit.com/FezVrasta/bootstrap-material-design/4aad2fe4/dist/js/material.min.js"></script>
    <script src="https://cdn.rawgit.com/FezVrasta/bootstrap-material-design/4aad2fe4/dist/js/ripples.min.js"></script>
    <script src="https://cdn.rawgit.com/FezVrasta/bootstrap-material-design/4aad2fe4/dist/js/ripples.min.js"></script>
    <script src="https://cdn.rawgit.com/FezVrasta/dropdown.js/5583fb6f/jquery.dropdown.js"></script>
    <script type="text/javascript">
        $.material.init();
        
        $(document).ready(function() {
            $(".select").dropdown({"optionClass": "withripple"});
        });
        
        $('.alert.alert-dismissible.alert-success, .alert.alert-dismissible.alert-info').fadeTo(5000, 500).slideUp(500, function(){
            $(this).slideUp(500);
        });
        
        function selectAll() {
            $("table input:checkbox").prop ( "checked" , true );
        }
        
        function deselectAll() {
            $("table input:checkbox").prop ( "checked", false);
        }

    </script>
</body>

</html>
