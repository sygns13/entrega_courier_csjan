<form method="post" v-on:submit.prevent="update(fillobject.id)">
  <div class="box-body" style="font-size: 14px;">

 


    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="txtserieE" class="col-sm-2 control-label">Serie del Medidor:<spam style="color:red;">*</spam></label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="txtserieE" name="txtserieE" placeholder="Serie"
            maxlength="100" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.serie">
        </div>
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="txtdescripcionE" class="col-sm-2 control-label">Descripción:<spam style="color:red;">*</spam></label>
        <div class="col-sm-10">
          <textarea class="form-control" rows="4" placeholder="Descripción del Medidor" id="txtdescripcionE" v-model="fillobject.descripcion"></textarea>
        </div>
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="txtlectura_ultimaE" class="col-sm-2 control-label">Última Lectura Kw:<spam style="color:red;">*</spam></label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="txtlectura_ultimaE" name="txtlectura_ultimaE" placeholder="Serie"
            maxlength="40" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.lectura_ultima" onkeypress="return umeros(event);">
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