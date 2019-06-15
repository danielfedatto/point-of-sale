// Função Autoplay dos banners
autoplay()   
function autoplay() {
    $('.carousel').carousel('next');
    setTimeout(autoplay, 5500);
}
var scroller = new SweetScroll({
	header: '#desk-nav',
});
var enviaFormularioContato = function(token) {
    $("#form_contato").submit();
    var espera = setTimeout(function(){
        grecaptcha.reset();
    }, 3000);
}
var enviaFormularioTrabalheConosco = function(token) {
    $("#form_trabalheconosco").submit();
    var espera = setTimeout(function(){
        grecaptcha.reset();
    }, 3000);
}
var enviaFormularioNewsletter = function(token) {
    $("#form_newsletter").submit();
    var espera = setTimeout(function(){
        grecaptcha.reset();
    }, 3000);
}
$(document).ready(function(){
	// Altera a cor do menu do topo ao rolar a tela
	$('.sidenav').sidenav({
		draggable: true,
	});
	$('.sidenav').sidenav({
		draggable: true,
	});
	$('.modal').modal();
	$('select').formSelect();
	$('input#input_text, textarea#textarea2').characterCounter();
	$('.carousel.carousel-slider').carousel({
		dist: 0,
		padding: 0,
		fullWidth: true,
		indicators: true,
	});
	$(".data").mask("99/99/9999");
    $(".mesano").mask("99/9999");
    $(".cpf").mask("999.999.999-99");
    $(".cnpj").mask("99.999.999/9999-99");
    $(".fone").mask("(99)9999-9999?9");
    $(".uf").mask("aa");
    $(".cartaocredito").mask("9999 9999 9999 9999");
    $(".cep").mask("99999-999");
    $("#enviaContato").click(function(event) {
        event.preventDefault();
        // $("#form_contato").submit();
    });
    $("#enviaTrabalheConosco").click(function(event) {
        event.preventDefault();
        // $("#form_trabalheconosco").submit();
    });
    $("#enviaNewsletter").click(function(event) {
        event.preventDefault();
        // $("#form_newsletter").submit();
    });
	$("#form_contato").validar({
        "marcar": false,
        "after": function() {
            $("#envies").show('slow');
            $.post(URLBASE + 'contato/enviar', this.serialize(), function(data) {
                if (data.ok) {
                    $("#envies p").html("Contato enviado com sucesso!");
                    document.form_contato.reset();
                } else {
                    $("#envies p").html(data.msg);
                }
                setTimeout(function(){
                    $("#envies p").html("Enviando");
                    $("#envies").hide("slow");
                    grecaptcha.reset();
                }, 4000);
            }, 'json');
            return false;
        }
    });

    $("#form_trabalheconosco").validar({
        "marcar": false,    
        "after": function() {
            var formData = new FormData(this[0]);
            $("#envies").show('slow');
            $.ajax({
                url: URLBASE + 'trabalheconosco/enviar', 
                type: 'POST',
                dataType: 'json',
                processData: false,
                contentType: false,
                data: formData
                ,success: function(data) {
                    if (data.ok) {
                        $("#envies p").html(data.msg);
                        document.form_trabalheconosco.reset();                    
                    } else {
                        $("#envies p").html(data.msg);
                    }
                    setTimeout(function(){
                        $("#envies p").html("Enviando");
                        $("#envies").hide("slow");
                        grecaptcha.reset();
                    }, 3000);
                },
                error: function(data) {
                    console.log(data);
                }
            });
            return false;
        },"marcar": false
    });

    $("#form_newsletter").validar({
        "marcar": false,
        "after": function() {
            $("#envies").show('slow');
            $.post(URLBASE + 'newsletter/enviar', this.serialize(), function(data) {
                if (data.ok) {
                    $("#envies p").html(data.msg);
                    document.form_newsletter.reset();
                } else {
                    $("#envies p").html(data.msg);
                }
                setTimeout(function(){
                    $("#envies p").html("Enviando");
                    $("#envies").hide("slow");
                    grecaptcha.reset();
                }, 4000);
            }, 'json');
            return false;
        }
	});

	$('#fCurriculo').on( 'change', function() {
        myfile= $(this).val();
        var ext = myfile.split('.').pop();
        if(ext=="pdf" || ext=="docx" || ext=="doc" || ext==""){
            // Certo
        } else{
            alert("O formato '." + ext + "' não é valido.\nSelecione um arquivo do tipo .doc, .docx ou .pdf e tente novamente.");
            $(this).val('');
        }
    });
	
});
