{{-- <form method="post" v-on:submit.prevent="update(fillobject.id)"> --}}
    <div class="box-body" style="font-size: 14px;">
  
   
      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <div class="col-sm-12">
            <label for="imgLeerDatosE">Ver Imagen del Display</label>
          </div>
          <div class="col-sm-6">
            <div style="width: 100%; min-height:100px; border: 1px solid gray; margin-bottom:10px;">
              <center>
                <img id="imgLeerDatos" style="max-width: 100%; max-height: 100%;" v-if="fillobject.idImagens != '0'" v-bind:src="'{{ asset('/web/imagen/')}}'+'/'+fillobject.ruta_imgImagens">
              </center>
            </div>
            {{-- <button type="button" class="btn btn-primary" id="btnGuardar" @click="capturarImagen()"><span
              class="fa fa-camera"></span> Capturar Imagen</button> --}}
          </div>
  
          <label for="txtlecturaLectura_medidorsE" class="col-sm-2 control-label">Lectura Actual Kw:<spam style="color:red;">*</spam></label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="txtlecturaLectura_medidorsE" name="txtlecturaLectura_medidorsE" placeholder="0.00" readonly
              maxlength="40" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.lecturaLectura_medidors" @change="cambioLecturaE()" onkeypress="return soloNumeros(event);">
          </div>
  
          
          
          <label for="txtlectura_ultimaE" class="col-sm-2 control-label" style="padding-top: 15px;">Lectura Anterior Kw:<spam style="color:red;">*</spam></label>
          <div class="col-sm-4" style="padding-top: 15px;">
            <input type="text" class="form-control" id="txtlectura_ultimaE" name="txtlectura_ultimaE" placeholder="0.00" readonly
              maxlength="40" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.lectura_ultimaLectura_medidors">
          </div>
  
  
          <label for="txtconsumo_kwLectura_medidors" class="col-sm-2 control-label" style="padding-top: 15px;">Consumo Kw:<spam style="color:red;">*</spam></label>
          <div class="col-sm-4" style="padding-top: 15px;">
            <input type="text" class="form-control" id="txtconsumo_kwLectura_medidors" name="txtconsumo_kwLectura_medidors" placeholder="0.00" readonly
              maxlength="40" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.consumo_kwLectura_medidors">
          </div>
  
          <label for="txtconsumo_solesLectura_medidors" class="col-sm-2 control-label" style="padding-top: 15px;">Consumo Soles S/:<spam style="color:red;">*</spam></label>
  
          <div class="col-sm-4" style="padding-top: 15px;">
            <input type="text" class="form-control" id="txtconsumo_solesLectura_medidors" name="txtconsumo_solesLectura_medidors" placeholder="0.00" readonly
              maxlength="40" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.consumo_solesLectura_medidors">
          </div>
  
        </div>
      </div>
  
      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtfillobject" class="col-sm-2 control-label">Observación de Lectura:<spam style="color:red;">*</spam></label>
          <div class="col-sm-10">
            <textarea class="form-control" rows="4" placeholder="Observación de la Lectura" id="txtfillobject" v-model="fillobject.observacionesLectura_medidors" readonly></textarea>
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <div class="col-sm-12">
            <label for="imgLeerDatosEMed">Ver Imagen del Medidor</label>
          </div>

          <div class="col-sm-6">
            <div style="width: 100%; min-height:100px; border: 1px solid gray; margin-bottom:10px;">
              <center>
                <img id="imgLeerDatosMed" style="max-width: 100%; max-height: 100%;" v-if="fillobject.idImagensMed != '0'" v-bind:src="'{{ asset('/web/imgmedidor/')}}'+'/'+fillobject.ruta_imgImagensMed">
              </center>
            </div>
            {{-- <button type="button" class="btn btn-primary" id="btnGuardar" @click="capturarImagen()"><span
              class="fa fa-camera"></span> Capturar Imagen</button> --}}
          </div>
        </div>
      </div>
  
      
  
  
    </div>
  
    <!-- /.box-body -->
    <div class="box-footer">
      {{-- <button type="submit" class="btn btn-primary" id="btnSaveE"><i class="fa fa-floppy-o" aria-hidden="true"></i>
        Modificar</button> --}}
  
      <button type="button" class="btn btn-default" id="btnCloseE" @click.prevent="cerrarFormV()">Cerrar</button>
  
      {{-- <div class="sk-circle" v-show="divloaderEdit">
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
      </div> --}}
  
    </div>
    <!-- /.box-footer -->
  
  {{-- </form> --}}