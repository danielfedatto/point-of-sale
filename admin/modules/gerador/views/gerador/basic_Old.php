<!--SCRIPTS - ARRUMAR OS CAMINHOS--
<!--JQUERY--
<script src="<?php echo url::base() ?>js/jquery-1.10.2.min.js" type="text/javascript"></script>

<!--VALIDAR--
<script src="<?php echo url::base() ?>extras/1.3.4.js" type="text/javascript"></script>

<!--FANCYBOX--
<script src="<?php echo url::base() ?>extras/jquery.fancybox-1.3.1.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo url::base() ?>extras/jquery.fancybox-1.3.1.min.css" type="text/css" media="" />
<!--FIM SCRIPTS-->

<div id="interno">
    <h1>Gerar CRUD</h1>

    <p><a href="#instrucoes" id="abreInstrucao" >Instruções de Uso</a></p>

    <p>Para gerar o CRUD, informe os campos abaixo:</p>

    <form class="padrao" id="form_cadastro" name="form_cadastro" method="post">
        <fieldset>
            <legend>Módulo</legend>
            <div class="item-form hases">
                <label for="fTabela">Tabela</label>
                <input type="text" id="fTabela" name="fTabela" validar="texto" />

                <label for="fHas">Has</label>
                <input type="text" id="fHas" name="fHas[]" />

                <img src="<?php echo url::base(); ?>images/bt_mais.png" class="mais" onclick="maisHas()" />
                <img src="<?php echo url::base(); ?>images/bt_menos.png" class="menos" onclick="menosHas()" />
            </div>
        </fieldset>

        <fieldset>
            <legend>Campos</legend>
            <div class="item-form campos">
                <label for="fCampo">Campo</label>
                <input type="text" id="fCampo" name="fCampo[]" value="ID" />
                <label for="fTipo">Tipo</label>
                <select id="fTipo" name="fTipo[]" onchange="setTamanho(this)">
                    <option value="VARCHAR">String</option>
                    <option value="PASSWORD">Senha</option>
                    <option value="TEXT">Texto</option>
                    <option value="INT" selected>Inteiro</option>
                    <option value="DECIMAL">Valores (ex: 39,67)</option>
                    <option value="DATE">Data</option>
                    <option value="TIME">Hora</option>
                    <option value="TIMESTAMP">Data e Hora</option>
                    <option value="SET">Conjunto (ex: Sim ou Não)</option>
                    <option value="IMAGEM">Imagem</option>
                    <option value="ARQUIVO">Arquivo (ex: DOC ou PDF)</option>
                </select>
                <label for="fTamanho">Tamanho</label>
                <input type="text" class="pno" id="fTamanho" name="fTamanho[]" value="11" />
                <label for="fDefault">Default</label>
                <input type="text" id="fDefault" name="fDefault[]" value="" />
                <label for="fPrimaria">Primária</label>
                <select id="fPrimaria" name="fPrimaria[]" style='width: 60px;' >
                    <option value="S" selected>Sim</option>
                    <option value="N">Não</option>
                </select>
                <label for="fAuto">Auto</label>
                <select id="fAuto" name="fAuto[]" style='width: 60px;' >
                    <option value="S" selected>Sim</option>
                    <option value="N">Não</option>
                </select>
                <label for="fRef">Ref</label>
                <input type="text" id="fRef" name="fRef[]" value="" />
                <label for="fPesquisar">Pesquisar</label>
                <select id="fPesquisar" name="fPesquisar[]" style='width: 60px;' >
                    <option value="S">Sim</option>
                    <option value="N" selected>Não</option>
                </select>
                <label for="fReq">Required</label>
                <select id="fReq" name="fReq[]" style='width: 60px;' >
                    <option value="S" selected>Sim</option>
                    <option value="N">Não</option>
                </select>

                <img src="<?php echo url::base(); ?>images/bt_mais.png" class="mais" onclick="maisCampo()" />
                <img src="<?php echo url::base(); ?>images/bt_menos.png" class="menos" onclick="menosCampo()" />
            </div>
        </fieldset>

        <button type="submit" id="cadastrar">Enviar</button>
        <button type="reset" id="limpar">Limpar</button>
    </form>
    <div id="envies" style="color: red; display: none;">Aguarde...</div>
