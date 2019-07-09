jQuery.validar = {};

jQuery.validar.isEmpty = function(val) {
    var re = /^\s{1,}$/g; //match any white space including space, tab, form-feed, etc.
    if ((val.length === 0) || (val === null) || ((val.search(re)) > -1)) {
        return true;
    } else {
        return false;
    }
};
// End jQuery.validar.isEmpty

jQuery.validar.isCPF = function(arg) {
    if (arg === '000.000.000-00' || 
        arg === '111.111.111-11' || 
        arg === '222.222.222-22' || 
        arg === '333.333.333-33' || 
        arg === '444.444.444-44' || 
        arg === '555.555.555-55' || 
        arg === '666.666.666-66' || 
        arg === '777.777.777-77' || 
        arg === '888.888.888-88' || 
        arg === '999.999.999-99'){
        
	return false;
        }
    var pri = arg.substring(0, 3);
    var seg = arg.substring(4, 7);
    var ter = arg.substring(8, 11);
    var qua = arg.substring(12, 14);
    var i;
    var numero = (pri + seg + ter + qua);
    var s = numero;
    var c = s.substr(0, 9);
    var dv = s.substr(9, 2);
    var d1 = 0;
    for (i = 0; i < 9; i++)
        d1 += c.charAt(i) * (10 - i);
    var result;
    if (d1 == 0) result = "falso";
    d1 = 11 - (d1 % 11);
    if (d1 > 9) d1 = 0;
    if (dv.charAt(0) != d1) result = "falso";
    d1 *= 2;
    for (i = 0; i < 9; i++) d1 += c.charAt(i) * (11 - i);
    d1 = 11 - (d1 % 11);
    if (d1 > 9) d1 = 0;
    if (dv.charAt(1) != d1) result = "falso";
    return !(result == "falso");
};
// End jQuery.validar.isCPF

jQuery.validar.isCNPJ = function(str) {
    if (!(str = /^\d?(\d{2})\.?(\d{3})\.?(\d{3})\/?(\d{4})\-?(\d{2})/.exec(str))) return false;

    var sum1 = 0,
    sum2 = 0,
    sum3 = 0,
    calc1 = 5,
    calc2 = 6;

    str.shift();
    str = str.join("");

    for (var i = 0; i <= 12; i++) {
        calc1 = (calc1 < 2) ? 9 : calc1;
        calc2 = (calc2 < 2) ? 9 : calc2;

        if (i <= 11) sum1 += str[i] * calc1;

        sum2 += str[i] * calc2;
        sum3 += str[i];
        calc1--;
        calc2--;
    }

    sum1 %= 11;
    sum2 %= 11;

    return (sum3 && str[12] == (sum1 < 2 ? 0 : 11 - sum1) && str[13] == (sum2 < 2 ? 0 : 11 - sum2)) ? str : false;
}
// End jQuery.validar.isCNPJ

jQuery.validar.isEmail = function(str) {
    var apos = str.indexOf("@");
    return !(apos < 1 || str.lastIndexOf(".") - apos < 2 || str.lastIndexOf(".") === str.length-1);
}
// End jQuery.validar.isEmail

jQuery.validar.isSenha = function(str) {
    if(str.length < 6) return false;
    else return true;
}
// End jQuery.validar.isSenha

jQuery.validar.isData = function(str){
    var expReg = /^((0[1-9]|[12]\d)\/(0[1-9]|1[0-2])|30\/(0[13-9]|1[0-2])|31\/(0[13578]|1[02]))\/(19|20)?\d{2}$/;
    var aRet = true;
    if ((str) && (str.match(expReg)) && (str != '')) {
        var dia = str.substring(0,2);
        var mes = str.substring(3,5);
        var ano = str.substring(6,10);
        if ((mes == 4 || mes == 6 || mes == 9 || mes == 11 ) && dia > 30) 
            aRet = false;
        else 
        if ((ano % 4) != 0 && mes == 2 && dia > 28) 
            aRet = false;
        else
        if ((ano%4) == 0 && mes == 2 && dia > 29)
            aRet = false;
    } else 
        aRet = false;  
    return aRet;
};
// End jQuery.validar.isData

