<div class="container">
    <script type="text/javascript">
	$(function() {

	    carregar(0, 30, '<?php print site_url('home/search_load/?pesquisa=' . $pesquisa . '&lugarPesquisa=' . $lugarPesquisa . '&vrsPesquisada=' . $vrsPesquisada . ''); ?>');

	    $("a.carregar-mais").click(function(evento) {
		evento.preventDefault();
		var init = $("ol li").length;

		carregar(init, 30, '<?php print site_url('home/search_load/?pesquisa=' . $pesquisa . '&lugarPesquisa=' . $lugarPesquisa . '&vrsPesquisada=' . $vrsPesquisada . ''); ?>');
	    });

	    function carregar(init, max, url) {
		var dados = {init: init, max: max};

		$("ol").append('<li>Carregando...</li>');
		$("#total").append('0');

		$.post(url, dados, function(data) {

		    $("ol li").last().remove();

		    for (i = 0; i < data.dados.length; i++) {
			var txt = '<blockquote style="margin-bottom: 4px;">'
				+ '<p><a  '
				+ 'href="<?php print site_url('home/index'); ?>/'
				+ data.dados[i].vrs_abreviado + '/'
				+ data.dados[i].tes_abreviado + '/'
				+ data.dados[i].liv_abreviado + '/'
				+ data.dados[i].ver_capitulo + '/'
				+ data.dados[i].ver_versiculo + '"'
				+ 'style="cursor: pointer;"  class="' + data.dados[i].grif_cor + '" target="_blank">'
				+ data.dados[i].ver_texto
				+ '</a></p>'
				+ '<small>' + data.dados[i].vrs_nome + ' / '
				+ data.dados[i].tes_nome + ' / '
				+ data.dados[i].liv_nome
				+ ' / Capitulo ' + data.dados[i].ver_capitulo
				+ ' / Versiculo ' + data.dados[i].ver_versiculo
				+ '</small>'
				+ '</blockquote>';

			$("ol").append('<li>' + txt + '</li>');
		    }

		    var conta = $("ol li").length;

		    if (conta == max || conta < max) {
			$("#total").append(data.totalResults);
		    }

		    if (conta == data.totalResults) {
			$("a.carregar-mais").hide();
		    }

		}, "json");
	    }

	});
    </script>


    <!-- List group -->
    <style type="text/css">
	ol li{
	    list-style-type: none; 
	}
    </style>
    <div class="container" style="margin-top: 5px;">
	<div class="row well well-small text-center">
	    <p><span class="label label-important">RESULTADO: <b id="total"></b> versiculos localizados</span></p>
	    <ol></ol>
	    <a href="#" class="carregar-mais  btn btn-mini btn-success">Carregar Mais</a>

	</div>

	<div>Página processada em <strong>{elapsed_time}</strong> segundos</div>
    </div>
</div>