<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="product" content="Virtual SHIFTS" />
    <meta name="description" content="Gestion para turnos" />
    <meta name="author" content="IP Innovatech" />

    <link href="css/metro-bootstrap.css" rel="stylesheet" />
    <link href="css/metro-bootstrap-responsive.css" rel="stylesheet" />
    <link href="css/iconFont.css" rel="stylesheet" />
    <link href="css/docs.css" rel="stylesheet" />
    <link href="js/prettify/prettify.css" rel="stylesheet" />
    
    <link href="css/simpleModal/basic.css" rel="stylesheet" />
    <link href="css/simpleModal/basic_ie.css" rel="stylesheet" />
    <link href="css/simpleModal/demo.css" rel="stylesheet" />
    <link href="css/portal.css" rel="stylesheet" />
    
    
    <!-- Load JavaScript Libraries -->
    <script src="js/jquery/jquery.js"></script>
    <script src="js/jquery/jquery.min.js"></script>
    <script src="js/jquery/jquery.widget.min.js"></script>
    <script src="js/jquery/jquery.mousewheel.js"></script>
    <script src="js/jquery/jquery.easing.1.3.min.js"></script>
    <script src="js/prettify/prettify.js"></script>
    <script src="js/holder/holder.js"></script>
    
    <link rel="shortcut icon" href="favicon.png" />

    <!-- Metro UI CSS JavaScript plugins -->
    <script src="js/load-metro.js"></script>
    
    
    <script src="js/simpleModal/jquery.simplemodal.js"></script>
    
    <script type="text/javascript">
    
    if(Function('/*@cc_on return document.documentMode===10@*/')()){ $("html").addClass("ie10"); }
        
        function lanzar_modal(){
            document.getElementById('captcha').src = 'clases/securimage/securimage_show.php?' + Math.random();
            $('#basic-modal-content').modal({
                opacity: 40,
                overlayClose: true,
                closeClass: 'closeModal'
            });
        }
        
        function login(){
            var user = $("#user").val();
            var pass = $("#pass").val();
            var captcha_code = $("#captcha_code").val();
            
            $.ajax({
                'url':"gestionseguridad/control.php",
                'type': 'POST',
                'dataType': 'JSON',
                'async': false,
                'data': { username: user, password: pass, captcha_code: captcha_code },
                'success': function(result){

                    if( result.status == "success" ){
                            window.location = result.data.url;
                    }else if(result.status == "error" && result.error_description == "user_dose_not_exist"){
                        $.Notify({
                            content: "Datos de usuario incorrectos.",
                            style: {background: 'red', color: 'white'},
                            timeout: 5000,
                            width: 250,
                            height: 30                            
                        });
                        $(".closeModal").click();
                    }else if(result.status == "error" && result.error_description == "pass_not_match"){
                        $.Notify({
                            content: "Datos de usuario incorrectos.",
                            style: {background: 'red', color: 'white'},
                            timeout: 5000,
                            width: 250,
                            height: 30                            
                        });
                        $(".closeModal").click();
                    }else if(result.status == "error" && result.error_description == "no_db"){
                        $.Notify({
                            content: "Ha ocurrido un error por favor intente de nuevo mas tarde.",
                            style: {background: 'red', color: 'white'},
                            timeout: 5000,
                            width: 250,
                            height: 30                            
                        });
                        $(".closeModal").click();
                    }else if(result.status == "error" && result.error_description == "captcha_error"){
                        $.Notify({
                            content: "Codigo de seguridad incorrecto.",
                            style: {background: 'red', color: 'white'},
                            timeout: 5000,
                            width: 250,
                            height: 30                            
                        });
                        $(".closeModal").click();
                    }
                }
            });
        }        
       
    </script>


    <title>Virtual SHIFTS</title>
