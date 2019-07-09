$(document).ready(function() {
    $(".fone").mask("(99)9999-9999?9");
    $(".uf").mask("aa");
    $(".cep").mask("99999-999");
    $(".cpf").mask("999.999.999-99");
    $(".cnpj").mask("99.999.999/9999-99");
    $(".ie").mask("999.999.999.999");
    $(".rg").mask("9999999999");
    $(".data").mask("99/99/9999");
    $(".hora").mask("99:99");
    $(".valor").maskMoney({
        decimal: ",",
        thousands: "."
    });

    //Initialize Select2 Elements
    $(".select2").select2();

    //DATEPICKER
    $(".data").datepicker({
        format: 'dd/mm/yyyy',                
        language: 'pt-BR'
    });
//    $(".data").datepicker({
//        dateFormat: 'dd/mm/yy',
//        changeMonth: true,
//        changeYear: true,
//        dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
//        dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
//        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
//        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
//        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
//        nextText: 'Próximo',
//        prevText: 'Anterior'
//    });
    
    $('#lista-icones :checked').parent().addClass('checked');

    $('#lista-icones').delegate('span', 'click', function(){
      $('#lista-icones .checked').removeClass('checked');
      $(this).prev().click().parent().addClass('checked');
    });

    /*LIMPAR CAMPOS EDIT*/
    $("#limpa").click(function(event) {
        event.preventDefault();
        document.formEdit.reset();
    });

    /*SALVAR CAMPOS*/
    $("#salvar").click(function(event) {
        event.preventDefault();
        $("#formEdit").submit();
    });

    $("#formEdit").validar({
        "marcar": false
    });

    $("#formFotos").validar({
        "marcar": false
    });

    $("#formLogin").validar({
        "after": function() {
            $.post(URLBASE + 'login/login', this.serialize(), function(data) {
                if (data.ok) {
                    location.href = URLBASE + 'index';
                } else {
                    alert('Login ou senha não conferem, tente novamente!!');
                    document.formLogin.reset();
                }
            }, 'json');
            return false;
        },
        "marcar": false
    });

    /*LIMPAR CAMPOS LOGIN*/
    $("#limpaLog").click(function(event) {
        event.preventDefault();
        document.formLogin.reset();
    });

    /*ENTRAR LOGIN*/
    $("#entrar").click(function(event) {
        event.preventDefault();
        $("#formLogin").submit();
    });
});

//FUNCAO PARA FAVORITAR OS MODULOS
function favoritar(id) {
    $.get(URLBASE + 'ajax/favoritar/' + id, true, function(data) {
        if (data.ok) {
            if (data.ok == "S") {
                $("#fav_" + id).addClass("fav");
            } else {
                $("#fav_" + id).removeClass("fav");
            }
        } else {
            alert('Ooops, houve algum problema!!');
        }
    }, 'json');
}

//FUNÇÃO QUE SELECIONA OU DESMARCA TODOS ITENS DO LST
function selecionar(value) {
    if (value) {
        $(".seleciona").attr("checked", true);
    } else {
        $(".seleciona").attr("checked", false);
    }
}

//FUNCAO PARA EXCLUIR TODOS MARCADOS
function excluirTodos(modulo) {
    var form = '<form id="excluiMarcados" name="excluiMarcados" method="post" action="' + URLBASE + modulo + '/excluirTodos">';
    $(".seleciona").each(function() {
        if ($(this).attr("valor") > 0 && $(this).attr("checked")) {
            form += '<input type="hidden" name="item[]" value="' + $(this).attr("valor") + '">';
        }
    })
    form += '</form>';

    $("#formExc").html(form);

    $("#excluiMarcados").submit();
}

/*FUNCOES DE CLIENTE*/
//FUNCAO QUE TROCA CLIENTE FISICO/JURIDICO
function tipoPessoa(tipo, cliente) {
    $.get(URLBASE + 'clientes/tipopessoa/' + tipo + '/' + cliente, true, function(data) {
        if (data.ok) {
            $("#tipoPessoa").html(data.ok);

            if (tipo == "F") {
                $(".fone").mask("(99)9999-9999?9");
                $(".cpf").mask("999.999.999-99");
                $(".rg").mask("9999999999");
                $(".data").mask("99/99/9999");

                $("#verificaCpf").validar({
                    "after": function() {
                        $.post(URLBASE + 'clientes/verifica', this.serialize(), function(data) {
                            if (data.result == false) {
                                alert("Esse CPF já está cadastrado!");
                                $("#CLI_CPF").val("");
                                $(this).focus();
                            }
                            $("#cpfLoading").css("display", "none");
                        }, 'json');
                        return false;
                    }
                });

                $("#CLI_CPF").change(function() {
                    $("#cpfLoading").css("display", "inline-block");
                    $("#cpfV").val($(this).val());
                    $("#verificaCpf").submit();
                });
            } else {
                $(".fone").mask("(99)9999-9999?9");
                $(".cnpj").mask("99.999.999/9999-99");
                $(".ie").mask("999.999.999.999");

                $("#verificaCnpj").validar({
                    "after": function() {
                        $.post(URLBASE + 'clientes/verifica', this.serialize(), function(data) {
                            if (data.result == false) {
                                alert("Esse CNPJ já está cadastrado!");
                                $("#CLI_CNPJ").val("");
                                $(this).focus();
                            }
                            $("#cnpjLoading").css("display", "none");
                        }, 'json');
                        return false;
                    }
                });

                $("#CLI_CNPJ").change(function() {
                    $("#cnpjLoading").css("display", "inline-block");
                    $("#cnpjV").val($(this).val());
                    $("#verificaCnpj").submit();
                });
            }

            $(".loading").css("display", "none");
        } else {
            alert('Ooops, houve algum problema!!');
        }
    }, 'json');
}

