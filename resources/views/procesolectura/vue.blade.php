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
        classTitle:'fa fa-cogs',
        classMenu0:'',
        classMenu1:'',
        classMenu2:'',
        classMenu3:'active',
        classMenu4:'',
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

        fillobject:{ 'id':'0', 
                    'estado':'', 
                    'anio':'', 
                    'mes':'',
                    'mesNombre':'',
                    'fecha_generado':'',
                    'fecha_anulado':'',
                    'fecha_aprobado':'',
                    'fecha_finalizado':'',
                    'user_genera_id':'',
                    'user_anula_id':'',
                    'user_aprueba':'',
                    'user_finaliza':'',
                    'observaciones_generacion':'',
                    'observaciones_anulacion':'',
                    'observaciones_aprobacion':'',
                    'observaciones_finalizacion':'',
                    'orden_trabajo':'',
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

        estado : '1', 
        anio : '{{$yearActual}}', 
        mes : '{{$mesActual}}',
        fecha_generado : '',
        fecha_anulado : '',
        fecha_aprobado : '',
        fecha_finalizado : '',
        user_genera_id : '',
        user_anula_id : '',
        user_aprueba : '',
        user_finaliza : '',
        observaciones_generacion : '',
        observaciones_anulacion : '',
        observaciones_aprobacion : '',
        observaciones_finalizacion : '',
        orden_trabajo : '',

        estadoE : '1', 
        anioE : '{{$yearActual}}', 
        mesE : '{{$mesActual}}',
        fecha_generadoE : '',
        fecha_anuladoE : '',
        fecha_aprobadoE : '',
        fecha_finalizadoE : '',
        user_genera_idE : '',
        user_anula_idE : '',
        user_apruebaE : '',
        user_finalizaE : '',
        observaciones_generacionE : '',
        observaciones_anulacionE : '',
        observaciones_aprobacionE : '',
        observaciones_finalizacionE : '',
        orden_trabajoE : '',

        contProcesoLectura : 0,


        divloaderNuevo:false,
        divloaderEdit:false,
        divloaderProceso:false,

        mostrarPalenIni:true,

        thispage:'1',
        divprincipal:false,


        proceso: '',
        procesamiento: '',
        observacion:'',
        procesar:'',
        estadoProceso: '0',

        doProccess:'',


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
            var url = 'proceso_lecturasre';

            axios.get(url).then(response=>{

                let result= response.data.result;
                this.contProcesoLectura= response.data.contProcesoLectura;

                if(result == 1){
                    this.fillobject.id = response.data.procesoLectura.id;
                    this.fillobject.estado = response.data.procesoLectura.estado;
                    this.fillobject.anio = response.data.procesoLectura.anio;
                    this.fillobject.mes = response.data.procesoLectura.mes;
                    this.fillobject.mesNombre = response.data.procesoLectura.mesNombre;
                    this.fillobject.fecha_generado = response.data.procesoLectura.fecha_generado;
                    this.fillobject.fecha_anulado = response.data.procesoLectura.fecha_anulado;
                    this.fillobject.fecha_aprobado = response.data.procesoLectura.fecha_aprobado;
                    this.fillobject.fecha_finalizado = response.data.procesoLectura.fecha_finalizado;
                    this.fillobject.user_genera_id = response.data.procesoLectura.user_genera_id;
                    this.fillobject.user_anula_id = response.data.procesoLectura.user_anula_id;
                    this.fillobject.user_aprueba = response.data.procesoLectura.user_aprueba;
                    this.fillobject.user_finaliza = response.data.procesoLectura.user_finaliza;
                    this.fillobject.observaciones_generacion = response.data.procesoLectura.observaciones_generacion;
                    this.fillobject.observaciones_anulacion = response.data.procesoLectura.observaciones_anulacion;
                    this.fillobject.observaciones_aprobacion = response.data.procesoLectura.observaciones_aprobacion;
                    this.fillobject.observaciones_finalizacion = response.data.procesoLectura.observaciones_finalizacion;
                    this.fillobject.orden_trabajo = response.data.procesoLectura.orden_trabajo;
                }
                else{
                    this.fillobject = { 'id':'0', 
                        'estado':'', 
                        'anio':'', 
                        'mes':'',
                        'mesNombre':'',
                        'fecha_generado':'',
                        'fecha_anulado':'',
                        'fecha_aprobado':'',
                        'fecha_finalizado':'',
                        'user_genera_id':'',
                        'user_anula_id':'',
                        'user_aprueba':'',
                        'user_finaliza':'',
                        'observaciones_generacion':'',
                        'observaciones_anulacion':'',
                        'observaciones_aprobacion':'',
                        'observaciones_finalizacion':'',
                        'orden_trabajo' :'',
                    };
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
        nuevo:function () {
            this.divNuevo=true;
            this.divloaderEdit=false;
            this.$nextTick(function () {
                this.cancelForm();
            })
        },
        cerrarForm: function () {
            this.divNuevo=false;
            this.cancelForm();
        },
        cancelForm: function () {
            
            this.estado = '1'; 
            this.anio = '{{$yearActual}}'; 
            this.mes = '{{$mesActual}}';
            this.fecha_generado = '';
            this.fecha_anulado = '';
            this.fecha_aprobado = '';
            this.fecha_finalizado = '';
            this.user_genera_id = '';
            this.user_anula_id = '';
            this.user_aprueba = '';
            this.user_finaliza = '';
            this.observaciones_generacion = '';
            this.observaciones_anulacion = '';
            this.observaciones_aprobacion = '';
            this.observaciones_finalizacion = '';
            this.orden_trabajo = '';


            this.$nextTick(() => {
                $('#cbuanio').focus();
            })

            this.divEdit=false;
        },
        create:function () {
            var url='proceso_lecturasre';

            $("#btnGuardar").attr('disabled', true);
            $("#btnCancel").attr('disabled', true);
            $("#btnClose").attr('disabled', true);

            this.divloaderNuevo=true;

            var data = new  FormData();

            data.append('estado', this.estado);
            data.append('anio', this.anio);
            data.append('mes', this.mes);
            data.append('fecha_generado', this.fecha_generado);
            data.append('fecha_anulado', this.fecha_anulado);
            data.append('fecha_aprobado', this.fecha_aprobado);
            data.append('fecha_finalizado', this.fecha_finalizado);
            data.append('user_genera_id', this.user_genera_id);
            data.append('user_anula_id', this.user_anula_id);
            data.append('user_aprueba', this.user_aprueba);
            data.append('user_finaliza', this.user_finaliza);
            data.append('observaciones_generacion', this.observaciones_generacion);
            data.append('observaciones_anulacion', this.observaciones_anulacion);
            data.append('observaciones_aprobacion', this.observaciones_aprobacion);
            data.append('observaciones_finalizacion', this.observaciones_finalizacion);
            data.append('orden_trabajo', this.orden_trabajo);


            const config = { headers: { 'Content-Type': 'multipart/form-data' } };

            axios.post(url,data,config).then(response=>{

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

            this.anioE = this.fillobject.anio;
            this.mesE = this.fillobject.mes;
            this.orden_trabajoE = this.fillobject.orden_trabajo;
            this.observaciones_generacionE = this.fillobject.observaciones_generacion;

            this.divNuevo=false;
            this.divEdit=true;
            this.divloaderEdit=false;

            this.$nextTick(() => {
                $('#cbuanioE').focus();
            });

        },
        cerrarFormE: function(){

            this.divEdit=false;

            this.$nextTick(function () {
                this.estadoE = '1'; 
                this.anioE = '{{$yearActual}}'; 
                this.mesE = '{{$mesActual}}';
                this.fecha_generadoE = '';
                this.fecha_anuladoE = '';
                this.fecha_aprobadoE = '';
                this.fecha_finalizadoE = '';
                this.user_genera_idE = '';
                this.user_anula_idE = '';
                this.user_apruebaE = '';
                this.user_finalizaE = '';
                this.observaciones_generacionE = '';
                this.observaciones_anulacionE = '';
                this.observaciones_aprobacionE = '';
                this.observaciones_finalizacionE = '';
                this.orden_trabajoE = '';
    
            })

        },

        update: function (id) {

            var url="proceso_lecturasre/"+id;
            $("#btnSaveE").attr('disabled', true);
            $("#btnCloseE").attr('disabled', true);
            this.divloaderEdit=true;

            this.fillobject.oldImg= this.oldImg;
            var v1 = this.nivel;

            var data = new  FormData();

            data.append('estado', this.estadoE);
            data.append('anio', this.anioE);
            data.append('mes', this.mesE);
            data.append('fecha_generado', this.fecha_generadoE);
            data.append('fecha_anulado', this.fecha_anuladoE);
            data.append('fecha_aprobado', this.fecha_aprobadoE);
            data.append('fecha_finalizado', this.fecha_finalizadoE);
            data.append('user_genera_id', this.user_genera_idE);
            data.append('user_anula_id', this.user_anula_idE);
            data.append('user_aprueba', this.user_apruebaE);
            data.append('user_finaliza', this.user_finalizaE);
            data.append('observaciones_generacion', this.observaciones_generacionE);
            data.append('observaciones_anulacion', this.observaciones_anulacionE);
            data.append('observaciones_aprobacion', this.observaciones_aprobacionE);
            data.append('observaciones_finalizacion', this.observaciones_finalizacionE);
            data.append('orden_trabajo', this.orden_trabajoE);

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

        anular:function (dato) {
            this.observacion = '';

            this.proceso='ANULAR';
            this.procesamiento='Anulación';
            this.procesar='Anular Proceso de Lectura';
            this.doProccess='Anular';

            this.estadoProceso = '0';

            $("#modalProceso").modal('show');
            this.$nextTick(() => {
                $('#txtobservacion').focus();
            });
      },

        aprobar:function (dato) {
            this.observacion = '';

            this.proceso='APROBAR';
            this.procesamiento='Aprobación';
            this.procesar='Aprobar Proceso de Lectura';
            this.doProccess='Aprobar';

            this.estadoProceso = '2';

            $("#modalProceso").modal('show');
            this.$nextTick(() => {
                $('#txtobservacion').focus();
            });
      },

        finalizar:function (dato) {
            this.observacion = '';

            this.proceso='FINALIZAR';
            this.procesamiento='Finalización';
            this.procesar='Finalizar Proceso de Lectura';
            this.doProccess='Finalizar';

            this.estadoProceso = '3';

            $("#modalProceso").modal('show');
            this.$nextTick(() => {
                $('#txtobservacion').focus();
            });
      },

      procesarProceso:function (dato) {
        swal.fire({
              title: '¿Estás seguro?',
              text: "¿Desea "+this.procesar+"?. Esta acción no se puede deshacer",
              type: 'info',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, '+ this.doProccess
          }).then((result) => {

            if (result.value) {
                var url = 'proceso_lecturasre/altabaja';
                $("#btnSaveProceso").attr('disabled', true);
                $("#btnCancelProceso").attr('disabled', true);
                this.divloaderBaja=true;

                var data = new  FormData();
                data.append('id', this.fillobject.id);
                data.append('observacion', this.observacion);
                data.append('estadoProceso', this.estadoProceso);
                const config = { headers: { 'Content-Type': 'multipart/form-data' } };
                
                axios.post(url, data, config).then(response=>{

                    $("#btnSaveProceso").removeAttr("disabled");
                    $("#btnCancelProceso").removeAttr("disabled");
                    this.divloaderBaja=false;

                    if(response.data.result=='1'){
                        app.getDatos(app.thispage);//listamos
                        toastr.success(response.data.msj);//mostramos mensaje
                        $("#modalProceso").modal('hide');
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


}
});
</script>