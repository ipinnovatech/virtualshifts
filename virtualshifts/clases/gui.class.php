<?php

class GUI{
    
    var $header;
    var $footer;
    var $icon;

    function GUI( $id_tipo_usuario ){
        
        include("data.php");
        
        $app_dir = $app_url;
        
        $nombres_usuario = $_SESSION['nombres'];
        $apellidos_usuario = $_SESSION['apellidos'];
        
        $this->icon = '<link rel="shortcut icon" href="'.$app_dir.'favicon.png" />';

        if($id_tipo_usuario == 9){ // SUPERADMIN
            $this->header = '<header>
                                <div class="navigation-bar bg-grayLight">
                                    <div class="navigation-bar-content container">
                                        <a href="'.$app_dir.'page/superadmin/index.php" class="element brand sin-hover-header"><img src="'.$app_dir.'images/favicon.png" style="width: 80px; margin-right: 10px; margin-top: -13px;" /><div style="margin-top: -65px; margin-left: 75px;"><strong style="font-size: 24pt !important;">&nbsp;&nbsp;Virtual SHIFTS</strong></div></a>
                                        <div class="element place-right sin-hover-header" style="cursor: pointer;" title="Cerrar sesi&oacute;n" id="basic-modal" onclick="cerrar_sesion();">
                                            <span class="brand sin-hover-header" style="font-size: 16pt !important; font-weight: bold;">'.$nombres_usuario.' '.$apellidos_usuario.'</span>
                                            <span class="icon-exit fg-red" style="float: right; font-size: 24pt !important; margin-top: -28px; margin-left: 9px;"></span>                    
                                        </div>                
                                    </div>
                                </div>
                            </header>';    
        }else if($id_tipo_usuario == 10){
            $this->header = '<header>
                                <div class="navigation-bar bg-grayLight">
                                    <div class="navigation-bar-content container">
                                        <a href="'.$app_dir.'page/admin/index.php" class="element brand sin-hover-header"><img src="'.$app_dir.'images/favicon.png" style="width: 80px; margin-right: 10px; margin-top: -13px;" /><div style="margin-top: -65px; margin-left: 75px;"><strong style="font-size: 24pt !important;">&nbsp;&nbsp;Virtual SHIFTS</strong></div></a>
                                        <div class="element place-right sin-hover-header" style="cursor: pointer;" title="Cerrar sesi&oacute;n" id="basic-modal" onclick="cerrar_sesion();">
                                            <span class="brand sin-hover-header" style="font-size: 16pt !important; font-weight: bold;">'.$nombres_usuario.' '.$apellidos_usuario.'</span>
                                            <span class="icon-exit fg-red" style="float: right; font-size: 24pt !important; margin-top: -28px; margin-left: 9px;"></span>                    
                                        </div>                
                                    </div>
                                </div>
                            </header>';
        }else if($id_tipo_usuario == 11){
            $this->header = '<header>
                                <div class="navigation-bar bg-grayLight">
                                    <div class="navigation-bar-content container">
                                        <a href="#" class="element brand sin-hover-header"><img src="'.$app_dir.'images/favicon.png" style="width: 80px; margin-right: 10px; margin-top: -13px;" /><div style="margin-top: -65px; margin-left: 75px;"><strong style="font-size: 24pt !important;">&nbsp;&nbsp;Virtual SHIFTS</strong></div></a>
                                        <div class="element place-right sin-hover-header" style="cursor: pointer;" title="Cerrar sesi&oacute;n" id="basic-modal" onclick="cerrar_sesion();">
                                            <span class="brand sin-hover-header" style="font-size: 16pt !important; font-weight: bold;">'.$nombres_usuario.' '.$apellidos_usuario.'</span>
                                            <span class="icon-exit fg-red" style="float: right; font-size: 24pt !important; margin-top: -28px; margin-left: 9px;"></span>                    
                                        </div>                
                                    </div>
                                </div>
                            </header>';
        }               
        
         $this->footer = '<footer>
                            <div class="navigation-bar bg-ip">
                                <div class="navigation-bar-content container">
                                    <span class="element sin-hover-footer place-right">
                                        2014, Virtual DATE SHIFTS &copy; by <a class="fg-color-white" href="http://www.ipinnovatech.com">IP Innovatech</a>  
                                    </span>
                                    <a class="element place-left sin-hover-footer" href="http://www.ipinnovatech.com" >
                                        <img src="'.$app_dir.'images/footer.png" style="margin-top: -37px;" />
                                    </a>
                                </div>
                            </div>
                        </footer>';                
                
        
    }
       
    function get_header(){
        return $this->header;
    }
    
    function get_footer(){
        return $this->footer;
    }
}

?>