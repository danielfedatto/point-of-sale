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
                        <span><?php echo strip_tags($cas->CAS_TEXTO); ?></span>
                    </div>
                    <div class="internCasesBtn">
                        <a class="btnType2" href="<?php echo url::base().$imgCase[0]; ?>" 
                            data-fancybox="cases_<?php echo $cas->CAS_ID; ?>"                         
                            data-caption="<?php echo $cas->CAS_TITULO; ?>">Ver Projeto</a>
                    </div>
                </figcaption>
            </figure>
            <div style="display: none;">
                <?php
                $galeria = ORM::factory("galeria")->where("GAL_IMAGEM", "like", "%fotos_cases/thumb_".$cas->CAS_ID."_%")->find_all();
                foreach($galeria as $key => $gal){
                    $imgGal = glob("admin/".$gal->GAL_IMAGEM);
                    if($imgGal AND strpos($gal->GAL_IMAGEM, "thumb_" . $cas->CAS_ID . "_")){ ?>
                        <a href="<?php echo url::base().str_replace("thumb_", "", $imgGal[0]); ?>"
                            data-fancybox="cases_<?php echo $cas->CAS_ID; ?>"                         
                            data-thumb="<?php echo url::base().$imgGal[0]; ?>"
                            data-caption="<?php echo $gal->GAL_LEGENDA; ?>">
                        </a>
                    <?php 
                    } 
                } ?> 
            </div>
        <?php
        }
    } ?>
</section>