jQuery.validar.isDataAtual = function(str){
    var expReg = /^((0[1-9]|[12]\d)\/(0[1-9]|1[0-2])|30\/(0[13-9]|1[0-2])|31\/(0[13578]|1[02]))\/(19|20)?\d{2}$/;
    var aRet = true;
    if ((str) && (str.match(expReg)) && (str != '')) {
        var dia = str.substring(0,2);
        var mes = str.substring(3,5);
        var ano = str.substring(6,10);
        
        var hoje = new Date();
        var diaAt = hoje.getDate();
        mesAt = hoje.getMonth();
        mesAt++;
        anoAt = hoje.getFullYear();
        if(diaAt < 10){
            var diacerto = "0"+diaAt;
        }else{
            var diacerto = diaAt;
        }
        
        if ((mes == 4 || mes == 6 || mes == 9 || mes == 11 ) && dia > 30) 
            aRet = false;
        else 
        if ((ano % 4) != 0 && mes == 2 && dia > 28) 
            aRet = false;
        else
        if ((ano%4) == 0 && mes == 2 && dia > 29)
            aRet = false;
        else
        if (ano > anoAt){
            aRet = false;
        }else if(ano == anoAt){ 
            if(mes > mesAt){
                aRet = false;
            }else if(mes == mesAt){
                if(dia > diacerto){
                    aRet = false;
                }
            }
        }
    } else 
        aRet = false;  
    return aRet;
};
// End jQuery.validar.isDataAtual

jQuery.validar.isNascimento = function(str, anoAtual, idadeMaxima){
    if(jQuery.validar.isData(str)){
        var arr = str.split("/");
        var idade = parseInt(anoAtual) - parseInt(arr[2]);
        
        if(idade <= idadeMaxima && idade > 10)
            return true;
        else
            return false;
    }
    return false;
};
// End jQuery.validar.isNascimento

//jricardoprog ;P
//(function($){
//    $.float = function(val){var _float = parseFloat(val.replace(".", "").replace(",", "."));if(isNaN(_float)) _float=0;return _float;}
//    $.fn.float = function(){return $.float(this.val()) }
//	
//    $.moeda = function(num){x=0;if(num<0){num=Math.abs(num);x=1;}if(isNaN(num))num="0";cents=Math.floor((num*100+0.5)%100);num= Math.floor((num*100+0.5)/100).toString();if(cents<10)cents="0"+cents;for(var i=0;i<Math.floor((num.length-(1+i))/3);i++)num= num.substring(0,num.length-(4*i+3))+'.'+num.substring(num.length-(4*i+3));ret=num+','+cents;if(x===1)ret=' - '+ret;return ret;}
//    $.fn.moeda = function(val){this.val($.moeda(val));return this;}
//})(jQuery);

jQuery.validar.toInt = function(v){
    return v.replace(/\D/g,"");
};

jQuery.validar.isValor = function(val) { // validar="valor" nÃ£o deixa salvar com valor 0,00 
    var re = /^\s{1,}$/g; //match any white space including space, tab, form-feed, etc.
    if ((val.length === 0) || (val === null) || ((val.search(re)) > -1) || (val === "0,00") || val === "R$ 0,00" ) {
        return false;
    } else {
        return true;
    }
};

jQuery.validar.filtro = "[validar=valor], [validar=int], [validar=texto], [validar=email], [validar=cpf], [validar=igual], [validar=cnpj], [validar=nascimento], [validar=data], [validar=dataAtual], [validar=senha], [opcional=email], [opcional=cpf], [opcional=igual], [opcional=cnpj], [opcional=nascimento], [opcional=data], [opcional=senha], [opcional=dataAtual], [opcional=int], [opcional=valor]";

jQuery.validar.marcar = function($elements){
    $elements
    .filter(jQuery.validar.filtro)
    .filter(":visible")
    .each(function() {
        if($(this).attr("validar")){
            $(this).after("<em> *</em>");
        }
    });
};
// End jQuery.validar.marcar

