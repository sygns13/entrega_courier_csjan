<form v-on:submit.prevent="create">
  <div class="box-body" style="font-size: 14px;">


      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtserie" class="col-sm-2 control-label">Serie del Medidor:<spam style="color:red;">*</spam></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="txtserie" name="txtserie" placeholder="Serie"
              maxlength="100" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="serie">
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtdescripcion" class="col-sm-2 control-label">Descripción:<spam style="color:red;">*</spam></label>
          <div class="col-sm-10">
            <textarea class="form-control" rows="4" placeholder="Descripción del Medidor" id="txtdescripcion" v-model="descripcion"></textarea>
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtlectura_ultima" class="col-sm-2 control-label">Última Lectura Kw:<spam style="color:red;">*</spam></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="txtlectura_ultima" name="txtlectura_ultima" placeholder="Serie"
              maxlength="40" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="lectura_ultima" onkeypress="return soloNumeros(event);">
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