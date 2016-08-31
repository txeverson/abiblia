<div class="container">

    <!-- List group -->
    <div class="container" style="margin-top: 5px;">

	<!-- Aplicando cores de marcação -->
	<style type="text/css">
	    .optionsCorVermelho {background-color: #f2bfbf;}
	    .optionsCorAzul {background-color: #d0d2f5;}
	    .optionsCorAmarelo {background-color: #e3e78c;}
	    .optionsCorCiano {background-color: #bfebf2;}
	    .optionsCorVerde {background-color: #c8f3c7;}
	    .optionsCorRoxo {background-color: #f5d0f3;}

	    .versiculoNumero{
		font-style: italic;
		color: #b5111b;
	    }
	</style>

	<!-- Corpo do versiculo -->
	<div  class="txt_vers row well well-small" style="text-align: justify;">
	    <?php
	    print $versiculos_lista;
	    ?>
	</div>

	<!-- Modal de marcar versiculo -->
	<div id="modalFavorito" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-body">

		<?php
		if ($this->session->userdata('logado') == true)
		{
		    ?>
    		<fieldset>
    		    <legend>Favorito <i id="retorno"></i></legend>
    		    <!-- Form favorito -->

    		    <textarea id="texto" rows="4" style="width: 96%;" disabled="disabled"></textarea>

    		    <textarea id="comentario" rows="4" style="width: 96%;"></textarea>

    		    <div class="row-fluid">
    			<label class="label" style="background-color: #f2bfbf; padding: 10px;">
    			    <input type="radio" name="cor" id="optionsCor1" value="optionsCorVermelho" checked>
    			</label>

    			<label class="label" style="background-color: #d0d2f5; padding: 10px;">
    			    <input type="radio" name="cor" id="optionsCor2" value="optionsCorAzul">
    			</label>

    			<label class="label" style="background-color: #e3e78c; padding: 10px;">
    			    <input type="radio" name="cor" id="optionsCor3" value="optionsCorAmarelo">
    			</label>

    			<label class="label" style="background-color: #bfebf2; padding: 10px;">
    			    <input type="radio" name="cor" id="optionsCor4" value="optionsCorCiano" >
    			</label>

    			<label class="label" style="background-color: #c8f3c7; padding: 10px;">
    			    <input type="radio" name="cor" id="optionsCor5" value="optionsCorVerde">
    			</label>

    			<label class="label" style="background-color: #f5d0f3; padding: 10px;">
    			    <input type="radio" name="cor" id="optionsCor6" value="optionsCorRoxo">
    			</label>

    		    </div>

    		    <hr />
    		    <button id="salvar" type="button" class="btn btn-primary">Salvar</button>
    		    <button class="btn" data-dismiss="modal">Fechar</button>

    		    <!-- FIM form favorito -->
    		</fieldset>
		    <?php
		}
		else
		{
		    print $this->load->view('include/btn_login');
		}
		?>




	    </div>
	</div> 
	<!-- FIM modal de marcar do versiculo -->

	<!-- Modal de edição versiculo -->
	<div id="modalEdicaoFavorito" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-body"></div>
	</div> 
	<!-- FIM modal de edição do versiculo -->

	<div>Página processada em <strong>{elapsed_time}</strong> segundos</div>
    </div>
</div>


