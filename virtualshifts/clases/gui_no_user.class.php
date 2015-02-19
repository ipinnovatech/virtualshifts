<?php

class GUI_NU{
    
    var $header;
    var $footer;
    var $icon;

    function GUI_NU(  ){
        
        include("data.php");
        
        $app_dir = $app_url;
        
        $this->icon = '<link rel="shortcut icon" href="'.$app_dir.'favicon.png" />';
        
        $this->header = '<header>
                            <div class="navigation-bar bg-grayLight">
                            </div>
                        </header>';
        
         $this->footer = '<footer>
                            <div class="navigation-bar bg-ip">
                                <div class="navigation-bar-content container">
                                    <span class="element sin-hover-footer place-right">
                                        2014, Virtual HUMAN INTERFACE &copy; by <a class="fg-color-white" href="http://www.ipinnovatech.com">IP Innovatech</a>  
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