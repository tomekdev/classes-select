@extends('layouts.master') 

@section('head')
    <link rel="stylesheet" href="{{ URL::asset('css/admin.css') }}" />
@endsection

@section('extra-wrapper-start')
    <div class="admin-panel">
@endsection

@section('extra-wrapper-end')
    </div>
@endsection

@section('navbar')

<div class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            @if (Auth::guard('admin')->check())
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            @endif
            <a class="navbar-left" href="/"><img src="https://wu.po.opole.pl/wp-content/uploads/2014/07/logo-3-640x360.png" style="max-height:60px" /></a>
        </div>
        @if (Auth::guard('admin')->check())
        <div class="navbar-collapse collapse navbar-responsive-collapse">
            <ul class="nav navbar-nav">
                <li {{{ (Request::url() === route('admin.terms')? 'class=active' : '') }}}><a href="{{ route('admin.terms') }}">Terminy zapisu</a></li>
                <li {{{ (Request::url() === route('admin.students')? 'class=active' : '') }}}><a href="{{ route('admin.students') }}">Studenci</a></li>
                <li {{{ (Request::url() === route('admin.subjects')? 'class=active' : '') }}}><a href="{{ route('admin.subjects') }}">Przedmioty wybieralne</a></li>
                <li {{{ (Request::url() === route('admin.faculties')? 'class=active' : '') }}}><a href="{{ route('admin.faculties') }}">Wydziały</a></li>
                <li {{{ (Request::url() === route('admin.fields')? 'class=active' : '') }}}><a href="{{ route('admin.fields') }}">Kierunki</a></li>
                <li {{{ (Request::url() === route('admin.semesters')? 'class=active' : '') }}}><a href="{{ route('admin.semesters') }}">Semestry</a></li>
                <li {{{ (Request::url() === route('admin.degrees')? 'class=active' : '') }}}><a href="{{ route('admin.degrees') }}">Stopnie</a></li>
                <li {{{ (Request::url() === route('admin.studyForms')? 'class=active' : '') }}}><a href="{{ route('admin.studyForms') }}">Formy studiów</a></li>
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
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">{{{Auth::guard('admin')->user()->name}}} {{{Auth::guard('admin')->user()->surname}}}<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('admin.changePassword') }}">Zmień hasło</a></li>
                        <li><a href="{{ route('admin.configuration') }}">Ustawienia</a></li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ route('admin.logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                Wyloguj
                            </a>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
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
