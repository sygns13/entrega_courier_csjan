<form method="post" v-on:submit.prevent="update(fillobject.id)">
  <div class="box-body" style="font-size: 14px;">

 


    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="txtcantidad_sobresE" class="col-sm-2 control-label">Cantidad de Sobres:</label>
        <div class="col-sm-2">
          <input type="text" class="form-control" id="txtcantidad_sobresE" name="txtcantidad_sobresE" placeholder="Cantidad"
            maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.cantidad_sobres" onkeypress="return soloNumeros(event);">
        </div>
      </div>
    </div>

    {{-- <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="txtorigen_sobreE" class="col-sm-2 control-label">Origen del Sobre:</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="txtorigen_sobreE" name="txtorigen_sobreE" placeholder="Origen del Sobre"
            maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.origen_sobre">
        </div>
      </div>
    </div> --}}

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="cbudependencia_idE" class="col-sm-2 control-label">Origen del Sobre:</label>
        <div class="col-sm-7">
          <select class="form-control" id="cbudependencia_idE" name="cbudependencia_idE" v-model="fillobject.dependencia_id" @change="cambioDependenciaE">
            <option disabled value="0">Seleccione una Dependencia</option>
            @foreach ($dependencias as $dato)
              <option value="{{$dato->id}}">{{$dato->nombre}}</option> 
            @endforeach
          </select>
        </div>
        <label for="txtmetaE" class="col-sm-1 control-label">Meta:</label>
        <div class="col-sm-2">
          <input type="text" class="form-control" id="txtmetaE" name="txtmetaE" placeholder="Meta"
            maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.meta" disabled>
        </div>
        @foreach ($dependencias as $dato)
        <input type="hidden" id="id-metaE-{{$dato->id}}" value="{{$dato->meta}}">
        @endforeach
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="txtnumero_documentoE" class="col-sm-2 control-label">Número de Documento:</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="txtnumero_documentoE" name="txtnumero_documentoE" placeholder="Número de Documento"
            maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.numero_documento">
        </div>
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="txtexpedienteE" class="col-sm-2 control-label">Expediente:</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="txtexpedienteE" name="txtexpedienteE" placeholder="Expediente"
            maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.expediente">
        </div>
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="txttelefono_origenE" class="col-sm-2 control-label">Teléfono Contacto Origen:<spam style="color:red;">*</spam></label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="txttelefono_origenE" name="txttelefono_origenE" placeholder="Teléfono Contacto Origen"
            maxlength="100" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.telefono_origen">
        </div>
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="txtfecha_ingresoE" class="col-sm-2 control-label">Fecha de Ingreso a logística:<spam style="color:red;">*</spam></label>
        <div class="col-sm-3">
          <input type="date" class="form-control" id="txtfecha_ingresoE" name="txtfecha_ingresoE" placeholder="dd/mm/aaaa"
            maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.fecha_ingreso">
        </div>
      </div>
    </div>

    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <label for="txtdependenciaE" class="col-sm-2 control-label">Persona, Cargo, y Organo o Dependencia:</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="txtdependenciaE" name="txtdependenciaE" placeholder="Persona, Cargo, y Organo o Dependencia"
            maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.dependencia">
        </div>
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
        <label for="txtprovinciaE" class="col-sm-2 control-label">Provincia o Sede:</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="txtprovinciaE" name="txtprovinciaE" placeholder="Provincia o Sede"
            maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillobject.provincia">
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