<section class="interBanner">
</section>
<div class="caseBar">
    <figure><img src="<?php echo url::base(); ?>dist/img/caseicon.png" alt=""></figure>
</div>
<section class="blogInterna">
    <div class="container">
    <h4><?php echo $blo->BLO_TITULO; ?></h4>
    <div class="categories_blog">
        <?php foreach($categorias as $cat){ ?>
            <a class="btnType2" href="<?php echo url::base(); ?>blog/categoria/<?php echo $cat->CAT_ID; ?>/<?php echo urlencode(Controller_Index::arrumaURL($cat->CAT_TITULO)); ?>" title="<?php echo $cat->CAT_TITULO; ?>"><?php echo $cat->CAT_TITULO; ?></a>
        <?php } ?>
    </div>
    <div class="blogWrap">
        <?php
        foreach($blog as $blo){
            $blogcategorias = ORM::factory('blogcategorias')->where('BLO_ID', '=', $blo->BLO_ID)->find_all();
            $imgBlog = glob('admin/upload/blog/thumb_'.$blo->BLO_ID.'.*');
            if($imgBlog){ ?>
                <article>
                    <figure>
                        <a href="<?php echo url::base(); ?>post/ver/<?php echo $blo->BLO_ID; ?>/<?php echo urlencode(Controller_Index::arrumaURL($blo->BLO_TITULO)); ?>" title="<?php echo $blc->categorias->CAT_TITULO; ?>">
                            <img src="<?php echo url::base().$imgBlog[0]; ?>" alt="<?php echo $blo->BLO_TITULO; ?>">
                        </a>
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