<section id="lista">
    <h1>A Gente Fala</h1>
    
    <!--MENSAGEM DE INCLUSAO, ALTERACAO OU EXCLUSAO-->
    <?php if($mensagem != ""){ ?>
        <?php echo $mensagem ?>
    <?php } ?>
    
    <!--INCLUIR E PESQUISA-->
    <div class="operacoes"><a href="<?php echo url::base() ?>artigos/edit" class="btn-inserir">Novo</a><form id="formBusca" name="formBusca" method="get" action="<?php echo url::base() ?>artigos/pesquisa" class="pesquisa">
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
                              <span><a href="#" onclick="ordenar('ART_ID', 'asc')" class="seta-acima"></a>
                                  <a href="#" onclick="ordenar('ART_ID', 'desc')" class="seta-abaixo"></a></span>
                          </th>
                          <th>Título
                              <span><a href="#" onclick="ordenar('ART_TITULO', 'asc')" class="seta-acima"></a>
                                  <a href="#" onclick="ordenar('ART_TITULO', 'desc')" class="seta-abaixo"></a></span>
                          </th>
                          <th>Data
                              <span><a href="#" onclick="ordenar('ART_DATA', 'asc')" class="seta-acima"></a>
                                  <a href="#" onclick="ordenar('ART_DATA', 'desc')" class="seta-abaixo"></a></span>
                          </th>
                          <th style="width: 100px"></th>
                      </tr>

                      <?php
                      //SE TEM CADASTRADO, MOSTRA. SENÃO, MOSTRA O AVISO
                      if (count($artigos) > 0) {
                          foreach($artigos as $art){
                              ?>
                              <tr><td><?php echo $art->ART_ID; ?></td>
                                  <td><?php echo $art->ART_TITULO; ?></td>
                                  <td><?php echo Controller_Index::aaaammdd_ddmmaaaa($art->ART_DATA); ?></td>
                                  <td>
                                      <a href="<?php echo url::base() ?>artigos/edit/<?php echo $art->ART_ID; ?>" 
                                          class="btn-app-list fa fa-edit"></a>
                                          <a onclick="if (window.confirm('Deseja realmente excluir o registro?')) {
                                              location.href = '<?php echo url::base() ?>artigos/excluir/<?php echo 
                                                  $art->ART_ID; ?>';
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
                              <td colspan="4" class="naoEncontrado">Nenhum Artigos encontrado</td>
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
