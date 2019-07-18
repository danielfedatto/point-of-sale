$(document).ready(function() {
    $(".fone").mask("(99)9999-9999?9");

    $("#salvarNews").click(function(event) {
        event.preventDefault();
        $("#newsLetter").submit();
    });

    $("#newsLetter").validar({
        "after": function() {
            $("#enviandoNews").show();
            $.post(URLBASE + 'contatos/news', this.serialize(), function(data) {
                if (data.ok) {
                    alert('Obrigado por realizar seu cadastro! \nReceberá nossas novidades em breve...');
                    $('#NEW_EMAIL').val('');
                } else {
                    alert('Ops! Não conseguimos receber seu cadastro... \nTente novamente mais tarde!');
                }
                $("#enviandoNews").hide();
            }, 'json');
            return false;
        },
        "marcar": false
    });

    /*SALVAR CAMPOS*/
    $("#salvarContato").click(function(event) {
        event.preventDefault();
        $("#formContato").submit();
    });

    $("#formContato").validar({
        "after": function() {
            $("#enviando").show();
            $.post(URLBASE + 'contatos/enviar', this.serialize(), function(data) {
                if (data.ok) {
                    $('#enviando').html('<h5>Obrigado por entrar em contato! <br/>Retornaremos em breve...<h5>');
                } else {
                    $('#enviando').html('<h5>Ops! N&atilde;o conseguimos receber seu contato... <br/>Tente novamente mais tarde!</h5>');
                }    
            }, 'json');
            return false;
        },
        "marcar": false
    });
});

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

function mask(o, f) {
    setTimeout(function () {
        var v = f(o.value);
        if (v != o.value) {
            o.value = v;
        }
    }, 1);
}
