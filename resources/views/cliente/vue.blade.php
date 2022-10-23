<script type="text/javascript">
 let app = new Vue({
    el: '#app',
    data:{
        titulo:"Puesto: {{ $puesto->nombre }} - N° {{ $puesto->numero }}",
        subtitulo: "Gestión de Clientes",
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
        classTitle:'fa fa-users',
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
                    'vinculo':'', 
                    'persona_id':'', 
                    'puesto_local_id':'{{ $puesto->id }}', 
                    'inicio':'',
                    'final':'',
                    'activo':'',
                    'tipoPersona':'',
                    'tipo_documentoPersona':'',
                    'num_documentoPersona':'',
                    'apellidosPersona':'',
                    'nombresPersona':'',
                    'telefonoPersona':'',
                    'direccionPersona':'',
                    'emailPersona':'',
                    'idUsers':'',
                    'name':'',
                    'email':'',
                    'modifpassword': 0 , 
                    'password':'', 
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

        vinculo : '',
        persona_id : '0',
        puesto_local_id : '{{ $puesto->id }}',
        inicio : '',
        final : '',
        activo : '1',
        tipoPersona : '',
        tipo_documentoPersona : 'DNI',
        num_documentoPersona : '',
        apellidosPersona : '',
        nombresPersona : '',
        telefonoPersona : '',
        direccionPersona : '',
        emailPersona : '',

        divloaderNuevo:false,
        divloaderEdit:false,

        mostrarPalenIni:true,

        thispage:'1',
        divprincipal:false,

        fechabaja:'',
        fechaalta:'',
        divloaderBaja:false,
        divloaderAlta:false,

        tipoDocIdentidad: 'DNI',
        nombreCliente: 'Nombres',

        tipoDocIdentidadE: 'DNI',
        nombreClienteE: 'Nombres',

        validated:'0',

        name : '',
        password : '',

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
            var url = '../clientere?v1='+this.puesto_local_id+'&page='+page+'&busca='+busca;

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

            this.vinculo = '';
            this.persona_id = '0';
            this.puesto_local_id = '{{ $puesto->id }}';
            this.inicio = '';
            this.final = '';
            this.activo = '1';
            this.tipoPersona = '1';
            this.num_documentoPersona = '';
            this.apellidosPersona = '';
            this.nombresPersona = '';
            this.telefonoPersona = '';
            this.direccionPersona = '';
            this.emailPersona = '';
            this.tipo_documentoPersona = 'DNI';

            this.tipoDocIdentidad = 'DNI';
            this.nombreCliente = 'Nombres';

            this.name = '';
            this.password = '';

            this.$nextTick(() => {
                $('#cbutipoPersona').focus();
            })

            this.divEdit=false;
        },
        pressNuevoDNI: function() {

            if (this.tipoPersona == '1') {
                this.tipoDocIdentidad = 'DNI';
                this.tipo_documentoPersona = 'DNI';
                this.nombreCliente = 'Nombres';
            } else {
                this.tipoDocIdentidad = 'RUC';
                this.tipo_documentoPersona = 'RUC';
                this.nombreCliente = 'Razón Social';
            }

            var url='/persona/buscarDNI';

            axios.post(url,{tipoPersona:this.tipoPersona,tipo_documentoPersona:this.tipo_documentoPersona,num_documentoPersona:this.num_documentoPersona}).then(response=>{

                if(String(response.data.result)=='1'){

                    /* this.persona_id = '0';
                    this.apellidosPersona = '';
                    this.nombresPersona = '';
                    this.telefonoPersona = '';
                    this.direccionPersona = '';
                    this.emailPersona = ''; */

                    this.$nextTick(function () {
                        $("#txtnombresPersona").focus();
                    });

                    //toastr.success(response.data.msj);
                }else if (String(response.data.result)=='2') {

                    console.log(response);

                    this.persona_id = response.data.idPer;
                    this.apellidosPersona = response.data.persona.apellidos;
                    this.nombresPersona = response.data.persona.nombres;
                    this.telefonoPersona = response.data.persona.telefono;
                    this.direccionPersona = response.data.persona.direccion;
                    this.emailPersona = response.data.persona.email;

                    this.formularioCrear=true;

                    this.$nextTick(function () {
                        $("#txtnombresPersona").focus();
                    });
                }else{
                        /* this.persona_id = '0';
                        this.apellidosPersona = '';
                        this.nombresPersona = '';
                        this.telefonoPersona = '';
                        this.direccionPersona = '';
                        this.emailPersona = ''; */

                        this.$nextTick(function () {
                            $("#txtnombresPersona").focus();
                        });

                    /* $('#'+response.data.selector).focus();
                    $('#'+response.data.selector).css( "border", "1px solid red" );
                    toastr.error(response.data.msj); */
                }
            }).catch(error=>{
                //this.errors=error.response.data
            })
        },
        create:function () {
            var url='../clientere';

            $("#btnGuardar").attr('disabled', true);
            $("#btnCancel").attr('disabled', true);
            $("#btnClose").attr('disabled', true);

            this.divloaderNuevo=true;

            var data = new  FormData();

            data.append('vinculo', this.vinculo);
            data.append('persona_id', this.persona_id);
            data.append('puesto_local_id', this.puesto_local_id);
            data.append('inicio', this.inicio);
            data.append('final', this.final);
            data.append('tipoPersona', this.tipoPersona);
            data.append('num_documentoPersona', this.num_documentoPersona);
            data.append('apellidosPersona', this.apellidosPersona);
            data.append('nombresPersona', this.nombresPersona);
            data.append('telefonoPersona', this.telefonoPersona);
            data.append('direccionPersona', this.direccionPersona);
            data.append('emailPersona', this.emailPersona);
            data.append('tipo_documentoPersona', this.tipo_documentoPersona);
            data.append('activo', this.activo);

            data.append('name', this.name);
            data.append('password', this.password);


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
                var url = '../clientere/'+dato.id;
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
            this.fillobject.vinculo = dato.vinculo;
            this.fillobject.persona_id = dato.persona_id;
            this.fillobject.puesto_local_id = dato.puesto_local_id;
            this.fillobject.inicio = dato.inicio;
            this.fillobject.final = dato.final;
            this.fillobject.activo = dato.activo;
            this.fillobject.tipoPersona = dato.tipoPersona;
            this.fillobject.tipo_documentoPersona = dato.tipo_documentoPersona;
            this.fillobject.num_documentoPersona = dato.num_documentoPersona;
            this.fillobject.apellidosPersona = dato.apellidosPersona;
            this.fillobject.nombresPersona = dato.nombresPersona;
            this.fillobject.telefonoPersona = dato.telefonoPersona;
            this.fillobject.direccionPersona = dato.direccionPersona;
            this.fillobject.emailPersona = dato.emailPersona;

            this.fillobject.idUsers=dato.idUsers;
            this.fillobject.name=dato.name;
            this.fillobject.email=dato.emailPersona;
            this.fillobject.password='';
            this.fillobject.modifpassword= 0;

            if(this.fillobject.idUsers == '0'){
                this.fillobject.modifpassword= 1;
            }

            this.divNuevo=false;
            this.divEdit=true;
            this.divloaderEdit=false;

            this.$nextTick(() => {
                $('#cbutipoPersonaE').focus();
            });

        },
        cerrarFormE: function(){

            this.divEdit=false;

            this.$nextTick(function () {
                this.fillobject= { 
                    'id':'',
                    'vinculo':'', 
                    'persona_id':'', 
                    'puesto_local_id':'{{ $puesto->id }}', 
                    'inicio':'',
                    'final':'',
                    'activo':'',
                    'tipoPersona':'',
                    'tipo_documentoPersona':'',
                    'num_documentoPersona':'',
                    'apellidosPersona':'',
                    'nombresPersona':'',
                    'telefonoPersona':'',
                    'direccionPersona':'',
                    'emailPersona':'',
                    'idUsers':'',
                    'name':'',
                    'email':'',
                    'modifpassword': 0 , 
                    'password':'', 
                };
    
            })

        },

        pressNuevoDNIE: function() {

            if (this.fillobject.tipoPersona == '1') {
                this.tipoDocIdentidadE = 'DNI';
                this.fillobject.tipo_documentoPersona = 'DNI';
                this.nombreClienteE = 'Nombres';
            } else {
                this.tipoDocIdentidadE = 'RUC';
                this.fillobject.tipo_documentoPersona = 'RUC';
                this.nombreClienteE = 'Razón Social';
            }

            var url='/persona/buscarDNI';

            axios.post(url,{tipoPersona:this.fillobject.tipoPersona, tipo_documentoPersona:this.fillobject.tipo_documentoPersona,num_documentoPersona:this.fillobject.num_documentoPersona}).then(response=>{

                if(String(response.data.result)=='1'){

                    /* this.fillobject.persona_id = '0';
                    this.fillobject.apellidosPersona = '';
                    this.fillobject.nombresPersona = '';
                    this.fillobject.telefonoPersona = '';
                    this.fillobject.direccionPersona = '';
                    this.fillobject.emailPersona = ''; */

                    this.$nextTick(function () {
                        $("#txtnombresPersonaE").focus();
                    });

                    //toastr.success(response.data.msj);
                }else if (String(response.data.result)=='2') {

                    this.fillobject.persona_id = response.data.idPer;
                    this.fillobject.apellidosPersona = response.data.persona.apellidos;
                    this.fillobject.nombresPersona = response.data.persona.nombres;
                    this.fillobject.telefonoPersona = response.data.persona.telefono;
                    this.fillobject.direccionPersona = response.data.persona.direccion;
                    this.fillobject.emailPersona = response.data.persona.email;

                    this.fillobject.formularioCrear=true;

                    this.$nextTick(function () {
                        $("#txtnombresPersonaE").focus();
                    });
                }else{
                        /* this.fillobject.persona_id = '0';
                        this.fillobject.apellidosPersona = '';
                        this.fillobject.nombresPersona = '';
                        this.fillobject.telefonoPersona = '';
                        this.fillobject.direccionPersona = '';
                        this.fillobject.emailPersona = ''; */

                        this.$nextTick(function () {
                            $("#txtnombresPersonaE").focus();
                        });

                    /* $('#'+response.data.selector).focus();
                    $('#'+response.data.selector).css( "border", "1px solid red" );
                    toastr.error(response.data.msj); */
                }
            }).catch(error=>{
                //this.errors=error.response.data
            })
        },

        update: function (id) {

            var url="../clientere/"+id;
            $("#btnSaveE").attr('disabled', true);
            $("#btnCloseE").attr('disabled', true);
            this.divloaderEdit=true;

            this.fillobject.oldImg= this.oldImg;
            var v1 = this.nivel;

            var data = new  FormData();

            data.append('vinculo', this.fillobject.vinculo);
            data.append('persona_id', this.fillobject.persona_id);
            data.append('inicio', this.fillobject.inicio);
            data.append('final', this.fillobject.final);
            data.append('tipoPersona', this.fillobject.tipoPersona);
            data.append('tipo_documentoPersona', this.fillobject.tipo_documentoPersona);
            data.append('num_documentoPersona', this.fillobject.num_documentoPersona);
            data.append('apellidosPersona', this.fillobject.apellidosPersona);
            data.append('nombresPersona', this.fillobject.nombresPersona);
            data.append('telefonoPersona', this.fillobject.telefonoPersona);
            data.append('direccionPersona', this.fillobject.direccionPersona);
            data.append('emailPersona', this.fillobject.emailPersona);
            data.append('activo', this.fillobject.activo);
            data.append('idUsers', this.fillobject.idUsers);
            data.append('name', this.fillobject.name);
            data.append('password', this.fillobject.password);
            data.append('modifpassword', this.fillobject.modifpassword);

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
        modifclave: function(){

            if(this.fillobject.modifpassword == 1){
                setTimeout(function(){ $("#txtpasswordE").focus(); }, 100);
            }
            if(this.fillobject.modifpassword == 0){
                this.fillobject.password='';
            }

        },
        bajafn:function (dato) {
            swal.fire({
              title: '¿Estás seguro?',
              text: "Nota: Si se da de baja el Cliente, No podrá ser empleado para los reportes",
              type: 'info',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, dar de baja'
          }).then((result) => {

            if (result.value) {
                var url = '../clientere/altabaja';
                $("#btnSaveBaja").attr('disabled', true);
                $("#btnCancelBaja").attr('disabled', true);
                this.divloaderBaja=true;

                var data = new  FormData();
                data.append('id', dato.id);
                data.append('idUsers', dato.idUsers);
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
            /* this.fillobject.id=dato.id;
            this.fillobject.serie = dato.serie;
            this.fillobject.descripcion = dato.descripcion;
            this.fillobject.alta = dato.alta;
            this.fillobject.baja = dato.baja;
            this.fillobject.activo = dato.activo;

            $("#boxTituloBaja").text('Medidor de Serie: '+this.fillobject.nombre);
            $("#modalBaja").modal('show');
            this.$nextTick(() => {
                $('#txtbajafn').focus();
            }); */
      },
      confirmaBaja:function (dato) {
        swal.fire({
              title: '¿Estás seguro?',
              text: "Nota: Si se da de baja el Cliente, No podrá ser empleado para los reportes",
              type: 'info',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, dar de baja'
          }).then((result) => {

            if (result.value) {
                var url = '../clientere/altabaja';
                $("#btnSaveBaja").attr('disabled', true);
                $("#btnCancelBaja").attr('disabled', true);
                this.divloaderBaja=true;

                var data = new  FormData();
                data.append('id', this.fillobject.id);
                data.append('activo', '0');
                data.append('fecha_baja', this.fechabaja);
                data.append('idUsers', dato.idUsers);
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
              text: "Nota: Si da de alta el Cliente, podrá ser empleado en los Reportes",
              type: 'info',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, dar de alta'
          }).then((result) => {

            if (result.value) {
                var url = '../clientere/altabaja';
                $("#btnSaveBaja").attr('disabled', true);
                $("#btnCancelBaja").attr('disabled', true);
                this.divloaderBaja=true;

                var data = new  FormData();
                data.append('id', dato.id);
                data.append('activo', '1');
                data.append('fecha_baja', this.fechabaja);
                data.append('idUsers', dato.idUsers);
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