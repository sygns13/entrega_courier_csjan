<form v-on:submit.prevent="create">
  <div class="box-body" style="font-size: 14px;">


    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <div class="col-sm-12">
          <label for="imgLeerDatos">Leer Imagen del Display</label>
        </div>

        <div  style="width: 100%;" v-if="verCbuCamera && btnBotonFoto">
        <label for="listaDeDispositivos" class="col-sm-2 control-label">Seleccione Cámara:<spam style="color:red;">*</spam></label>
        <div class="col-sm-4">
          <select class="form-control" id="listaDeDispositivos" name="listaDeDispositivos" v-model="listaDeDispositivo" @change="changeDispositivo()">
          </select>
        </div>
        </div>
        <div class="col-sm-12"></div>

        <div class="col-sm-6">
          <div style="width: 100%; min-height:100px; border: 1px solid gray; margin-bottom:10px;">
            <center>
            <img id="imgLeerDatos" style="max-width: 100%; max-height: 100%;" v-if="uploadReady">
            <video muted="muted" id="video" v-if="fotoReady"></video>
	          <canvas id="canvas" style="display: none;" v-if="fotoReady"></canvas>
            </center>
          </div>
          <button type="button" class="btn btn-primary" id="btnCapturarImg" @click="capturarImagen()" v-if="btnBotonFoto && !verCbuCamera" style="margin-top: 15px;"><span
            class="fa fa-camera"></span> Usar Cámara</button>

          <button type="button" class="btn btn-primary" id="boton" @click="tomarFoto()" v-if="btnBotonFoto && verCbuCamera" style="margin-top: 15px;"><span
            class="fa fa-picture-o"></span> Capturar Imagen</button>

          <button type="button" class="btn btn-success" id="btnSubirImg" @click="subirImagen()" v-if="btnBotonFoto && !verCbuCamera" style="margin-top: 15px;"><span
            class="fa fa-upload"></span> Subir Imagen</button>

            <button type="button" class="btn btn-warning" id="btnCancelTomarFoto" @click="cancelTomarFoto()" v-if="btnBotonFoto && verCbuCamera" style="margin-top: 15px;"><span
              class="fa fa-times"></span> Cancel</button>

            <div class="col-md-12">

              <div class="form-group" v-if="!btnBotonFoto && !verCbuCamera">
                <label for="cbuestado" class="col-sm-2 control-label" style="margin-top: 15px;">Cargar Imagen</label>
          
                <div class="col-sm-8">
                   <input name="archivo" type="file" id="archivo" class="archivo form-control" @change="getImage"  v-if="uploadReady" style="margin-top: 15px;"
          accept=".png, .jpg, .jpeg, .gif, .jpe, .PNG, .JPG, .JPEG, .GIF, .JPE"/>
                 </div>
                 <div class="col-sm-2">
                  <button type="button" class="btn btn-warning" id="btnCancelSubir" @click="cancelSubirImagen()" style="margin-top: 15px;"><span
                    class="fa fa-times"></span> Cancel</button>
                 </div>
              </div>
          
          </div>
        </div>

        <label for="txtlecturaLectura_medidors" class="col-sm-2 control-label">Lectura Actual Kw:<spam style="color:red;">*</spam></label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="txtlecturaLectura_medidors" name="txtlecturaLectura_medidors" placeholder="0.00"
            maxlength="40" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.lecturaLectura_medidors" @change="cambioLectura()" onkeypress="return soloNumeros(event);">
        </div>

        
        
        <label for="txtlectura_ultima" class="col-sm-2 control-label" style="padding-top: 15px;">Lectura Anterior Kw:<spam style="color:red;">*</spam></label>
        <div class="col-sm-4" style="padding-top: 15px;">
          <input type="text" class="form-control" id="txtlectura_ultima" name="txtlectura_ultima" placeholder="0.00" readonly
            maxlength="40" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.lectura_ultima">
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


{{-- 
      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtconsumo_kwLectura_medidors" class="col-sm-2 control-label">Consumo Kw:<spam style="color:red;">*</spam></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="txtconsumo_kwLectura_medidors" name="txtconsumo_kwLectura_medidors" placeholder="0.00" readonly
              maxlength="40" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.consumo_kwLectura_medidors">
          </div>
        </div>
      </div> --}}

