<div class="box box-primary panel-group">

    <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
        <h3 class="box-title">Menú Principal</h3>
    </div>

    <div class="box-body" style="border: 1px solid #3c8dbc;">


        @if(accesoUser([1]))
        <div class="col-md-12">
            <h3><b>Tablas Base</b></h3>
        </div>
        @endif

        @if(accesoUser([1]))


        <div class="col-lg-3 col-md-6 col-xs-12">
            <!-- small box -->
            <a href="{{URL::to('oficinas')}}" >
            <div class="small-box bg-purple" style="box-shadow: 0px 10px 30px 0px #8d8686;">
              <div class="inner">
                <h3 style="font-size: 30px">Oficinas</h3>
  
                <p>Gestión de Oficinas</p>
              </div>
              <div class="icon" style="top: 7px;">
               <i class="fa fa-building"></i> 
              </div>
              <div  class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></div>
            </div>
          </a>
          </div>

          <div class="col-lg-3 col-md-6 col-xs-12">
            <!-- small box -->
            <a href="{{URL::to('dependencias')}}" >
            <div class="small-box bg-green" style="box-shadow: 0px 10px 30px 0px #8d8686;">
              <div class="inner">
                <h3 style="font-size: 30px">Dependencias</h3>
  
                <p>Gestión de Dependencias</p>
              </div>
              <div class="icon" style="top: 7px;">
               <i class="fa fa-building"></i> 
              </div>
              <div  class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></div>
            </div>
          </a>
          </div>

        @endif



          @if(accesoUser([1,2]))
          <div class="col-md-12">
              <h3><b>Módulos del Sistema</b></h3>
          </div>
          @endif
  
          @if(accesoUser([1,2]))

            @if($tipouser->id == 1 || ($tipouser->id == 2 && $permiso1 != null))
              <div class="col-lg-3 col-md-6 col-xs-12">
                <!-- small box -->
                <a href="{{URL::to('formulario1')}}" >
                <div class="small-box bg-primary" style="box-shadow: 0px 10px 30px 0px #8d8686;">
                  <div class="inner">
                    <h3 style="font-size: 30px">Formulario 01</h3>
      
                    <p>Formulario Inicial</p>
                  </div>
                  <div class="icon" style="top: 7px;">
                  <i class="fa fa-pencil-square-o"></i> 
                  </div>
                  <div id="recibosH" class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></div>
                </div>
              </a>
              </div>
            @endif
          @endif

          @if(accesoUser([1,2]))
            @if($tipouser->id == 1 || ($tipouser->id == 2 && $permiso2 != null))
            <div class="col-lg-3 col-md-6 col-xs-12">
            <!-- small box -->
            <a href="{{URL::to('formulario2')}}" >
            <div class="small-box bg-primary" style="box-shadow: 0px 10px 30px 0px #8d8686;">
              <div class="inner">
                  <h3 style="font-size: 30px">Formulario 02</h3>
      
                  <p>Formulario Final</p>
                </div>
                <div class="icon" style="top: 7px;">
                  <i class="fa fa-pencil-square-o"></i>
                </div>
                <div class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></div>
              </div>
            </a>
            </div>
            @endif
          @endif


          @if(accesoUser([1]))
          <div class="col-lg-3 col-md-6 col-xs-12">
            <a href="{{URL::to('usuarios')}}" >
            <div class="small-box bg-maroon" style="box-shadow: 0px 10px 30px 0px #8d8686;">
              <div class="inner">
                <h3 style="font-size: 30px">Usuarios</h3>
    
                <p>Gestión de Usuarios</p>
              </div>
              <div class="icon" style="top: 7px;">
                <i class="fa fa-users"></i>
              </div>
              <div class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></div>
            </div>
          </a>
          </div>
          @endif
  
  


        @if(accesoUser([1,2]))
        <div class="col-md-12">
            <h3><b>Reportes</b></h3>
        </div>


        @if(accesoUser([1]))
        <div class="col-lg-3 col-md-6 col-xs-12">
          <!-- small box -->
          <a href="{{URL::to('reporte1')}}" >
          <div class="small-box bg-aqua" style="box-shadow: 0px 10px 30px 0px #8d8686;">
            <div class="inner">
              <h3 style="font-size: 30px">Rep. Usuarios</h3>

              <p>Reporte de Usuarios</p>
            </div>
            <div class="icon" style="top: 7px;">
             <i class="fa fa-print"></i> 
            </div>
            <div  class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></div>
          </div>
        </a>
        </div>
        @endif

        @if(accesoUser([1,2]))
        <div class="col-lg-3 col-md-6 col-xs-12">
          <!-- small box -->
          <a href="{{URL::to('reporte2')}}" >
          <div class="small-box bg-aqua" style="box-shadow: 0px 10px 30px 0px #8d8686;">
            <div class="inner">
              <h3 style="font-size: 30px">Rep. Courier</h3>

              <p>Reporte de Entrega Courier</p>
            </div>
            <div class="icon" style="top: 7px;">
             <i class="fa fa-print"></i> 
            </div>
            <div  class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></div>
          </div>
        </a>
        </div>

        @endif

        @endif
      
</div>
</div>