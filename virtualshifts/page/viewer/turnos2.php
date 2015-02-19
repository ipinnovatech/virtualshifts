<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../../css/metro-bootstrap.css"/>
     
    <script type="text/javascript" src="../../js/jquery/jquery-1.9.0.min.js"></script>
    <script type="text/javascript" src="../../js/jquery/jquery.mousewheel.min.js"></script>
    <script type="text/javascript" src="../../js/jquery/jquery.widget.min.js"></script>
    <script type="text/javascript" src="../../js/jquery/jquery.flippy.min.js"></script>
    <script type="text/javascript" src="../../js/metro-times.js"></script>
    
    <script type="text/javascript">
    
    var asesor=0;
    var nomina=0;
    var seleccion=0;
    var mySonido;
    var myVideo = '';
    var myVideo1 = '';
    var tmp=0;
        
    function initialize(){       

            setInterval('iniciar()',2000);
            setInterval('cambio_video()',10000);
            mySonido=document.getElementById("audio_cambio");        
    }
    
    function iniciar(){

        var myVideo=document.getElementById("video1");
        
                
        if (myVideo.paused){ 
            if(tmp<4)
            myVideo.play();
           } else tmp++;
            
        var parametros="asesor="+asesor+"&nomina="+nomina+"&seleccion="+seleccion;                    
            
        $.ajax({               
                type: "POST",
                url:"get_turnos.php",
                data: parametros,
                dataType: 'JSON',
                success: function(data) {
                    
                    //alert(data);
                    if( data.cambios == "si"){
                        
                        if(data.asesor.cambios == "si"){
                            
                            asesor=data.asesor.datos['C_ACTUAL'];
                            
                            mySonido.play();
                            
                            $("#flipbox_1").flippy({
                                  
                                    duration: "1000",
                                    direction: "TOP",
                                    onFinish: function change(){
                                         $("#flipbox_1").html('<div style="float:left;"><h1 class="text-alert" style="color: #ffffff; margin-left: 35px;">Aportes</h1><h1 style="color: #ffffff; margin-left: 35px;">Turno '+data.asesor.datos['T_CODIGO']+'</h1><h3 style="color: #ffffff; margin-left: 35px;">'+data.asesor.datos['T_NOMBRE']+'</h3></div><div style="float:right; width: 100px; color: #ffffff; font-size: 19px;"><img src="../../images/asesor1.png" style="width: 82px; height: 82px; border-radius: 15px;margin-top: 10px; "/>&nbsp;&nbsp;Asesor:<br />&nbsp;Casilla 1</div>');
                        
                                    }
                            });
                        }   
                        
                        if(data.nomina.cambios == "si"){
                            
                            nomina=data.nomina.datos['C_ACTUAL'];
                            
                            mySonido.play();
                            
                            $("#flipbox_2").flippy({
                                  
                                    duration: "1000",
                                    direction: "TOP",
                                    
                                    onFinish: function change(){
                                        
                                        $("#flipbox_2").html('<div style="float:left;"><h1 class="text-successlight" style="color: #ffffff; margin-left: 35px;">N&oacute;mina</h1><h1 style="color: #ffffff; margin-left: 35px;">Turno '+data.nomina.datos['T_CODIGO']+'</h1><h3 style="color: #ffffff; margin-left: 35px;">'+data.nomina.datos['T_NOMBRE']+'</h3></div><div style="float:right; width: 100px; color: #ffffff; font-size: 19px;"><img src="../../images/asesor1.png" style="width: 82px; height: 82px; border-radius: 15px;margin-top: 10px; "/>&nbsp;&nbsp;Asesor:<br />&nbsp;Casilla 2</div>');
           
                                    }
                                 
                            });
                        }
                        
                        if(data.seleccion.cambios == "si"){
                            
                            seleccion=data.seleccion.datos['C_ACTUAL'];
                            
                            mySonido.play();
                                
                            $("#flipbox_3").flippy({
                                    duration: "1000",
                                    direction: "TOP",
                                    
                                    onFinish: function change(){
                                        $("#flipbox_3").html('<div style="float:left;"><h1 class="text-info" style="color: #ffffff; margin-left: 35px;">Vinculaci&oacute;n</h1><h1 style="color: #ffffff; margin-left: 35px;">Turno '+data.seleccion.datos['T_CODIGO']+'</h1><h3 style="color: #ffffff; margin-left: 35px;">'+data.seleccion.datos['T_NOMBRE']+'</h3></div><div style="float:right; width: 100px; color: #ffffff; font-size: 19px;"><img src="../../images/asesor1.png" style="width: 82px; height: 82px; border-radius: 15px;margin-top: 10px; "/>&nbsp;&nbsp;Asesor:<br />&nbsp;Casilla 3</div>');
            
                                    }
                            });
                        }
                    }
                }                
            });                      
    } 
    
    function cambio_turno(consulta){
        
        $("#flipbox_"+consulta).flippy({
            //color_target: "red",
            duration: "500",
            direction: "TOP",
          //verso: "woohoo"
          onFinish: function change(){
            if (consulta == 1){
                $("#flipbox_"+consulta).html('<div style="float:left;"><h1 class="text-alert" style="color: #ffffff; margin-left: 35px;">Aportes</h1><h1 style="color: #ffffff; margin-left: 35px;">Turno A12</h1><h3 style="color: #ffffff; margin-left: 35px;">Pedro Lievano</h3></div><div style="float:right; width: 100px; color: #ffffff; font-size: 19px;"><img src="images/asesor1.png" style="width: 82px; height: 82px; border-radius: 15px;margin-top: 10px; "/>&nbsp;&nbsp;Asesor:<br />&nbsp;Casilla 4</div>');
            }else if (consulta == 2){
                $("#flipbox_"+consulta).html('<div style="float:left;"><h1 class="text-successlight" style="color: #ffffff; margin-left: 35px;">N&oacute;mina</h1><h1 style="color: #ffffff; margin-left: 35px;">Turno N23</h1><h3 style="color: #ffffff; margin-left: 35px;">Yoseph Orozco</h3></div><div style="float:right; width: 100px; color: #ffffff; font-size: 19px;"><img src="images/asesor1.png" style="width: 82px; height: 82px; border-radius: 15px;margin-top: 10px; "/>&nbsp;&nbsp;Asesor:<br />&nbsp;Casilla 5</div>');
            }else {
                $("#flipbox_"+consulta).html('<div style="float:left;"><h1 class="text-info" style="color: #ffffff; margin-left: 35px;">Vinculaci&oacute;n</h1><h1 style="color: #ffffff; margin-left: 35px;">Turno V44</h1><h3 style="color: #ffffff; margin-left: 35px;">Olga Plata</h3></div><div style="float:right; width: 100px; color: #ffffff; font-size: 19px;"><img src="images/asesor1.png" style="width: 82px; height: 82px; border-radius: 15px;margin-top: 10px; "/>&nbsp;&nbsp;Asesor:<br />&nbsp;Casilla 6</div>');
            }
          }
        });        
    }
    
    function cambio_video(){
        $.ajax({               
                type: "POST",
                url:"get_video.php",
                success: function(data) {
                    //console.debug($("#fuente_video").attr('src'));
                    $("#fuente_video").attr('src', 'vids/'+data);
                    if(data != myVideo1){
                       $("#video1")[0].load();
                       myVideo1 = data; 
                    }                    
                    //console.debug($("#fuente_video").attr('src'));                    
                }
        });
        
    }        
