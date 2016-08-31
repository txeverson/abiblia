<script type="text/javascript">
    $(document).ready(function() {
	/* 
	 * Manipulando modo de edição
	 */

	var cor;
	// Form de edição
	$('#optionsCor1E').click(function() {
	    cor = $('#optionsCor1E').val()
	});
	$('#optionsCor2E').click(function() {
	    cor = $('#optionsCor2E').val()
	});
	$('#optionsCor3E').click(function() {
	    cor = $('#optionsCor3E').val()
	});
	$('#optionsCor4E').click(function() {
	    cor = $('#optionsCor4E').val()
	});
	$('#optionsCor5E').click(function() {
	    cor = $('#optionsCor5E').val()
	});
	$('#optionsCor6E').click(function() {
	    cor = $('#optionsCor6E').val()
	});

	$('#salvarEdicao').click(function() {

	    var dados = {
		fav_id: $('#fav_id').val(),
		comentario: $('#comentarioEditado').val(),
		cor: cor
	    };

	    $.post('http://localhost/biblia/home/favorito', dados, function(data) {

		$('#retornoE').append(data);
		setTimeout(function(){location.reload()},900);
	    });
	});

	// Formulario de edição do versiculo
	$('#modalEdicaoFavorito').on('hidden', function() {
	    // faça algo
	    location.reload();
	})

    });
    

</script>

<form action="<?php print site_url('home/favorito'); ?>" method="post">
    <fieldset>
	<legend>Editando Favorito<i id="retornoE"></i></legend>
	<!-- Form favorito -->

	<input type="hidden" name="fav_id" id="fav_id" value="<?php print $dados->fav_id; ?>">

	<textarea rows="4" style="width: 96%;" disabled="disabled"><?php print $dados->fav_texto; ?></textarea>

	<textarea id="comentarioEditado" name="comentarioEditado"  rows="4" style="width: 96%;"><?php print $dados->fav_comentario; ?></textarea>

	<div class="row-fluid">
	    <label class="label" style="background-color: #f2bfbf; padding: 10px;">
		<input type="radio" name="cor" id="optionsCor1E" value="optionsCorVermelho" <?php print $dados->fav_cor == 'optionsCorVermelho' ? 'checked' : ''; ?>>
	    </label>

	    <label class="label" style="background-color: #d0d2f5; padding: 10px;">
		<input type="radio" name="cor" id="optionsCor2E" value="optionsCorAzul" <?php print $dados->fav_cor == 'optionsCorAzul' ? 'checked' : ''; ?>>
	    </label>

	    <label class="label" style="background-color: #e3e78c; padding: 10px;">
		<input type="radio" name="cor" id="optionsCor3E" value="optionsCorAmarelo" <?php print $dados->fav_cor == 'optionsCorAmarelo' ? 'checked' : ''; ?>>
	    </label>

	    <label class="label" style="background-color: #bfebf2; padding: 10px;">
		<input type="radio" name="cor" id="optionsCor4E" value="optionsCorCiano" <?php print $dados->fav_cor == 'optionsCorCiano' ? 'checked' : ''; ?>>
	    </label>

	    <label class="label" style="background-color: #c8f3c7; padding: 10px;">
		<input type="radio" name="cor" id="optionsCor5E" value="optionsCorVerde" <?php print $dados->fav_cor == 'optionsCorVerde' ? 'checked' : ''; ?>>
	    </label>

	    <label class="label" style="background-color: #f5d0f3; padding: 10px;">
		<input type="radio" name="cor" id="optionsCor6E" value="optionsCorRoxo" <?php print $dados->fav_cor == 'optionsCorRoxo' ? 'checked' : ''; ?>>
	    </label>

	</div>

	<hr />
	<button id="salvarEdicao" type="button" class="btn btn-success">Salvar</button>
	<button class="btn btn-inverse" data-dismiss="modal">Fechar</button>

	<!-- FIM form favorito -->
    </fieldset>
</form>