</div>

<script type="text/javascript">
    //TOTAL DE CAMPOS
    var total = 1;
    var totalHas = 1;

    //CAMPO NOVO
    var campo = '<div class="item-form campos" >' +
            '<label for="fCampo">Campo</label>' +
            '<input type="text" id="fCampo" name="fCampo[]" value="" />' +
            '<label for="fTipo">Tipo</label>' +
            '<select id="fTipo" name="fTipo[]" onchange="setTamanho(this)">' +
            '<option value="VARCHAR" selected>String</option>' +
            '<option value="PASSWORD">Senha</option>' +
            '<option value="TEXT">Texto</option>' +
            '<option value="INT">Inteiro</option>' +
            '<option value="DECIMAL">Valores (ex: 39,67)</option>' +
            '<option value="DATE">Data</option>' +
            '<option value="TIME">Hora</option>' +
            '<option value="TIMESTAMP">Data e Hora</option>' +
            '<option value="SET">Conjunto (ex: Sim ou Não)</option>' +
            '<option value="IMAGEM">Imagem</option>' +
            '<option value="ARQUIVO">Arquivo (ex: DOC ou PDF)</option>' +
            '</select>' +
            '<label for="fTamanho">Tamanho</label>' +
            '<input type="text" class="pno" id="fTamanho" name="fTamanho[]" value="" />' +
            '<label for="fDefault">Default</label>' +
            '<input type="text" id="fDefault" name="fDefault[]" value="" />' +
            '<label for="fPrimaria">Primária</label>' +
            '<select id="fPrimaria" name="fPrimaria[]" style="width: 60px;" >' +
            '<option value="S">Sim</option>' +
            '<option value="N" selected>Não</option>' +
            '</select>' +
            '<label for="fAuto">Auto</label>' +
            '<select id="fAuto" name="fAuto[]" style="width: 60px;" >' +
            '<option value="S">Sim</option>' +
            '<option value="N" selected>Não</option>' +
            '</select>' +
            '<label for="fRef">Ref</label>' +
            '<input type="text" id="fRef" name="fRef[]" value="" />' +
            '<label for="fPesquisar">Pesquisar</label>' +
            '<select id="fPesquisar" name="fPesquisar[]" style="width: 60px;" >' +
            '<option value="S">Sim</option>' +
            '<option value="N" selected>Não</option>' +
            '</select>' +
            '<label for="fReq">Required</label>' +
            '<select id="fReq" name="fReq[]" style="width: 60px;" >' +
            '<option value="S" selected>Sim</option>' +
            '<option value="N">Não</option>' +
            '</select>' +
            '</div>';

    //NOVO HAS
    var Has = '<div class="item-form hases">' +
            '<span>&nbsp;</span>' +
            '<span>&nbsp;</span>' +
            '<label for="fHas">Has</label>' +
            '<input type="text" id="fHas" name="fHas[]" />' +
            '</div>';

    function maisCampo() {
        $(".campos").last().after(campo);
        total++;
    }

    function menosCampo() {
        if (total > 1) {
            $(".campos").last().remove();
            total--;
        }
    }

    function maisHas() {
        $(".hases").last().after(Has);
        totalHas++;
    }

    function menosHas() {
        if (totalHas > 1) {
            $(".hases").last().remove();
            totalHas--;
        }
    }

    function setTamanho(put) {
        var list = put.parentNode;
        if (list.children) {
            var child = list.children[5];

            //SETA O VALOR DEFAULT COMO VAZIO
            list.children[7].value = "";

            //SETA O VALOR PRIMARIO COMO "NAO"
            list.children[9].value = "N";

            //SETA O VALOR AUTO INCREMENT COMO "NAO"
            list.children[11].value = "N";

            switch (put.value) {
                case "VARCHAR":
                    child.value = 100;
                    break;
                case "PASSWORD":
                    child.value = 32;
                    break;
                case "INT":
                    child.value = 11;
                    //SETA O VALOR DEFAULT COMO 0
                    list.children[7].value = 0;
                    break;
                case "DECIMAL":
                    child.value = "10,2";
                    //SETA O VALOR DEFAULT COMO 0
                    list.children[7].value = 0;
                    break;
                case "DATE":
                    //SETA O VALOR DEFAULT COMO 0
                    list.children[7].value = '';
                    break;
                case "TIME":
                    //SETA O VALOR DEFAULT COMO 0
                    list.children[7].value = '00:00';
                    break;
                case "TIMESTAMP":
                    child.value = '';

                    //SETA O VALOR DEFAULT COMO CURRENT
                    list.children[7].value = 'CURRENT_TIMESTAMP';
                    break;
                case "SET":
                    child.value = "Sim,Não";

                    //SETA O VALOR DEFAULT COMO 0
                    list.children[7].value = 'Sim';

                    //SETA A PESQUISA COMO BLOQUEADA
                    list.children[15].value = 'N';
                    break;
                case "IMAGEM":
                    //SETA A PESQUISA COMO BLOQUEADA
                    list.children[15].value = 'N';
                    child.value = "";
                    break;
                case "ARQUIVO":
                    //SETA A PESQUISA COMO BLOQUEADA
                    list.children[15].value = 'N';
                    child.value = "";
                    break;
                default:
                    child.value = "";
                    break;
            }
        }
    }
