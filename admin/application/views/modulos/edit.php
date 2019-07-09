<section id="formulario">
    
    <div class="infos">
        <h1>Módulo</h1>
    </div>

    <div class="col-md-12">
        <div class="box box-info">
            <form class="form-horizontal" id="formEdit" name="formEdit" method="post" action="<?php echo url::base() ?>modulos/save">

                <div class="box-body">

                    <input type="hidden" id="MOD_ID" readonly name="MOD_ID" value="<?php echo $modulo["MOD_ID"] ?>">

                    <div class="form-group">
                        <label for="MOD_NOME" class="col-sm-2 control-label">Nome *</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Nome" id="MOD_NOME" name="MOD_NOME" validar="texto" value="<?php echo $modulo["MOD_NOME"] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="MOD_LINK" class="col-sm-2 control-label">Link *</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Link" id="MOD_LINK" name="MOD_LINK" validar="texto" value="<?php echo $modulo["MOD_LINK"] ?>"> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="CAM_ID" class="col-sm-2 control-label">Categoria *</label>
                        <div class="col-sm-10">
                            <select class="form-control select2" id="CAM_ID" name="CAM_ID">
                                <?php foreach($categoriamodulo as $cam){ ?>
                                <option value="<?php echo $cam->CAM_ID ?>" <?php if($cam->CAM_ID == $modulo["CAM_ID"]) echo "selected"; ?>>
                                    <?php echo $cam->CAM_NOME ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Ícone</label>
                            <input type="radio" id="vazio" name="MOD_ICONE" value="" <?php if ($modulo["MOD_ICONE"] == "") echo "checked"?>> Nenhum
                            <ul id="lista-icones">
                                <li>
                                    <input type="radio" id="fa fa-dashboard" name="MOD_ICONE" value="fa fa-dashboard" <?php if ($modulo["MOD_ICONE"] == "fa fa-dashboard") echo "checked"?>>
                                    <span class="fa fa-dashboard"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-files-o" name="MOD_ICONE" value="fa fa-files-o" <?php if ($modulo["MOD_ICONE"] == "fa fa-files-o") echo "checked"?>>
                                    <span class="fa fa-files-o"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-th" name="MOD_ICONE" value="fa fa-th" <?php if ($modulo["MOD_ICONE"] == "fa fa-th") echo "checked"?>>
                                    <span class="fa fa-th"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-pie-chart" name="MOD_ICONE" value="fa fa-pie-chart" <?php if ($modulo["MOD_ICONE"] == "fa fa-pie-chart") echo "checked"?>>
                                    <span class="fa fa-pie-chart"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-laptop" name="MOD_ICONE" value="fa fa-laptop" <?php if ($modulo["MOD_ICONE"] == "fa fa-laptop") echo "checked"?>>
                                    <span class="fa fa-laptop"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-edit" name="MOD_ICONE" value="fa fa-edit" <?php if ($modulo["MOD_ICONE"] == "fa fa-edit") echo "checked"?>>
                                    <span class="fa fa-edit"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-table" name="MOD_ICONE" value="fa fa-table" <?php if ($modulo["MOD_ICONE"] == "fa fa-table") echo "checked"?>>
                                    <span class="fa fa-table"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-calendar" name="MOD_ICONE" value="fa fa-calendar" <?php if ($modulo["MOD_ICONE"] == "fa fa-calendar") echo "checked"?>>
                                    <span class="fa fa-calendar"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-envelope" name="MOD_ICONE" value="fa fa-envelope" <?php if ($modulo["MOD_ICONE"] == "fa fa-envelope") echo "checked"?>>
                                    <span class="fa fa-envelope"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-folder" name="MOD_ICONE" value="fa fa-folder" <?php if ($modulo["MOD_ICONE"] == "fa fa-folder") echo "checked"?>>
                                    <span class="fa fa-folder"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-share" name="MOD_ICONE" value="fa fa-share" <?php if ($modulo["MOD_ICONE"] == "fa fa-share") echo "checked"?>>
                                    <span class="fa fa-share"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-book" name="MOD_ICONE" value="fa fa-book" <?php if ($modulo["MOD_ICONE"] == "fa fa-book") echo "checked"?>>
                                    <span class="fa fa-book"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-map" name="MOD_ICONE" value="fa fa-map" <?php if ($modulo["MOD_ICONE"] == "fa fa-map") echo "checked"?>>
                                    <span class="fa fa-map"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-archive" name="MOD_ICONE" value="fa fa-archive" <?php if ($modulo["MOD_ICONE"] == "fa fa-archive") echo "checked"?>>
                                    <span class="fa fa-archive"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-anchor" name="MOD_ICONE" value="fa fa-anchor" <?php if ($modulo["MOD_ICONE"] == "fa fa-anchor") echo "checked"?>>
                                    <span class="fa fa-anchor"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-bell" name="MOD_ICONE" value="fa fa-bell" <?php if ($modulo["MOD_ICONE"] == "fa fa-bell") echo "checked"?>>
                                    <span class="fa fa-bell"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-area-chart" name="MOD_ICONE" value="fa fa-area-chart" <?php if ($modulo["MOD_ICONE"] == "fa fa-area-chart") echo "checked"?>>
                                    <span class="fa fa-area-chart"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-cogs" name="MOD_ICONE" value="fa fa-cogs" <?php if ($modulo["MOD_ICONE"] == "fa fa-cogs") echo "checked"?>>
                                    <span class="fa fa-cogs"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-code" name="MOD_ICONE" value="fa fa-code" <?php if ($modulo["MOD_ICONE"] == "fa fa-code") echo "checked"?>>
                                    <span class="fa fa-code"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-credit-card" name="MOD_ICONE" value="fa fa-credit-card" <?php if ($modulo["MOD_ICONE"] == "fa fa-credit-card") echo "checked"?>>
                                    <span class="fa fa-credit-card"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-group" name="MOD_ICONE" value="fa fa-group" <?php if ($modulo["MOD_ICONE"] == "fa fa-group") echo "checked"?>>
                                    <span class="fa fa-group"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-image" name="MOD_ICONE" value="fa fa-image" <?php if ($modulo["MOD_ICONE"] == "fa fa-image") echo "checked"?>>
                                    <span class="fa fa-image"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-inbox" name="MOD_ICONE" value="fa fa-inbox" <?php if ($modulo["MOD_ICONE"] == "fa fa-inbox") echo "checked"?>>
                                    <span class="fa fa-inbox"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-modey" name="MOD_ICONE" value="fa fa-money" <?php if ($modulo["MOD_ICONE"] == "fa fa-money") echo "checked"?>>
                                    <span class="fa fa-money"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-tags" name="MOD_ICONE" value="fa fa-tags" <?php if ($modulo["MOD_ICONE"] == "fa fa-tags") echo "checked"?>>
                                    <span class="fa fa-tags"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-user" name="MOD_ICONE" value="fa fa-user" <?php if ($modulo["MOD_ICONE"] == "fa fa-user") echo "checked"?>>
                                    <span class="fa fa-user"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-truck" name="MOD_ICONE" value="fa fa-truck" <?php if ($modulo["MOD_ICONE"] == "fa fa-truck") echo "checked"?>>
                                    <span class="fa fa-truck"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-unlock" name="MOD_ICONE" value="fa fa-unlock" <?php if ($modulo["MOD_ICONE"] == "fa fa-unlock") echo "checked"?>>
                                    <span class="fa fa-unlock"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-unlock-alt" name="MOD_ICONE" value="fa fa-unlock-alt" <?php if ($modulo["MOD_ICONE"] == "fa fa-unlock-alt") echo "checked"?>>
                                    <span class="fa fa-unlock-alt"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-rss-square" name="MOD_ICONE" value="fa fa-rss-square" <?php if ($modulo["MOD_ICONE"] == "fa fa-rss-square") echo "checked"?>>
                                    <span class="fa fa-rss-square"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-object-group" name="MOD_ICONE" value="fa fa-object-group" <?php if ($modulo["MOD_ICONE"] == "fa fa-object-group") echo "checked"?>>
                                    <span class="fa fa-object-group"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-folder-open" name="MOD_ICONE" value="fa fa-folder-open" <?php if ($modulo["MOD_ICONE"] == "fa fa-folder-open") echo "checked"?>>
                                    <span class="fa fa-folder-open"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-cubes" name="MOD_ICONE" value="fa fa-cubes" <?php if ($modulo["MOD_ICONE"] == "fa fa-cubes") echo "checked"?>>
                                    <span class="fa fa-cubes"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-database" name="MOD_ICONE" value="fa fa-database" <?php if ($modulo["MOD_ICONE"] == "fa fa-database") echo "checked"?>>
                                    <span class="fa fa-database"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-circle-o" name="MOD_ICONE" value="fa fa-circle-o" <?php if ($modulo["MOD_ICONE"] == "fa fa-circle-o") echo "checked"?>>
                                    <span class="fa fa-circle-o"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-magnet" name="MOD_ICONE" value="fa fa-magnet" <?php if ($modulo["MOD_ICONE"] == "fa fa-magnet") echo "checked"?>>
                                    <span class="fa fa-magnet"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-camera" name="MOD_ICONE" value="fa fa-camera" <?php if ($modulo["MOD_ICONE"] == "fa fa-camera") echo "checked"?>>
                                    <span class="fa fa-camera"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-flag" name="MOD_ICONE" value="fa fa-flag" <?php if ($modulo["MOD_ICONE"] == "fa fa-flag") echo "checked"?>>
                                    <span class="fa fa-flag"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-link" name="MOD_ICONE" value="fa fa-link" <?php if ($modulo["MOD_ICONE"] == "fa fa-link") echo "checked"?>>
                                    <span class="fa fa-link"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-save" name="MOD_ICONE" value="fa fa-save" <?php if ($modulo["MOD_ICONE"] == "fa fa-save") echo "checked"?>>
                                    <span class="fa fa-save"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-shopping-cart" name="MOD_ICONE" value="fa fa-shopping-cart" <?php if ($modulo["MOD_ICONE"] == "fa fa-shopping-cart") echo "checked"?>>
                                    <span class="fa fa-shopping-cart"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-clone" name="MOD_ICONE" value="fa fa-clone" <?php if ($modulo["MOD_ICONE"] == "fa fa-clone") echo "checked"?>>
                                    <span class="fa fa-clone"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-comments-o" name="MOD_ICONE" value="fa fa-comments-o" <?php if ($modulo["MOD_ICONE"] == "fa fa-comments-o") echo "checked"?>>
                                    <span class="fa fa-comments-o"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-bank" name="MOD_ICONE" value="fa fa-bank" <?php if ($modulo["MOD_ICONE"] == "fa fa-bank") echo "checked"?>>
                                    <span class="fa fa-bank"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-bars" name="MOD_ICONE" value="fa fa-bars" <?php if ($modulo["MOD_ICONE"] == "fa fa-bars") echo "checked"?>>
                                    <span class="fa fa-bars"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-bullhorn" name="MOD_ICONE" value="fa fa-bullhorn" <?php if ($modulo["MOD_ICONE"] == "fa fa-bullhorn") echo "checked"?>>
                                    <span class="fa fa-bullhorn"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-briefcase" name="MOD_ICONE" value="fa fa-briefcase" <?php if ($modulo["MOD_ICONE"] == "fa fa-briefcase") echo "checked"?>>
                                    <span class="fa fa-briefcase"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-bicycle" name="MOD_ICONE" value="fa fa-bicycle" <?php if ($modulo["MOD_ICONE"] == "fa fa-bicycle") echo "checked"?>>
                                    <span class="fa fa-bicycle"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-bolt" name="MOD_ICONE" value="fa fa-bolt" <?php if ($modulo["MOD_ICONE"] == "fa fa-bolt") echo "checked"?>>
                                    <span class="fa fa-bolt"></span>
                                </li>
                                <li>
                                    <input type="radio" id="fa fa-star" name="MOD_ICONE" value="fa fa-star" <?php if ($modulo["MOD_ICONE"] == "fa fa-star") echo "checked"?>>
                                    <span class="fa fa-star"></span>
                                </li>
                            </ul>

                    </div>
                
                </div>

                <!-- /.box-body -->
                <div class="box-footer">
                    <p class="legenda"><em>*</em> Campos obrigatórios.</p>
                    <button type="submit" class="btn pull-right btn-success" id="salvar">Salvar</button>
                    <button type="reset" class="btn btn-danger" onClick="history.go(-1)" id="limpa" >Cancelar</button>
                </div>
                <!-- /.box-footer -->

            </form>
        </div>
    </div>
</section>