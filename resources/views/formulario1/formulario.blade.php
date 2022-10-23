<form v-on:submit.prevent="create">
  <div class="box-body" style="font-size: 14px;">


    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="txtcantidad_sobres" class="col-sm-2 control-label">Cantidad de Sobres:</label>
        <div class="col-sm-2">
          <input type="text" class="form-control" id="txtcantidad_sobres" name="txtcantidad_sobres" placeholder="Cantidad"
            maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="cantidad_sobres" onkeypress="return soloNumeros(event);">
        </div>
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="txtorigen_sobre" class="col-sm-2 control-label">Origen del Sobre:</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="txtorigen_sobre" name="txtorigen_sobre" placeholder="Origen del Sobre"
            maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="origen_sobre">
        </div>
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="txtnumero_documento" class="col-sm-2 control-label">Número de Documento:</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="txtnumero_documento" name="txtnumero_documento" placeholder="Número de Documento"
            maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="numero_documento">
        </div>
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="txtexpediente" class="col-sm-2 control-label">Expediente:</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="txtexpediente" name="txtexpediente" placeholder="Expediente"
            maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="expediente">
        </div>
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="txttelefono_origen" class="col-sm-2 control-label">Teléfono Contacto Origen:<spam style="color:red;">*</spam></label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="txttelefono_origen" name="txttelefono_origen" placeholder="Teléfono Contacto Origen"
            maxlength="100" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="telefono_origen">
        </div>
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="txtfecha_ingreso" class="col-sm-2 control-label">Fecha de Ingreso a logística:<spam style="color:red;">*</spam></label>
        <div class="col-sm-3">
          <input type="date" class="form-control" id="txtfecha_ingreso" name="txtfecha_ingreso" placeholder="dd/mm/aaaa"
            maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fecha_ingreso">
        </div>
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="txtdependencia" class="col-sm-2 control-label">Persona, Cargo, y Organo o Dependencia:</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="txtdependencia" name="txtdependencia" placeholder="Persona, Cargo, y Organo o Dependencia"
            maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="dependencia">
        </div>
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
        <label for="txtprovincia" class="col-sm-2 control-label">Provincia o Sede:</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="txtprovincia" name="txtprovincia" placeholder="Provincia o Sede"
            maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="provincia">
        </div>
      </div>
    </div>


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