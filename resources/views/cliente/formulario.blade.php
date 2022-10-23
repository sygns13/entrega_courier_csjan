<form v-on:submit.prevent="create">
  <div class="box-body" style="font-size: 14px;">

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="cbutipoPersona" class="col-sm-2 control-label">Tipo:<spam style="color:red;">*</spam></label>
        <div class="col-sm-4">
          <select class="form-control" id="cbutipoPersona" name="cbutipoPersona" v-model="tipoPersona" @change="pressNuevoDNI()">
            <option value="1">Natural</option>
            <option value="2">Jurídico</option>
          </select>
        </div>
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="txtnum_documentoPersona" class="col-sm-2 control-label">Documento de Identidad @{{tipoDocIdentidad}}:<spam style="color:red;">*</spam></label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="txtnum_documentoPersona" name="txtnum_documentoPersona" placeholder="N° de Doc" maxlength="11"
            autofocus v-model="num_documentoPersona" @keyup.enter="pressNuevoDNI()" required
            @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" :disabled="validated == 1"  @change="pressNuevoDNI()"
           >
        </div>
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="txtnombresPersona" class="col-sm-2 control-label">@{{nombreCliente}}:<spam style="color:red;">*</spam></label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="txtnombresPersona" name="txtnombresPersona" placeholder="Nombre"
            maxlength="250" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="nombresPersona">
        </div>

        <template v-if="tipoPersona == '1'">
        <label for="apellidosPersona" class="col-sm-2 control-label">Apellidos:<spam style="color:red;">*</spam></label>
        <div class="col-sm-4">
            <input type="text" class="form-control" id="apellidosPersona" name="apellidosPersona" placeholder="Apellidos"
              maxlength="250" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="apellidosPersona">
          </div>
        </template>
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
          <label for="txtemailPersona" class="col-sm-2 control-label">Email:<spam style="color:red;">*</spam></label>
          <div class="col-sm-4">
            <input type="email" class="form-control" id="txtemailPersona" name="txtemailPersona" placeholder="example@domain.com"
              maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="emailPersona">
          </div>

          <label for="txtdireccionPersona" class="col-sm-2 control-label">Dirección:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="txtdireccionPersona" name="txtdireccionPersona" placeholder="Av. Jr. Psje."
              maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="direccionPersona">
          </div>

      </div>
    </div>


    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
          <label for="txttelefonoPersona" class="col-sm-2 control-label">Teléfono:</label>
          <div class="col-sm-2">
            <input type="text" class="form-control" id="txttelefonoPersona" name="txttelefonoPersona" placeholder="Telef / Cell"
              maxlength="50" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="telefonoPersona">
          </div>
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="cbuactivoPersona" class="col-sm-2 control-label">Estado:<spam style="color:red;">*</spam></label>
        <div class="col-sm-4">
          <select class="form-control" id="cbuactivoPersona" name="cbuactivoPersona" v-model="activo">
            <option value="1">Activado</option>
            <option value="0">Inactivo</option>
          </select>
        </div>
      </div>
    </div>

    <div class="col-md-12">
      <hr>
    </div>

    <center>
      <h4>Datos de Usuario</h4>
    </center>

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="txtname" class="col-sm-2 control-label">Username:<spam style="color:red;">*</spam></label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="txtname" name="txtname" placeholder="Username" maxlength="500"
            @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="name">
        </div>
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="txtpassword" class="col-sm-2 control-label">Password:<spam style="color:red;">*</spam></label>
        <div class="col-sm-10">
          <input type="password" class="form-control" id="txtpassword" name="txtpassword" placeholder="********"
            maxlength="500" v-model="password">
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