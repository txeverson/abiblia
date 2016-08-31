<blockquote style="margin-bottom: 4px;">

    <p>
	<a  href="<?php
	print site_url('home/index/'
			. $linha->vrs_abreviado . '/'
			. $linha->tes_abreviado . '/'
			. $linha->liv_abreviado . '/'
			. $linha->ver_capitulo . '/'
			. $linha->ver_versiculo);
	?>"
	    style="cursor: pointer;"  class="<?php print $grifado_ver; ?>" target="_blank">
	    <?php
	    print $grifado_ver_i_abre
		    . highlight_phrase($linha->ver_texto, "$busca", '<span class="text-error">', '</span>')
		    . $grifado_ver_i_fecha;
	    ?>   
	</a>
    </p> 
    <small>

	<?php print $linha->vrs_nome; ?> / 
	<?php print $linha->tes_nome; ?> / 
	<?php print $linha->liv_nome; ?> / 
	Capitulo<?php print $linha->ver_capitulo; ?> / 
	Versiculo <?php print $linha->ver_versiculo; ?>

    </small>
</blockquote>
