@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    Iniciar Sesión
@endsection

@section('content')
    <body class="hold-transition login-page" style=" background-image: url('{{ asset('/img/fondo3.jpg') }}');    background-size: cover;
    background-repeat: no-repeat;
    height: 100%;">
    <div id="app" v-cloak>
        <div class="login-box" style="width: 410px;">

{{--                 <div class="card2" style="text-align: center;margin-top: 50px;border-radius: 3px">
                        <img class="" src="{{ asset('/img/logo.png') }}" style="padding-top: 7px;">
        
                    </div> --}}

            <div class="login-logo" style="background-color: white !important; border-radius: 10px;border-radius: 10px; border: 10px solid #00000012;">
                
                <a href="{{ url('/home') }}" style="font-size:28px; display:inline-block;">
                    <b>PLATAFORMA VIRTUAL</b> <br>
                    
                    <img src="{{ asset('/img/Poder_Judicial_del_Peru.jpg') }}" alt="" style="padding:10px; width: 180px; display:inline-block;"> </a>
                    <b>Registro de Entrega Courier</b>
            </div><!-- /.login-logo -->

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Error!</strong> Tenemos algunos Algunos Problemas<br>
                    <ul style="margin-bottom: 0px;">
                        @foreach ($errors->all() as $error)
                        {{-- <li>{{ $error }}</li>  --}}
                        @if($error=="The name field is required.")
                        <li>El campo Usuario es necesario.</li>
                        @endif

                        @if($error=="The password field is required.")
                        <li>El campo Contraseña es necesario.</li>
                        @endif

                        @if($error=="These credentials do not match our records.")
                        <li>Estas credenciales no coinciden con nuestros registros.</li>
                        @endif

                        @if($error=="usuarioActiv")
                        <li>El usuario del sistema se encuentra desactivado, comuncarse con el administrador del sistema.</li>
                        @endif

                       {{--  @if($error=="alumnoSemestre")
                        <li>El semestre al que pertenece el alumno se encuentra cerrado, comuniquese con el administrador del sistema.</li>
                        @endif --}}

                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="login-box-body" style=" background-color: white !important;    border-radius: 10px; border-radius: 10px; border: 10px solid #00000012;">
                <center><b>LOGIN DE ACCESO</b></center>
                <p class="login-box-msg" style="    font-size: 17px;"> Ingrese sus credenciales para iniciar sesión </p>
                <form action="{{ url('/login') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    
                    
                    <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="usuario" name="name" id="name" autofocus/>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="{{ trans('adminlte_lang::message.password') }}" name="password"/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="checkbox icheck">
                                <label style="font-size: 16px; font-weight: bold;">
                                    <input style="display:none; " type="checkbox" name="remember"> Recuerdame
                                </label>
                            </div>
                        </div><!-- /.col -->
                        <div class="col-xs-6">
                            <button type="submit" class="btn btn-primary btn-block btn-flat"><i class="fa fa-check-square" aria-hidden="true"></i> Iniciar Sesión</button>
                        </div><!-- /.col -->
                        <div class="col-xs-6">
                        <button type="reset" class="btn btn-warning btn-block btn-flat" id="reset"><i class="fa fa-share-square" aria-hidden="true"></i> Cancelar</button>
                    </div>
                    </div>
                </form>

                {{-- @include('adminlte::auth.partials.social_login') 
                <br>
                <a href="{{ url('#') }}" style="font-weight: bold; color: #ffffff;">Olvidé mi Contraseña</a><br> --}}
                {{-- <a href="{{ url('/register') }}" class="text-center">{{ trans('adminlte_lang::message.registermember') }}</a> --}}

            </div><!-- /.login-box-body -->

        </div><!-- /.login-box -->
    </div>
    @include('adminlte::layouts.partials.scripts_auth')

    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
        $("#reset").click(function() {
            $("#name").focus();
        });
      });
    </script>
    </body>

@endsection