<script type="text/javascript">
 let app = new Vue({
    el: '#app',
    data:{
        titulo:"Proceso de Lectura",
        subtitulo: "Principal",
        subtitulo2: "Principal",

        subtitle2:false,
        subtitulo2:"",

        tipouserPerfil:'{{ $tipouser->nombre }}',
        userPerfil:'{{ Auth::user()->name }}',
        mailPerfil:'{{ Auth::user()->email }}',


        divloader0:true,
        divloader1:false,
        divloader2:false,
        divloader3:false,
        divloader4:false,
        divloader5:false,
        divloader6:false,
        divloader7:false,
        divloader8:false,
        divloader9:false,
        divloader10:false,
        divtitulo:true,
        classTitle:'fa fa-object-group',
        classMenu0:'',
        classMenu1:'',
        classMenu2:'',
        classMenu3:'',
        classMenu4:'',
        classMenu5:'active',
        classMenu6:'',
        classMenu7:'',
        classMenu8:'',
        classMenu9:'',
        classMenu10:'',
        classMenu11:'',
        classMenu12:'',
        classMenu13:'',
        classMenu14:'',
        classMenu15:'',


        registros: [],
        errors:[],

        fillobject:{ 'id':'', 
                    'serie':'', 
                    'descripcion':'', 
                    'alta':'',
                    'baja':'',
                    'activo':'',
                    'lectura_ultima':'',
                    'borrado':'',
                    'created_at':'',
                    'updated_at':'',
                    'puesto_local_id':'',
                    'puesto':'',
                    'numeroPuesto':'',
                    'dirPuesto':'',
                    'tipoPuesto':'',
                    'referenciaPuesto':'',
                    'zona_id':'',
                    'altaPuesto':'',
                    'nombreZona':'',
                    'descripcionZona':'',
                    'idProceso_lecturas':'',
                    'idLectura_medidors':'',
                    'proceso_lectura_idLectura_medidors':'',
                    'medidors_idLectura_medidors':'',
                    'estadoLectura_medidors':'',
                    'lectura_consistenteLectura_medidors':'',
                    'lecturaLectura_medidors':'',
                    'lectura_ultimaLectura_medidors':'',
                    'consumo_kwLectura_medidors':'',
                    'consumo_solesLectura_medidors':'',
                    'observacionesLectura_medidors':'',
                    'fecha_programacionLectura_medidors':'',
                    'fecha_lecturaLectura_medidors':'',
                    'idUsers':'',
                    'nameUsers':'',
                    'emailUsers':'',
                    'idTipo_users':'',
                    'nombreTipo_users':'',
                    'descripcionTipo_users':'',
                    'idPersonas':'',
                    'tipoPersonas':'',
                    'tipo_documentoPersonas':'',
                    'num_documentoPersonas':'',
                    'apellidosPersonas':'',
                    'nombresPersonas':'',
                    'telefonoPersonas':'',
                    'direccionPersonas':'',
                    'emailPersonas':'',
                    'idTrabajadors':'',
                    'cargoTrabajadors':'',
                    'oficina_idTrabajadors':'',
                    'idImagens':'',
                    'ruta_imgImagens':'',
                    'idImagensMed':'',
                    'ruta_imgImagensMed':'',
                    },

        pagination: {
            'total': 0,
            'current_page': 0,
            'per_page': 0,
            'last_page': 0,
            'from': 0,
            'to': 0
        },
        offset: 9,

        buscar:'',
        divNuevo:false,
        divEdit:false,
        divVerDatos:false,


        divloaderNuevo:false,
        divloaderEdit:false,
        divloaderProgramacion:false,

        mostrarPalenIni:true,

        thispage:'1',
        divprincipal:false,

        Programacion: 'REALIZAR',
        procesar: 'Grabar',
        doProccess: 'Registrar',

        costoUnitarioKw: {{ $costoUnitarioKw->value }},

        btnBotonFoto:true,
        btnBotonFotoE:true,

        imagen : null,
        uploadReady: false,

        imagenE : null,
        uploadReadyE: false,

        oldImg:'',
        image:'',

        verImgE:true,

        listaDeDispositivo: null,
        verCbuCamera:false,
        stream: null,
        fotoReady: false,

        tipoImage: 1,


        listaDeDispositivoE: null,
        verCbuCameraE: false,
        fotoReadyE: false,


        //Capturar medidor

        btnBotonFotoMed:true,
        btnBotonFotoEMed:true,

        imagenMed : null,
        uploadReadyMed: false,

        imagenEMed : null,
        uploadReadyEMed: false,

        oldImgMed:'',
        imageMed:'',

        verImgEMed:true,

        listaDeDispositivoMed: null,
        verCbuCameraMed:false,
        streamMed: null,
        fotoReadyMed: false,

        tipoImageMed: 1,


        listaDeDispositivoEMed: null,
        verCbuCameraEMed: false,
        fotoReadyEMed: false,



    },
    created:function () {
        this.getDatos(this.thispage);

        
    },
    mounted: function () {
        $("#divtitulo").show('slow');
        this.divloader0=false;
        this.divprincipal=true;
    },
    computed:{
        isActived: function(){
            return this.pagination.current_page;
        },
        pagesNumber: function () {
            if(!this.pagination.to){
                return [];
            }

            var from=this.pagination.current_page - this.offset 
            var from2=this.pagination.current_page - this.offset 
            if(from<1){
                from=1;
            }

            var to= from2 + (this.offset*2); 
            if(to>=this.pagination.last_page){
                to=this.pagination.last_page;
            }

            var pagesArray = [];
            while(from<=to){
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        }
    },

    filters:{
    mostrarNumero(value){
      
      if(value != null && value != undefined){
        value=parseFloat(value).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      }

      return value;
    },
    pasfechaVista:function(date){
        if(date!=null && date.length==10){
            date=date.slice(-2)+'/'+date.slice(-5,-3)+'/'+date.slice(0,4);            
        }else{
          return '';
        }

        return date;
    },
    leftpad:function(n, length) {
        var  n = n.toString();
        while(n.length < length)
            n = "0" + n;
        return n;
    }

  },

    methods: {


        getDatos: function (page) {
            var busca=this.buscar;
            var url = 'lectura_datosre?page='+page+'&busca='+busca;

            axios.get(url).then(response=>{

                this.registros= response.data.registros.data;
                this.pagination= response.data.pagination;

                //this.mostrarPalenIni=true;

                if(this.registros.length==0 && this.thispage!='1'){
                    var a = parseInt(this.thispage) ;
                    a--;
                    this.thispage=a.toString();
                    this.changePage(this.thispage);
                }
            })
        },
        changePage:function (page) {
            this.pagination.current_page=page;
            this.getDatos(page);
            this.thispage=page;
        },
        buscarBtn: function () {
            this.getDatos();
            this.thispage='1';
        },

        doLectura:function (dato) {

           /*  this.Programacion='REALIZAR';
            this.procesar='Grabar';
            this.doProccess='Registrar'; */

            this.fillobject.id = dato.id; 
            this.fillobject.serie = dato.serie; 
            this.fillobject.descripcion = dato.descripcion; 
            this.fillobject.alta = dato.alta;
            this.fillobject.baja = dato.baja;
            this.fillobject.activo = dato.activo;
            this.fillobject.lectura_ultima = (parseFloat(dato.lectura_ultima)).toFixed(2);
            this.fillobject.borrado = dato.borrado;
            this.fillobject.created_at = dato.created_at;
            this.fillobject.updated_at = dato.updated_at;
            this.fillobject.puesto_local_id = dato.puesto_local_id;
            this.fillobject.puesto = dato.puesto;
            this.fillobject.numeroPuesto = dato.numeroPuesto;
            this.fillobject.dirPuesto = dato.dirPuesto;
            this.fillobject.tipoPuesto = dato.tipoPuesto;
            this.fillobject.referenciaPuesto = dato.referenciaPuesto;
            this.fillobject.zona_id = dato.zona_id;
            this.fillobject.altaPuesto = dato.altaPuesto;
            this.fillobject.nombreZona = dato.nombreZona;
            this.fillobject.descripcionZona = dato.descripcionZona;
            this.fillobject.idProceso_lecturas = dato.idProceso_lecturas;
            this.fillobject.idLectura_medidors = dato.idLectura_medidors;
            this.fillobject.proceso_lectura_idLectura_medidors = dato.proceso_lectura_idLectura_medidors;
            this.fillobject.medidors_idLectura_medidors = dato.medidors_idLectura_medidors;
            this.fillobject.estadoLectura_medidors = dato.estadoLectura_medidors;
            this.fillobject.lectura_consistenteLectura_medidors = dato.lectura_consistenteLectura_medidors;
            this.fillobject.lecturaLectura_medidors = dato.lecturaLectura_medidors;
            this.fillobject.lectura_ultimaLectura_medidors = dato.lectura_ultimaLectura_medidors;
            this.fillobject.consumo_kwLectura_medidors = dato.consumo_kwLectura_medidors;
            this.fillobject.consumo_solesLectura_medidors = dato.consumo_solesLectura_medidors;
            this.fillobject.observacionesLectura_medidors = dato.observacionesLectura_medidors;
            this.fillobject.fecha_programacionLectura_medidors = dato.fecha_programacionLectura_medidors;
            this.fillobject.fecha_lecturaLectura_medidors = dato.fecha_lecturaLectura_medidors;
            this.fillobject.idUsers = '0';
            this.fillobject.nameUsers = dato.nameUsers;
            this.fillobject.emailUsers = dato.emailUsers;
            this.fillobject.idTipo_users = dato.idTipo_users;
            this.fillobject.nombreTipo_users = dato.nombreTipo_users;
            this.fillobject.descripcionTipo_users = dato.descripcionTipo_users;
            this.fillobject.idPersonas = dato.idPersonas;
            this.fillobject.tipoPersonas = dato.tipoPersonas;
            this.fillobject.tipo_documentoPersonas = dato.tipo_documentoPersonas;
            this.fillobject.num_documentoPersonas = dato.num_documentoPersonas;
            this.fillobject.apellidosPersonas = dato.apellidosPersonas;
            this.fillobject.nombresPersonas = dato.nombresPersonas;
            this.fillobject.telefonoPersonas = dato.telefonoPersonas;
            this.fillobject.direccionPersonas = dato.direccionPersonas;
            this.fillobject.emailPersonas = dato.emailPersonas;
            this.fillobject.idTrabajadors = dato.idTrabajadors;
            this.fillobject.cargoTrabajadors = dato.cargoTrabajadors;
            this.fillobject.oficina_idTrabajadors = dato.oficina_idTrabajadors;
            this.fillobject.idImagens = dato.idImagens;
            this.fillobject.ruta_imgImagens = dato.ruta_imgImagens;
            this.fillobject.idImagensMed = dato.idImagensMed;
            this.fillobject.ruta_imgImagensMed = dato.ruta_imgImagensMed;


            this.divNuevo=true;
            this.divloaderEdit=false;
            this.divEdit=false;
            this.divVerDatos=false;
            /* this.$nextTick(function () {
                this.cancelForm();
            }) */
      },

      cambioLectura:function() {

        if(this.fillobject.lecturaLectura_medidors != null && this.fillobject.lecturaLectura_medidors != ''){
            this.fillobject.lecturaLectura_medidors = parseFloat(this.fillobject.lecturaLectura_medidors).toFixed(2);
            if(parseFloat(this.fillobject.lecturaLectura_medidors) > parseFloat(this.fillobject.lectura_ultima)){
                this.fillobject.consumo_kwLectura_medidors = (parseFloat(this.fillobject.lecturaLectura_medidors) - parseFloat(this.fillobject.lectura_ultima)).toFixed(2); 
                this.fillobject.consumo_solesLectura_medidors = (parseFloat(this.fillobject.consumo_kwLectura_medidors) * parseFloat(this.costoUnitarioKw)).toFixed(2);
            }
            else{
                this.fillobject.consumo_kwLectura_medidors = '';
                this.fillobject.consumo_solesLectura_medidors = '';
                toastr.error("El Resultado del Consumo no puede ser Negativo o 0");//mostramos mensaje
            }
            
        }
      },

      cancelForm: function () {
        this.fillobject.lecturaLectura_medidors = '';
        this.fillobject.consumo_kwLectura_medidors = '';
        this.fillobject.consumo_solesLectura_medidors = '';
        this.fillobject.observacionesLectura_medidors = '';
        this.cancelSubirImagenMed();
        this.cancelTomarFotoMed();
        this.cancelSubirImagen();
        this.cancelTomarFoto();
        this.$nextTick(() => {
            $('#txtlecturaLectura_medidors').focus();
        })

        this.divEdit=false;
     },
        cerrarForm: function () {
            this.divNuevo=false;
            this.cancelForm();
        },

        subirImagen: function(){
            this.btnBotonFoto = false;
            this.uploadReady = true;
        },

        subirImagenE: function(){
            this.btnBotonFotoE = false;
            this.uploadReadyE = true;
        },

        getImage(event){
            //Asignamos la imagen a  nuestra data
            if (!event.target.files.length)
            {
                this.imagen=null;
            }
            else{
                this.imagen = event.target.files[0];
                var image = document.getElementById('imgLeerDatos');
                console.log(image);
                image.src = URL.createObjectURL(event.target.files[0]);
                this.tipoImage = 1;

                Tesseract.recognize(
                    image.src,
                    'eng',
                    { logger: m => console.log(m) }
                ).then(({ data: { text } }) => {
                    console.log("text "+text)
                    if(isNaN(text)){
                        toastr.error("No se pudo reconocer automáticamente la lectura");//mostramos mensaje
                    }
                    else{
                        app.fillobject.lecturaLectura_medidors = text;
                        app.cambioLectura();
                    }
                })
            }
        },
        getImageE(event){
            if (!event.target.files.length)
            {
                this.imagenE=null;
            }
            else{
                this.verImgE = false;
                this.imagenE = event.target.files[0];
                var image = document.getElementById('imgLeerDatos');
                console.log(image);
                image.src = URL.createObjectURL(event.target.files[0]);
                this.tipoImage = 1;

                Tesseract.recognize(
                    image.src,
                    'eng',
                    { logger: m => console.log(m) }
                ).then(({ data: { text } }) => {
                    console.log("text "+text)
                    if(isNaN(text)){
                        toastr.error("No se pudo reconocer automáticamente la lectura");//mostramos mensaje
                    }
                    else{
                        app.fillobject.lecturaLectura_medidors = text;
                        app.cambioLecturaE();
                    }
                })
            }
        },

        cancelSubirImagen:function () {
            this.btnBotonFoto = true;
            this.imagen=null;
            this.uploadReady = false;
        },

        cancelSubirImagenE:function () {
            this.btnBotonFotoE = true;
            this.imagenE=null;
            this.uploadReadyE = false;
            this.verImgE = true;
        },

        create:function () {
            var url='lectura_datosre';

            $("#btnGuardar").attr('disabled', true);
            $("#btnCancel").attr('disabled', true);
            $("#btnClose").attr('disabled', true);

            this.divloaderNuevo=true;

            var data = new  FormData();

            data.append('id', this.fillobject.id);
            data.append('idLectura_medidors', this.fillobject.idLectura_medidors);
            data.append('lecturaLectura_medidors', this.fillobject.lecturaLectura_medidors);
            data.append('observacionesLectura_medidors', this.fillobject.observacionesLectura_medidors);
            data.append('imagen', this.imagen);
            data.append('tipoImage', this.tipoImage);

            data.append('imagenMed', this.imagenMed);
            data.append('tipoImageMed', this.tipoImageMed);

            const config = { headers: { 'Content-Type': 'multipart/form-data' } };

            axios.post(url,data, config).then(response=>{

                $("#btnGuardar").removeAttr("disabled");
                $("#btnCancel").removeAttr("disabled");
                $("#btnClose").removeAttr("disabled");
                this.divloaderNuevo=false;

                if(response.data.result=='1'){
                    this.getDatos(this.thispage);
                    this.errors=[];
                    this.cerrarForm();
                    toastr.success(response.data.msj);
                }else{
                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
            }).catch(error=>{
                this.errors=error.response.data
            })
        },

      editar:function (dato) {
      

        this.fillobject.id = dato.id; 
        this.fillobject.serie = dato.serie; 
        this.fillobject.descripcion = dato.descripcion; 
        this.fillobject.alta = dato.alta;
        this.fillobject.baja = dato.baja;
        this.fillobject.activo = dato.activo;
        this.fillobject.lectura_ultima = (parseFloat(dato.lectura_ultima)).toFixed(2);
        this.fillobject.borrado = dato.borrado;
        this.fillobject.created_at = dato.created_at;
        this.fillobject.updated_at = dato.updated_at;
        this.fillobject.puesto_local_id = dato.puesto_local_id;
        this.fillobject.puesto = dato.puesto;
        this.fillobject.numeroPuesto = dato.numeroPuesto;
        this.fillobject.dirPuesto = dato.dirPuesto;
        this.fillobject.tipoPuesto = dato.tipoPuesto;
        this.fillobject.referenciaPuesto = dato.referenciaPuesto;
        this.fillobject.zona_id = dato.zona_id;
        this.fillobject.altaPuesto = dato.altaPuesto;
        this.fillobject.nombreZona = dato.nombreZona;
        this.fillobject.descripcionZona = dato.descripcionZona;
        this.fillobject.idLectura_medidors = dato.idLectura_medidors;
        this.fillobject.proceso_lectura_idLectura_medidors = dato.proceso_lectura_idLectura_medidors;
        this.fillobject.medidors_idLectura_medidors = dato.medidors_idLectura_medidors;
        this.fillobject.estadoLectura_medidors = dato.estadoLectura_medidors;
        this.fillobject.lectura_consistenteLectura_medidors = dato.lectura_consistenteLectura_medidors;
        this.fillobject.lecturaLectura_medidors = (parseFloat(dato.lecturaLectura_medidors)).toFixed(2);
        this.fillobject.lectura_ultimaLectura_medidors = (parseFloat(dato.lectura_ultimaLectura_medidors)).toFixed(2);
        this.fillobject.consumo_kwLectura_medidors = (parseFloat(dato.consumo_kwLectura_medidors)).toFixed(2);
        this.fillobject.consumo_solesLectura_medidors = (parseFloat(dato.consumo_solesLectura_medidors)).toFixed(2);
        this.fillobject.observacionesLectura_medidors = dato.observacionesLectura_medidors;
        this.fillobject.fecha_programacionLectura_medidors = dato.fecha_programacionLectura_medidors;
        this.fillobject.fecha_lecturaLectura_medidors = dato.fecha_lecturaLectura_medidors;
        this.fillobject.idUsers = dato.idUsers;
        this.fillobject.nameUsers = dato.nameUsers;
        this.fillobject.emailUsers = dato.emailUsers;
        this.fillobject.idTipo_users = dato.idTipo_users;
        this.fillobject.nombreTipo_users = dato.nombreTipo_users;
        this.fillobject.descripcionTipo_users = dato.descripcionTipo_users;
        this.fillobject.idPersonas = dato.idPersonas;
        this.fillobject.tipoPersonas = dato.tipoPersonas;
        this.fillobject.tipo_documentoPersonas = dato.tipo_documentoPersonas;
        this.fillobject.num_documentoPersonas = dato.num_documentoPersonas;
        this.fillobject.apellidosPersonas = dato.apellidosPersonas;
        this.fillobject.nombresPersonas = dato.nombresPersonas;
        this.fillobject.telefonoPersonas = dato.telefonoPersonas;
        this.fillobject.direccionPersonas = dato.direccionPersonas;
        this.fillobject.emailPersonas = dato.emailPersonas;
        this.fillobject.idTrabajadors = dato.idTrabajadors;
        this.fillobject.cargoTrabajadors = dato.cargoTrabajadors;
        this.fillobject.oficina_idTrabajadors = dato.oficina_idTrabajadors;
        this.fillobject.idImagens = dato.idImagens;
        this.fillobject.ruta_imgImagens = dato.ruta_imgImagens;
        this.fillobject.idImagensMed = dato.idImagensMed;
        this.fillobject.ruta_imgImagensMed = dato.ruta_imgImagensMed;

        this.oldImg=dato.ruta_imgImagens;
        this.oldImgMed=dato.ruta_imgImagensMed;


        this.divNuevo=false;
        this.divVerDatos=false;
        this.divEdit=true;
        this.divloaderEdit=false;
    },

    cambioLecturaE:function() {

        if(this.fillobject.lecturaLectura_medidors != null && this.fillobject.lecturaLectura_medidors != ''){
            this.fillobject.lecturaLectura_medidors = parseFloat(this.fillobject.lecturaLectura_medidors).toFixed(2);
            if(parseFloat(this.fillobject.lecturaLectura_medidors) > parseFloat(this.fillobject.lectura_ultimaLectura_medidors)){
                this.fillobject.consumo_kwLectura_medidors = (parseFloat(this.fillobject.lecturaLectura_medidors) - parseFloat(this.fillobject.lectura_ultimaLectura_medidors)).toFixed(2); 
                this.fillobject.consumo_solesLectura_medidors = (parseFloat(this.fillobject.consumo_kwLectura_medidors) * parseFloat(this.costoUnitarioKw)).toFixed(2);
            }
            else{
                this.fillobject.consumo_kwLectura_medidors = '';
                this.fillobject.consumo_solesLectura_medidors = '';
                toastr.error("El Resultado del Consumo no puede ser Negativo o 0");//mostramos mensaje
            }
            
        }
    },
    cerrarFormE: function(){

        this.cancelSubirImagenE();
        this.cancelTomarFotoE();

        this.cancelSubirImagenEMed();
        this.cancelTomarFotoEMed();

        this.divEdit=false;
        this.$nextTick(function () {
            this.fillobject= { 'id':'', 
                        'serie':'', 
                        'descripcion':'', 
                        'alta':'',
                        'baja':'',
                        'activo':'',
                        'lectura_ultima':'',
                        'borrado':'',
                        'created_at':'',
                        'updated_at':'',
                        'puesto_local_id':'',
                        'puesto':'',
                        'numeroPuesto':'',
                        'dirPuesto':'',
                        'tipoPuesto':'',
                        'referenciaPuesto':'',
                        'zona_id':'',
                        'altaPuesto':'',
                        'nombreZona':'',
                        'descripcionZona':'',
                        'idProceso_lecturas':'',
                        'idLectura_medidors':'',
                        'proceso_lectura_idLectura_medidors':'',
                        'medidors_idLectura_medidors':'',
                        'estadoLectura_medidors':'',
                        'lectura_consistenteLectura_medidors':'',
                        'lecturaLectura_medidors':'',
                        'lectura_ultimaLectura_medidors':'',
                        'consumo_kwLectura_medidors':'',
                        'consumo_solesLectura_medidors':'',
                        'observacionesLectura_medidors':'',
                        'fecha_programacionLectura_medidors':'',
                        'fecha_lecturaLectura_medidors':'',
                        'idUsers':'',
                        'nameUsers':'',
                        'emailUsers':'',
                        'idTipo_users':'',
                        'nombreTipo_users':'',
                        'descripcionTipo_users':'',
                        'idPersonas':'',
                        'tipoPersonas':'',
                        'tipo_documentoPersonas':'',
                        'num_documentoPersonas':'',
                        'apellidosPersonas':'',
                        'nombresPersonas':'',
                        'telefonoPersonas':'',
                        'direccionPersonas':'',
                        'emailPersonas':'',
                        'idTrabajadors':'',
                        'cargoTrabajadors':'',
                        'oficina_idTrabajadors':'',
                        'idImagens':'',
                        'ruta_imgImagens':'',
                        'idImagensMed':'',
                        'ruta_imgImagensMed':'',
                    };
        })
    },

    update: function (id) {

        var url="lectura_datosre/"+id;
        $("#btnSaveE").attr('disabled', true);
        $("#btnCloseE").attr('disabled', true);
        this.divloaderEdit=true;

        /* this.fillobject.oldImg= this.oldImg;
        var v1 = this.nivel; */

        var data = new  FormData();

        data.append('idLectura_medidors', this.fillobject.idLectura_medidors);
        data.append('lecturaLectura_medidors', this.fillobject.lecturaLectura_medidors);
        data.append('observacionesLectura_medidors', this.fillobject.observacionesLectura_medidors);
        data.append('imagen', this.imagenE);
        data.append('oldimg', this.oldImg);
        data.append('tipoImage', this.tipoImage);

        data.append('imagenMed', this.imagenEMed);
        data.append('oldimgMed', this.oldImgMed);
        data.append('tipoImageMed', this.tipoImageMed);

        data.append('_method', 'PUT');

        const config = { headers: { 'Content-Type': 'multipart/form-data' } };


        axios.post(url, data, config).then(response=>{


            $("#btnSaveE").removeAttr("disabled");
            $("#btnCloseE").removeAttr("disabled");
            this.divloaderEdit=false;
            
            if(response.data.result=='1'){   
                this.getDatos(this.thispage);
                this.cerrarFormE();
                toastr.success(response.data.msj);

            }else{
                $('#'+response.data.selector).focus();
                toastr.error(response.data.msj);
            }

        }).catch(error=>{
            this.errors=error.response.data
        })
    },

    verDatos:function (dato) {
        this.fillobject.id = dato.id; 
        this.fillobject.serie = dato.serie; 
        this.fillobject.descripcion = dato.descripcion; 
        this.fillobject.alta = dato.alta;
        this.fillobject.baja = dato.baja;
        this.fillobject.activo = dato.activo;
        this.fillobject.lectura_ultima = (parseFloat(dato.lectura_ultima)).toFixed(2);
        this.fillobject.borrado = dato.borrado;
        this.fillobject.created_at = dato.created_at;
        this.fillobject.updated_at = dato.updated_at;
        this.fillobject.puesto_local_id = dato.puesto_local_id;
        this.fillobject.puesto = dato.puesto;
        this.fillobject.numeroPuesto = dato.numeroPuesto;
        this.fillobject.dirPuesto = dato.dirPuesto;
        this.fillobject.tipoPuesto = dato.tipoPuesto;
        this.fillobject.referenciaPuesto = dato.referenciaPuesto;
        this.fillobject.zona_id = dato.zona_id;
        this.fillobject.altaPuesto = dato.altaPuesto;
        this.fillobject.nombreZona = dato.nombreZona;
        this.fillobject.descripcionZona = dato.descripcionZona;
        this.fillobject.idLectura_medidors = dato.idLectura_medidors;
        this.fillobject.proceso_lectura_idLectura_medidors = dato.proceso_lectura_idLectura_medidors;
        this.fillobject.medidors_idLectura_medidors = dato.medidors_idLectura_medidors;
        this.fillobject.estadoLectura_medidors = dato.estadoLectura_medidors;
        this.fillobject.lectura_consistenteLectura_medidors = dato.lectura_consistenteLectura_medidors;
        this.fillobject.lecturaLectura_medidors = (parseFloat(dato.lecturaLectura_medidors)).toFixed(2);
        this.fillobject.lectura_ultimaLectura_medidors = (parseFloat(dato.lectura_ultimaLectura_medidors)).toFixed(2);
        this.fillobject.consumo_kwLectura_medidors = (parseFloat(dato.consumo_kwLectura_medidors)).toFixed(2);
        this.fillobject.consumo_solesLectura_medidors = (parseFloat(dato.consumo_solesLectura_medidors)).toFixed(2);
        this.fillobject.observacionesLectura_medidors = dato.observacionesLectura_medidors;
        this.fillobject.fecha_programacionLectura_medidors = dato.fecha_programacionLectura_medidors;
        this.fillobject.fecha_lecturaLectura_medidors = dato.fecha_lecturaLectura_medidors;
        this.fillobject.idUsers = dato.idUsers;
        this.fillobject.nameUsers = dato.nameUsers;
        this.fillobject.emailUsers = dato.emailUsers;
        this.fillobject.idTipo_users = dato.idTipo_users;
        this.fillobject.nombreTipo_users = dato.nombreTipo_users;
        this.fillobject.descripcionTipo_users = dato.descripcionTipo_users;
        this.fillobject.idPersonas = dato.idPersonas;
        this.fillobject.tipoPersonas = dato.tipoPersonas;
        this.fillobject.tipo_documentoPersonas = dato.tipo_documentoPersonas;
        this.fillobject.num_documentoPersonas = dato.num_documentoPersonas;
        this.fillobject.apellidosPersonas = dato.apellidosPersonas;
        this.fillobject.nombresPersonas = dato.nombresPersonas;
        this.fillobject.telefonoPersonas = dato.telefonoPersonas;
        this.fillobject.direccionPersonas = dato.direccionPersonas;
        this.fillobject.emailPersonas = dato.emailPersonas;
        this.fillobject.idTrabajadors = dato.idTrabajadors;
        this.fillobject.cargoTrabajadors = dato.cargoTrabajadors;
        this.fillobject.oficina_idTrabajadors = dato.oficina_idTrabajadors;
        this.fillobject.idImagens = dato.idImagens;
        this.fillobject.ruta_imgImagens = dato.ruta_imgImagens;
        this.fillobject.idImagensMed = dato.idImagensMed;
        this.fillobject.ruta_imgImagensMed = dato.ruta_imgImagensMed;


        this.divNuevo=false;
        this.divEdit=false;
        this.divVerDatos=true;

    },

    cerrarFormV: function(){

        this.divVerDatos=false;
        this.$nextTick(function () {
            this.fillobject= { 'id':'', 
                    'serie':'', 
                    'descripcion':'', 
                    'alta':'',
                    'baja':'',
                    'activo':'',
                    'lectura_ultima':'',
                    'borrado':'',
                    'created_at':'',
                    'updated_at':'',
                    'puesto_local_id':'',
                    'puesto':'',
                    'numeroPuesto':'',
                    'dirPuesto':'',
                    'tipoPuesto':'',
                    'referenciaPuesto':'',
                    'zona_id':'',
                    'altaPuesto':'',
                    'nombreZona':'',
                    'descripcionZona':'',
                    'idProceso_lecturas':'',
                    'idLectura_medidors':'',
                    'proceso_lectura_idLectura_medidors':'',
                    'medidors_idLectura_medidors':'',
                    'estadoLectura_medidors':'',
                    'lectura_consistenteLectura_medidors':'',
                    'lecturaLectura_medidors':'',
                    'lectura_ultimaLectura_medidors':'',
                    'consumo_kwLectura_medidors':'',
                    'consumo_solesLectura_medidors':'',
                    'observacionesLectura_medidors':'',
                    'fecha_programacionLectura_medidors':'',
                    'fecha_lecturaLectura_medidors':'',
                    'idUsers':'',
                    'nameUsers':'',
                    'emailUsers':'',
                    'idTipo_users':'',
                    'nombreTipo_users':'',
                    'descripcionTipo_users':'',
                    'idPersonas':'',
                    'tipoPersonas':'',
                    'tipo_documentoPersonas':'',
                    'num_documentoPersonas':'',
                    'apellidosPersonas':'',
                    'nombresPersonas':'',
                    'telefonoPersonas':'',
                    'direccionPersonas':'',
                    'emailPersonas':'',
                    'idTrabajadors':'',
                    'cargoTrabajadors':'',
                    'oficina_idTrabajadors':'',
                    'idImagens':'',
                    'ruta_imgImagens':'',
                    'idImagensMed':'',
                    'ruta_imgImagensMed':'',
                };
        })
    },

    procesarProgramacion:function (dato) {
        swal.fire({
              title: '¿Estás seguro?',
              text: "¿Desea "+this.procesar+" la Programación al Operador Seleccionado?",
              type: 'info',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, '+ this.doProccess
          }).then((result) => {

            if (result.value) {
                var url = 'lectura_datosre/altabaja';
                $("#btnSaveProgramacion").attr('disabled', true);
                $("#btnCancelProgramacion").attr('disabled', true);
                this.divloaderProgramacion=true;

/*                 var data = new  FormData();
                data.append('id', this.fillobject.id);
                data.append('observacion', this.observacion);
                data.append('estadoProceso', this.estadoProceso); */
                const config = { headers: { 'Content-Type': 'multipart/form-data' } };
                
                axios.post(url, this.fillobject, config).then(response=>{

                    $("#btnSaveProgramacion").removeAttr("disabled");
                    $("#btnCancelProgramacion").removeAttr("disabled");
                    this.divloaderProgramacion=false;

                    if(response.data.result=='1'){
                        app.getDatos(app.thispage);//listamos
                        toastr.success(response.data.msj);//mostramos mensaje
                        $("#modalProgramacion").modal('hide');
                        //this.cerrarFormE();
                    }else{
                        // $('#'+response.data.selector).focus();
                        toastr.error(response.data.msj);
                    }
                }).catch(error=>{
                    this.errors=error.response.data
                });
            }

        }).catch(swal.noop);
      },

      borrar:function (dato) {
          swal.fire({
              title: '¿Estás seguro?',
              text: "¿Desea eliminar la Programación Seleccionada?",
              type: 'info',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, Eliminar'
          }).then((result) => {


            if (result.value) {
                var url = 'lectura_datosre/'+dato.idLectura_medidors;
                axios.delete(url).then(response=>{//eliminamos

                    if(response.data.result=='1'){
                        app.getDatos(app.thispage);//listamos
                        toastr.success(response.data.msj);//mostramos mensaje
                    }else{
                        // $('#'+response.data.selector).focus();
                        toastr.error(response.data.msj);
                    }
                });
            }

            }).catch(swal.noop);
        },

    //FUNCIONTES TO ADVANCE PROGRAMATION -- CREATE
    tieneSoporteUserMedia:function () {
        return !!(navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia);
    },
    _getUserMedia:function (...arguments){
        return (navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia).apply(navigator, arguments);
    },
    limpiarSelect:function () {
        if(this.verCbuCamera && this.btnBotonFoto){
            $listaDeDispositivos = document.querySelector("#listaDeDispositivos");
            this.listaDeDispositivo = null;
            for (let x = $listaDeDispositivos.options.length - 1; x >= 0; x--)
            $listaDeDispositivos.remove(x);
        }
    },
    obtenerDispositivos:function(){
        return navigator
                .mediaDevices
                .enumerateDevices();
    },
    llenarSelectConDispositivosDisponibles:function (dispositivos) {
        $listaDeDispositivos = document.querySelector("#listaDeDispositivos");
        this.limpiarSelect();
        this.obtenerDispositivos()
            .then(dispositivos => {
                const dispositivosDeVideo = [];
                dispositivos.forEach(dispositivo => {
                    const tipo = dispositivo.kind;
                    if (tipo === "videoinput") {
                        dispositivosDeVideo.push(dispositivo);
                    }
                });

                // Vemos si encontramos algún dispositivo, y en caso de que si, entonces llamamos a la función
                if (dispositivosDeVideo.length > 0) {
                    // Llenar el select
                    dispositivosDeVideo.forEach(dispositivo => {
                        const option = document.createElement('option');
                        option.value = dispositivo.deviceId;
                        option.text = dispositivo.label;
                        $listaDeDispositivos.appendChild(option);
                    });
                }
            });
    },
    capturarImagen:function(){
        this.verCbuCamera = true;
        this.fotoReady = true;
        if (!this.tieneSoporteUserMedia()) {
            this.verCbuCamera = false;
            this.fotoReady = false;
            Swal.fire({
                icon: 'error',
                title: 'Función no soportada',
                text: 'Lo siento. Tu navegador no soporta esta característica. Intenta actualizarlo.',
            })
        return;
        }
        //Aquí guardaremos el stream globalmente
        this.obtenerDispositivos()
        .then(dispositivos => {
            // Vamos a filtrarlos y guardar aquí los de vídeo
            const dispositivosDeVideo = [];

            // Recorrer y filtrar
            dispositivos.forEach(function(dispositivo) {
                const tipo = dispositivo.kind;
                if (tipo === "videoinput") {
                    dispositivosDeVideo.push(dispositivo);
                }
            });

            // Vemos si encontramos algún dispositivo, y en caso de que si, entonces llamamos a la función
            // y le pasamos el id de dispositivo
            if (dispositivosDeVideo.length > 0) {
                // Mostrar stream con el ID del primer dispositivo, luego el usuario puede cambiar
                this.mostrarStream(dispositivosDeVideo[0].deviceId);
            }
        });
    },
    mostrarStream:function(idDeDispositivo) {
        $listaDeDispositivos = document.querySelector("#listaDeDispositivos");
        $video = document.querySelector("#video");
        $boton = document.querySelector("#boton");
        $canvas = document.querySelector("#canvas");
        // Creamos el stream
        this._getUserMedia({
                video: {
                    // Justo aquí indicamos cuál dispositivo usar
                    deviceId: idDeDispositivo,
                }
            },
            (streamObtenido) => {
                // Aquí ya tenemos permisos, ahora sí llenamos el select,
                // pues si no, no nos daría el nombre de los dispositivos
                app.llenarSelectConDispositivosDisponibles();
                app.listaDeDispositivo = idDeDispositivo;

                // Simple asignación
                app.stream = streamObtenido;

                // Mandamos el stream de la cámara al elemento de vídeo
                $video.srcObject = app.stream;
                $video.play();

            }, (error) => {
                console.log("Permiso denegado o error: ", error);
                toastr.error("No se puede acceder a la cámara, o no diste permiso.");
            });
    },
    changeDispositivo:function () {
        if (app.stream) {
            app.stream.getTracks().forEach(function(track) {
                track.stop();
            });
        }
        // Mostrar el nuevo stream con el dispositivo seleccionado
        this.mostrarStream(this.listaDeDispositivo);
    },
    tomarFoto:function () {
        $video = document.querySelector("#video");
        $canvas = document.querySelector("#canvas");
        $video.pause();

        //Obtener contexto del canvas y dibujar sobre él
        let contexto = $canvas.getContext("2d");
        $canvas.width = $video.videoWidth;
        $canvas.height = $video.videoHeight;
        contexto.drawImage($video, 0, 0, $canvas.width, $canvas.height);

        let foto = $canvas.toDataURL(); //Esta es la foto, en base 64

        this.imagen = foto;
        this.tipoImage = 2;

        Tesseract.recognize(
            foto,
            'eng',
            { logger: m => console.log(m) }
        ).then(({ data: { text } }) => {
            console.log("text "+text)
            if(isNaN(text)){
                toastr.error("No se pudo reconocer automáticamente la lectura");//mostramos mensaje
            }
            else{
                app.fillobject.lecturaLectura_medidors = text;
                app.cambioLectura();
            }
        })

        return;
    },
    cancelTomarFoto:function () {
        this.limpiarSelect();
        this.btnBotonFoto = true;
        this.verCbuCamera = false;
        this.fotoReady = false;
    },

    //FUNCIONTES TO ADVANCE PROGRAMATION -- EDIT
    limpiarSelectE:function () {
        if(this.verCbuCameraE && this.btnBotonFotoE){
            $listaDeDispositivos = document.querySelector("#listaDeDispositivosE");
            this.listaDeDispositivoE = null;
            for (let x = $listaDeDispositivos.options.length - 1; x >= 0; x--)
            $listaDeDispositivos.remove(x);
        }
    },
    llenarSelectConDispositivosDisponiblesE:function (dispositivos) {
        $listaDeDispositivos = document.querySelector("#listaDeDispositivosE");
        this.limpiarSelectE();
        this.obtenerDispositivos()
            .then(dispositivos => {
                const dispositivosDeVideo = [];
                dispositivos.forEach(dispositivo => {
                    const tipo = dispositivo.kind;
                    if (tipo === "videoinput") {
                        dispositivosDeVideo.push(dispositivo);
                    }
                });

                // Vemos si encontramos algún dispositivo, y en caso de que si, entonces llamamos a la función
                if (dispositivosDeVideo.length > 0) {
                    // Llenar el select
                    dispositivosDeVideo.forEach(dispositivo => {
                        const option = document.createElement('option');
                        option.value = dispositivo.deviceId;
                        option.text = dispositivo.label;
                        $listaDeDispositivos.appendChild(option);
                    });
                }
            });
    },
    capturarImagenE:function(){
        this.verCbuCameraE = true;
        this.fotoReadyE = true;
        this.verImgE = false;
        if (!this.tieneSoporteUserMedia()) {
            this.verCbuCameraE = false;
            this.fotoReadyE = false;
            this.verImgE = true;
            Swal.fire({
                icon: 'error',
                title: 'Función no soportada',
                text: 'Lo siento. Tu navegador no soporta esta característica. Intenta actualizarlo.',
            })
        return;
        }
        //Aquí guardaremos el stream globalmente
        this.obtenerDispositivos()
        .then(dispositivos => {
            // Vamos a filtrarlos y guardar aquí los de vídeo
            const dispositivosDeVideo = [];

            // Recorrer y filtrar
            dispositivos.forEach(function(dispositivo) {
                const tipo = dispositivo.kind;
                if (tipo === "videoinput") {
                    dispositivosDeVideo.push(dispositivo);
                }
            });

            // Vemos si encontramos algún dispositivo, y en caso de que si, entonces llamamos a la función
            // y le pasamos el id de dispositivo
            if (dispositivosDeVideo.length > 0) {
                // Mostrar stream con el ID del primer dispositivo, luego el usuario puede cambiar
                this.mostrarStreamE(dispositivosDeVideo[0].deviceId);
            }
        });
    },
    mostrarStreamE:function(idDeDispositivo) {
        $listaDeDispositivos = document.querySelector("#listaDeDispositivosE");
        $video = document.querySelector("#videoE");
        $boton = document.querySelector("#botonE");
        $canvas = document.querySelector("#canvasE");
        // Creamos el stream
        this._getUserMedia({
                video: {
                    // Justo aquí indicamos cuál dispositivo usar
                    deviceId: idDeDispositivo,
                }
            },
            (streamObtenido) => {
                // Aquí ya tenemos permisos, ahora sí llenamos el select,
                // pues si no, no nos daría el nombre de los dispositivos
                app.llenarSelectConDispositivosDisponiblesE();
                app.listaDeDispositivoE = idDeDispositivo;

                // Simple asignación
                app.stream = streamObtenido;

                // Mandamos el stream de la cámara al elemento de vídeo
                $video.srcObject = app.stream;
                $video.play();

            }, (error) => {
                console.log("Permiso denegado o error: ", error);
                toastr.error("No se puede acceder a la cámara, o no diste permiso.");
            });
    },
    changeDispositivoE:function () {
        if (app.stream) {
            app.stream.getTracks().forEach(function(track) {
                track.stop();
            });
        }
        // Mostrar el nuevo stream con el dispositivo seleccionado
        this.mostrarStreamE(this.listaDeDispositivoE);
    },
    tomarFotoE:function () {
        $video = document.querySelector("#videoE");
        $canvas = document.querySelector("#canvasE");
        $video.pause();

        //Obtener contexto del canvas y dibujar sobre él
        let contexto = $canvas.getContext("2d");
        $canvas.width = $video.videoWidth;
        $canvas.height = $video.videoHeight;
        contexto.drawImage($video, 0, 0, $canvas.width, $canvas.height);

        let foto = $canvas.toDataURL(); //Esta es la foto, en base 64

        this.imagenE = foto;
        this.tipoImage = 2;

        Tesseract.recognize(
            foto,
            'eng',
            { logger: m => console.log(m) }
        ).then(({ data: { text } }) => {
            console.log("text "+text)
            if(isNaN(text)){
                toastr.error("No se pudo reconocer automáticamente la lectura");//mostramos mensaje
            }
            else{
                app.fillobject.lecturaLectura_medidors = text;
                app.cambioLecturaE();
            }
        })

        return;
    },
    cancelTomarFotoE:function () {
        this.limpiarSelectE();
        this.btnBotonFotoE = true;
        this.verCbuCameraE = false;
        this.fotoReadyE = false;
        this.verImgE = true;
        this.imagenE=null;
    },


    //Capturar Imagen Medidor

    subirImagenMed: function(){
            this.btnBotonFotoMed = false;
            this.uploadReadyMed = true;
        },

    subirImagenEMed: function(){
        this.btnBotonFotoEMed = false;
        this.uploadReadyEMed = true;
    },

    getImageMed(event){
        //Asignamos la imagen a  nuestra data
        if (!event.target.files.length)
        {
            this.imagenMed=null;
        }
        else{
            this.imagenMed = event.target.files[0];
            var image = document.getElementById('imgLeerDatosMed');
            console.log(image);
            image.src = URL.createObjectURL(event.target.files[0]);
            this.tipoImageMed = 1;
        }
    },
        getImageEMed(event){
            if (!event.target.files.length)
            {
                this.imagenEMed=null;
            }
            else{
                this.verImgEMed = false;
                this.imagenEMed = event.target.files[0];
                var image = document.getElementById('imgLeerDatosMed');
                console.log(image);
                image.src = URL.createObjectURL(event.target.files[0]);
                this.tipoImageMed = 1;

            }
        },

        cancelSubirImagenMed:function () {
            this.btnBotonFotoMed = true;
            this.imagenMed=null;
            this.uploadReadyMed = false;
        },

        cancelSubirImagenEMed:function () {
            this.btnBotonFotoEMed = true;
            this.imagenEMed=null;
            this.uploadReadyEMed = false;
            this.verImgEMed = true;
        },

    //FUNCIONTES TO ADVANCE PROGRAMATION -- CREATE
    tieneSoporteUserMediaMed:function () {
        return !!(navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia);
    },
    _getUserMediaMed:function (...arguments){
        return (navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia).apply(navigator, arguments);
    },
    limpiarSelectMed:function () {
        if(this.verCbuCameraMed && this.btnBotonFotoMed){
            $listaDeDispositivos = document.querySelector("#listaDeDispositivosMed");
            this.listaDeDispositivoMed = null;
            for (let x = $listaDeDispositivos.options.length - 1; x >= 0; x--)
            $listaDeDispositivos.remove(x);
        }
    },
    obtenerDispositivosMed:function(){
        return navigator
                .mediaDevices
                .enumerateDevices();
    },
    llenarSelectConDispositivosDisponiblesMed:function (dispositivos) {
        $listaDeDispositivos = document.querySelector("#listaDeDispositivosMed");
        this.limpiarSelectMed();
        this.obtenerDispositivosMed()
            .then(dispositivos => {
                const dispositivosDeVideo = [];
                dispositivos.forEach(dispositivo => {
                    const tipo = dispositivo.kind;
                    if (tipo === "videoinput") {
                        dispositivosDeVideo.push(dispositivo);
                    }
                });

                // Vemos si encontramos algún dispositivo, y en caso de que si, entonces llamamos a la función
                if (dispositivosDeVideo.length > 0) {
                    // Llenar el select
                    dispositivosDeVideo.forEach(dispositivo => {
                        const option = document.createElement('option');
                        option.value = dispositivo.deviceId;
                        option.text = dispositivo.label;
                        $listaDeDispositivos.appendChild(option);
                    });
                }
            });
    },
    capturarImagenMed:function(){
        this.verCbuCameraMed = true;
        this.fotoReadyMed = true;
        if (!this.tieneSoporteUserMediaMed()) {
            this.verCbuCameraMed = false;
            this.fotoReadyMed = false;
            Swal.fire({
                icon: 'error',
                title: 'Función no soportada',
                text: 'Lo siento. Tu navegador no soporta esta característica. Intenta actualizarlo.',
            })
        return;
        }
        //Aquí guardaremos el stream globalmente
        this.obtenerDispositivosMed()
        .then(dispositivos => {
            // Vamos a filtrarlos y guardar aquí los de vídeo
            const dispositivosDeVideo = [];

            // Recorrer y filtrar
            dispositivos.forEach(function(dispositivo) {
                const tipo = dispositivo.kind;
                if (tipo === "videoinput") {
                    dispositivosDeVideo.push(dispositivo);
                }
            });

            // Vemos si encontramos algún dispositivo, y en caso de que si, entonces llamamos a la función
            // y le pasamos el id de dispositivo
            if (dispositivosDeVideo.length > 0) {
                // Mostrar stream con el ID del primer dispositivo, luego el usuario puede cambiar
                this.mostrarStreamMed(dispositivosDeVideo[0].deviceId);
            }
        });
    },
    mostrarStreamMed:function(idDeDispositivo) {
        $listaDeDispositivos = document.querySelector("#listaDeDispositivosMed");
        $video = document.querySelector("#videoMed");
        $boton = document.querySelector("#botonMed");
        $canvas = document.querySelector("#canvasMed");
        // Creamos el stream
        this._getUserMediaMed({
                video: {
                    // Justo aquí indicamos cuál dispositivo usar
                    deviceId: idDeDispositivo,
                }
            },
            (streamObtenido) => {
                // Aquí ya tenemos permisos, ahora sí llenamos el select,
                // pues si no, no nos daría el nombre de los dispositivos
                app.llenarSelectConDispositivosDisponiblesMed();
                app.listaDeDispositivoMed = idDeDispositivo;

                // Simple asignación
                app.streamMed = streamObtenido;

                // Mandamos el stream de la cámara al elemento de vídeo
                $video.srcObject = app.streamMed;
                $video.play();

            }, (error) => {
                console.log("Permiso denegado o error: ", error);
                toastr.error("No se puede acceder a la cámara, o no diste permiso.");
            });
    },
    changeDispositivoMed:function () {
        if (app.streamMed) {
            app.streamMed.getTracks().forEach(function(track) {
                track.stop();
            });
        }
        // Mostrar el nuevo stream con el dispositivo seleccionado
        this.mostrarStreamMed(this.listaDeDispositivoMed);
    },
    tomarFotoMed:function () {
        $video = document.querySelector("#videoMed");
        $canvas = document.querySelector("#canvasMed");
        $video.pause();

        //Obtener contexto del canvas y dibujar sobre él
        let contexto = $canvas.getContext("2d");
        $canvas.width = $video.videoWidth;
        $canvas.height = $video.videoHeight;
        contexto.drawImage($video, 0, 0, $canvas.width, $canvas.height);

        let foto = $canvas.toDataURL(); //Esta es la foto, en base 64

        this.imagenMed = foto;
        this.tipoImageMed = 2;

        return;
    },
    cancelTomarFotoMed:function () {
        this.limpiarSelectMed();
        this.btnBotonFotoMed = true;
        this.verCbuCameraMed = false;
        this.fotoReadyMed = false;
    },

    //FUNCIONTES TO ADVANCE PROGRAMATION -- EDIT
    limpiarSelectEMed:function () {
        if(this.verCbuCameraEMed && this.btnBotonFotoEMed){
            $listaDeDispositivos = document.querySelector("#listaDeDispositivosEMed");
            this.listaDeDispositivoEMed = null;
            for (let x = $listaDeDispositivos.options.length - 1; x >= 0; x--)
            $listaDeDispositivos.remove(x);
        }
    },
    llenarSelectConDispositivosDisponiblesEMed:function (dispositivos) {
        $listaDeDispositivos = document.querySelector("#listaDeDispositivosEMed");
        this.limpiarSelectEMed();
        this.obtenerDispositivosMed()
            .then(dispositivos => {
                const dispositivosDeVideo = [];
                dispositivos.forEach(dispositivo => {
                    const tipo = dispositivo.kind;
                    if (tipo === "videoinput") {
                        dispositivosDeVideo.push(dispositivo);
                    }
                });

                // Vemos si encontramos algún dispositivo, y en caso de que si, entonces llamamos a la función
                if (dispositivosDeVideo.length > 0) {
                    // Llenar el select
                    dispositivosDeVideo.forEach(dispositivo => {
                        const option = document.createElement('option');
                        option.value = dispositivo.deviceId;
                        option.text = dispositivo.label;
                        $listaDeDispositivos.appendChild(option);
                    });
                }
            });
    },
    capturarImagenEMed:function(){
        this.verCbuCameraEMed = true;
        this.fotoReadyEMed = true;
        this.verImgEMed = false;
        if (!this.tieneSoporteUserMediaMed()) {
            this.verCbuCameraEMed = false;
            this.fotoReadyEMed = false;
            this.verImgEMed = true;
            Swal.fire({
                icon: 'error',
                title: 'Función no soportada',
                text: 'Lo siento. Tu navegador no soporta esta característica. Intenta actualizarlo.',
            })
        return;
        }
        //Aquí guardaremos el stream globalmente
        this.obtenerDispositivosMed()
        .then(dispositivos => {
            // Vamos a filtrarlos y guardar aquí los de vídeo
            const dispositivosDeVideo = [];

            // Recorrer y filtrar
            dispositivos.forEach(function(dispositivo) {
                const tipo = dispositivo.kind;
                if (tipo === "videoinput") {
                    dispositivosDeVideo.push(dispositivo);
                }
            });

            // Vemos si encontramos algún dispositivo, y en caso de que si, entonces llamamos a la función
            // y le pasamos el id de dispositivo
            if (dispositivosDeVideo.length > 0) {
                // Mostrar stream con el ID del primer dispositivo, luego el usuario puede cambiar
                this.mostrarStreamEMed(dispositivosDeVideo[0].deviceId);
            }
        });
    },
    mostrarStreamEMed:function(idDeDispositivo) {
        $listaDeDispositivos = document.querySelector("#listaDeDispositivosEMed");
        $video = document.querySelector("#videoEMed");
        $boton = document.querySelector("#botonEMed");
        $canvas = document.querySelector("#canvasEMed");
        // Creamos el stream
        this._getUserMediaMed({
                video: {
                    // Justo aquí indicamos cuál dispositivo usar
                    deviceId: idDeDispositivo,
                }
            },
            (streamObtenido) => {
                // Aquí ya tenemos permisos, ahora sí llenamos el select,
                // pues si no, no nos daría el nombre de los dispositivos
                app.llenarSelectConDispositivosDisponiblesEMed();
                app.listaDeDispositivoEMed = idDeDispositivo;

                // Simple asignación
                app.streamMed = streamObtenido;

                // Mandamos el stream de la cámara al elemento de vídeo
                $video.srcObject = app.streamMed;
                $video.play();

            }, (error) => {
                console.log("Permiso denegado o error: ", error);
                toastr.error("No se puede acceder a la cámara, o no diste permiso.");
            });
    },
    changeDispositivoEMed:function () {
        if (app.streamMed) {
            app.streamMed.getTracks().forEach(function(track) {
                track.stop();
            });
        }
        // Mostrar el nuevo stream con el dispositivo seleccionado
        this.mostrarStreamEMed(this.listaDeDispositivoEMed);
    },
    tomarFotoEMed:function () {
        $video = document.querySelector("#videoEMed");
        $canvas = document.querySelector("#canvasEMed");
        $video.pause();

        //Obtener contexto del canvas y dibujar sobre él
        let contexto = $canvas.getContext("2d");
        $canvas.width = $video.videoWidth;
        $canvas.height = $video.videoHeight;
        contexto.drawImage($video, 0, 0, $canvas.width, $canvas.height);

        let foto = $canvas.toDataURL(); //Esta es la foto, en base 64

        this.imagenEMed = foto;
        this.tipoImageMed = 2;
        return;
    },
    cancelTomarFotoEMed:function () {
        this.limpiarSelectEMed();
        this.btnBotonFotoEMed = true;
        this.verCbuCameraEMed = false;
        this.fotoReadyEMed = false;
        this.verImgEMed = true;
        this.imagenEMed =null;
    },

}
});
</script>