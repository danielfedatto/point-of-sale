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
                    <div class="internCasesBtn"><a class="btnType2" href="#" target="_blank">Ver Projeto</a></div>
                </figcaption>
            </figure>
        <?php
        }
    } ?>
</section>