<section id="lista">
    <h1>Banners</h1>
    
    <!--MENSAGEM DE INCLUSAO, ALTERACAO OU EXCLUSAO-->
    <?php if($mensagem != ""){ ?>
        <?php echo $mensagem ?>
    <?php } ?>
    
    <!--INCLUIR E PESQUISA-->
    <div class="operacoes"><a href="<?php echo url::base() ?>banners/edit" class="btn-inserir">Novo</a><form id="formBusca" name="formBusca" method="get" action="<?php echo url::base() ?>banners/pesquisa" class="pesquisa">
            <label for="chave">Pesquise um registro:</label>
            <input type="search" id="chave" name="chave" placeholder="Busca" />
            
            <!--ORDENACAO-->
            <input type="hidden" id="ordem" name="ordem" value="<?php echo $ordem; ?>">
            <input type="hidden" id="sentido" name="sentido" value="<?php echo $sentido; ?>">

            <button type="submit">Buscar</button>
        </form>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">

                      <tr>
                            <th style="width: 70px">#
                              <span><a href="#" onclick="ordenar('BAN_ID', 'asc')" class="seta-acima"></a>
                                  <a href="#" onclick="ordenar('BAN_ID', 'desc')" class="seta-abaixo"></a></span>
                          </th>
                          <th>Título
                              <span><a href="#" onclick="ordenar('BAN_TITULO', 'asc')" class="seta-acima"></a>
                                  <a href="#" onclick="ordenar('BAN_TITULO', 'desc')" class="seta-abaixo"></a></span>
                          </th>
                          <th>Início
                              <span><a href="#" onclick="ordenar('BAN_INICIO', 'asc')" class="seta-acima"></a>
                                  <a href="#" onclick="ordenar('BAN_INICIO', 'desc')" class="seta-abaixo"></a></span>
                          </th>
                          <th>Fim
                              <span><a href="#" onclick="ordenar('BAN_FIM', 'asc')" class="seta-acima"></a>
                                  <a href="#" onclick="ordenar('BAN_FIM', 'desc')" class="seta-abaixo"></a></span>
                          </th>
                          <th>Ordem
                              <span><a href="#" onclick="ordenar('BAN_ORDEM', 'asc')" class="seta-acima"></a>
                                  <a href="#" onclick="ordenar('BAN_ORDEM', 'desc')" class="seta-abaixo"></a></span>
                          </th>
                          <th>Página
                              <span><a href="#" onclick="ordenar('BAN_PAGINA', 'asc')" class="seta-acima"></a>
                                  <a href="#" onclick="ordenar('BAN_PAGINA', 'desc')" class="seta-abaixo"></a></span>
                          </th>
                          <th style="width: 100px"></th>
                      </tr>

                      <?php
                      //SE TEM CADASTRADO, MOSTRA. SENÃO, MOSTRA O AVISO
                      if (count($banners) > 0) {
                          foreach($banners as $ban){
                              ?>
                              <tr><td><?php echo $ban->BAN_ID; ?></td>
                                  <td><?php echo $ban->BAN_TITULO; ?></td>
                                  <td><?php echo Controller_Index::aaaammdd_ddmmaaaa($ban->BAN_INICIO); ?></td>
                                  <td><?php echo Controller_Index::aaaammdd_ddmmaaaa($ban->BAN_FIM); ?></td>
                                  <td><?php echo $ban->BAN_ORDEM; ?></td>
                                  <td><?php echo $ban->BAN_PAGINA; ?></td>
                                  <td>
                                      <a href="<?php echo url::base() ?>banners/edit/<?php echo $ban->BAN_ID; ?>" 
                                          class="btn-app-list fa fa-edit"></a>
                                          <a onclick="if (window.confirm('Deseja realmente excluir o registro?')) {
                                              location.href = '<?php echo url::base() ?>banners/excluir/<?php echo 
                                                  $ban->BAN_ID; ?>';
                                          }    
                                         " class="btn-app-list fa fa-trash"></a>
                                  </td>
                              </tr>
                              <?php
                          }
                      }
                      else {
                          ?>
                          <tr>
                              <td colspan="6" class="naoEncontrado">Nenhum Banners encontrado</td>
                          </tr>
                          <?php
                      }
                      ?>

                  </table>
              </div>
    
                <!--EXCLUI TODOS MARCADOS--><!--PAGINACAO-->
                <?php echo $pagination; ?>
            </div>
        </div>
    </div>
</section>

<!--ONDE MONTA O FORMULARIO PARA EXCLUIR OS MARCADOS-->
<div id="formExc"></div>
