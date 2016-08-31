$(function() {

    carregar(0, 46, 'load.php');

    /*
     $("a.carregar-mais").click(function(evento) {
     evento.preventDefault();
     var init = $("ol li").length;
     
     carregar(init, 15, 'load.php');
     
     });
     */
    $(document).ready(function() {
        //evento scroll
        $(window).scroll(function() {
            //quando o usuario chegar no fim da rolagem
            if ($(window).scrollTop() + $(window).height() == $(document).height()) {
                var init = $("ol li").length;

                carregar(init, 15, 'load.php');

            }
        });
    });

    function carregar(init, max, url) {
        var dados = {init: init, max: max};

        //$("ol").append('<li>Carregando...</li>');

        $.post(url, dados, function(data) {

            $("ol li").last().remove();

            for (i = 0; i < data.dados.length; i++) {
                $("ol").append('<li>' + data.dados[i].liv_nome + '</li>');
            }

            var conta = $("ol li").length;
            /*
             if (conta == data.totalResults) {
             $("a.carregar-mais").hide();
             }
             */
        }, "json");
    }

});