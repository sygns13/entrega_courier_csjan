<script type="text/javascript">
 let app = new Vue({
    el: '#app',
    data:{
        titulo:"Programación de Rutas",
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
        classTitle:'fa fa-map',
        classMenu0:'',
        classMenu1:'',
        classMenu2:'',
        classMenu3:'',
        classMenu4:'active',
        classMenu5:'',
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
                    'consumo_kwLectura_medidors':'',
                    'consumo_solesLectura_medidors':'',
                    'observacionesLectura_medidors':'',
                    'fecha_programacionLectura_medidors':'',
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

        descripcion : '',
        nombre : '',
        activo : 1,


        divloaderNuevo:false,
        divloaderEdit:false,
        divloaderProgramacion:false,

        mostrarPalenIni:true,

        thispage:'1',
        divprincipal:false,

        Programacion: 'REALIZAR',
        procesar: 'Grabar',
        doProccess: 'Registrar',


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
            var url = 'programar_rutasre?page='+page+'&busca='+busca;

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

        programar:function (dato) {

            this.Programacion='REALIZAR';
            this.procesar='Grabar';
            this.doProccess='Registrar';

            this.fillobject.id = dato.id; 
            this.fillobject.serie = dato.serie; 
            this.fillobject.descripcion = dato.descripcion; 
            this.fillobject.alta = dato.alta;
            this.fillobject.baja = dato.baja;
            this.fillobject.activo = dato.activo;
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
            this.fillobject.consumo_kwLectura_medidors = dato.consumo_kwLectura_medidors;
            this.fillobject.consumo_solesLectura_medidors = dato.consumo_solesLectura_medidors;
            this.fillobject.observacionesLectura_medidors = dato.observacionesLectura_medidors;
            this.fillobject.fecha_programacionLectura_medidors = dato.fecha_programacionLectura_medidors;
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

            this.estadoProceso = '0';

            $("#modalProgramacion").modal('show');
            this.$nextTick(() => {
                $('#cbuidUser').focus();
            });
      },

      editar:function (dato) {

        this.Programacion='MODIFICAR';
        this.procesar='Editar';
        this.doProccess='Modificar';
        

        this.fillobject.id = dato.id; 
        this.fillobject.serie = dato.serie; 
        this.fillobject.descripcion = dato.descripcion; 
        this.fillobject.alta = dato.alta;
        this.fillobject.baja = dato.baja;
        this.fillobject.activo = dato.activo;
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
        this.fillobject.lecturaLectura_medidors = dato.lecturaLectura_medidors;
        this.fillobject.consumo_kwLectura_medidors = dato.consumo_kwLectura_medidors;
        this.fillobject.consumo_solesLectura_medidors = dato.consumo_solesLectura_medidors;
        this.fillobject.observacionesLectura_medidors = dato.observacionesLectura_medidors;
        this.fillobject.fecha_programacionLectura_medidors = dato.fecha_programacionLectura_medidors;
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

        this.estadoProceso = '0';

        $("#modalProgramacion").modal('show');
        this.$nextTick(() => {
            $('#cbuidUser').focus();
        });
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
                var url = 'programar_rutasre/altabaja';
                $("#btnSaveProgramacion").attr('disabled', true);
                $("#btnCancelProgramacion").attr('disabled', true);
                this.divloaderProgramacion=true;

/*                 var data = new  FormData();
                data.append('id', this.fillobject.id);
                data.append('observacion', this.observacion);
                data.append('estadoProceso', this.estadoProceso); */
                const config = { headers: { 'Content-Type': 'multipart/form-data' } };
                
                axios.post(url, this.fillobject).then(response=>{

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
                var url = 'programar_rutasre/'+dato.idLectura_medidors;
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
}
});
</script>