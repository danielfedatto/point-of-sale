<section id="lista">
    <h1>Categoria Módulo</h1>
    
    <!--MENSAGEM DE INCLUSAO, ALTERACAO OU EXCLUSAO-->
    <?php if($mensagem != ""){ ?>
        <?php echo $mensagem ?>
    <?php } ?>
    
    <!--INCLUIR E PESQUISA-->
    <div class="operacoes">
        <a href="<?php echo url::base() ?>categoriamodulo/edit" class="btn-inserir">Novo</a>

        <form id="formBusca" name="formBusca" method="get" action="<?php echo url::base() ?>categoriamodulo/pesquisa" class="pesquisa">
            <label for="chave">Pesquise um registro:</label>
            <input type="search" id="chave" name="chave" placeholder="Busca" />
            <button type="submit">Buscar</button>
        </form>
    </div>
    
    <div class="row">
        <div class="col-md-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <!--LISTA DE REGISTROS-->
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 10px"><input type="checkbox" class="seleciona" onclick="selecionar(this.checked)" valor="0"></th>
                        <th style="width: 50px">#</th>
                        <th>Nome</th>
                        <th>Ordem</th>
                        <th style="width: 100px"></th>
                    </tr>
                    
                    <?php
                    if (count($categoriamodulo) > 0) {
                        foreach($categoriamodulo as $cam){
                            ?>
                            <tr>
                                <td><input type="checkbox" class="seleciona" valor="<?php echo $cam->CAM_ID; ?>"></td>
                                <td class="codigo direita"><?php echo $cam->CAM_ID; ?></td>
                                <td><?php echo $cam->CAM_NOME; ?></td>
                                <td><?php echo $cam->CAM_ORDEM; ?></td>
                                <td>
                                    <a href="<?php echo url::base() ?>categoriamodulo/edit/<?php echo $cam->CAM_ID; ?>" 
                                        class="btn-app-list fa fa-edit"></a>
                                    <a onclick="
                                        if (window.confirm('Deseja realmente excluir o registro?')) {
                                            location.href = '<?php echo url::base() ?>categoriamodulo/excluir/<?php echo 
                                                $cam->CAM_ID; ?>';
                                        }    
                                       " class="btn-app-list fa fa-trash">
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    else {
                        ?>
                        <tr>
                            <td colspan="4" class="naoEncontrado">Nenhuma Categoria encontrada</td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
            <!--EXCLUI TODOS MARCADOS-->
            <div class="operacoes">
                <a onclick="
                    if (window.confirm('Deseja realmente excluir os registros marcados?')) {
                        excluirTodos('<?php echo Request::current()->controller(); ?>');
                    }
                   " class="btn-excluir-todos">Excluir todos marcados</a>
            </div>
            
            <!--PAGINACAO-->
            <?php echo $pagination; ?>
            
          </div>
        </div>
    </div>
</section>

<!--ONDE MONTA O FORMULARIO PARA EXCLUIR OS MARCADOS-->
<div id="formExc"></div>
