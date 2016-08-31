<kbd>
    <Numero do versiculo 
    <a href="#myVer<?php print $linha->ver_id; ?>"  role="button" data-toggle="modal" class="btn btn-mini <?php print $grifado_ver . ' ' . $marcar_ver; ?>" >
	<?php print $linha->ver_versiculo; ?>
    </a> 

    <!-- Texto do versiculo -->
    <small class="text-warning"><i><?php print $linha->ver_versiculo; ?></i></small> 
    <?php
    print $b_abre_selec
	    . $b_abre_grif
	    . $linha->ver_texto
	    . $b_fecha_grif
	    . $b_fecha_selec;
    ?>
</kbd>
