<div class="box box-primary panel-group">

    <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
        <h3 class="box-title">Menú Principal</h3>
    </div>

    <div class="box-body" style="border: 1px solid #3c8dbc;">


        @if(accesoUser([1,2,3]))
        <div class="col-md-12">
            <h3><b>Tablas Base</b></h3>
        </div>
        @endif

        @if(accesoUser([1,2,3]))


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
            <a href="{{URL::to('zonas')}}" >
            <div class="small-box bg-green" style="box-shadow: 0px 10px 30px 0px #8d8686;">
            <div class="inner">
                <h3 style="font-size: 30px">Zonas</h3>

                <p>Gestión de Zonas</p>
            </div>
            <div class="icon" style="top: 7px;">
                <i class="fa fa-map-signs"></i>
            </div>
            <div class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></div>
            </div>
          </a>
        </div>

        @endif



          @if(accesoUser([1,2,3,4]))
          <div class="col-md-12">
              <h3><b>Módulos de Gestión del Sistema</b></h3>
          </div>
          @endif
  
          @if(accesoUser([1,2,3]))

          <div class="col-lg-3 col-md-6 col-xs-12">
            <!-- small box -->
            <a href="{{URL::to('puestos')}}" >
            <div class="small-box bg-primary" style="box-shadow: 0px 10px 30px 0px #8d8686;">
              <div class="inner">
                <h3 style="font-size: 30px">Puestos</h3>
  
                <p>Gestión de Puestos</p>
              </div>
              <div class="icon" style="top: 7px;">
               <i class="fa fa-bank"></i> 
              </div>
              <div id="recibosH" class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></div>
            </div>
          </a>
          </div>
          @endif

          @if(accesoUser([1,2]))
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


          @if(accesoUser([1,2,3]))
          <div class="col-lg-3 col-md-6 col-xs-12">
              <!-- small box -->
              <a href="{{URL::to('proceso_lecturas')}}" >
              <div class="small-box bg-yellow" style="box-shadow: 0px 10px 30px 0px #8d8686;">
              <div class="inner">
                  <h3 style="font-size: 30px">Proceso Lectura</h3>
  
                  <p>Gestión del Proceso de Lectura</p>
              </div>
              <div class="icon" style="top: 7px;">
                  <i class="fa fa-cogs"></i>
              </div>
              <div class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></div>
              </div>
            </a>
          </div>
          @endif
  
  
          @if(accesoUser([1,2,3]))
          <div class="col-lg-3 col-md-6 col-xs-12">
              <!-- small box -->
              <a href="{{URL::to('programar_rutas')}}" >
              <div class="small-box bg-Teal" style="box-shadow: 0px 10px 30px 0px #8d8686;">
              <div class="inner">
                  <h3 style="font-size: 30px">Rutas</h3>
          
                  <p>Programar Rutas</p>
              </div>
              <div class="icon" style="top: 7px;">
          <i class="fa fa-map"></i> 
              </div>
              <div id="recibosP" class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></div>
              </div>
            </a>
          </div>
          @endif
  
  
  
          @if(accesoUser([1,2,3,4]))
          <div class="col-lg-3 col-md-6 col-xs-12">
              <!-- small box -->
              <a href="{{URL::to('lectura_datos')}}" >
              <div class="small-box bg-red-active" style="box-shadow: 0px 10px 30px 0px #8d8686;">
              <div class="inner">
                  <h3 style="font-size: 30px">Lectura de Datos</h3>
          
                  <p>Tomar Lectura de Datos</p>
              </div>
              <div class="icon" style="top: 7px;">
              <i class="fa fa-object-group"></i> 
              </div>
              <div id="recibosP" class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></div>
              </div>
            </a>
          </div> 
        @endif


        @if(accesoUser([1,2,3,4,5]))
        <div class="col-md-12">
            <h3><b>Reportes</b></h3>
        </div>


        @if(accesoUser([1,2,3]))
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

        @if(accesoUser([1,2,3,4]))
        <div class="col-lg-3 col-md-6 col-xs-12">
          <!-- small box -->
          <a href="{{URL::to('reporte2')}}" >
          <div class="small-box bg-aqua" style="box-shadow: 0px 10px 30px 0px #8d8686;">
            <div class="inner">
              <h3 style="font-size: 30px">Rep. Clientes</h3>

              <p>Reporte de Clientes</p>
            </div>
            <div class="icon" style="top: 7px;">
             <i class="fa fa-print"></i> 
            </div>
            <div  class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></div>
          </div>
        </a>
        </div>

        <div class="col-lg-3 col-md-6 col-xs-12">
          <!-- small box -->
          <a href="{{URL::to('reporte3')}}" >
          <div class="small-box bg-aqua" style="box-shadow: 0px 10px 30px 0px #8d8686;">
            <div class="inner">
              <h3 style="font-size: 30px">Puestos Negocio</h3>

              <p>Reporte de Puestos de Negocio</p>
            </div>
            <div class="icon" style="top: 7px;">
             <i class="fa fa-print"></i> 
            </div>
            <div  class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></div>
          </div>
        </a>
        </div>

        <div class="col-lg-3 col-md-6 col-xs-12">
          <!-- small box -->
          <a href="{{URL::to('reporte4')}}" >
          <div class="small-box bg-aqua" style="box-shadow: 0px 10px 30px 0px #8d8686;">
            <div class="inner">
              <h3 style="font-size: 30px">Rep. Rutas</h3>

              <p>Reporte de Rutas</p>
            </div>
            <div class="icon" style="top: 7px;">
             <i class="fa fa-print"></i> 
            </div>
            <div  class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></div>
          </div>
        </a>
        </div>
        @endif

        <div class="col-lg-3 col-md-6 col-xs-12">
          <!-- small box -->
          <a href="{{URL::to('reporte5')}}" >
          <div class="small-box bg-aqua" style="box-shadow: 0px 10px 30px 0px #8d8686;">
            <div class="inner">
              <h3 style="font-size: 30px">Libro Lectura</h3>

              <p>Reporte de Libro de Lecturas</p>
            </div>
            <div class="icon" style="top: 7px;">
             <i class="fa fa-print"></i> 
            </div>
            <div  class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></div>
          </div>
        </a>
        </div>

        <div class="col-lg-3 col-md-6 col-xs-12">
          <!-- small box -->
          <a href="{{URL::to('reporte6')}}" >
          <div class="small-box bg-aqua" style="box-shadow: 0px 10px 30px 0px #8d8686;">
            <div class="inner">
              <h3 style="font-size: 30px">Rep. Calculo</h3>

              <p>Reporte de Calculo de Consumoss</p>
            </div>
            <div class="icon" style="top: 7px;">
             <i class="fa fa-print"></i> 
            </div>
            <div  class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></div>
          </div>
        </a>
        </div>
        @endif
      
</div>
</div>