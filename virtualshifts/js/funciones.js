function verificar_campo(campo,tipo_verificacion){

    if(tipo_verificacion=="1"){

        var patron = /^\w+$/;

        mensaje_error = "El campo contiene caracteres no v\xE1lidos";

    }else if(tipo_verificacion=="2"){

        var patron = /^[a-zA-Z0-9\?\s]+$/;

        mensaje_error = "El campo contiene caracteres no v\xE1lidos";

    }else if(tipo_verificacion=="3"){

        var patron = /^[a-zA-Z0-9Ò—\?\.\,\s]+$/;

        mensaje_error = "El campo contiene caracteres no v\xE1lidos";

    }else if(tipo_verificacion=="dir"){

        var patron = /^[a-zA-Z0-9@\.\-\#\(\)\s]+$/;

        mensaje_error = "El campo contiene caracteres no v\xE1lidos";

    }else if(tipo_verificacion=="form_exter"){

        var patron = /^[a-zA-Z0-9@\.\-\_\s]+$/;

        mensaje_error = "El campo contiene caracteres no v\xE1lidos";

    }else if(tipo_verificacion=="correo"){

        var patron = /[\w-\.]@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

        mensaje_error = "Formato de correo incorrecto";

    }else if(tipo_verificacion=="numeros"){

        var patron = /^[0-9]+$/;

        mensaje_error = "El campo solo debe contener valores num\xE9ricos";

    }else if(tipo_verificacion=="time"){

        var patron = /^[0-2][0-9]:[0-5][0-9]:[0-5][0-9]$/;

        mensaje_error = "El campo debe contener valores de tiempo en formato HH:mm:ss";

    }else if(tipo_verificacion=="ip"){

        var patron = /^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/;

        mensaje_error = "El campo debe contener valores de tipo IP xxx.xxx.xxx.xxx";

    }else if(tipo_verificacion=="patron_marcacion"){

        var patron = /^([0-9]|X|Z|N|\-|\[|\]|\.)+$/;

        mensaje_error = "El campo solo debe contener valores num\xE9ricos, las letras X, Z o N, los simbolos corchetes, punto y guion.";

    }

    if(campo.value == ""){
        if($(campo).parent().next().is('span')){
            $(campo).parent().next().remove('span');
        }
        
        $(campo).parent().addClass('error-state')
        $(campo).parent().after('<span class="span2 fg-red" style="margin-left: 5px;" >Por favor diligencie el campo</span>');
        
        return "error";

    }else{

        if(!campo.value.match(patron)){

            if($(campo).parent().next().is('span')){
                $(campo).parent().next().remove('span');
            }
            
            $(campo).parent().addClass('error-state')
            $(campo).parent().after('<span class="span2 fg-red" style="margin-left: 5px;" >'+mensaje_error+'</span>');
            
            return "error";

        }else{
            if($(campo).parent().next().is('span')){
                $(campo).parent().next().remove('span');
            }
                    
             $(campo).parent().removeClass("error-state");
            
            return "success";
        }

    }

}