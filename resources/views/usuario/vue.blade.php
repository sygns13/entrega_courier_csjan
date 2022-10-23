<script type="text/javascript">
 let app = new Vue({
    el: '#app',
    data:{
        titulo:"Gestión de Usuarios",
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
        classTitle:'fa fa-user',
        classMenu0:'',
        classMenu1:'',
        classMenu2:'active',
        classMenu3:'',
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



        usuarios: [],

        tipousers: [],
        persona:[],
        user:[],
        errors:[],

        filluser:{ 'id':'', 
                    'name':'', 
                    'email':'', 
                    'password':'', 
                    'activo':'',
                    'persona_id':'',
                    'tipo_user_id':'',
                    'idTrabajador':'',
                    'cargoTrabajador':'',
                    'oficina_idTrabajador':'',
                    'tipoPersona':'',
                    'tipo_documentoPersona':'',
                    'num_documentoPersona':'',
                    'apellidosPersona':'',
                    'nombresPersona':'',
                    'telefonoPersona':'',
                    'direccionPersona':'',
                    'modifpassword': 0 , 
                    'tipouser':'' ,
                    'permiso_form1': false,
                    'permiso_form2': false
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
        divNuevoUsuario:false,
        divEditUsuario:false,

        name : '',
        email : '',
        activo : 1,
        persona_id : 0,
        tipo_user_id : 0,
        password : '',

        cargoTrabajador : '',
        oficina_idTrabajador : '0',

        tipoPersona : '1',
        tipo_documentoPersona : 'DNI',
        num_documentoPersona : '',
        apellidosPersona : '',
        nombresPersona : '',
        telefonoPersona : '',
        direccionPersona : '',

        permiso_form1: false,
        permiso_form2: false,


        divloaderNuevo:false,
        divloaderEdit:false,
        divloaderEditUsuario:false,


        formularioCrear:false,
        mostrarPalenIni:false,

        validated:'0',
        imagen : null,


        thispage:'1',

        divprincipal:false,


    },
    created:function () {
        this.getUsuarios(this.thispage);

        
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


        getUsuarios: function (page) {
            var busca=this.buscar;
            var url = 'usuario?page='+page+'&busca='+busca;

            axios.get(url).then(response=>{

                this.usuarios= response.data.usuarios.data;
                this.pagination= response.data.pagination;

                this.mostrarPalenIni=true;

                if(this.usuarios.length==0 && this.thispage!='1'){
                    var a = parseInt(this.thispage) ;
                    a--;
                    this.thispage=a.toString();
                    this.changePage(this.thispage);
                }
            })
        },
        changePage:function (page) {
            this.pagination.current_page=page;
            this.getUsuarios(page);
            this.thispage=page;
        },
        buscarBtn: function () {
            this.getUsuarios();
            this.thispage='1';
        },
        nuevoUsuario:function () {
            this.divNuevoUsuario=true;
            this.divloaderEditUsuario=false;

            this.$nextTick(function () {
                this.cancelFormUsuario();
            })
            
        },
        cerrarFormUsuario: function () {
            this.divNuevoUsuario=false;
            this.cancelFormUsuario();
        },
        cancelFormUsuario: function () {
            this.validated='0';
            this.$nextTick(function () {
                this.formularioCrear=false;
                $(".form-control").css("border","1px solid #d2d6de");
                $('#txtdni').focus();
            })
            this.name = '';
            this.email = '';
            this.activo = 1;
            this.persona_id = 0;
            this.tipo_user_id = 0;
          
            this.password = '';

            this.tipoPersona = '1';
            this.tipo_documentoPersona = 'DNI';
            this.num_documentoPersona = '';
            this.apellidosPersona = '';
            this.nombresPersona = '';
            this.telefonoPersona = '';
            this.direccionPersona = '';
            this.permiso_form1 = false;
            this.permiso_form2 = false;

            this.cargoTrabajador = '';
            this.oficina_idTrabajador = '0';
            

            this.divEditUsuario=false;


        },

        pressNuevoDNI: function() {

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

                    this.persona_id = response.data.idPer;
                    this.apellidosPersona = response.data.persona.apellidos;
                    this.nombresPersona = response.data.persona.nombres;
                    this.telefonoPersona = response.data.persona.telefono;
                    this.direccionPersona = response.data.persona.direccion;
                    this.email = response.data.persona.email;

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

        createUsuario:function () {
            var url='usuario';

            $("#btnGuardar").attr('disabled', true);
            $("#btnCancel").attr('disabled', true);
            $("#btnClose").attr('disabled', true);

            this.divloaderNuevo=true;


            var data = new  FormData();

            data.append('name', this.name);
            data.append('email', this.email);
            data.append('activo', this.activo);
            data.append('persona_id', this.persona_id);
            data.append('tipo_user_id', this.tipo_user_id);
            data.append('password', this.password);
            
            data.append('cargoTrabajador', this.cargoTrabajador);
            data.append('oficina_idTrabajador', this.oficina_idTrabajador);

            data.append('tipoPersona', this.tipoPersona);
            data.append('tipo_documentoPersona', this.tipo_documentoPersona);
            data.append('num_documentoPersona', this.num_documentoPersona);
            data.append('apellidosPersona', this.apellidosPersona);
            data.append('nombresPersona', this.nombresPersona);
            data.append('telefonoPersona', this.telefonoPersona);
            data.append('direccionPersona', this.direccionPersona);

            const config = { headers: { 'Content-Type': 'multipart/form-data' } };

            axios.post(url,data,config).then(response=>{

                $("#btnGuardar").removeAttr("disabled");
                $("#btnCancel").removeAttr("disabled");
                $("#btnClose").removeAttr("disabled");
                this.divloaderNuevo=false;

                if(response.data.result=='1'){
                    this.getUsuarios(this.thispage);
                    this.errors=[];
                    this.cerrarFormUsuario();
                    toastr.success(response.data.msj);
                }else{
                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
            }).catch(error=>{
                this.errors=error.response.data
            })
        },
        borrarUsuario:function (usuario) {
          swal.fire({
              title: '¿Estás seguro?',
              text: "¿Desea eliminar el usuario seleccionado? -- Nota: Este proceso no se podrá revertir",
              type: 'info',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, eliminar'
          }).then((result) => {


            if (result.value) {
            var url = 'usuario/'+usuario.id;
                            axios.delete(url).then(response=>{//eliminamos

                                if(response.data.result=='1'){
                                app.getUsuarios(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                               toastr.error(response.data.msj);
                           }
                       });
                    }

                        }).catch(swal.noop);
        },
        editUsuario:function (usuario) {

            this.filluser.id=usuario.id;
            this.filluser.name=usuario.name;
            this.filluser.email=usuario.email;
            this.filluser.password='';
            this.filluser.activo=usuario.activo;
            this.filluser.persona_id=usuario.persona_id;
            this.filluser.tipo_user_id=usuario.tipo_user_id;

            this.filluser.idTrabajador=usuario.idTrabajador;
            this.filluser.cargoTrabajador=usuario.cargoTrabajador;
            this.filluser.oficina_idTrabajador=usuario.oficina_idTrabajador;

            this.filluser.tipoPersona=usuario.tipoPersona;
            this.filluser.tipo_documentoPersona=usuario.tipo_documentoPersona;
            this.filluser.num_documentoPersona=usuario.num_documentoPersona;
            this.filluser.apellidosPersona=usuario.apellidosPersona;
            this.filluser.nombresPersona=usuario.nombresPersona;
            this.filluser.telefonoPersona=usuario.telefonoPersona;
            this.filluser.direccionPersona=usuario.direccionPersona;
            this.filluser.modifpassword= 0;
            this.filluser.tipouser=usuario.tipouser;

            usuario.permisosUsuario.forEach((permiso) => {
                if(permiso.codigo_form == "form1"){
                    this.filluser.permiso_form1 = true;
                }
                if(permiso.codigo_form == "form2"){
                    this.filluser.permiso_form2 = true;
                }
            });
           

            this.divNuevoUsuario=false;
            this.divEditUsuario=true;
            this.divloaderEdit=false;

        },
        cerrarFormUsuarioE: function(){

            this.divEditUsuario=false;

            this.$nextTick(function () {
                this.filluser = { 'id':'', 
                    'name':'', 
                    'email':'', 
                    'password':'', 
                    'activo':'',
                    'persona_id':'',
                    'tipo_user_id':'',
                    'idTrabajador':'',
                    'cargoTrabajador':'',
                    'oficina_idTrabajador':'',
                    'tipoPersona':'',
                    'tipo_documentoPersona':'',
                    'num_documentoPersona':'',
                    'apellidosPersona':'',
                    'nombresPersona':'',
                    'telefonoPersona':'',
                    'direccionPersona':'',
                    'modifpassword': 0 , 
                    'tipouser':'' ,
                    'permiso_form1': false,
                    'permiso_form2': false
                };
    
            })

        },

        modifclave: function(){

            if(this.filluser.modifpassword == 1){
                setTimeout(function(){ $("#txtpasswordE").focus(); }, 100);
            }
            if(this.filluser.modifpassword == 0){
                this.filluser.password='';
            }

        },

        pressNuevoDNIE: function() {

            var url='/persona/buscarDNI';

            axios.post(url,{tipoPersona:this.filluser.tipoPersona, tipo_documentoPersona:this.filluser.tipo_documentoPersona,num_documentoPersona:this.filluser.num_documentoPersona}).then(response=>{

                if(String(response.data.result)=='1'){

                    /* this.filluser.persona_id = '0';
                    this.filluser.apellidosPersona = '';
                    this.filluser.nombresPersona = '';
                    this.filluser.telefonoPersona = '';
                    this.filluser.direccionPersona = '';
                    this.filluser.emailPersona = ''; */

                    this.$nextTick(function () {
                        $("#txtnombresPersonaE").focus();
                    });

                    //toastr.success(response.data.msj);
                }else if (String(response.data.result)=='2') {

                    this.filluser.persona_id = response.data.idPer;
                    this.filluser.apellidosPersona = response.data.persona.apellidos;
                    this.filluser.nombresPersona = response.data.persona.nombres;
                    this.filluser.telefonoPersona = response.data.persona.telefono;
                    this.filluser.direccionPersona = response.data.persona.direccion;
                    this.filluser.email = response.data.persona.email;

                    this.filluser.formularioCrear=true;

                    this.$nextTick(function () {
                        $("#txtnombresPersonaE").focus();
                    });
                }else{
                        /* this.filluser.persona_id = '0';
                        this.filluser.apellidosPersona = '';
                        this.filluser.nombresPersona = '';
                        this.filluser.telefonoPersona = '';
                        this.filluser.direccionPersona = '';
                        this.filluser.emailPersona = ''; */

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

        updateUsuario: function (id) {

            var url="usuario/"+id;
            $("#btnSaveE").attr('disabled', true);
            $("#btnCloseE").attr('disabled', true);
            this.divloaderEdit=true;

            axios.put(url, this.filluser).then(response=>{


                $("#btnSaveE").removeAttr("disabled");
                $("#btnCloseE").removeAttr("disabled");
                this.divloaderEdit=false;
                
                if(response.data.result=='1'){   
                    this.getUsuarios(this.thispage);
                    this.cerrarFormUsuarioE();
                    toastr.success(response.data.msj);

                }else{
                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }

            }).catch(error=>{
                this.errors=error.response.data
            })
        },
    bajaUsuario:function (usuario) {
          swal.fire({
              title: '¿Estás seguro?',
              text: "Nota: Si se desactiva el usuario, No podrá acceder al sistema, hasta que sea activado nuevamente",
              type: 'info',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, desactivar'
          }).then((result) => {

            if (result.value) {
            var url = 'usuario/altabaja/'+usuario.id+'/0';
                            axios.get(url).then(response=>{//eliminamos

                                if(response.data.result=='1'){
                                app.getUsuarios(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                               toastr.error(response.data.msj);
                           }
                       });
                    }

                        }).catch(swal.noop);
    },
    altaUsuario:function (usuario) {
        swal.fire({
            title: '¿Estás seguro?',
            text: "Nota: Si activa el usuario, podrá acceder al sistema nuevamente",
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Activar'
        }).then((result) => {

        if (result.value) {
        var url = 'usuario/altabaja/'+usuario.id+'/1';
                        axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                            app.getUsuarios(app.thispage);//listamos
                            toastr.success(response.data.msj);//mostramos mensaje
                        }else{
                            // $('#'+response.data.selector).focus();
                            toastr.error(response.data.msj);
                        }
                    });

                    }

                    }).catch(swal.noop);
    },

    impFicha:function (usuario) {

        this.filluser.id=usuario.id;
        this.filluser.name=usuario.name;
        this.filluser.email=usuario.email;
        this.filluser.password='';
        this.filluser.activo=usuario.activo;
        this.filluser.persona_id=usuario.persona_id;
        this.filluser.tipo_user_id=usuario.tipo_user_id;

        this.filluser.idTrabajador=usuario.idTrabajador;
        this.filluser.cargoTrabajador=usuario.cargoTrabajador;
        this.filluser.oficina_idTrabajador=usuario.oficina_idTrabajador;

        this.filluser.tipoPersona=usuario.tipoPersona;
        this.filluser.tipo_documentoPersona=usuario.tipo_documentoPersona;
        this.filluser.num_documentoPersona=usuario.num_documentoPersona;
        this.filluser.apellidosPersona=usuario.apellidosPersona;
        this.filluser.nombresPersona=usuario.nombresPersona;
        this.filluser.telefonoPersona=usuario.telefonoPersona;
        this.filluser.direccionPersona=usuario.direccionPersona;
        this.filluser.modifpassword= 0;
        this.filluser.tipouser=usuario.tipouser;

        $('#modalFicha').modal(); 

    },
    Imprimir:function (usuario) {
        $("#FichaUsuario").printArea();
    },
}
});
</script>