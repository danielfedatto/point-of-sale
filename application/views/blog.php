<section class="blogInterna">
    <div class="container">
    <h3>Fique por dentro das <span>novidades</span></h3>
    <div class="blogWrap">
        <?php
        foreach($blog as $blo){
            $blogcategorias = ORM::factory('blogcategorias')->where('BLO_ID', '=', $blo->BLO_ID)->find_all();
            $imgBlog = glob('admin/upload/blog/thumb_'.$blo->BLO_ID.'.*');
            if($imgBlog){ ?>
                <article>
                    <figure>
                        <img src="<?php echo url::base().$imgBlog[0]; ?>" alt="<?php echo $blo->BLO_TITULO; ?>">
                    </figure>
                    <div class="categories">
                        <?php foreach($blogcategorias as $blc){ ?>
                            <a class="btnType2" href="<?php echo url::base(); ?>blog/categoria/<?php echo $blc->categorias->CAT_ID; ?>/<?php echo urlencode($blc->categorias->CAT_TITULO); ?>" title="<?php echo $blc->categorias->CAT_TITULO; ?>"><?php echo $blc->categorias->CAT_TITULO; ?></a>
                        <?php } ?>
                    </div>
                    <a href="<?php echo url::base(); ?>post/ver/<?php echo $blo->BLO_ID; ?>/<?php echo urlencode(Controller_Index::arrumaURL($blo->BLO_TITULO)); ?>" title="<?php echo $blc->categorias->CAT_TITULO; ?>">
                        <h5><?php echo $blo->BLO_TITULO; ?></h5>
                    </a>
                    <div class="articleFooter">
                        <span>Por 
                            <a href="#"><?php echo $blo->usuarios->USU_NOME; ?></a>
                        </span>
                        <span class="comments"><?php echo Controller_Index::tempoCorrido($blo->BLO_DATA_E_HORA); ?>
                            <svg class="icon icon-access_time">
                                <use xlink:href="#icon-access_time"></use>
                            </svg>
                        </span>
                    </div>
                    <a class="btnType2" href="<?php echo url::base(); ?>post/ver/<?php echo $blo->BLO_ID; ?>/<?php echo urlencode(Controller_Index::arrumaURL($blo->BLO_TITULO)); ?>" title="">Ler Tudo</a>
                </article>
            <?php 
            }
        } ?>
    </div>

    <?php echo $pagination; ?>

    </div>
</section>