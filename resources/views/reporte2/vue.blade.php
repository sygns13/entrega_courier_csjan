<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Reportes",
       subtitulo: "Reporte de Registros de Entrega Courier",
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
   classTitle:'fa fa-file-pdf-o',
   classMenu0:'',
   classMenu1:'',
   classMenu2:'',
   classMenu3:'',
   classMenu4:'',
   classMenu5:'',
   classMenu6:'',
   classMenu7:'active',
   classMenu8:'',
   classMenu9:'',
   classMenu10:'',
   classMenu11:'',
   classMenu12:'',


   divprincipal:false,

   registros: [],
   errors:[],

   pagination: {
   'total': 0,
           'current_page': 0,
           'per_page': 0,
           'last_page': 0,
           'from': 0,
           'to': 0
           },
    

   offset: 9,
   divloaderNuevo:false,

   thispage:'1',

   fecha_ingresoIni:'',
   fecha_ingresoFin:'',
   codigo_registro:'',
   origen_sobre:'',
   expediente:'',
   telefono_origen:'',
   tipo_envio:'',
   detalle_envio:'',
   orden_servicio:'',
   fecha_entregaIni:'',
   fecha_entregaFin:'',
   username1:'',
   username2:'',
   dependencia_id:0,


   mostrartabla:false,

   registrosimp:[],

   dependencia: null,

},
created:function () {
   //this.getInfoInicial();
   //this.getRecibos(this.thispage);
},
mounted: function () {
   this.divloader0=false;
   this.divprincipal=true;
   $("#divtitulo").show('slow');

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
   },
},

filters: {
    pasfechaVista:function(date){
        if(date!=null && date.length==10){
            date=date.slice(-2)+'/'+date.slice(-5,-3)+'/'+date.slice(0,4);            
        }else{
            return '';
        }

        return date;
    },
  fecha: function (value) {
    if (!value) return ''
    value = value.toString()
    return value.slice(8)+"/"+value.slice(5,7)+"/"+value.slice(0,4)
  },

  mescotejar:function (value) {
    if (!value) return ''
    value = parseInt(value.toString());
    switch (value) {
        case 1:
                return "ENERO";
            break;
        case 2:
                return "FEBRERO";
            break;
        case 3:
                return "MARZO";
            break;
        case 4:
                return "ABRIL";
            break;
        case 5:
                return "MAYO";
            break;
        case 6:
                return "JUNIO";
            break;
        case 7:
                return "JULIO";
            break;
        case 8:
                return "AGOSTO";
            break;
        case 8:
                return "AGOSTO";
            break;
        case 9:
                return "SETIEMBRE";
            break;
        case 10:
                return "OCTUBRE";
            break;
        case 11:
                return "NOVIEMBRE";
            break;
    
        case 12:
                return "DICIEMBRE";
            break;
    
        default:
                return "";
            break;
    }

    return value
  },
},

methods: {


    cambiarfiltro:function(){
        this.mostrartabla=false;
    },


    cancelFiltros:function(page){
        this.fecha_ingresoIni = '';
        this.fecha_ingresoFin = '';
        this.codigo_registro = '';
        this.origen_sobre = '';
        this.expediente = '';
        this.telefono_origen = '';
        this.tipo_envio = '';
        this.detalle_envio = '';
        this.orden_servicio = '';
        this.fecha_entregaIni = '';
        this.fecha_entregaFin = '';
        this.username1 = '';
        this.username2 = '';
        this.dependencia_id = 0;

        this.mostrartabla=false;
    },



    buscarDatos:function(){

    //  $("body").css({ 'height' : '2100px'});
    
    var url="reporte2/buscarDatos";


    this.divloaderNuevo=true;
    this.mostrartabla=false;


    axios.post(url,{fecha_ingresoIni:this.fecha_ingresoIni, fecha_ingresoFin:this.fecha_ingresoFin, codigo_registro:this.codigo_registro, origen_sobre:this.origen_sobre, expediente:this.expediente, telefono_origen:this.telefono_origen, tipo_envio:this.tipo_envio, detalle_envio:this.detalle_envio, orden_servicio:this.orden_servicio, fecha_entregaIni:this.fecha_entregaIni, fecha_entregaFin:this.fecha_entregaFin, username1:this.username1, username2:this.username2, dependencia_id:this.dependencia_id}).then(response=>{

        this.mostrartabla=true;
        this.registros= response.data.registros.data;
        this.pagination= response.data.pagination;
        this.dependencia= response.data.dependencia;

        this.divloaderNuevo=false;
        this.mostrartabla=true;
        
        alertify.success('Datos Cargados Exitosamente'); 

    }).catch(error=>{
        this.errors=error.response.data
    })
    },


imprimirReporte(){

    var url="reporte2/buscarDatosImp";

    this.divloaderNuevo=true;
    $("#btncrearReporte").attr('disabled', true);
    axios.post(url,{fecha_ingresoIni:this.fecha_ingresoIni, fecha_ingresoFin:this.fecha_ingresoFin, codigo_registro:this.codigo_registro, origen_sobre:this.origen_sobre, expediente:this.expediente, telefono_origen:this.telefono_origen, tipo_envio:this.tipo_envio, detalle_envio:this.detalle_envio, orden_servicio:this.orden_servicio, fecha_entregaIni:this.fecha_entregaIni, fecha_entregaFin:this.fecha_entregaFin, username1:this.username1, username2:this.username2, dependencia_id:this.dependencia_id}).then(response=>{

        this.divloaderNuevo=false;
        $("#btncrearReporte").removeAttr("disabled");
       this.registrosimp= response.data.registrosimp;
       this.dependencia= response.data.dependencia;

       this.$nextTick(function () {

        var options = { extraHead : '<style rel="stylesheet" type="text/css" media="print">@page { size: landscape; } body {-webkit-print-color-adjust: exact; } #divImp{width: 30cm!important; } .saltoDePagina{ display:block; page-break-before:always;} #btncrearArea{display: none!important;} #btnvolver1{display: none!important;} #btnvolver2{display: none!important;} #tablaNoPrint{display: none!important;} #tablaPrint{display: block!important;} #titulo1{padding-top: 0px!important;} .logorep{ top:0mm!important;} #tablerep2{width:9cm;} #titulo7{display: block!important;} #tablelast{width:50%!important;} .divResult{display: none!important;}</style>', strict:false  };

        $("#divImp").printArea(options);
        });


   }).catch(error=>{
       this.errors=error.response.data
   })

},

   changePage:function (page) {
       this.pagination.current_page=page;
       this.getRecibos(page);
       this.thispage=page;
   },
   buscarBtn: function () {
       this.getRecibos();
       this.thispage='1';
   },

}
});

</script>