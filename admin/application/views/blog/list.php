<section id="lista">
    <h1>Blog</h1>
    
    <!--MENSAGEM DE INCLUSAO, ALTERACAO OU EXCLUSAO-->
    <?php if($mensagem != ""){ ?>
        <?php echo $mensagem ?>
    <?php } ?>
    
    <!--INCLUIR E PESQUISA-->
    <div class="operacoes"><a href="<?php echo url::base() ?>blog/edit" class="btn-inserir">Novo</a><form id="formBusca" name="formBusca" method="get" action="<?php echo url::base() ?>blog/pesquisa" class="pesquisa">
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
                              <span><a href="#" onclick="ordenar('BLO_ID', 'asc')" class="seta-acima"></a>
                                  <a href="#" onclick="ordenar('BLO_ID', 'desc')" class="seta-abaixo"></a></span>
                          </th>
                          <th>Título
                              <span><a href="#" onclick="ordenar('BLO_TITULO', 'asc')" class="seta-acima"></a>
                                  <a href="#" onclick="ordenar('BLO_TITULO', 'desc')" class="seta-abaixo"></a></span>
                          </th>
                          <th>Data/Hora
                              <span><a href="#" onclick="ordenar('BLO_DATA_E_HORA', 'asc')" class="seta-acima"></a>
                                  <a href="#" onclick="ordenar('BLO_DATA_E_HORA', 'desc')" class="seta-abaixo"></a></span>
                          </th>
                          <th>Usuário
                              <span><a href="#" onclick="ordenar('USU_NOME', 'asc')" class="seta-acima"></a>
                                  <a href="#" onclick="ordenar('USU_NOME', 'desc')" class="seta-abaixo"></a></span>
                          </th>
                          <th style="width: 130px"></th>
                      </tr>

                      <?php
                      //SE TEM CADASTRADO, MOSTRA. SENÃO, MOSTRA O AVISO
                      if (count($blog) > 0) {
                          foreach($blog as $blo){
                              ?>
                              <tr><td><?php echo $blo->BLO_ID; ?></td>
                                  <td><?php echo $blo->BLO_TITULO; ?></td>
                                  <td><?php echo $blo->BLO_DATA_E_HORA; ?></td>
                                  <td><?php echo $blo->usuarios->USU_NOME; ?></td>
                                  <td>
                                    <a href="<?php echo url::base() ?>galeria/index/blog/<?php echo $blo->BLO_ID; ?>" 
                                          class="btn-app-list fa fa-photo"></a>
                                      <a href="<?php echo url::base() ?>blog/edit/<?php echo $blo->BLO_ID; ?>" 
                                          class="btn-app-list fa fa-edit"></a>
                                          <a onclick="if (window.confirm('Deseja realmente excluir o registro?')) {
                                              location.href = '<?php echo url::base() ?>blog/excluir/<?php echo 
                                                  $blo->BLO_ID; ?>';
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
                              <td colspan="5" class="naoEncontrado">Nenhum Blog encontrado</td>
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
