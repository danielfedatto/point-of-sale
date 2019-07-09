<section id="lista">
    <h1>Contatos</h1>
    
    <!--MENSAGEM DE INCLUSAO, ALTERACAO OU EXCLUSAO-->
    <?php if($mensagem != ""){ ?>
        <?php echo $mensagem ?>
    <?php } ?>
    
    <!--INCLUIR E PESQUISA-->
    <div class="operacoes">
        <form id="formBusca" name="formBusca" method="get" action="<?php echo url::base() ?>contatos/pesquisa" class="pesquisa">
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
                              <span><a href="#" onclick="ordenar('CON_ID', 'asc')" class="seta-acima"></a>
                                  <a href="#" onclick="ordenar('CON_ID', 'desc')" class="seta-abaixo"></a></span>
                          </th>
                          <th>Data
                              <span><a href="#" onclick="ordenar('CON_DATA', 'asc')" class="seta-acima"></a>
                                  <a href="#" onclick="ordenar('CON_DATA', 'desc')" class="seta-abaixo"></a></span>
                          </th>
                          <th>Nome
                              <span><a href="#" onclick="ordenar('CON_NOME', 'asc')" class="seta-acima"></a>
                                  <a href="#" onclick="ordenar('CON_NOME', 'desc')" class="seta-abaixo"></a></span>
                          </th>
                          <th>Email
                              <span><a href="#" onclick="ordenar('CON_EMAIL', 'asc')" class="seta-acima"></a>
                                  <a href="#" onclick="ordenar('CON_EMAIL', 'desc')" class="seta-abaixo"></a></span>
                          </th>
                          <th>Fone
                              <span><a href="#" onclick="ordenar('CON_FONE', 'asc')" class="seta-acima"></a>
                                  <a href="#" onclick="ordenar('CON_FONE', 'desc')" class="seta-abaixo"></a></span>
                          </th>
                          <th style="width: 100px"></th>
                      </tr>

                      <?php
                      //SE TEM CADASTRADO, MOSTRA. SENÃO, MOSTRA O AVISO
                      if (count($contatos) > 0) {
                          foreach($contatos as $con){
                              ?>
                              <tr><td><?php echo $con->CON_ID; ?></td>
                                  <td><?php echo Controller_Index::aaaammdd_ddmmaaaa($con->CON_DATA); ?></td>
                                  <td><?php echo $con->CON_NOME; ?></td>
                                  <td><?php echo $con->CON_EMAIL; ?></td>
                                  <td><?php echo $con->CON_FONE; ?></td>
                                  <td>
                                      <a href="<?php echo url::base() ?>contatos/edit/<?php echo $con->CON_ID; ?>" 
                                          class="btn-app-list fa fa-edit"></a>
                                  </td>
                              </tr>
                              <?php
                          }
                      }
                      else {
                          ?>
                          <tr>
                              <td colspan="6" class="naoEncontrado">Nenhum Contatos encontrado</td>
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
