<section class="interBanner">
</section>
<div class="caseBar">
    <figure><img src="<?php echo url::base(); ?>dist/img/caseicon.png" alt=""></figure>
</div>
<section class="casePost">
    <div class="container">
        <div class="casePostController">
            <article>
                <h4><?php echo $case->CAS_TITULO; ?></h4>
                <div class="categories">
                    <?php foreach($servicos as $ser){ ?>
                        <a class="btnType2" href="<?php echo url::base(); ?>cases/servicos/<?php echo $ser->SER_ID; ?>/<?php echo urlencode(Controller_Index::arrumaURL($ser->SER_TITULO)); ?>" title="<?php echo $ser->SER_TITULO; ?>"><?php echo $ser->SER_TITULO; ?></a>
                    <?php } ?>
                </div>
                <div class="postText">
                    <?php
                    $imgCase = glob('admin/upload/cases/'.$case->CAS_ID.'.*'); 
                    if($imgCase){ ?>
                        <figure>
                            <img src="<?php echo url::base().$imgCase[0]; ?>" alt="">
                        </figure>
                    <?php 
                    } ?>
                    <h4><?php echo $case->CAS_SUBTITULO; ?></h4>
                    <?php echo $case->CAS_TEXTO; ?>
                </div>
                <?php if($case->CAS_DETALHES != ''){ ?>
                    <div class="caseInfoTable">
                        <h5>Detalhes do Projeto:</h5>
                        <?php echo str_replace('border="1"', '', $case->CAS_DETALHES); ?>
                        <!-- <table>
                            <tr>
                                <td>Planejamento e estudo de mercado:</td>
                                <td>Gerson Renato Klein</td>
                            </tr>
                            <tr>
                                <td>Arquitetura Comercial:</td>
                                <td>Arq. Paloma Bugança - CAU A135676-3 </td>
                            </tr>
                            <tr>
                                <td>Design de Consumo:</td>
                                <td>Tatiane Denise Luquini</td>
                            </tr>
                            <tr>
                                <td>Execução da Obra:</td>
                                <td>Contrutora RDA</td>
                            </tr>
                            <tr>
                                <td>Entrega Final:</td>
                                <td>Novembro/2018</td>
                            </tr>
                        </table> -->
                    </div>
                <?php } ?>
                <h4>Outros Projetos:</h4>
                <div class="otherCaseWrap">
                    <?php 
                    foreach($relacionados as $rel){ 
                        $imgCasRel = glob('admin/upload/cases/thumb_'.$rel->CAS_ID.'.*');
                        if($imgCasRel){ ?>
                            <article>
                                <figure>
                                    <a href="<?php echo url::base(); ?>caseinterna/index/<?php echo $rel->CAS_ID; ?>/<?php echo urlencode(Controller_Index::arrumaURL($rel->CAS_TITULO)); ?>">
                                        <img src="<?php echo url::base().$imgCasRel[0]; ?>" alt="<?php echo $rel->CAS_TITULO?>">
                                    </a>
                                </figure>
                                <a href="<?php echo url::base(); ?>caseinterna/index/<?php echo $rel->CAS_ID; ?>/<?php echo urlencode(Controller_Index::arrumaURL($rel->CAS_TITULO)); ?>">
                                    <h5><?php echo $rel->CAS_TITULO?></h5>
                                </a>
                                <a href="<?php echo url::base(); ?>caseinterna/index/<?php echo $rel->CAS_ID; ?>/<?php echo urlencode(Controller_Index::arrumaURL($rel->CAS_TITULO)); ?>">
                                    <p><?php echo $rel->CAS_SUBTITULO?></p>
                                </a>
                            </article>
                        <?php 
                        }
                    } ?>
                </div>
            </article>
        </div>
    </div>
</section>