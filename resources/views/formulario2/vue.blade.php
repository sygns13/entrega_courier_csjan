<script type="text/javascript">
 let app = new Vue({
    el: '#app',
    data:{
        titulo:"Entrega Courier",
        subtitulo: "Formulario Final Form 02",
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
        classTitle:'fa fa-pencil-square-o',
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

        fillobject:{ 
            'codigo_registro': '',
            'cantidad_sobres': '',
            'origen_sobre': '',
            'numero_documento': '',
            'expediente': '',
            'telefono_origen': '',
            'fecha_ingreso': '',
            'provincia': '',
            'dependencia': '',
            'direccion': '',
            'tipo_envio': '',
            'detalle_envio': '',
            'fecha_entrega': '',
            'orden_servicio': '',
            'observacion': '',
            'user_id_registro1': '',
            'ip_registro1': '',
            'fecha_registro1': '',
            'hora_registro1': '',
            'user_id_registro2': '',
            'ip_registro2': '',
            'fecha_registro2': '',
            'hora_registro2': '',

            'tipoUpdate': 2,
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


        divloaderNuevo:false,
        divloaderEdit:false,

        mostrarPalenIni:true,

        thispage:'1',
        divprincipal:false,

        codigo_registro: '',


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
            var url = 'formulariore?page='+page+'&busca='+busca;

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
        buscarCUR:function () {
            var url='formulariore2/buscar?codigo_registro='+this.codigo_registro;

            axios.get(url).then(response=>{

                if(String(response.data.result)=='1'){
                    this.edit(response.data.registro);
                    //toastr.success(response.data.msj);
                }else{
                    Swal.fire({
                        type: 'error',
                        title: 'Error',
                        text: response.data.msj,
                    })
                }
            }).catch(error=>{
                //this.errors=error.response.data
            })
        },
        edit:function (dato) {

            this.codigo_registro = dato.codigo_registro;

            this.fillobject.id=dato.id;
            this.fillobject.codigo_registro=dato.codigo_registro;
            this.fillobject.cantidad_sobres=dato.cantidad_sobres;
            this.fillobject.origen_sobre=dato.origen_sobre;
            this.fillobject.numero_documento=dato.numero_documento;
            this.fillobject.expediente=dato.expediente;
            this.fillobject.telefono_origen=dato.telefono_origen;
            this.fillobject.fecha_ingreso=dato.fecha_ingreso;
            this.fillobject.provincia=dato.provincia;
            this.fillobject.dependencia=dato.dependencia;
            this.fillobject.direccion=dato.direccion;
            this.fillobject.tipo_envio=dato.tipo_envio;
            this.fillobject.detalle_envio=dato.detalle_envio;
            this.fillobject.fecha_entrega=dato.fecha_entrega;
            this.fillobject.orden_servicio=dato.orden_servicio;
            this.fillobject.observacion=dato.observacion;

            this.divNuevo=false;
            this.divEdit=true;
            this.divloaderEdit=false;

            if(dato.user_id_registro2 != null){
                this.tipoUpdate = 3;
            }

            this.$nextTick(() => {
                $('#txtdetalle_envioE').focus();
            });

        },
        cerrarFormE: function(){

            this.divEdit=false;

            this.$nextTick(function () {
                this.fillobject={ 'codigo_registro': '',
                                    'cantidad_sobres': '',
                                    'origen_sobre': '',
                                    'numero_documento': '',
                                    'expediente': '',
                                    'telefono_origen': '',
                                    'fecha_ingreso': '',
                                    'provincia': '',
                                    'dependencia': '',
                                    'direccion': '',
                                    'tipo_envio': '',
                                    'detalle_envio': '',
                                    'fecha_entrega': '',
                                    'orden_servicio': '',
                                    'observacion': '',
                                    'user_id_registro1': '',
                                    'ip_registro1': '',
                                    'fecha_registro1': '',
                                    'hora_registro1': '',
                                    'user_id_registro2': '',
                                    'ip_registro2': '',
                                    'fecha_registro2': '',
                                    'hora_registro2': '',

                                    'tipoUpdate': 2,};
    
            })

        },

        update: function (id) {

            var url="formulariore/"+id;
            $("#btnSaveE").attr('disabled', true);
            $("#btnCloseE").attr('disabled', true);
            this.divloaderEdit=true;

            this.fillobject.oldImg= this.oldImg;
            var v1 = this.nivel;

            var data = new  FormData();

            data.append('cantidad_sobres', this.fillobject.cantidad_sobres);
            data.append('origen_sobre', this.fillobject.origen_sobre);
            data.append('numero_documento', this.fillobject.numero_documento);
            data.append('expediente', this.fillobject.expediente);
            data.append('telefono_origen', this.fillobject.telefono_origen);
            data.append('fecha_ingreso', this.fillobject.fecha_ingreso);
            data.append('provincia', this.fillobject.provincia);
            data.append('dependencia', this.fillobject.dependencia);
            data.append('direccion', this.fillobject.direccion);
            data.append('ip_registro1', this.fillobject.ip_registro1);

            data.append('tipo_envio', this.fillobject.tipo_envio);
            data.append('detalle_envio', this.fillobject.detalle_envio);
            data.append('fecha_entrega', this.fillobject.fecha_entrega);
            data.append('orden_servicio', this.fillobject.orden_servicio);
            data.append('observacion', this.fillobject.observacion);
            data.append('ip_registro2', this.fillobject.ip_registro2);

            data.append('tipoUpdate', this.fillobject.tipoUpdate);

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
}
});
</script>