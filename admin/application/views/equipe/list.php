<section id="lista">
    <h1>Equipe</h1>
    
    <!--MENSAGEM DE INCLUSAO, ALTERACAO OU EXCLUSAO-->
    <?php if($mensagem != ""){ ?>
        <?php echo $mensagem ?>
    <?php } ?>
    
    <!--INCLUIR E PESQUISA-->
    <div class="operacoes"><a href="<?php echo url::base() ?>equipe/edit" class="btn-inserir">Novo</a><form id="formBusca" name="formBusca" method="get" action="<?php echo url::base() ?>equipe/pesquisa" class="pesquisa">
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
                              <span><a href="#" onclick="ordenar('EQU_ID', 'asc')" class="seta-acima"></a>
                                  <a href="#" onclick="ordenar('EQU_ID', 'desc')" class="seta-abaixo"></a></span>
                          </th>
                          <th>Nome
                              <span><a href="#" onclick="ordenar('EQU_NOME', 'asc')" class="seta-acima"></a>
                                  <a href="#" onclick="ordenar('EQU_NOME', 'desc')" class="seta-abaixo"></a></span>
                          </th>
                          <th>Ordem
                              <span><a href="#" onclick="ordenar('EQU_ORDEM', 'asc')" class="seta-acima"></a>
                                  <a href="#" onclick="ordenar('EQU_ORDEM', 'desc')" class="seta-abaixo"></a></span>
                          </th>
                          <th style="width: 100px"></th>
                      </tr>

                      <?php
                      //SE TEM CADASTRADO, MOSTRA. SENÃO, MOSTRA O AVISO
                      if (count($equipe) > 0) {
                          foreach($equipe as $equ){
                              ?>
                              <tr><td><?php echo $equ->EQU_ID; ?></td>
                                  <td><?php echo $equ->EQU_NOME; ?></td>
                                  <td><?php echo $equ->EQU_ORDEM; ?></td>
                                  <td>
                                      <a href="<?php echo url::base() ?>equipe/edit/<?php echo $equ->EQU_ID; ?>" 
                                          class="btn-app-list fa fa-edit"></a>
                                          <a onclick="if (window.confirm('Deseja realmente excluir o registro?')) {
                                              location.href = '<?php echo url::base() ?>equipe/excluir/<?php echo 
                                                  $equ->EQU_ID; ?>';
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
                              <td colspan="4" class="naoEncontrado">Nenhum Equipe encontrado</td>
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