</script>
    
<title>Virtual Turnos</title>
</head>
<body class="metro" style="background-color: #CFCFCF; width: 75%;" onload="initialize()">
    <div class="grid container " style="width: 160%;">    
        <div class="row" style="width: 170%;">
            <div style="perspective: 510px;" class="span7">
                <div style="transform: rotateX(0deg); opacity: 1; background: none repeat scroll 0% 0% rgb(255, 255, 255);" class="tile quadro-ip bg-lightEfiBlue flipbox" id="flipbox_1"><div style="float:left;"><h1 class="text-alert" style="color: #ffffff; margin-left: 35px;">Aportes</h1><h1 style="color: #ffffff; margin-left: 35px;">Turno A14</h1><h3 style="color: #ffffff; margin-left: 35px;">Alejandro Rios</h3></div><div style="float:right; width: 100px; color: #ffffff; font-size: 19px;"><img src="images/asesor1.png" style="width: 82px; height: 82px; border-radius: 15px;margin-top: 10px; ">&nbsp;&nbsp;Asesor:<br>&nbsp;Casilla 1</div></div>
                <div style="transform: rotateX(0deg); opacity: 1; background: none repeat scroll 0% 0% rgb(255, 255, 255);" class="tile quadro-ip bg-efiblue flipbox" id="flipbox_2"><div style="float:left;"><h1 class="text-successlight" style="color: #ffffff; margin-left: 35px;">Nómina</h1><h1 style="color: #ffffff; margin-left: 35px;">Turno N11</h1><h3 style="color: #ffffff; margin-left: 35px;">MAURICIO VARGAS</h3></div><div style="float:right; width: 100px; color: #ffffff; font-size: 19px;"><img src="images/asesor1.png" style="width: 82px; height: 82px; border-radius: 15px;margin-top: 10px; ">&nbsp;&nbsp;Asesor:<br>&nbsp;Casilla 2</div></div>
                <div style="transform: rotateX(0deg); opacity: 1; background: none repeat scroll 0% 0% rgb(255, 255, 255);" class="tile quadro-ip bg-darkEfiBlue flipbox" id="flipbox_3"><div style="float:left;"><h1 class="text-info" style="color: #ffffff; margin-left: 35px;">Vinculación</h1><h1 style="color: #ffffff; margin-left: 35px;">Turno V14</h1><h3 style="color: #ffffff; margin-left: 35px;">Array</h3></div><div style="float:right; width: 100px; color: #ffffff; font-size: 19px;"><img src="images/asesor1.png" style="width: 82px; height: 82px; border-radius: 15px;margin-top: 10px; ">&nbsp;&nbsp;Asesor:<br>&nbsp;Casilla 3</div></div>
            </div>
            <div class="span8">
                    <div>
                   <!-- <img src="images/eficacia1.png" style="width: 70%; height: 70%; margin-left: 75px;"/>-->
                    <img src="images/eficacia1.png" style="float:left; width: 434px; height: 168px;">
                    <img src="images/logo_ip_blanco2.png" style="float:right;">
                    </div>            
                    <!--<video id="video1" width="100%" height="100%" loop="loop"  autoplay="autoplay" muted="true">-->
                    <video id="video1" loop="loop" autoplay="autoplay" height="349px" width="620px">    
                                    
                        <source id="fuente_video" src="vids/vid2.mp4" type="video/mp4">
                      
                      <!--Your browser does not support the video tag.-->
                    </video>
                    <audio id="audio_cambio">
                         <source src="vids/sonido.mp3" type="audio/mpeg">
                    </audio>   
                    <br>
                    <br>
                    <div id="clock " class="times inverse" data-role="times" data-style-divider="fg-dark" data-blink="false" style="font-size: 50px"><span class="countHours"><span class="digit-wrapper">                        <span style="top: 0px; opacity: 1;" class="digit bg-dark fg-white">1</span>                    </span>                    <span class="digit-wrapper">                        <span style="top: 0px; opacity: 1;" class="digit bg-dark fg-white">4</span>                    </span></span><span class="divider fg-dark"></span><span class="countMinutes"><span class="digit-wrapper">                        <span style="top: 0px; opacity: 1;" class="digit bg-dark fg-white">5</span>                    </span>                    <span class="digit-wrapper">                        <span style="top: 0px; opacity: 1;" class="digit bg-dark fg-white">5</span>                    </span></span></div>          
            </div>
        </div>
  
    </div> 


<script>     
        //console.debug(myVideo);
//        switch (myVideo){
//            case "vid1.mp4":
//            setInterval("cambio_video("+myVideo+");",332000);
//            break;
//            
//            case "intro_ipinnovatech.mp4":
//            setInterval("cambio_video("+myVideo+");",44000);
//            break;
//            
//            case "vid2.mp4":
//            setInterval("cambio_video("+myVideo+");",358000);
//            break;
//            
//            default:
//            break;
//        }
        
</script>
</body></html>