<section class="blogPost">
    <div class="container">
        <div class="blogPostController">
            <aside>
            <div class="autorPost">
                <figure>
                    <?php
                    $img = glob("admin/upload/usuarios/thumb_".$blog->usuarios->USU_ID.".*");
                    if($img){
                        $img = $img[0];
                    }else{
                        $img = "admin/dist/img/pessoa.png";
                    } ?>
                    <img src="<?php echo url::base().$img; ?>" alt="">
                </figure>
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
            </div>
            </aside>
            <article>
                <h5><?php echo $blog->BLO_TITULO; ?><h5>
                <?php echo $blog->BLO_TEXTO; ?>
            </article>
        </div>
    </div>
</section>