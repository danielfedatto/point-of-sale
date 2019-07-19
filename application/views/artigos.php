<section class="blogPost">
    <div class="container">
        <div class="blogPostController">
            <aside>
            </aside>
            <article>
                <div class="postText">
                    <h4><?php echo $artigo->ART_TITULO; ?></h4>
                    <?php 
                    echo $artigo->ART_TEXTO; 
                    
                    $imgArtigo = glob("admin/upload/artigos/".$artigo->ART_ID.".*");
                    if($imgArtigo){?>
                        <figure><img src="<?php echo url::base().$imgArtigo[0]; ?>" alt="<?php echo $artigo->ART_TITULO; ?>"></figure>
                    <?php
                    } ?>
                    <div class="fb-comments"></div>
                </div>
            </article>
        </div>
    </div>
</section>