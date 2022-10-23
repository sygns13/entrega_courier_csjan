<script type="text/javascript">
 let app = new Vue({
    el: '#app',
    data:{
        titulo:"Puesto: {{ $puesto->nombre }} - N° {{ $puesto->numero }}",
        subtitulo: "Gestión de Medidores",
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
        classTitle:'fa fa-fax',
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
                    'serie':'', 
                    'descripcion':'', 
                    'alta':'', 
                    'baja':'',
                    'activo':'',
                    'lectura_ultima':'',
                    'puesto_local_id': '{{ $puesto->id }}'
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

        serie : '0',
        descripcion : '',
        alta : '',
        baja : '',
        activo : 1,
        lectura_ultima : 0,
        puesto_local_id : '{{ $puesto->id }}',


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
            var url = '../medidore?v1='+this.puesto_local_id+'&page='+page+'&busca='+busca;

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

            this.serie = '';
            this.descripcion = '';
            this.alta = '';
            this.baja = '';
            this.activo = 1;
            this.lectura_ultima = 0;

            this.$nextTick(() => {
                $('#txtserie').focus();
            })

            this.divEdit=false;
        },
        create:function () {
            var url='../medidore';

            $("#btnGuardar").attr('disabled', true);
            $("#btnCancel").attr('disabled', true);
            $("#btnClose").attr('disabled', true);

            this.divloaderNuevo=true;

            var data = new  FormData();

            data.append('serie', this.serie);
            data.append('descripcion', this.descripcion);
            data.append('alta', this.alta);
            data.append('activo', this.activo);
            data.append('lectura_ultima', this.lectura_ultima);
            data.append('puesto_local_id', this.puesto_local_id);


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
                var url = '../medidore/'+dato.id;
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
            this.fillobject.serie = dato.serie;
            this.fillobject.descripcion = dato.descripcion;
            this.fillobject.alta = dato.alta;
            this.fillobject.baja = dato.baja;
            this.fillobject.activo = dato.activo;
            this.fillobject.lectura_ultima = dato.lectura_ultima;

            this.divNuevo=false;
            this.divEdit=true;
            this.divloaderEdit=false;

            this.$nextTick(() => {
                $('#txtserieE').focus();
            });

        },
        cerrarFormE: function(){

            this.divEdit=false;

            this.$nextTick(function () {
                this.fillobject= { 
                    'id':'',
                    'serie':'', 
                    'descripcion':'', 
                    'alta':'', 
                    'baja':'',
                    'activo':'',
                    'lectura_ultima':'',
                    'puesto_local_id': '{{ $puesto->id }}'
                };
    
            })

        },

        update: function (id) {

            var url="../medidore/"+id;
            $("#btnSaveE").attr('disabled', true);
            $("#btnCloseE").attr('disabled', true);
            this.divloaderEdit=true;

            this.fillobject.oldImg= this.oldImg;
            var v1 = this.nivel;

            var data = new  FormData();

            data.append('serie', this.fillobject.serie);
            data.append('descripcion', this.fillobject.descripcion);
            data.append('alta', this.fillobject.alta);
            data.append('baja', this.fillobject.baja);
            data.append('activo', this.fillobject.activo);
            data.append('lectura_ultima', this.fillobject.lectura_ultima);

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
            this.fillobject.serie = dato.serie;
            this.fillobject.descripcion = dato.descripcion;
            this.fillobject.alta = dato.alta;
            this.fillobject.baja = dato.baja;
            this.fillobject.activo = dato.activo;
            this.fillobject.lectura_ultima = dato.lectura_ultima;

            $("#boxTituloBaja").text('Medidor de Serie: '+this.fillobject.serie);
            $("#modalBaja").modal('show');
            this.$nextTick(() => {
                $('#txtbajafn').focus();
            });
      },
      confirmaBaja:function (dato) {
        swal.fire({
              title: '¿Estás seguro?',
              text: "Nota: Si se da de baja el Medidor, No podrá ser empleado para la toma de lecturas",
              type: 'info',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, dar de baja'
          }).then((result) => {

            if (result.value) {
                var url = '../medidore/altabaja';
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
              text: "Nota: Si da de alta el Medidor, podrá ser empleado en la toma de lecturas",
              type: 'info',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, dar de alta'
          }).then((result) => {

            if (result.value) {
                var url = '../medidore/altabaja';
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