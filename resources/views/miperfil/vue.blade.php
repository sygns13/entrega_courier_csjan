<script type="text/javascript">
    let app = new Vue({
       el: '#app',
       data:{
           titulo:"Mi perfil",
           subtitulo: "Módulo Principal",
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
           classTitle:'fa fa-user-secret',
           classMenu0:'',
           classMenu1:'',
           classMenu2:'',
           classMenu3:'',
           classMenu4:'',
           classMenu5:'',
           classMenu6:'active',
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
                    'nombreOficina':'' ,

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
 
   
   
           divloaderNuevo:false,
   
           divloaderEdit:false,

           idUser:'0',
   
           thispage:'1',
   
           divprincipal:false,
   
           modifpassword:1,


           pswa:'',
           pswn1:'',
           pswn2:'',
   
   
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
               //var busca=this.buscar;
               var url = 'usuario/miperfil'
   
               axios.post(url).then(response=>{

                    this.filluser.id=response.data.usuario.id;
                    this.filluser.name=response.data.usuario.name;
                    this.filluser.email=response.data.usuario.email;
                    this.filluser.password='';
                    this.filluser.activo=response.data.usuario.activo;
                    this.filluser.persona_id=response.data.usuario.persona_id;
                    this.filluser.tipo_user_id=response.data.usuario.tipo_user_id;

                    this.filluser.idTrabajador=response.data.usuario.idTrabajador;
                    this.filluser.cargoTrabajador=response.data.usuario.cargoTrabajador;
                    this.filluser.oficina_idTrabajador=response.data.usuario.oficina_idTrabajador;

                    this.filluser.tipoPersona=response.data.usuario.tipoPersona;
                    this.filluser.tipo_documentoPersona=response.data.usuario.tipo_documentoPersona;
                    this.filluser.num_documentoPersona=response.data.usuario.num_documentoPersona;
                    this.filluser.apellidosPersona=response.data.usuario.apellidosPersona;
                    this.filluser.nombresPersona=response.data.usuario.nombresPersona + ' ' + response.data.usuario.apellidosPersona;
                    this.filluser.telefonoPersona=response.data.usuario.telefonoPersona;
                    this.filluser.direccionPersona=response.data.usuario.direccionPersona;
                    this.filluser.modifpassword= 0;
                    this.filluser.tipouser=response.data.usuario.tipouser;
                    this.filluser.nombreOficina=response.data.usuario.nombreOficina;

                    response.data.usuario.permisosUsuario.forEach((permiso) => {
                        if(permiso.codigo_form == "form1"){
                            this.filluser.permiso_form1 = true;
                        }
                        if(permiso.codigo_form == "form2"){
                            this.filluser.permiso_form2 = true;
                        }
                    });


               })
           },
           

           modifclave:function () {

            this.pswa='';
            this.pswn1='';
            this.pswn2='';
   

$("#boxTitulo").text('Usuario: '+this.filluser.name);
$("#modalEditar").modal('show');

$("#txtdato2").focus();
},

  
          
updatepsw:function (usuario) {
             swal.fire({
                 title: '¿Estás seguro?',
                 text: "Desea modificar su Password",
                 type: 'info',
                 showCancelButton: true,
                 confirmButtonColor: '#3085d6',
                 cancelButtonColor: '#d33',
                 confirmButtonText: 'Si, Modificar'
             }).then((result) => {
   
               if (result.value) {
               app.update();
   
                        }
   
                           }).catch(swal.noop);
         },

         update:function (id) {
       var url="usuario/modificarclave";
       $("#btnSaveE").attr('disabled', true);
       $("#btnCancelE").attr('disabled', true);
       app.divloaderEdit=true;

       var data = new  FormData();
       
            data.append('pswa', app.pswa);
            data.append('pswn1', app.pswn1);
            data.append('pswn2', app.pswn2);


            const config = { headers: { 'Content-Type': 'multipart/form-data' } };

    
            axios.post(url,data, config).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCancelE").removeAttr("disabled");
           app.divloaderEdit=false;
           
           if(response.data.result=='1'){   
 
           $("#modalEditar").modal('hide');
           toastr.success(response.data.msj);

           }else{
               $('#'+response.data.selector).focus();
               toastr.error(response.data.msj);
           }

       }).catch(error=>{
          // this.errors=error.response.data
       })
   },
   }
   });
   </script>