<form v-on:submit.prevent="create">
  <div class="box-body" style="font-size: 14px;">


    <div class="col-md-12" style="padding-top: 15px;">
      <label for="cbuzonas" class="col-sm-2 control-label">Zona:*</label>
      <div class="col-sm-4">
      <select class="form-control" id="cbuzonas" name="cbuzonas" v-model="zona_id">
        <option disabled value="0">Seleccione...</option>
        @foreach ($zonas as $dato)
          <option value="{{$dato->id}}">{{$dato->nombre}}</option> 
        @endforeach
      </select>
      </div>
    </div>



      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtnombre" class="col-sm-2 control-label">Nombre del Puesto:<spam style="color:red;">*</spam></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="txtnombre" name="txtnombre" placeholder="Nombre del Puesto - Local"
              maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="nombre">
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtnumero" class="col-sm-2 control-label">Número:<spam style="color:red;">*</spam></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="txtnumero" name="txtnumero" placeholder="Número"
              maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="numero">
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <label for="cbutipo" class="col-sm-2 control-label">Tipo:*</label>
        <div class="col-sm-4">
        <select class="form-control" id="cbutipo" name="cbutipo" v-model="tipo">
          <option disabled value="0">Seleccione...</option>
            <option value="UNICO">Unico</option> 
            <option value="DIVIDIDO">Dividido</option> 
        </select>
        </div>
      </div>


      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtdireccion" class="col-sm-2 control-label">Dirección:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="txtdireccion" name="txtdireccion" placeholder="Dirección"
              maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="direccion">
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtreferenia" class="col-sm-2 control-label">Referencia:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="txtreferenia" name="txtreferenia" placeholder="Referenia"
              maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="referenia">
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtalta" class="col-sm-2 control-label">Fecha de Alta:<spam style="color:red;">*</spam></label>
          <div class="col-sm-2">
            <input type="date" class="form-control" id="txtalta" name="txtalta" placeholder="dd/mm/aaaa"
              maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="alta">
          </div>
        </div>
      </div>

      {{-- <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
            <label for="txtposision" class="col-sm-2 control-label">Orden de Publicación:<spam style="color:red;">*</spam></label>
            <div class="col-sm-4">
              <input type="number" v-model.number="posision"  class="form-control" id="txtposision" name="txtposision" placeholder="N°" onKeyUp="if(this.value.length>4){this.value='9999';}else if(this.value<0){this.value='0';}" placeholder="N°">
            </div>
        </div>
      </div> --}}


      {{-- <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="cbuactivo" class="col-sm-2 control-label">Estado:<spam style="color:red;">*</spam></label>
          <div class="col-sm-4">
            <select class="form-control" id="cbuactivo" name="cbuactivo" v-model="activo">
              <option value="1">Activado</option>
              <option value="0">Desactivado</option>
            </select>
          </div>
        </div>
      </div> --}}


  </div>

  <!-- /.box-body -->
  <div class="box-footer">
    <button type="submit" class="btn btn-info" id="btnGuardar"><span
      class="fa fa-floppy-o"></span> Guardar</button>

  <button type="reset" class="btn btn-warning" id="btnCancel"
    @click="cancelForm()"><span class="fa fa-rotate-left"></span> Cancelar</button>

    <button type="button" class="btn btn-danger" id="btnClose" @click.prevent="cerrarForm()"><span
        class="fa fa-power-off"></span> Cerrar</button>

    <div class="sk-circle" v-show="divloaderNuevo">
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