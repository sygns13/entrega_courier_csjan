<script type="text/javascript">
 let app = new Vue({
    el: '#app',
    data:{
        titulo:"Gestión de Puestos-Locales",
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
        classTitle:'fa fa-bank',
        classMenu0:'',
        classMenu1:'',
        classMenu2:'',
        classMenu3:'',
        classMenu4:'',
        classMenu5:'',
        classMenu6:'',
        classMenu7:'',
        classMenu8:'active',
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
                    'id':'',
                    'zona_id':'', 
                    'nombre':'', 
                    'numero':'', 
                    'direccion':'', 
                    'tipo':'', 
                    'referenia':'', 
                    'alta':'', 
                    'baja':'',
                    'activo':''
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

        zona_id : '0',
        nombre : '',
        numero : '',
        direccion : '',
        tipo : '0',
        referenia : '',
        alta : '',
        baja : '',
        activo : 1,


        divloaderNuevo:false,
        divloaderEdit:false,

        mostrarPalenIni:true,

        thispage:'1',
        divprincipal:false,

        fechabaja:'',
        fechaalta:'',
        divloaderBaja:false,
        divloaderAlta:false,


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
            var url = 'puestosre?page='+page+'&busca='+busca;

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

            this.zona_id = '0';
            this.nombre = '';
            this.numero = '';
            this.direccion = '';
            this.tipo = '0';
            this.referenia = '';
            this.alta = '';
            this.baja = '';
            this.activo = 1;

            this.$nextTick(() => {
                $('#cbuzonas').focus();
            })

            this.divEdit=false;
        },
        create:function () {
            var url='puestosre';

            $("#btnGuardar").attr('disabled', true);
            $("#btnCancel").attr('disabled', true);
            $("#btnClose").attr('disabled', true);

            this.divloaderNuevo=true;

            var data = new  FormData();

            data.append('zona_id', this.zona_id);
            data.append('nombre', this.nombre);
            data.append('numero', this.numero);
            data.append('direccion', this.direccion);
            data.append('tipo', this.tipo);
            data.append('referenia', this.referenia);
            data.append('alta', this.alta);
            data.append('activo', this.activo);


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
        borrar:function (dato) {
          swal.fire({
              title: '¿Estás seguro?',
              text: "¿Desea eliminar el Registro seleccionado? -- Nota: Este proceso no se podrá revertir",
              type: 'info',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, eliminar'
          }).then((result) => {


            if (result.value) {
                var url = 'puestosre/'+dato.id;
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
        edit:function (dato) {

            this.fillobject.id=dato.id;
            this.fillobject.zona_id = dato.zona_id;
            this.fillobject.nombre = dato.nombre;
            this.fillobject.numero = dato.numero;
            this.fillobject.direccion = dato.direccion;
            this.fillobject.tipo = dato.tipo;
            this.fillobject.referenia = dato.referenia;
            this.fillobject.alta = dato.alta;
            this.fillobject.baja = dato.baja;
            this.fillobject.activo = dato.activo;

            this.divNuevo=false;
            this.divEdit=true;
            this.divloaderEdit=false;

            this.$nextTick(() => {
                $('#txtnombreE').focus();
            });

        },
        cerrarFormE: function(){

            this.divEdit=false;

            this.$nextTick(function () {
                this.fillobject= { 
                    'id':'',
                    'zona_id':'', 
                    'nombre':'', 
                    'numero':'', 
                    'direccion':'', 
                    'tipo':'', 
                    'referenia':'', 
                    'alta':'', 
                    'baja':'',
                    'activo':''
                };
    
            })

        },

        update: function (id) {

            var url="puestosre/"+id;
            $("#btnSaveE").attr('disabled', true);
            $("#btnCloseE").attr('disabled', true);
            this.divloaderEdit=true;

            this.fillobject.oldImg= this.oldImg;
            var v1 = this.nivel;

            var data = new  FormData();

            data.append('zona_id', this.fillobject.zona_id);
            data.append('nombre', this.fillobject.nombre);
            data.append('numero', this.fillobject.numero);
            data.append('direccion', this.fillobject.direccion);
            data.append('tipo', this.fillobject.tipo);
            data.append('referenia', this.fillobject.referenia);
            data.append('alta', this.fillobject.alta);
            data.append('baja', this.fillobject.baja);
            data.append('activo', this.fillobject.activo);

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
        bajafn:function (dato) {
            this.fillobject.id=dato.id;
            this.fillobject.zona_id = dato.zona_id;
            this.fillobject.nombre = dato.nombre;
            this.fillobject.numero = dato.numero;
            this.fillobject.direccion = dato.direccion;
            this.fillobject.tipo = dato.tipo;
            this.fillobject.referenia = dato.referenia;
            this.fillobject.alta = dato.alta;
            this.fillobject.baja = dato.baja;
            this.fillobject.activo = dato.activo;

            $("#boxTituloBaja").text('Puesto/Local: '+this.fillobject.nombre);
            $("#boxNumeroBaja").text('Número: '+this.fillobject.numero);
            $("#modalBaja").modal('show');
            this.$nextTick(() => {
                $('#txtbajafn').focus();
            });
      },
      confirmaBaja:function (dato) {
        swal.fire({
              title: '¿Estás seguro?',
              text: "Nota: Si se da de baja el Puesto/Local, No podrá ser empleado para la toma de lecturas en adelante ",
              type: 'info',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, dar de baja'
          }).then((result) => {

            if (result.value) {
                var url = 'puestosre/altabaja';
                $("#btnSaveBaja").attr('disabled', true);
                $("#btnCancelBaja").attr('disabled', true);
                this.divloaderBaja=true;

                var data = new  FormData();
                data.append('id', this.fillobject.id);
                data.append('activo', '0');
                data.append('fecha_baja', this.fechabaja);
                const config = { headers: { 'Content-Type': 'multipart/form-data' } };
                
                axios.post(url, data, config).then(response=>{

                    $("#btnSaveBaja").removeAttr("disabled");
                    $("#btnCancelBaja").removeAttr("disabled");
                    this.divloaderBaja=false;

                    if(response.data.result=='1'){
                        app.getDatos(app.thispage);//listamos
                        toastr.success(response.data.msj);//mostramos mensaje
                        $("#modalBaja").modal('hide');
                        this.cerrarFormE();
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
      altafn:function (dato) {
          swal.fire({
              title: '¿Estás seguro?',
              text: "Nota: Si da de alta el Puesto/Local, podrá ser empleado en la toma de lecturas",
              type: 'info',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, dar de alta'
          }).then((result) => {

            if (result.value) {
                var url = 'puestosre/altabaja';
                $("#btnSaveBaja").attr('disabled', true);
                $("#btnCancelBaja").attr('disabled', true);
                this.divloaderBaja=true;

                var data = new  FormData();
                data.append('id', dato.id);
                data.append('activo', '1');
                data.append('fecha_baja', this.fechabaja);
                const config = { headers: { 'Content-Type': 'multipart/form-data' } };
                
                axios.post(url, data, config).then(response=>{

                    $("#btnSaveBaja").removeAttr("disabled");
                    $("#btnCancelBaja").removeAttr("disabled");
                    this.divloaderBaja=false;

                    if(response.data.result=='1'){
                        app.getDatos(app.thispage);//listamos
                        toastr.success(response.data.msj);//mostramos mensaje
                        this.cerrarFormE();
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