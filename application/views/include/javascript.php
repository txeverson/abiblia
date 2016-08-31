<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php print base_url('assets/js/jquery.js'); ?>"></script>
<script src="<?php print base_url('assets/js/bootstrap-transition.js'); ?>"></script>
<script src="<?php print base_url('assets/js/bootstrap-alert.js'); ?>"></script>
<script src="<?php print base_url('assets/js/bootstrap-modal.js'); ?>"></script>
<script src="<?php print base_url('assets/js/bootstrap-dropdown.js'); ?>"></script>
<script src="<?php print base_url('assets/js/bootstrap-scrollspy.js'); ?>"></script>
<script src="<?php print base_url('assets/js/bootstrap-tab.js'); ?>"></script>
<script src="<?php print base_url('assets/js/bootstrap-tooltip.js'); ?>"></script>
<script src="<?php print base_url('assets/js/bootstrap-popover.js'); ?>"></script>
<script src="<?php print base_url('assets/js/bootstrap-button.js'); ?>"></script>
<script src="<?php print base_url('assets/js/bootstrap-collapse.js'); ?>"></script>
<script src="<?php print base_url('assets/js/bootstrap-carousel.js'); ?>"></script>
<script src="<?php print base_url('assets/js/bootstrap-typeahead.js'); ?>"></script>
<script src="<?php print base_url('assets/js/bootstrap-datetimepicker.min.js'); ?>"></script>
<script src="<?php print base_url('assets/js/bootstrap-datetimepicker.pt-BR.js'); ?>"></script>
<script src="<?php print base_url('assets/js/bootstrap.file-input.js'); ?>"></script>
<script src="<?php print base_url('assets/ckeditor/ckeditor.js'); ?>"></script>


<script type="text/javascript">
    $(function()
    {
	//$("#exibeComentariVer").popover();
    });

    // <textarea id="editor1">
    // Configurando os editores do campo textarea
    CKEDITOR.replace('editorFull', {
	toolbar: 'Full'
    });
    CKEDITOR.replace('editorBasic', {
	toolbar: 'Basic'
    });

    // ------------------------------------------------------------------

    function abrir(URL) {
	var width = 800;
	var height = 550;
	var left = 0;
	var top = 0;
	window.open(
		URL,
		'janela',
		'width=' + width + ', \n\
                height=' + height + ', \n\
                top=' + top + ', \n\
                left=' + left + ', \n\
                scrollbars=yes, \n\
                status=no, \n\
                toolbar=no, \n\
                location=no, \n\
                directories=no, \n\
                menubar=no, \n\
                resizable=no, \n\
                fullscreen=yes'
		);
    }

    $('#datetime').datetimepicker({
	format: 'dd/MM/yyyy',
	//format: 'dd/MM/yyyy hh:mm:ss',
	language: 'pt-BR'
    });

    // Formatando o campo file 
    //$('input[type=file]').bootstrapFileInput();
    $('.file-inputs').bootstrapFileInput();

    // Criando dependencia de campos select   
    $(document).ready(function() {
	// Evento change no campo tipo  
	$("select[name=setor]").change(function() {
	    $("select[name=funcao]").html('<option value="">Carregando...</option>');
	    $.post("http://192.168.254.201/phpzon_medicina/index/funcionario/?pagina=select", {setor: $(this).val()},
	    function(valor) {
		$("select[name=funcao]").html(valor);
	    }
	    );
	});

    });
    // Macara dos capos peso e altura e Calculo de IMC
    function mascara(src, mask) {
	var i = src.value.length;
	var saida = mask.substring(0, 1);
	var texto = mask.substring(i);

	if (texto.substring(0, 1) !== saida)
	{
	    src.value += texto.substring(0, 1);
	}
    }

    function SomenteNumero(e) {
	var tecla = (window.event) ? event.keyCode : e.which;
	if ((tecla > 47 && tecla < 58))
	    return true;
	else {
	    if (tecla == 8 || tecla == 0)
		return true;
	    else
		return false;
	}
    }



</script>

</body>
</html>