$(document).ready(function() {
    //CHECA SE EMAIL EXISTE
    $("#verificaEmail").validar({
        "after": function() {
            $.post(URLBASE + 'clientes/verifica', this.serialize(), function(data) {
                if (data.result == false) {
                    alert("Esse Email já está cadastrado!");
                    $("#CLI_EMAIL").val("");
                    $(this).focus();
                }
                $("#emailLoading").css("display", "none");
            }, 'json');
            return false;
        }
    });

    $("#CLI_EMAIL").change(function() {
        $("#emailLoading").css("display", "inline-block");
        $("#emailV").val($(this).val());
        $("#verificaEmail").submit();
    });
});

//CHECA O CEP E TRAZ O ENDEREÇO
function carregaDados(_this, pre) {
    if ($(_this).val().length == 9) {
        $("#cepLoading").css("display", "block");
        cep = $(_this).val();
        cep = cep.replace("-", "");
        $.get(URLBASE + "ajax/cep/" + cep, true, function(data) {
            $("#cepLoading").css("display", "none");

            if (data.ok.cidade != "") {
                //$("#CLI_CIDADE").val(data.ok.cidade);
                //$("#CLI_ESTADO").val(data.ok.uf);
                $("#" + pre + "_ENDERECO").val(data.ok.logradouro);
                $("#" + pre + "_BAIRRO").val(data.ok.bairro);

                if (data.est > 0 && data.cid > 0) {
                    $("#EST_ID").val(data.est);
                    trocaEstado(data.est, data.cid);
                }
            } else {
                alert("CEP não encontrado!!");
                $("#" + pre + "_CEP").val("");
            }
        }, 'json');
    }
}

//TRAZ OS MENUS QUANDO DIGITA NA BUSCA
function buscamenu(digitado) {
    $.post(URLBASE + "ajax/buscamenu/", {digitado: digitado}, function(data) {
        if (data.ok) {
            $(".sidebar-menu").html(data.menu);
        }
    }, 'json');
}

//TRAZ AS CIDADES QUANDO TROCA O ESTADO
function trocaEstado(uf, cidade) {
    $.get(URLBASE + "ajax/trocaestado/" + uf + "/" + cidade, true, function(data) {
        if (data.ok) {
            $("#cidades").html(data.ok);
            //Initialize Select2 Elements
            $(".select2").select2();
        } else {
            alert("Houve um Problema!!");
        }
    }, 'json');
}
/*FIM FUNCOES DE CLIENTE*/

//VERIFICA O 9 DIGITO DO TELEFONE
function verificaTelefone(puti){
    valor = $(puti).val();
    valor = valor.replace('_', '');
    //console.log(valor);
    if(valor.length > 13){
        //console.log(14);
        $(puti).mask('(99)99999-9999');
    }else{
        //console.log(13);
        $(puti).mask('(99)9999-9999?9');
    }
}

function ordenar(valor, sentido){
    $("#ordem").val(valor);
    $("#sentido").val(sentido);
    $('#formBusca').submit();
}

//NUMBER FORMAT PARA JS
function number_format( number, decimals, dec_point, thousands_sep ) {
    var n = number, prec = decimals;
    n = !isFinite(+n) ? 0 : +n;
    prec = !isFinite(+prec) ? 0 : Math.abs(prec);
    var sep = (typeof thousands_sep == "undefined") ? ',' : thousands_sep;
    var dec = (typeof dec_point == "undefined") ? '.' : dec_point;

    var s = (prec > 0) ? n.toFixed(prec) : Math.round(n).toFixed(prec); //fix for IE parseFloat(0.55).toFixed(0) = 0;

    var abs = Math.abs(n).toFixed(prec);
    var _, i;

    if (abs >= 1000) {
        _ = abs.split(/\D/);
        i = _[0].length % 3 || 3;

        _[0] = s.slice(0,i + (n < 0)) +
              _[0].slice(i).replace(/(\d{3})/g, sep+'$1');

        s = _.join(dec);
    } else {
        s = s.replace('.', dec);
    }

    return s;
}

//function online(){
//    $.post(URLBASE + 'online.php', true,
//        function (data) {
//            if(data.ausente){
//                var html = '<i class="fa fa-circle text-warning"></i> Ausente';
//                $(".user-panel .info a").html(html);
//            }
//            
//        }, 'json');
//}
//setInterval("online()", 3000); //A função é executada UMA VEZ A CADA três segundos