</head>
<body class="metro" style="height: auto;">
    <div id="basic-modal-content" class="bg-darkCobalt fg-white">
        <div style="width: 630px; margin: 0 auto;">
            <h3 class="fg-white">Iniciar sesi&oacute;n</h3>
    		<p class="fg-white">Ingrese su usuario y contrase&ntilde;a</p>
            
            <div class="tile half" style="cursor: default; ">
                <div class="tile-content icon bg-gray">
                    <!--<img src="images/icon_usuarios.png" />-->
                    <b class="icon-user"></b>
                </div>
            </div>
            <div class="input-control text" style="width: 300px;">
                <input id="user" type="text" value="" placeholder="Usuario" />
                <button class="btn-clear"></button>
            </div>
            <br />
            <div class="input-control password" style="width: 300px;">
                <input type="password" id="pass" value="" placeholder="Contrase&ntilde;a" />
                <button class="btn-reveal"></button>
            </div>
            <br />
            <img id="captcha" src="clases/securimage/securimage_show.php" alt="CAPTCHA Image" style="margin-left: 65px;" />
            <div class="input-control text" style="width: 126px;">
                <input type="text" id="captcha_code" name="captcha_code" value="" placeholder="Codigo de seguridad" />                                
            </div>
            <br />
            <a href="#" title="Cambiar codigo de seguridad" style="margin-left: 65px;" onclick="document.getElementById('captcha').src = 'clases/securimage/securimage_show.php?' + Math.random(); return false"><b class="icon-cycle" style="font-size: 16pt; padding-top: 10px;"></b></a>            
            <div class="input-control" style="width: 587px;">                
                <button class="closeModal" style="float: right; margin: 10px;">Cancelar</button>
                <button class="primary" style="float: right; margin: 10px;" onclick="login();">Iniciar sesi&oacute;n</button>
            </div>
            <br />
            <br />
            <br />            
        </div>
	</div>

    <header>
        <div class="navigation-bar bg-grayLight">
            <div class="navigation-bar-content container">
                <a href="/" class="element brand sin-hover-header"><img src="images/favicon.png" style="width: 80px; margin-right: 10px; margin-top: -13px;" /><div style="margin-top: -65px; margin-left: 75px;"><strong style="font-size: 24pt !important;">&nbsp;&nbsp;Virtual SHIFTS</strong></div></a>
                <div class="element place-right sin-hover-header" style="cursor: pointer;" title="Iniciar sesi&oacute;n" id='basic-modal' onclick="lanzar_modal();">
                    <span class="brand sin-hover-header" style="font-size: 16pt !important; font-weight: bold;">Iniciar Sesi&oacute;n</span>
                    <span class="icon-enter fg-color-white" style="float: right; font-size: 24pt !important; margin-top: -28px; margin-left: 9px;"></span>                    
                </div>                
            </div>
        </div>
    </header>
    <br />
    <div class="page" style="height: auto;">
        <div class="page-region">
            <div class="page-region-content">
                <h1>
                    Virtual<small class="on-right">SHIFTS</small>
                </h1>
                
                <div class="tiles clearfix">
                    <div class="tile">
                        <div class="tile-content icon bg-green" style="cursor: default;">
                            <b class="icon-list"></b>
                        </div>
                        <div class="brand">
                            <div class="name">Turnos</div>
                        </div>
                    </div>

                    <div class="tile" style="cursor: default;">
                        <div class="tile-content icon bg-orange">
                            <b class="icon-user"></b>
                        </div>
                        <div class="brand">
                            <span class="name">Usuarios</span>
                        </div>
                    </div>  
                    
                    <div class="tile" style="cursor: default;" onclick="window.location = 'page/consulta/index.php'">
                        <div class="tile-content icon bg-crimson">
                            <b class="icon-stats"></b>
                        </div>
                        <div class="brand">
                            <span class="name">Reportes</span>
                        </div>
                    </div>                  

                    <!--<div class="tile double live" data-role="live-tile" data-effect="slideLeft" data-easing="easeInBounce" style="cursor: default;">
                        <div class="tile-content">
                            <img src="images/vm1.png" alt="">
                        </div>
                        <div class="tile-content">
                            <img src="images/vm2.png" alt="">
                        </div>
                        <div class="tile-content">
                            <img src="images/vm3.png" alt="">
                        </div>
                    </div>-->
                </div>
            </div>
        </div>
    </div>    
    <footer>
        <div class="navigation-bar bg-ip">
            <div class="navigation-bar-content container">
                <span class="element sin-hover-footer place-right">
                    2014, Virtual MOBILE &copy; by <a class="fg-color-white" href="http://www.ipinnovatech.com">IP Innovatech</a>  
                </span>
                <a class="element place-left sin-hover-footer" href="http://www.ipinnovatech.com" >
                    <img src="images/footer.png" style="margin-top: -37px;" />
                </a>
            </div>
        </div>
    </footer>
</body>
</html>