<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPW</title>
    <link rel="shortcut icon" type="image/png" href="/img/spw_favicon.png"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdn.rawgit.com/FezVrasta/bootstrap-material-design/4aad2fe4/dist/css/bootstrap-material-design.min.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/FezVrasta/bootstrap-material-design/4aad2fe4/dist/css/ripples.min.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/FezVrasta/dropdown.js/5583fb6f/jquery.dropdown.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdn.rawgit.com/T00rk/bootstrap-material-datetimepicker/gh-pages/css/bootstrap-material-datetimepicker.css">
    @yield('head')
</head>

<body>

    @yield('navbar')

    <div class="container-fluid">
        <div class="row">
            <div id="ajaxMessages">
            </div>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
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
    
    @yield('extra-wrapper-start')
    @yield('content')
    @yield('extra-wrapper-end')

    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="https://cdn.rawgit.com/FezVrasta/bootstrap-material-design/4aad2fe4/dist/js/material.min.js"></script>
    <script src="https://cdn.rawgit.com/FezVrasta/bootstrap-material-design/4aad2fe4/dist/js/ripples.min.js"></script>
    <script src="https://cdn.rawgit.com/FezVrasta/bootstrap-material-design/4aad2fe4/dist/js/ripples.min.js"></script>
    <script src="https://cdn.rawgit.com/FezVrasta/dropdown.js/5583fb6f/jquery.dropdown.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/locale/pl.js"></script>
    <script src="https://cdn.rawgit.com/T00rk/bootstrap-material-datetimepicker/gh-pages/js/bootstrap-material-datetimepicker.js"></script>
    <script type="text/javascript">
        $.material.options.autofill = true;
        
        $(document).ready(function() {
            $.material.init();
            $(".select").dropdown({
                "optionClass": "withripple",
                "callback": function($dropdown) {
                    $dropdown.on("keydown", function(e){
                        if (e.keyCode === 40 || e.keyCode === 38) {
                            var $target = $(this).find('li[selected="selected"]');
                            var dropDownItems = e.keyCode === 40? $target.next() : $target.prev();
                            var $currentOption = $(this).data("select").find('option[selected]');
                            var newOption = e.keyCode === 40? $currentOption.next() : $currentOption.prev();
                            if (dropDownItems.length > 0) {
                                var $input  = $(this).find("input.fakeinput");
                                var $select = $dropdown.data("select");
                                $(this).find('li[selected="selected"]').removeAttr("selected").removeClass("selected");
                                $(dropDownItems[0]).attr("selected", "selected").addClass("selected");
                                $currentOption.removeAttr("selected");
                                newOption.attr("selected", "selected");
                                $input.val($(dropDownItems[0]).text());
                            }
                            e.preventDefault();
                        }
                        else if (e.keyCode === 13) {
                            var $input  = $(this).find("input.fakeinput");
                            $input.removeClass("focus");
                            e.preventDefault();
                        }
                    });
                    $dropdown.on("focusin", function() {
                        $target = $(this);
                        setTimeout(function(){
                            $target.find("li").attr("tabindex", -1);    
                        },100)   
                    });
                }
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('[name="_token"]').val()
                }
            });
            moment.locale("pl");
            $('.datetimepicker').bootstrapMaterialDatePicker({
                lang: "pl",
                format: "YYYY-MM-DD HH:mm"
            });
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

        function ajaxGetFields(value, id) {
            $.ajax({
                url: "{{ route('admin.ajaxGetFields') }}/"+value,
                method: "get",
                data: {},
                success: function (data) {
                    $('#select-field'+id).html(data);
                }
            });
        }

        function ajaxSaveSubject(id, selectable, selected, subject_id) {

            subSubject_id = $('#select' + id).val();
            $.ajax({
                url: "{{ route('student.ajaxSaveSubject') }}",
                method: "post",
                data: {
                        selectable:selectable,
                        selected:selected,
                        subject_id:subject_id,
                        selectedSubSubject:subSubject_id,
                },
                success: function (data) {
                    error = data.substr(0, 3);
                    selectData = data.substr(3);
                    message = '';
                    switch (error)
                    {
                        case 'WoW':
                            $('#select' + id).html(selectData);
                            message = '<div class="alert alert-dismissible alert-success">' +
                                '<button type="button" class="close" data-dismiss="alert">×</button>' +
                                '<strong>Pomyślnie zapisano na przedmiot.</strong>' +
                                '</div>';
                            break;
                        case 'err':
                            message = '<div class="alert alert-dismissible alert-danger">'+
                                '<button type="button" class="close" data-dismiss="alert">×</button>'+
                                '<strong>Aby się zapisać należy wybrać przedmiot.</strong>' +
                                '</div>';
                            break;
                        case 'hak':
                            message = '<div class="alert alert-dismissible alert-warning">' +
                                '<button type="button" class="close" data-dismiss="alert">×</button>' +
                                '<strong>hehe Janusz Hakier mode on. Pieseł Wardeł strzeże P.</strong>' +
                                '</div>';
                            break;
                        case '100':
                            message = '<div class="alert alert-dismissible alert-warning">' +
                                '<button type="button" class="close" data-dismiss="alert">×</button>' +
                                '<strong>Niestety nie możesz się już zapisać, ponieważ nie ma już wolnych miejsc na tym przedmiocie</strong>' +
                                '</div>';
                            break;
                    }
                    $('#ajaxMessages').html(message);
                }
            });
        }

        function deleteItems(msg, url) {
            var form = document.getElementById('del');
            form.action = url;
            if(confirm(msg)) {
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = '_method';
                input.value = 'DELETE';
                form.appendChild(input);
                form.submit();
            }
        }
    </script>
</body>

</html>
