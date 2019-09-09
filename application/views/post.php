<section class="blogBanner">
    <div class="banner">
        <?php $imgBlog = glob("admin/upload/blog/".$blog->BLO_ID.".*"); ?>
        <div class="slide_1" <?php if($imgBlog){ ?> style="background-image: url(<?php echo url::base().$imgBlog[0]; ?>); background-repeat: no-repeat; backgroudn-position: center center; background-size: 100% auto;" <?php } ?>>
            <div class="container">
                <div class="bannerContentPost">
                    <div class="blogBannerInfo">
                        <h4><?php echo $blog->BLO_TITULO; ?></h4>
                        <div class="blogBannerInfoFooter">
                            <div class="time">
                                <svg class="icon icon-access_time left">
                                    <use xlink:href="#icon-access_time"></use>
                                </svg><span><?php echo Controller_Index::tempoCorrido($blog->BLO_DATA_E_HORA); ?></span>
                            </div>
                            <!-- <div class="comments">
                                <svg class="icon icon-comments left">
                                    <use xlink:href="#icon-comments"></use>
                                </svg><span>141</span>
                            </div>
                            <div class="share">
                                <svg class="icon icon-share left">
                                    <use xlink:href="#icon-share"></use>
                                </svg><span>25</span>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="blogPost">
    <div class="container">
        <div class="blogPostController">
            <aside>
                <div class="autorPost">
                    <div class="autorFig">
                        <figure class="moldure">
                            <div class="borderTopLeft"></div>
                            <div class="borderTopRight"></div>
                                <?php
                                $img = glob("admin/upload/usuarios/thumb_".$blog->usuarios->USU_ID.".*");
                                if($img){
                                    $img = $img[0];
                                }else{
                                    $img = "admin/dist/img/pessoa.png";
                                } ?>
                            <img class="fluid-img" src="<?php echo url::base().$img; ?>" alt="">
                            <div class="borderBottomLeft"></div>
                            <div class="borderBottomRight"></div>
                        </figure>
                    </div>
                    <h5><?php echo $blog->usuarios->USU_NOME; ?></h5>
                    <h6><?php echo $blog->usuarios->USU_CARGO; ?></h6>
                    <ul class="socialMedia">
                        <?php if($blog->usuarios->USU_FACEBOOK != ''){ ?>
                            <li><a href="<?php echo $blog->usuarios->USU_FACEBOOK; ?>" target="_blank" title="Facebook"> 
                                <svg class="icon icon-facebook">
                                    <use xlink:href="#icon-facebook"></use>
                                </svg></a>
                            </li>
                        <?php } ?>
                        <?php if($blog->usuarios->USU_INSTAGRAM != ''){ ?>
                            <li><a href="<?php echo $blog->usuarios->USU_FACEBOOK; ?>" target="_blank" title="Instagram"> 
                                <svg class="icon icon-instagram">
                                    <use xlink:href="#icon-instagram"></use>
                                </svg></a>
                            </li>
                        <?php } ?>
                        <?php if($blog->usuarios->USU_BEHANCE != ''){ ?>
                            <li><a href="<?php echo $blog->usuarios->USU_BEHANCE; ?>" target="_blank" title="Behance"> 
                                <svg class="icon icon-behance">
                                    <use xlink:href="#icon-behance"></use>
                                </svg></a>
                            </li>
                        <?php } ?>
                    </ul>
                    <a class="otherPosts" href="<?php echo url::base(); ?>blog/autor/<?php echo $blog->usuarios->USU_ID; ?>" title="Outros posts">Outros posts</a>
                </div>
            </aside>
            <article>
                <div class="categories">
                    <?php foreach($blogcategorias as $cab){ ?>
                        <a class="btnType2" href="<?php echo url::base(); ?>blog/categoria/<?php echo $cab->categorias->CAT_ID; ?>/<?php echo urlencode($cab->categorias->CAT_TITULO); ?>" title="<?php echo $cab->categorias->CAT_TITULO; ?>"><?php echo $cab->categorias->CAT_TITULO; ?></a>
                    <?php } ?>
                </div>
                <div class="postText">
                    <h4><?php echo $blog->BLO_TITULO; ?></h4>
                    <?php 
                    echo $blog->BLO_TEXTO; 
                    if($imgBlog){?>
                        <figure><img class="fluid-img" src="<?php echo url::base().$imgBlog[0]; ?>" alt="<?php echo $blog->BLO_TITULO; ?>"></figure>
                    <?php
                    } ?>
                    <div class="fb-share-button"
                        data-href="<?php echo $_SERVER ['REQUEST_URI']; ?>"
                        data-layout="button"
                        data-size="large">
                        <a target="_blank"
                            href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $_SERVER ['REQUEST_URI']; ?>"
                            class="fb-xfbml-parse-ignore">
                            Compartilhar
                        </a>
                    </div>
                    <div class="fb-comments" data-href="<?php echo $_SERVER['SERVER_NAME']; ?><?php echo $_SERVER ['REQUEST_URI']; ?>" data-width="100%" data-numposts="10"></div>
                </div>
            </article>
        </div>
    </div>
</section>
<?php if(count($relacionados) > 0){ ?>
    <section class="blogInterna">
        <div class="container">
            <h3>Posts <span>relacionados</span></h3>
            <div class="blogWrap">
                <?php
                foreach($relacionados as $blo){
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
        </div>
    </section>
<?php } ?>