// function factory para o validar.me
jQuery.fn.validar = function(_opts) {
    var opts = $.extend({}, jQuery.fn.validar.options, _opts);
    
    var $elements = this.find("input, select, textarea");
	
    if(opts.marcar){
        jQuery.validar.marcar($elements);
    }
    
    // apply toInt
    $elements
    .filter("[validar=int]")
    .filter(":visible")
    .each(function() {
        $(this).keyup(function(){
            this.value = jQuery.validar.toInt(this.value);
        });
    });
    
    // apply toInt(opcional)
    $elements
    .filter("[opcional=int]")
    .filter(":visible")
    .each(function() {
        $(this).keyup(function(){
            this.value = jQuery.validar.toInt(this.value);
        });
    });
        
    this.submit(function() {
        var $this = $(this);
        return $this.validar.me.call($this, opts);
    });
};
// End jQuery.fn.validar
        
// function que valida o form (this)
jQuery.fn.validar.me = function(o) {
    var r = true;
	
    try {
        r = o.before.call(this);
    } catch (e) {
        //alert(e);
        r = false;
    }
	
    try {
        var $form = this;
        this.find("input, select, textarea")
        .filter(jQuery.validar.filtro)
        //.filter(":visible")
        .each(function() {
        		
            var $this = jQuery(this),
            val = jQuery.trim($this.val()),
            label = '',
            req = $this.attr("validar"),
            opc = $this.attr("opcional");
			
            if (typeof jQuery("label[for=" + $this.attr("id").replace("[]", "") + "]")[0] === "object") {
                label = jQuery.trim($form.find("label[for=" + $this.attr("id").replace("[]", "") + "]").text());
            } else {
                label = jQuery.trim($this.attr("label"));
            }
	
            try {
                if (r) {
                    if(req){
                        if (jQuery.validar.isEmpty(val) || $this.val() === $this.attr('holder')) {
                            throw "Por favor, preencha o campo " + label + ".";
                        }
                    }
					
                    if(opc || req){
                        /*OPCIONAL ERA TRANFORMADO EM REQUIRED TAMBÃ‰M. NOVA FORMA: SE O CAMPO NAO ESTIVER VAZIO VALIDA, SENÃƒO DEIXA*/
                        //req = opc || req;
				
                        //console.log(req);
			if (req === "valor") {
                            if (!jQuery.validar.isValor(val)) {
                                throw "Por favor, preencha corretamente o campo " + label + ".";
                            }
                        } else if (req === "email") {
                            if (!jQuery.validar.isEmail(val)) {
                                throw "Por favor, preencha corretamente o campo " + label + ".";
                            }
                        } else if (req === "cpf") {
                            if (!jQuery.validar.isCPF(val)) {
                                throw "Por favor, preencha corretamente o campo " + label + ".";
                            }
                        } else if (req === "cnpj") {
                            if (!jQuery.validar.isCNPJ(val)) {
                                throw "Por favor, preencha corretamente o campo " + label + ".";
                            }
                        } else if (req === "igual") {
                            if (val !== jQuery($this.attr("validarIgual")).val()) {
                                throw "Por favor, preencha corretamente o campo " + label + ".";
                            }
                        }else if (req === "data"){
                            if (!jQuery.validar.isData(val)) {
                                throw "Por favor, preencha corretamente o campo " + label + ".";
                            }
                        }else if (req === "dataAtual"){
                            if (!jQuery.validar.isDataAtual(val)) {
                                throw "Por favor, preencha corretamente o campo " + label + ".";
                            }
                        }else if (req === "nascimento") {
                            if (!jQuery.validar.isNascimento(val, jQuery.fn.validar.options.anoAtual, jQuery.fn.validar.options.idadeMaxima)) {
                                throw "Por favor, preencha corretamente o campo " + label + ".";
                            }
                        }else if (req === "senha") {
                            if (!jQuery.validar.isSenha(val)) {
                                throw "O campo " + label + " deve ter pelo menos 6 caracteres.";
                            }
                        }else if (opc === "data"){
                            if(val !== ""){
                                if (!jQuery.validar.isData(val)) {
                                    throw "Por favor, preencha corretamente o campo " + label + ".";
                                }
                            }
                        }else if (opc === "dataAtual"){
                            if(val !== ""){
                                if (!jQuery.validar.isDataAtual(val)) {
                                    throw "Por favor, preencha corretamente o campo " + label + ".";
                                }
                            }
                        }else if (opc === "nascimento"){
                            if(val !== ""){
                                if (!jQuery.validar.isNascimento(val)) {
                                    throw "Por favor, preencha corretamente o campo " + label + ".";
                                }
                            }
                        }else if (opc === "senha"){
                            if(val !== ""){
                                if (!jQuery.validar.isSenha(val)) {
                                    throw "O campo " + label + " deve ter pelo menos 6 caracteres.";
                                }
                            }
                        }else if (opc === "email"){
                            if(val !== ""){
                                if (!jQuery.validar.isEmail(val)) {
                                    throw "Por favor, preencha corretamente o campo " + label + ".";
                                }
                            }
                        }else if (opc === "cpf"){
                            if(val !== ""){
                                if (!jQuery.validar.isCPF(val)) {
                                    throw "Por favor, preencha corretamente o campo " + label + ".";
                                }
                            }
                        }else if (opc === "cnpj"){
                            if(val !== ""){
                                if (!jQuery.validar.isCNPJ(val)) {
                                    throw "Por favor, preencha corretamente o campo " + label + ".";
                                }
                            }
                        }
                    }
                    $this.removeClass(jQuery.fn.validar.options.classErro).addClass(jQuery.fn.validar.options.classSucesso);
                }
            } catch (e) {
                r = false;
	                    	
                $this.removeClass(jQuery.fn.validar.options.classSucesso).addClass(jQuery.fn.validar.options.classErro);
	                          
                if($("#alertaErro").length){
                    $("#alertaErro").remove();
                }
                
//                alerta = document.createElement("div");
//                
//                alerta.setAttribute("id", "alertaErro");
//                
//                alerta.setAttribute("name", "alertaErro");
//                
//                alerta.setAttribute("class", "alertaErro");
//                
//                alerta.setAttribute("style", "color: red;");
//                
//                alerta.innerHTML = e;
                
                alerta = document.createElement("label");
                
                alerta.setAttribute("id", "alertaErro");
                
                alerta.setAttribute("class", "control-label");
                
                alerta.setAttribute("style", "color: red;");
                
                alerta.innerHTML = "<i class='fa fa-times-circle-o'></i> "+e;
                
                $this.after(alerta);
                alerta.parentNode.parentNode.setAttribute("class", "form-group has-error");
                
                setTimeout(function(){
                    $("#alertaErro").remove();
                }, 4000);

                //o.alert(e);
                setTimeout(function() {
                    var el_foco_ui = document.getElementById("#"+$this.attr('id')+"-button");
                    if(el_foco_ui) {
                        $(el_foco_ui).focus();
                    }else{
                        $this.focus();
                    }
                }, 10);
            }
        });
                
    } catch (e) {
        alert(e);
        r = false;
    }

    if (r && typeof o.after === "function") {
        try {
            r = o.after.call(this);
        } catch (e) {
            alert(e);
            r = false;
        }
    }
    
    if(r){
        $("#salvar").hide();
        $("#preload-container").css("top", "0");
    }
    
    return r;
};
// End jQuery.fn.validar.me
        
// options defaults
jQuery.fn.validar.options = {
    "before": function(){
        return true;
    },
    "after": function(){
        return true;
    },
    "alert": function(message){
        alert(message);
    },
    "marcar": true,
    "anoAtual": 2014,
    "idadeMaxima": 130,
    "classSucesso": "validar-sucesso",
    "classErro": "validar-erro"
};
// End jQuery.fn.validar.options