<div style="width: 18cm;padding-left: 0px;" class="panel panel-defaultPrint container-fluid spark-screen" id='printarea'>
    <div style="width: 18cm;padding-top: 30px;">
        
        <div style="width: 18cm;">

            

            <div style="width: 18.2cm;">




                <table>
                    <tbody>
                        <tr>
                            <td style="width: 3.2cm;text-align: center;padding-top: 20px;">
                                <img src="{{ asset('/img/unasam.png') }}" style="width: 72px;">
                            </td>

                            <td style="width: 11.5cm;;text-align: center;padding-top: 20px;">
                                <p style="margin-bottom: 0px;font-size: 19px"><strong>UNIVERSIDAD NACIONAL</strong></p>
                                <p style="margin-bottom: 0px;font-size: 19px"><strong>SANTIAGO ANTÚNEZ DE MAYOLO</strong></p>
                                <hr style="margin-top: 5px;margin-bottom: 5px; width: 370px;" class="hrP"> 
                                <p style="font-family: Monotype Corsiva; font-size: 22px; color:#EDB23B">Una Nueva Universidad para el Desarrollo</p>  


                            </td>
                            <td style="width: 3.52cm; text-align: center;padding-top: 20px;" >
                                {{-- <img v-if="filluser.imagen.length>0" id="divImgFIcha" src="{{ asset('/img/unasam.png') }}" style="width: 90px;height: 90px;" class="img img-responsive"> --}}
                            </td>                    
                        </tr>
                    </tbody>
                </table>



                
            </div>


            <div style="width: 18cm;">
                <table>
                    <tbody>
                        <tr>
                            <td style="width: 3.2cm; text-align: center;padding-top: 17px;">
                                
                            </td>

                            <td style="width: 11.5cm;text-align: center;padding-top: 15px;padding-bottom: 20px;">
                                
                                <p style="margin-bottom: 0px;font-size: 19px"><strong>FICHA DE USUARIO DEL SISTEMA DE GESTIÓN DEL PORTAL INSTITUCIONAL DE LA FACULTAD DE ECONOMÍA  Y CONTABILIDAD</strong></p>
                                
                            </td>
                            <td style="width: 3.52cm; text-align: center;padding-top: 17px;">
                                
                            </td>                    
                        </tr>
                    </tbody>
                </table>
            </div>


            


            


            <div style="width: 18cm;"> 
                <table>
                    <tbody>
                        <tr>
                            <td style="width: 5.6cm; text-align: center; border: 1px;border-style: solid">
                                <p style="margin-bottom: 0px;font-size: 13px"><strong style="padding-left: 8px;"> 
                                    DNI
                                </strong>:</p>
                            </td>

                            <td style="width: 70%;text-align: center;padding-top: 17px;padding-bottom: 17px;border: 1px;border-style: solid;">
                                
                                <p  id="impArea" style="margin-bottom: 0px;font-size: 14px;text-align: justify;padding-left: 10px;padding-right: 10px;">
                                 @{{ filluser.dni }}
                             </p>
                             
                         </td>
                         
                     </tr>
                 </tbody>
             </table>
         </div>

         <div style="width: 18cm;"> 
            <table>
                <tbody>
                    <tr>
                        <td style="width: 5.6cm; text-align: center; border: 1px;border-style: solid">
                            <p style="margin-bottom: 0px;font-size: 13px"><strong style="padding-left: 8px;">Nombres y Apellidos</strong>:</p>
                        </td>

                        <td style="width: 70%;text-align: center;padding-top: 17px;padding-bottom: 17px;border: 1px;border-style: solid;">
                            
                            <p style="margin-bottom: 0px;font-size: 14px;text-align: justify;padding-left: 10px;padding-right: 10px;">
                             @{{ filluser.nombres }} @{{ filluser.apellidos }}
                         </p>
                         
                     </td>
                     
                 </tr>
             </tbody>
         </table>
     </div>

     <div style="width: 18cm;"> 
        <table>
            <tbody>
                <tr>
                    <td style="width: 5.6cm; text-align: center; border: 1px;border-style: solid">
                        <p style="margin-bottom: 0px;font-size: 13px"><strong style="padding-left: 8px;">Tipo de Usuario</strong>:</p>
                    </td>

                    <td style="width: 70%;text-align: center;padding-top: 17px;padding-bottom: 17px;border: 1px;border-style: solid;">
                        
                        <p style="margin-bottom: 0px;font-size: 14px;text-align: justify;padding-left: 10px;padding-right: 10px;">
                            @{{ filluser.tipouser }}   
                        </p>
                        
                    </td>
                    
                </tr>
            </tbody>
        </table>
    </div>




    <div style="width: 18cm;"> 
        <table>
            <tbody>
                <tr>
                    <td style="width: 5.6cm; text-align: center; border: 1px;border-style: solid">
                        <p style="margin-bottom: 0px;font-size: 13px"><strong style="padding-left: 8px;">Cargo</strong>:</p>
                    </td>

                    <td style="width: 70%;text-align: center;padding-top: 17px;padding-bottom: 17px;border: 1px;border-style: solid;">
                        
                        <p style="margin-bottom: 0px;font-size: 14px;text-align: justify;padding-left: 10px;padding-right: 10px;">
                            @{{ filluser.cargo }}   
                        </p>
                        
                    </td>
                    
                </tr>
            </tbody>
        </table>
    </div>

    <div style="width: 18cm;" v-if="filluser.tipouser_id==4"> 
        <table>
            <tbody>
                <tr>
                    <td style="width: 5.6cm; text-align: center; border: 1px;border-style: solid">
                        <p style="margin-bottom: 0px;font-size: 13px"><strong style="padding-left: 8px;">Programa de Estudios a Cargo</strong>:</p>
                    </td>

                    <td style="width: 70%;text-align: center;padding-top: 17px;padding-bottom: 17px;border: 1px;border-style: solid;">
                        
                        <p style="margin-bottom: 0px;font-size: 14px;text-align: justify;padding-left: 10px;padding-right: 10px;">
                            @{{ filluser.programaestudio }}   
                        </p>
                        
                    </td>
                    
                </tr>
            </tbody>
        </table>
    </div>




    <div style="width: 18cm;"> 
        <table>
            <tbody>
                <tr>
                    <td style="width: 5.6cm; text-align: center; border: 1px;border-style: solid">
                        <p style="margin-bottom: 0px;font-size: 13px"><strong style="padding-left: 8px;">EMAIL</strong>:</p>
                    </td>

                    <td style="width: 70%;text-align: center;padding-top: 17px;padding-bottom: 17px;border: 1px;border-style: solid;">
                        
                        <p style="margin-bottom: 0px;font-size: 15px;text-align: left;padding-left: 10px;padding-right: 10px;">  
                            @{{ filluser.email }} 
                        </p>
                        
                    </td>
                    
                </tr>
            </tbody>
        </table>
    </div>

    <div style="width: 18cm;"> 
        <table>
            <tbody>
                <tr>
                    <td style="width: 5.6cm; text-align: center; border: 1px;border-style: solid">
                        <p style="margin-bottom: 0px;font-size: 13px"><strong style="padding-left: 8px;">Teléfono</strong>:</p>
                    </td>

                    <td style="width: 70%;text-align: center;padding-top: 17px;padding-bottom: 17px;border: 1px;border-style: solid;">
                        
                        <p style="margin-bottom: 0px;font-size: 15px;text-align: left;padding-left: 10px;padding-right: 10px;">  
                            @{{ filluser.telefono }} 
                        </p>
                        
                    </td>
                    
                </tr>
            </tbody>
        </table>
    </div>

    <div style="width: 18cm;"> 
        <table>
            <tbody>
                <tr>
                    <td style="width: 5.6cm; text-align: center; border: 1px;border-style: solid">
                        <p style="margin-bottom: 0px;font-size: 13px"><strong style="padding-left: 8px;">DIRECCIÓN</strong>:</p>
                    </td>

                    <td style="width: 70%;text-align: center;padding-top: 17px;padding-bottom: 17px;border: 1px;border-style: solid;">
                        
                        <p style="margin-bottom: 0px;font-size: 15px;text-align: left;padding-left: 10px;padding-right: 10px;"> 
                            @{{ filluser.direccion }}   
                        </p>
                        
                    </td>
                    
                </tr>
            </tbody>
        </table>
    </div>


    


    

    <div style="width: 18cm;"> 
        <table>
            <tbody>
                <tr>
                    <td style="width: 5.6cm; text-align: center; border: 1px;border-style: solid">
                        <p style="margin-bottom: 0px;font-size: 13px"><strong style="padding-left: 10px;">USERNAME</strong>:</p>
                    </td>

                    <td style="width: 70%;text-align: center;padding-top: 17px;padding-bottom: 17px;border: 1px;border-style: solid;">
                        
                        <p style="margin-bottom: 0px;font-size: 14px;text-align: justify;padding-left: 10px;padding-right: 10px;">
                            @{{ filluser.name }}  
                        </p>
                        
                    </td>
                    
                </tr>
            </tbody>
        </table>
    </div>


    

</div>

</div>
</div>