</script>

<div id="instrucoes">
    <ul>
        <li>Tabela: Nome do Módulo a ser criado. (Ex: Produtos, telefone filiais, Categorias Notícias).</li>
        <li>Has: Define que esse Módulo vai se relacionar com outro Módulo (has_many, has_one). Seu valor deve ser o nome da referida tabela.</li>
        <li>Campo: Nome do campo do Módulo. (Ex: Título, texto, imagem, Data Cadastro). Caso seja uma chave estrangeira, deve ser um Tipo Inteiro, de preferência 
            "ID".</li>
        <li>Tipo: Tipo do campo do Módulo. (Ex: Inteiro, data, arquivo). Se tipo for "Senha", não adicione o "Confirmar Senha".</li>
        <li>Tamanho: Tamanho limite do campo do Módulo. Em alguns casos não é necessário (Ex: Tipo "Texto").
            Caso o Tipo seja "Conjunto", devem-se colocar os possíveis valores do mesmo (Ex: Sim,Não).</li>
        <li>Default: Valor padrão do campo. Caso seja uma chave estrangeira, seu valor deve ser o campo que nomeia a referida tabela (Ex: titulo, nome).</li>
        <li>Primária: Define que o campo será uma chave primária. Deve ser um Tipo Inteiro, de preferência "ID".</li>
        <li>Auto: Define que o campo será "Auto Increment". Normalmente utilizado em chaves primárias.</li>
        <li>Ref: Define que o campo será o elemento de relação com outro Módulo (chave estrangeira, belongs_to). Seu valor deve ser o nome da referida tabela.</li>
        <li>Pesquisar: Define se esse campo será incluso na busca do módulo, bem como na listagem.</li>
        <li>Required: Define que esse campo será obrigatório, e adicionado nas rules do Model.</li>
    </ul>
</div>

<script type="text/javascript">

    $(document).ready(function() {
        $("#instrucoes").hide();

        $("#abreInstrucao").fancybox({
            onClosed: function() {
                $("#instrucoes").hide();
            },
            onStart: function() {
                $("#instrucoes").show();
            }
        });

        $("#instrucoes").fancybox();

    });
</script>

