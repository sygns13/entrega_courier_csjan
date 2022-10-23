<form method="post" v-on:submit.prevent="update(fillobject.id)">
  <div class="box-body" style="font-size: 14px;">


    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="cbuanioE" class="col-sm-2 control-label">Año de Proceso de Lectura:<spam style="color:red;">*</spam></label>
        <div class="col-sm-4">
          <select class="form-control" id="cbuanioE" name="cbuanioE" v-model="anioE">
            <option value="2022">2022</option>
            <option value="2023">2023</option>
            <option value="2024">2024</option>
            <option value="2025">2025</option>
          </select>
        </div>
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="cbumesE" class="col-sm-2 control-label">Mes de Proceso de Lectura:<spam style="color:red;">*</spam></label>
        <div class="col-sm-4">
          <select class="form-control" id="cbumesE" name="cbumesE" v-model="mesE">
            <option value="01">Enero</option>
            <option value="02">Febrero</option>
            <option value="03">Marzo</option>
            <option value="04">Abril</option>
            <option value="05">Mayo</option>
            <option value="06">Junio</option>
            <option value="07">Julio</option>
            <option value="08">Agosto</option>
            <option value="09">Setiembre</option>
            <option value="10">Octubre</option>
            <option value="11">Noviembre</option>
            <option value="12">Diciembre</option>
          </select>
        </div>
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="txtorden_trabajoE" class="col-sm-2 control-label">Orden de Trabajo:</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="txtorden_trabajoE" name="txtorden_trabajoE" placeholder="Orden de Trabajo"
              maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="orden_trabajoE">
        </div>
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="txtobservaciones_generacionE" class="col-sm-2 control-label">Observaciones del Proceso:</label>
        <div class="col-sm-10">
          <textarea class="form-control" rows="4" placeholder="Observaciones en la Generación del Proceso" id="txtobservaciones_generacionE" v-model="observaciones_generacionE"></textarea>
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