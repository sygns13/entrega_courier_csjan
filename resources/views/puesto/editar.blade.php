<form method="post" v-on:submit.prevent="update(fillobject.id)">
  <div class="box-body" style="font-size: 14px;">

 


    <div class="col-md-12" style="padding-top: 15px;">
      <label for="cbuzonasE" class="col-sm-2 control-label">Zona:*</label>
      <div class="col-sm-4">
      <select class="form-control" id="cbuzonasE" name="cbuzonasE" v-model="fillobject.zona_id">
        <option disabled value="0">Seleccione...</option>
        @foreach ($zonas as $dato)
          <option value="{{$dato->id}}">{{$dato->nombre}}</option> 
        @endforeach
      </select>
      </div>
    </div>



      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtnombreE" class="col-sm-2 control-label">Nombre del Puesto:<spam style="color:red;">*</spam></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="txtnombreE" name="txtnombreE" placeholder="Nombre del Puesto - Local"
              maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.nombre">
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtnumeroE" class="col-sm-2 control-label">Número:<spam style="color:red;">*</spam></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="txtnumeroE" name="txtnumeroE" placeholder="Número"
              maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.numero">
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <label for="cbutipoE" class="col-sm-2 control-label">Tipo:*</label>
        <div class="col-sm-4">
        <select class="form-control" id="cbutipoE" name="cbutipoE" v-model="fillobject.tipo">
          <option disabled value="0">Seleccione...</option>
            <option value="UNICO">Unico</option> 
            <option value="DIVIDIDO">Dividido</option> 
        </select>
        </div>
      </div>


      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtdireccionE" class="col-sm-2 control-label">Dirección:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="txtdireccionE" name="txtdireccionE" placeholder="Dirección"
              maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.direccion">
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtrefereniaE" class="col-sm-2 control-label">Referencia:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="txtrefereniaE" name="txtrefereniaE" placeholder="Referenia"
              maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.referenia">
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtaltaE" class="col-sm-2 control-label">Fecha de Alta:<spam style="color:red;">*</spam></label>
          <div class="col-sm-2">
            <input type="date" class="form-control" id="txtaltaE" name="txtaltaE" placeholder="dd/mm/aaaa"
              maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.alta">
          </div>
        </div>
      </div>
    


  </div>

  <!-- /.box-body -->
  <div class="box-footer">
    <button type="submit" class="btn btn-primary" id="btnSaveE"><i class="fa fa-floppy-o" aria-hidden="true"></i>
      Modificar</button>

    <button type="button" class="btn btn-default" id="btnCloseE" @click.prevent="cerrarFormE()">Cancelar</button>

    <div class="sk-circle" v-show="divloaderEdit">
      <div class="sk-circle1 sk-child"></div>
      <div class="sk-circle2 sk-child"></div>
      <div class="sk-circle3 sk-child"></div>
      <div class="sk-circle4 sk-child"></div>
      <div class="sk-circle5 sk-child"></div>
      <div class="sk-circle6 sk-child"></div>
      <div class="sk-circle7 sk-child"></div>
      <div class="sk-circle8 sk-child"></div>
      <div class="sk-circle9 sk-child"></div>
      <div class="sk-circle10 sk-child"></div>
      <div class="sk-circle11 sk-child"></div>
      <div class="sk-circle12 sk-child"></div>
    </div>

  </div>
  <!-- /.box-footer -->

</form>