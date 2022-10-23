<form method="post" v-on:submit.prevent="update(fillobject.id)">
  <div class="box-body" style="font-size: 14px;">

 
    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <div class="col-sm-12">
          <label for="imgLeerDatosE">Leer Imagen</label>
        </div>

        <div  style="width: 100%;" v-if="verCbuCameraE && btnBotonFotoE">
          <label for="listaDeDispositivosE" class="col-sm-2 control-label">Seleccione Cámara:<spam style="color:red;">*</spam></label>
          <div class="col-sm-4">
            <select class="form-control" id="listaDeDispositivosE" name="listaDeDispositivosE" v-model="listaDeDispositivoE" @change="changeDispositivoE()">
            </select>
          </div>
          </div>
          <div class="col-sm-12"></div>


        <div class="col-sm-6">
          <div style="width: 100%; min-height:100px; border: 1px solid gray; margin-bottom:10px;">
            <center>
              <img style="max-width: 100%; max-height: 100%;" v-if="fillobject.idImagens != '0' && verImgE" v-bind:src="'{{ asset('/web/imagen/')}}'+'/'+fillobject.ruta_imgImagens">

              <img id="imgLeerDatos" style="max-width: 100%; max-height: 100%;" v-if="uploadReadyE">

              <video muted="muted" id="videoE" v-if="fotoReadyE"></video>
	            <canvas id="canvasE" style="display: none;" v-if="fotoReadyE"></canvas>
            </center>
          </div>
          <button type="button" class="btn btn-primary" id="btnCapturarImg" @click="capturarImagenE()" v-if="btnBotonFotoE && !verCbuCameraE" style="margin-top: 15px;"><span
            class="fa fa-camera"></span> Usar Cámara</button>

            <button type="button" class="btn btn-primary" id="botonE" @click="tomarFotoE()" v-if="btnBotonFotoE && verCbuCameraE" style="margin-top: 15px;"><span
              class="fa fa-picture-o"></span> Capturar Imagen</button>

          <button type="button" class="btn btn-success" id="btnSubirImg" @click="subirImagenE()" v-if="btnBotonFotoE && !verCbuCameraE" style="margin-top: 15px;"><span
            class="fa fa-upload"></span> Subir Imagen</button>

            <button type="button" class="btn btn-warning" id="btnCancelTomarFotoE" @click="cancelTomarFotoE()" v-if="btnBotonFotoE && verCbuCameraE" style="margin-top: 15px;"><span
              class="fa fa-times"></span> Cancel</button>

            <div class="col-md-12" style="padding-top: 15px;">
    
              <div class="form-group" v-if="!btnBotonFotoE && !verCbuCameraE">
                <label for="archivoE" class="col-sm-2 control-label">Imagen: (Opcional)</label>

                <div class="col-sm-8" v-if="uploadReadyE">
                   <input  name="archivoE" type="file" id="archivoE" class="archivo form-control" @change="getImageE"
                  accept=".png, .jpg, .jpeg, .gif, .jpe, .PNG, .JPG, .JPEG, .GIF, .JPE"/>
                  <span style="color:red">Ingrese una Imagen o un archivo adjunto solo si va a editar la Imagen del Banner</span>
                </div>

                <div class="col-sm-2">
                  <button type="button" class="btn btn-warning" id="btnCancelSubir" @click="cancelSubirImagenE()" style="margin-top: 15px;"><span
                    class="fa fa-times"></span> Cancel</button>
                 </div>
              
            </div>
          </div>

        </div>

        <label for="txtlecturaLectura_medidorsE" class="col-sm-2 control-label">Lectura Actual Kw:<spam style="color:red;">*</spam></label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="txtlecturaLectura_medidorsE" name="txtlecturaLectura_medidorsE" placeholder="0.00"
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
          <textarea class="form-control" rows="4" placeholder="Observación de la Lectura" id="txtfillobject" v-model="fillobject.observacionesLectura_medidors"></textarea>
        </div>
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <div class="col-sm-12">
          <label for="imgLeerDatosEMed">Leer Imagen del Medidor</label>
        </div>

        <div  style="width: 100%;" v-if="verCbuCameraEMed && btnBotonFotoEMed">
          <label for="listaDeDispositivosEMed" class="col-sm-2 control-label">Seleccione Cámara:<spam style="color:red;">*</spam></label>
          <div class="col-sm-4">
            <select class="form-control" id="listaDeDispositivosEMed" name="listaDeDispositivosEMed" v-model="listaDeDispositivoEMed" @change="changeDispositivoEMed()">
            </select>
          </div>
          </div>
          <div class="col-sm-12"></div>


        <div class="col-sm-6">
          <div style="width: 100%; min-height:100px; border: 1px solid gray; margin-bottom:10px;">
            <center>
              <img style="max-width: 100%; max-height: 100%;" v-if="fillobject.idImagensMed != '0' && verImgEMed" v-bind:src="'{{ asset('/web/imgmedidor/')}}'+'/'+fillobject.ruta_imgImagensMed">

              <img id="imgLeerDatosMed" style="max-width: 100%; max-height: 100%;" v-if="uploadReadyEMed">

              <video muted="muted" id="videoEMed" v-if="fotoReadyEMed"></video>
	            <canvas id="canvasEMed" style="display: none;" v-if="fotoReadyEMed"></canvas>
            </center>
          </div>
          <button type="button" class="btn btn-primary" id="btnCapturarImgMed" @click="capturarImagenEMed()" v-if="btnBotonFotoEMed && !verCbuCameraEMed" style="margin-top: 15px;"><span
            class="fa fa-camera"></span> Usar Cámara</button>

            <button type="button" class="btn btn-primary" id="botonEMed" @click="tomarFotoEMed()" v-if="btnBotonFotoEMed && verCbuCameraEMed" style="margin-top: 15px;"><span
              class="fa fa-picture-o"></span> Capturar Imagen</button>

          <button type="button" class="btn btn-success" id="btnSubirImgMed" @click="subirImagenEMed()" v-if="btnBotonFotoEMed && !verCbuCameraEMed" style="margin-top: 15px;"><span
            class="fa fa-upload"></span> Subir Imagen</button>

            <button type="button" class="btn btn-warning" id="btnCancelTomarFotoEMed" @click="cancelTomarFotoEMed()" v-if="btnBotonFotoEMed && verCbuCameraEMed" style="margin-top: 15px;"><span
              class="fa fa-times"></span> Cancel</button>

            <div class="col-md-12" style="padding-top: 15px;">
    
              <div class="form-group" v-if="!btnBotonFotoEMed && !verCbuCameraEMed">
                <label for="archivoEMed" class="col-sm-2 control-label">Imagen: (Opcional)</label>

                <div class="col-sm-8" v-if="uploadReadyEMed">
                   <input  name="archivoEMed" type="file" id="archivoEMed" class="archivo form-control" @change="getImageEMed"
                  accept=".png, .jpg, .jpeg, .gif, .jpe, .PNG, .JPG, .JPEG, .GIF, .JPE"/>
                  <span style="color:red">Ingrese una Imagen o un archivo adjunto solo si va a editar la Imagen del Banner</span>
                </div>

                <div class="col-sm-2">
                  <button type="button" class="btn btn-warning" id="btnCancelSubirMed" @click="cancelSubirImagenEMed()" style="margin-top: 15px;"><span
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