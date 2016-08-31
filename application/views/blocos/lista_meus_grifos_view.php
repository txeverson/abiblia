<blockquote  style="margin-bottom: 4px;" class="<?php print $linha->fav_cor; ?>">
    <div class="container-fluid">
    <div class="label label-info">
	<?php
	print strtoupper($linha->vrs_abreviado)
		. ' / '
		. $linha->liv_nome
		. ' / Capitulo '
		. $linha->fav_capitulo;
	?>: 
    </div>
    <a  href="<?php
    print site_url('home/index/'
		    . $linha->vrs_abreviado
		    . '/' . $linha->tes_abreviado
		    . '/' . $linha->liv_abreviado
		    . '/' . $linha->fav_capitulo);
    ?>  " target="_blank">

	<?php print $linha->fav_texto; ?> 

    </a>

    <small>
	<?php print empty($linha->fav_comentario) ? 'Nenhum comentário' : $linha->fav_comentario; ?>
    </small>

    <a style="float: right" href="
    <?php
    print site_url('home/removerFavoritoGrifado/?fav_id='
		    . $linha->fav_id
		    . '&voltar='
		    . current_url());
    ?>" 
       ><i class="icon-trash"></i></a>

</div>
</blockquote>