<!--STYLE-->
<style>
    #meio #main{
        margin: 0;
        width: 80%;
        overflow-x: hidden;
    }

    #topo{
        width: 100%;
        height: 100px;
        /* Para Mozilla/Gecko (Firefox etc) */
        background: -moz-linear-gradient(top, #DDDDDD, #000000) repeat-X;

        /* Para WebKit (Safari, Google Chrome etc) */
        background: -webkit-gradient(linear, left top, left bottom, from(#DDDDDD), to(#000000)) repeat-X;
        text-align: center;
        line-height: 100px;
        font-size: 18px;
        color: white;
        font-weight: bold;
    }

    #meio{

    }

    #meio #menu{
        width: 100%;
        overflow: auto;
        margin: 0;
        padding: 0;
    }

    #meio #menu li{
        float: left;
        list-style: none;
        border: 2px solid gray;
        border-top: 0;
        padding: 10px;
    }

    #meio #menu li+li{
        margin-left: 5px;
    }

    #meio #menu li a{
        text-decoration: none;
        cursor: pointer;
    }

    #meio #bemvindo{
        margin: 10px 0 0 10px;
    }

    #meio #interno{
        padding: 10px;
    }

    #rodape{
        width: 100%;
        height: 70px;
        /* Para Mozilla/Gecko (Firefox etc) */
        background: -moz-linear-gradient(top, #000000, #DDDDDD) repeat-X;

        /* Para WebKit (Safari, Google Chrome etc) */
        background: -webkit-gradient(linear, left top, left bottom, from(#000000), to(#DDDDDD)) repeat-X;
        text-align: center;
        line-height: 70px;
        font-size: 12px;
        color: white;
        font-weight: bold;
    }

    /*FORMULARIOS*/
    form.padrao {
        zoom: 1;
        margin: auto;
    }
    form.padrao:before,
    form.padrao:after {
        display: table;
        content: "";
    }
    form.padrao:after {
        clear: both;
    }
    form.padrao .item-form {
        zoom: 1;
        position: relative;
        margin-bottom: 12px;
        padding: 0 !important;
        width: 100%;
    }
    form.padrao .item-form:before,
    form.padrao .item-form:after {
        display: table;
        content: "";
    }
    form.padrao .item-form:after {
        clear: both;
    }
    form.padrao label, form.padrao span {
        /*clear: left;*/
        display: block;
        float: left !important;
        line-height: 24px;
        margin-right: 5px;
        text-align: right;
        width: 75px !important;
        clear: none !important;
    }
    form.padrao label:after {
        content: ':';
    }
    form.padrao input,
    form.padrao textarea,
    form.padrao select {

    }
    form.padrao .pno{
        width: 50px;
    }
    form.padrao input {
        line-height: 20px;
    }
    form.padrao textarea {
        height: 120px;
        resize: none;
    }
    form.padrao em {
        color: #f00;
        display: block;
        float: left;
    }
    form.padrao p.legenda {
        clear: left;
        color: #767676;
        float: left;
        font-size: 11px !important;
        margin-left: 105px;
    }
    form.padrao button {
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        background-color: #d5a412;
        background-image: -moz-linear-gradient(top, #DBDBDB, #000000);
        background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#DBDBDB), to(#000000));
        background-repeat: repeat-x;
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#DBDBDB', endColorstr='#000000', GradientType=0);
        border: 1px solid #73580a;
        color: #ffffff;
        float: right;
        font: bold 10px Arial, Helvetica, Verdana, sans-serif;
        margin-right: 5px;
        padding: 4px 10px;
        text-align: center;
        text-transform: uppercase;
    }
    form.padrao button:hover {
        background: #000000;
    }
    form.padrao .alertaErro {
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        background: rgba(0, 0, 0, 0.7);
        color: #ffffff;
        font: bold 10px/22px Arial, Helvetica, Verdana, sans-serif;
        padding: 0 10px;
        position: absolute;
        top: -15px;
        left: 22%;
        white-space: nowrap;
        z-index: 20;
    }
    form.padrao .alertaErro:before {
        border-left: 7px solid transparent;
        border-right: 7px solid transparent;
        border-top: 7px solid rgba(0, 0, 0, 0.7);
        content: '';
        display: block;
        position: absolute;
        top: 22px;
        left: 15px;
        width: 0;
        height: 0;
    }
    form.padrao .validar-erro {
        border-color: #ed1c24 !important;
    }
    form.padrao .validar-sucesso {
        border-color: #e0e0e0 !important;
        color: #808080 !important;
    }

    form.padrao fieldset {
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        border-radius: 10px;
        border: 1px solid #4aaada;
        margin-bottom: 20px;
        padding: 15px;
        width: 99%;
    }

    form.padrao fieldset legend {
        font-size: 14px;
        font-weight: bold;
        color: #000066;
        padding: 3px 10px;
    }

    form.padrao input,
    form.padrao textarea,
    form.padrao select, form.padrao .cke_1 {
        background-color: #f2f2f2;
        background-image: -moz-linear-gradient(top, #ffffff, #dfdfdf);
        background-image: -ms-linear-gradient(top, #ffffff, #dfdfdf);
        background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#dfdfdf));
        background-image: -webkit-linear-gradient(top, #ffffff, #dfdfdf);
        background-image: -o-linear-gradient(top, #ffffff, #dfdfdf);
        background-image: linear-gradient(top, #ffffff, #dfdfdf);
        background-repeat: repeat-x;
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#dfdfdf', GradientType=0);
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        border: 1px solid #e0e0e0;
        float: left;
        font-family: Arial, Helvetica, Verdana, sans-serif;
        font-size: 11px;
        padding: 2px;
        width: 65px;
    }

    form.padrao .cke_1{
        width: 400px;
    }

    form.padrao input[type=radio], form.padrao input[type=checkbox]{
        width: 20px;
    }

    form.padrao span{
        float: left;
    }
    /*FIM DORMULARIOS*/

    /*LISTAGEM E AFINS*/
    #listagem #lista{
        width: 100%;
        border: 1px solid;
        text-align: left;
    }

    #listagem #lista th.pqno{
        width: 60px;
    }

    #listagem #lista th.medio{
        width: 130px;
    }

    #listagem #lista .center{
        text-align: center;
    }

    #interno #inserir{
        width: 100px;
        float: left;
    }

    #interno #busca{
        width: 600px;
        float: right;
        text-align: right;
    }

    #interno #filtro{
        width: 100%;
        height: 30px;
    }

    #interno #listagem{
        float: none;
        margin-top: 10px;
        width: 100%;
    }

    /*PAGINACAO*/
    .pagination {
        margin-right: 17px;
        width: 100%;
    }
    .pagination {
        position: relative;
        text-align: center;
    }
    .pagination a {
        margin: 0 2px;
        padding: 5px 10px;
        background: #E6E6E6;
        -moz-border-radius: 4px;
        border-radius: 4px;
        border: 1px solid #D3D3D3;
        text-decoration: none;
        color: #F68B21;
    }
    .pagination a.active {
        background: #F68B21;
        color: white;
    }

    .menos, .mais{
        margin-left: 10px;
    }

    .cod{
        text-align: right;
    }
    
    .campos+.campos{
        margin-top: 50px;
    }
</style>
<!--FIM STYLE-->

<!--SCRIPTS FORMS-->
<script>
    $(document).ready(function() {

        $("a[rel=grupo_imagens]").fancybox();

        $("#limpar").click(function(event) {
            event.preventDefault();
            document.form_cadastro.reset();
        });

        $("#cadastrar").click(function(event) {
            event.preventDefault();
            $("#form_cadastro").submit();
        });

        $("#form_cadastro").validar({
            "after": function() {
                $("#envies").show('slow');
                $.post('<?php echo $config["urlForm"] ?>', this.serialize(), function(data) {
                    $("#envies").hide("slow");
                    if (data.ok === "OK") {
                        alert("CRUD gerado com sucesso!");
                        //document.form_cadastro.reset();
                    } else if (data.ok === "NOPE") {
                        alert('Não foi possível gerar o CRUD!!');
                    }
                }, 'json');
                return false;
            },
            "marcar": false
        });
    });
</script>
<!--FIM SCRIPTS FORMS-->