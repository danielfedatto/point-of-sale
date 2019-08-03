<div class="categories categories-cases">
    <?php foreach($servicos as $ser){ ?>
        <a class="btnType2" href="<?php echo url::base(); ?>cases/servicos/<?php echo $ser->SER_ID; ?>/<?php echo urlencode($ser->SER_TITULO); ?>" title="<?php echo $ser->SER_TITULO; ?>"><?php echo $ser->SER_TITULO; ?></a>
    <?php } ?>
</div>
<section class="internCases">
    <?php 
    foreach($cases as $cas){ 
        $imgCase = glob('admin/upload/cases/'.$cas->CAS_ID.'.*'); 
        if($imgCase){ ?>
            <figure>
                <img src="<?php echo url::base().$imgCase[0]; ?>" alt="<?php echo $cas->CAS_TITULO; ?>">
                <figcaption>
                    <div class="internCasesDesc">
                        <h5><?php echo $cas->CAS_TITULO; ?></h5>
                        <span><?php echo $cas->CAS_SUBTITULO?></span>
                    </div>
                    <div class="internCasesBtn">
                        <a class="btnType2" href="<?php echo url::base(); ?>caseinterna/index/<?php echo $cas->CAS_ID; ?>/<?php echo urlencode(Controller_Index::arrumaURL($cas->CAS_TITULO)); ?>">Ver Projeto</a>
                    </div>
                </figcaption>
            </figure>
        <?php
        }
    } ?>
</section>