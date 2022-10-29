<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        

                

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p style="overflow: hidden;text-overflow: ellipsis;max-width: 160px;" data-toggle="tooltip" title="{{ Auth::user()->name }}">{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
            </div>
        @endif

        <!-- search form (Optional) -->
        {{-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="{{ trans('adminlte_lang::message.search') }}..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form> --}}
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">

            <div class="no-print user-panel-unasam">
                <div class="no-print image" style="text-align: center;">
                    {{-- <img src="{{asset('/img/logo.jpg')}}"  alt="User Image" style="margin-top: 15px;height: 60px;" /> --}}
                    {{-- <ul class="no-print sidebar-menu">
                    <li class="no-print stroke treeview" style="font-family: Monotype Corsiva;font-size: 21px;color: #f9c52c;margin-top: 5px;">"Una Nueva Universidad<br>Para el Desarrollo"</li>
                    </ul> --}}
                </div>
            </div>

            {{-- <hr style="border-top: 1px solid #4d4d4d;"> --}}

            <li class="header">MENÚ PRINCIPAL</li>
            

            
            <li v-bind:class="classMenu0"><a href="{{ URL::to('home') }}"><i class='fa fa-home'></i> <span>Inicio</span></a></li>

            @if(accesoUser([1]))
            <li class="treeview" v-bind:class="classMenu1">
                <a href="#"><i class='fa fa-tasks'></i> <span>Tablas Base</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{URL::to('oficinas')}}"><i class='fa fa-sign-in'></i> Gestión de Oficinas</a></li>
                    <li><a href="{{URL::to('dependencias')}}"><i class='fa fa-sign-in'></i> Gestión de Dependencias</a></li>
                </ul>
            </li>
            @endif

            @if(accesoUser([1]))
                <li v-bind:class="classMenu2"><a href="{{URL::to('usuarios')}}"><i class='fa fa-users'></i> <span>Gestión de Usuarios</span></a></li>
            @endif

            @if(accesoUser([1,2]))
            <li class="treeview" v-bind:class="classMenu3">
                <a href="#"><i class='fa fa-pencil-square-o'></i> <span>Entrega Courier</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    @if($tipouser->id == 1 || ($tipouser->id == 2 && $permiso1 != null))
                    <li><a href="{{URL::to('formulario1')}}"><i class='fa fa-sign-in'></i> Formulario Inicial Form 01</a></li>
                    @endif
                    @if($tipouser->id == 1 || ($tipouser->id == 2 && $permiso2 != null))
                    <li><a href="{{URL::to('formulario2')}}"><i class='fa fa-sign-in'></i> Formulario Final Form 02</a></li>
                    @endif
                </ul>
            </li>
            @endif



            @if(accesoUser([1,2]))
            <li class="treeview" v-bind:class="classMenu7">
                <a href="#"><i class='fa fa-print'></i> <span>Reportes</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    @if(accesoUser([1]))
                    <li><a href="{{URL::to('reporte1')}}"><i class='fa fa-sign-in'></i> Reporte de Usuarios</a></li>
                    @endif
                    @if(accesoUser([1,2]))
                    <li><a href="{{URL::to('reporte2')}}"><i class='fa fa-sign-in'></i> Reporte Registros de Entrega</a></li>
                    @endif
                </ul>
            </li>
            @endif

            @if(accesoUser([1,2]))
            <li class="treeview" v-bind:class="classMenu6">
                <a href="#"><i class='fa fa-cogs'></i> <span>Configuraciones</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{URL::to('miperfil')}}"><i class='fa fa-sign-in'></i> Mi Perfil</a></li>
                    <li><a href="{{URL::to('salir')}}" ><i class='fa fa-sign-in'></i> <b>Cerrar Sesión</b></a></li>
                </ul>
            </li>
            @endif


        </ul><!-- /.sidebar-menu -->


       
    </section>
    <!-- /.sidebar -->
</aside>