{{--       <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtconsumo_solesLectura_medidors" class="col-sm-2 control-label">Consumo Soles S/:<spam style="color:red;">*</spam></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="txtconsumo_solesLectura_medidors" name="txtconsumo_solesLectura_medidors" placeholder="0.00" readonly
              maxlength="40" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.consumo_solesLectura_medidors">
          </div>
        </div>
      </div> --}}

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtfillobject" class="col-sm-2 control-label">Observación de Lectura:<spam style="color:red;">*</spam></label>
          <div class="col-sm-10">
            <textarea class="form-control" rows="4" placeholder="Observación de la Lectura" id="txtfillobject" v-model="fillobject.observacionesLectura_medidors"></textarea>
          </div>
        </div>
      </div>


      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <div class="col-sm-12">
            <label for="imgLeerDatosMed">Leer Imagen del Medidor</label>
          </div>
          <div  style="width: 100%;" v-if="verCbuCameraMed && btnBotonFotoMed">
            <label for="listaDeDispositivosMed" class="col-sm-2 control-label">Seleccione Cámara:<spam style="color:red;">*</spam></label>
            <div class="col-sm-4">
              <select class="form-control" id="listaDeDispositivosMed" name="listaDeDispositivosMed" v-model="listaDeDispositivoMed" @change="changeDispositivoMed()">
              </select>
            </div>
          </div>
          <div class="col-sm-12"></div>



          <div class="col-sm-6">
            <div style="width: 100%; min-height:100px; border: 1px solid gray; margin-bottom:10px;">
              <center>
              <img id="imgLeerDatosMed" style="max-width: 100%; max-height: 100%;" v-if="uploadReadyMed">
              <video muted="muted" id="videoMed" v-if="fotoReadyMed"></video>
              <canvas id="canvasMed" style="display: none;" v-if="fotoReadyMed"></canvas>
              </center>
            </div>
            <button type="button" class="btn btn-primary" id="btnCapturarImgMed" @click="capturarImagenMed()" v-if="btnBotonFotoMed && !verCbuCameraMed" style="margin-top: 15px;"><span
              class="fa fa-camera"></span> Usar Cámara</button>
  
            <button type="button" class="btn btn-primary" id="botonMed" @click="tomarFotoMed()" v-if="btnBotonFotoMed && verCbuCameraMed" style="margin-top: 15px;"><span
              class="fa fa-picture-o"></span> Capturar Imagen</button>
  
            <button type="button" class="btn btn-success" id="btnSubirImgMed" @click="subirImagenMed()" v-if="btnBotonFotoMed && !verCbuCameraMed" style="margin-top: 15px;"><span
              class="fa fa-upload"></span> Subir Imagen</button>
  
              <button type="button" class="btn btn-warning" id="btnCancelTomarFotoMed" @click="cancelTomarFotoMed()" v-if="btnBotonFotoMed && verCbuCameraMed" style="margin-top: 15px;"><span
                class="fa fa-times"></span> Cancel</button>
  
              <div class="col-md-12">
  
                <div class="form-group" v-if="!btnBotonFotoMed && !verCbuCameraMed">
                  <label for="cbuestado" class="col-sm-2 control-label" style="margin-top: 15px;">Cargar Imagen</label>
            
                  <div class="col-sm-8">
                     <input name="archivoMed" type="file" id="archivoMed" class="archivo form-control" @change="getImageMed"  v-if="uploadReadyMed" style="margin-top: 15px;"
            accept=".png, .jpg, .jpeg, .gif, .jpe, .PNG, .JPG, .JPEG, .GIF, .JPE"/>
                   </div>
                   <div class="col-sm-2">
                    <button type="button" class="btn btn-warning" id="btnCancelSubirMed" @click="cancelSubirImagenMed()" style="margin-top: 15px;"><span
                      class="fa fa-times"></span> Cancel</button>
                   </div>
                </div>
            
            </div>
          </div>


        </div>
      </div>

  </div>

  <!-- /.box-body -->
  <div class="box-footer">
    <button type="submit" class="btn btn-info" id="btnGuardar"><span
      class="fa fa-floppy-o"></span> Guardar</button>

  <button type="button" class="btn btn-warning" id="btnCancel"
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