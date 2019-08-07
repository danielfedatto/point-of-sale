<section class="weDescription">
    <div class="container">
        <h3><?php echo $nos->NOS_TITULO; ?></h3>
        <h5><?php echo strip_tags($nos->NOS_TEXTO); ?></h5>
    </div>
</section>
<section class="weOffer">
    <div class="container">
        <div class="weOfferBoxController">
            <?php 
            foreach($servicos as $ser){ 
                $imgSer = glob('admin/upload/servicos/imagem_interna_'.$ser->SER_ID.'.*'); 
                if($imgSer){ ?>
                    <div class="weOfferBox">
                        <figure>
                            <a href="<?php echo url::base(); ?>cases/servicos/<?php echo $ser->SER_ID; ?>/<?php echo urlencode(Controller_Index::arrumaURL($ser->SER_TITULO)); ?>">
                                <img src="<?php echo url::base().$imgSer[0]; ?>" alt="<?php echo $ser->SER_TITULO; ?>">
                            </a>
                        </figure>
                        <div class="offerDesc">
                            <h5><?php echo $ser->SER_TITULO; ?></h5> 
                            <?php echo strip_tags($ser->SER_TEXTO); ?>
                        </div>
                    </div>
                <?php
                }
            } ?>
        </div>
    </div>
</section>
<section class="teamWork">
    <div class="container">
        <h3>As <span>Mentes</span> Criativas</h3>
        <h6>Quem faz a magia acontecer</h6>
        <div class="teamWorkBoxController" id="teamwork">
            <?php
            foreach($equipe as $equi){ 
                $imgEqui = glob('admin/upload/equipe/'.$equi->EQU_ID.'.*');
                if($imgEqui){ ?>
                    <div class="teamWorkFig">
                        <figure class="moldure">
                            <div class="moldureHover">
                                <img src="<?php echo url::base().$imgEqui[0]; ?>" alt="<?php echo $equi->EQU_NOME; ?>">
                                <figcaption>
                                    <p><?php echo $equi->EQU_NOME; ?></p>
                                    <p><?php echo $equi->EQU_CARGO; ?></p>
                                </figcaption>
                            </div>
                        </figure>
                    </div>
                <?php
                }
            } ?>
        </div>
    </div>
</section>