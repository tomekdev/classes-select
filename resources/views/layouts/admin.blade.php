@extends('layouts.master') 

@section('head')
    <link rel="stylesheet" href="{{ URL::asset('css/admin.css') }}" />
@endsection

@section('content')
    <div class="admin-panel">
        @yield('content')
    </div>
@endsection

@section('navbar')

<div class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-left" href="/"><img src="https://wu.po.opole.pl/wp-content/uploads/2014/07/logo-3-640x360.png" style="max-height:60px" /></a>
        </div>
        @if (Auth::check())
        <div class="navbar-collapse collapse navbar-responsive-collapse">
            <ul class="nav navbar-nav">
                <li {{{ (Request::url() === route('student.dashboard')? 'class=active' : '') }}}><a href="{{ route('student.dashboard') }}">Terminy zapisu</a></li>
                <li {{{ (Request::url() === route('admin.students')? 'class=active' : '') }}}><a href="{{ route('admin.students') }}">Studenci</a></li>
                <li {{{ (Request::url() === route('student.dashboard')? 'class=active' : '') }}}><a href="{{ route('student.dashboard') }}">Przedmioty wybieralne</a></li>
                <li {{{ (Request::url() === route('student.dashboard')? 'class=active' : '') }}}><a href="{{ route('student.dashboard') }}">Wydziały</a></li>
                <li {{{ (Request::url() === route('student.dashboard')? 'class=active' : '') }}}><a href="{{ route('student.dashboard') }}">Kierunki</a></li>
                <li {{{ (Request::url() === route('student.dashboard')? 'class=active' : '') }}}><a href="{{ route('student.dashboard') }}">Semestry</a></li>
<!--
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
                </li>
-->
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">{{{Auth::user()->name}}} {{{Auth::user()->surname}}}<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="nieistniejącametoda">Zmień hasło</a></li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ route('student.logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                Wyloguj
                            </a>
                            <form id="logout-form" action="{{ route('student.logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        @endif
    </div>
</div>

@endsection
