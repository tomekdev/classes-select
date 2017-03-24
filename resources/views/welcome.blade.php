@extends('layouts.master')

@section('content')

 <!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<!-- Add your site or application content here -->
<div class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-left" href="/"><img src="https://wu.po.opole.pl/wp-content/uploads/2014/07/logo-3-640x360.png" style="max-height:60px"/></a>
        </div>
        <div class="navbar-collapse collapse navbar-responsive-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="javascript:void(0)">Logowanie</a></li>
                <!--<li><a href="javascript:void(0)">Link</a></li>
                <li class="dropdown">
                    <a href="bootstrap-elements.html" data-target="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown
        <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="javascript:void(0)">Action</a></li>
                        <li><a href="javascript:void(0)">Another action</a></li>
                        <li><a href="javascript:void(0)">Something else here</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Dropdown header</li>
                        <li><a href="javascript:void(0)">Separated link</a></li>
                        <li><a href="javascript:void(0)">One more separated link</a></li>
                    </ul>
                </li>-->
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <!--<li><a href="javascript:void(0)">Link</a></li>
                <li class="dropdown">
                    <a href="bootstrap-elements.html" data-target="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown
        <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="javascript:void(0)">Action</a></li>
                        <li><a href="javascript:void(0)">Another action</a></li>
                        <li><a href="javascript:void(0)">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="javascript:void(0)">Separated link</a></li>
                    </ul>
                </li>-->
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3>Logowanie</h3>
                </div>
                <div class="panel-body">
                    <form action="{{ route('login.student') }}" method="post">
                        <div class="form-group label-floating">
                            <label for="login" class="control-label">Login</label>
                            <input type="text" class="form-control" id="login" name="login">
                            <span class="help-block">Jako login może posłużyć numer indeksu, lub mail przypisany do konta</span>
                        </div>
                        <div class="form-group label-floating">
                            <label for="password" class="control-label">Hasło</label>
                            <input type="text" class="form-control" id="password" name="password">
                        </div>
                        <div class="pull-right">
                            <button class="btn">Zapomniałem hasła</button>
                            <button type="submit" class="btn btn-primary">Zaloguj</button>
                        </div>
                        <input type="hidden" name="_token" value="{{ Session::token() }}"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://cdn.rawgit.com/FezVrasta/bootstrap-material-design/4aad2fe4/dist/js/material.min.js"></script>
<script src="https://cdn.rawgit.com/FezVrasta/bootstrap-material-design/4aad2fe4/dist/js/ripples.min.js"></script>
<script type="text/javascript">
    $.material.init();

</script>

@endsection
