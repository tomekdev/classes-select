@extends('layouts.admin') @section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3>Konfiguracja aplikacji</h3>
                </div>
                <div class="panel-body">
                    <form class="form form-horizontal" method="post" action="{{route('admin.configuration')}}" autocomplete="off">
                        <h4>Dane serwera poczty</h4>
                        <span class="help-block">Dane te zostaną użyte do rozsyłania maili resetujących hasła i powiadomień o zapisach</span>
                        <div class="form-group">
                            <label for="mail_host" class="col-md-2 control-label">Host</label>
                            <div class="col-md-10">
                                <input type="text" name="mail_host" class="form-control" id="mail_host" value="{{old('mail_host')?: ($configuration? $configuration->mail_host : '')}}">
                                <span class="help-block">Aplikacja obsługuje serwery poczty wykorzystujące protokół SMTP</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mail_port" class="col-md-2 control-label">Port</label>
                            <div class="col-md-10">
                                <input type="number" name="mail_port" class="form-control" id="mail_port" value="{{old('mail_port')?: ($configuration? $configuration->mail_port : '')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mail_username" class="col-md-2 control-label">Nazwa użytkownika</label>
                            <div class="col-md-10">
                                <input type="text" name="mail_username" class="form-control" id="mail_username" value="{{old('mail_username')?: ($configuration? $configuration->mail_username : '')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mail_password" class="col-md-2 control-label">Hasło</label>
                            <div class="col-md-10">
                                <input type="password" name="mail_password" class="form-control" id="mail_password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mail_encryption" class="col-md-2 control-label">Tryb zabezpieczenia</label>
                            <div class="col-md-10">
                                <select class="form-control select" name="mail_encryption" required>
                                <option value="">-- wybierz --</option>
                                @foreach($encryptions as $mail_encryption)
                                    <option value="{{ $mail_encryption }}" {{ (($configuration && $configuration->mail_encryption == $mail_encryption) || old('mail_encryption') == $mail_encryption)? 'selected' : '' }}>{{ $mail_encryption }}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mail_from_name" class="col-md-2 control-label">Nadawca</label>
                            <div class="col-md-10">
                                <input type="text" name="mail_from_name" class="form-control" id="mail_from_name" value="{{old('mail_from_name')?: ($configuration? $configuration->mail_from_name : '')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mail_from_address" class="col-md-2 control-label">Adres nadawcy</label>
                            <div class="col-md-10">
                                <input type="text" name="mail_from_address" class="form-control" id="mail_from_address" value="{{old('mail_from_address')?: ($configuration? $configuration->mail_from_address : '')}}">
                                <span class="help-block">Pole powinno być uzupełnione faktycznym adresem email, z którego bedą wysyłane wiadomości. W przeciwnym razie niektóre serwery mogą odrzucać wiadomości z systemu.</span>
                            </div>
                        </div>
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary btn-raised pull-right">Zapisz</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
