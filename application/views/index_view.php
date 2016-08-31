<div class="container">

    <!-- List group -->
    <div class="container" style="margin-top: 5px;">

        <script type="text/javascript">
            $(document).ready(function () {

                /**
                 * Copiando seleção
                 */
                //$('button').click(function(){

                var texto;
                var cor;

                $(".txt_vers").mouseup(function (e) {

                    //Browsers decentes
                    if (window.getSelection) {
                        texto = String(window.getSelection());

                        //IE
                    } else if (document.selection) {
                        texto = document.selection.createRange().text;

                        //Pior que o IE oO... existe?
                    } else {
                        texto = "Seu browser é paia... não dá para fazer isto!";
                    }

                    // Ativando o modal
                    if (texto.length > 5) {
                        $('#modalFavorito').modal('show');

                        $("#texto").html(texto);
                    }
                });

                // Form novo favorito
                $('#optionsCor1').click(function () {
                    cor = $('#optionsCor1').val()
                });
                $('#optionsCor2').click(function () {
                    cor = $('#optionsCor2').val()
                });
                $('#optionsCor3').click(function () {
                    cor = $('#optionsCor3').val()
                });
                $('#optionsCor4').click(function () {
                    cor = $('#optionsCor4').val()
                });
                $('#optionsCor5').click(function () {
                    cor = $('#optionsCor5').val()
                });
                $('#optionsCor6').click(function () {
                    cor = $('#optionsCor6').val()
                });

                $('#salvar').click(function () {
                    var dados = {
                        vrs: '<?php print $linha->vrs_id; ?>',
                        tes: '<?php print $linha->tes_id; ?>',
                        liv: '<?php print $linha->liv_id; ?>',
                        capitulo: '<?php print $linha->ver_capitulo; ?>',
                        texto: texto,
                        comentario: $('#comentario').val(),
                        cor: cor
                    };

                    $.post('<?php print site_url('home/favorito'); ?>', dados, function (data) {

                        $('#retorno').append(data);
                        setTimeout(function () {
                            location.reload()
                        }, 900);
                    });
                });

                // Formulario para salvar marcação do  versiculo
                $('#modalFavorito').on('hidden', function () {
                    // faça algo
                    location.reload();
                })

            });
        </script>
        <!-- Aplicando cores de marcação -->
        <style type="text/css">
            .optionsCorVermelho {background-color: #f2bfbf;}
            .optionsCorAzul {background-color: #d0d2f5;}
            .optionsCorAmarelo {background-color: #e3e78c;}
            .optionsCorCiano {background-color: #bfebf2;}
            .optionsCorVerde {background-color: #c8f3c7;}
            .optionsCorRoxo {background-color: #f5d0f3;}
            .labelTag {padding: 10px;}

            .versiculoNumero{
                font-style: italic;
                color: #b5111b;
            }
        </style>

        <!-- Corpo do versiculo -->
        <div  class="txt_vers row well well-small" style="text-align: justify;">
        
                    <?php
                    /*
                     * Exibindo os versiculos Bíblicos
                     */
                    print $versiculos_lista;
                    ?>


        </div>

        <!-- Modal de marcar versiculo -->
        <div id="modalFavorito" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-body">

                    <?php
                    if ($this->session->userdata('logado') == true) {
                        ?>
                    <fieldset>
                        <legend>Favorito <i id="retorno"></i></legend>
                        <!-- Form favorito -->

                        <textarea id="texto" rows="4" style="width: 96%;" disabled="disabled" placeholder="Ops ..."></textarea>

                        <select name="listasDeFavoritos" style="width: 99%;">
                            <option value="1">Favoritos</option>
                            <option value="2">Estudo de isaias</option>
    <?php #print (($this->input->get('lugarPesquisa') == 'nt' ) ? 'selected' : '');    ?>
                        </select>

                        <textarea id="comentario" rows="4" style="width: 96%;" placeholder="Texto de comentário..."></textarea>

                        <div class="row-fluid">
                            <label class="label optionsCorVermelho labelTag">
                                <input type="radio" name="cor" id="optionsCor1" value="optionsCorVermelho" checked>
                            </label>

                            <label class="label optionsCorAzul labelTag">
                                <input type="radio" name="cor" id="optionsCor2" value="optionsCorAzul">
                            </label>

                            <label class="label optionsCorAmarelo labelTag">
                                <input type="radio" name="cor" id="optionsCor3" value="optionsCorAmarelo">
                            </label>

                            <label class="label optionsCorCiano labelTag">
                                <input type="radio" name="cor" id="optionsCor4" value="optionsCorCiano" >
                            </label>

                            <label class="label optionsCorVerde labelTag">
                                <input type="radio" name="cor" id="optionsCor5" value="optionsCorVerde">
                            </label>

                            <label class="label optionsCorRoxo labelTag">
                                <input type="radio" name="cor" id="optionsCor6" value="optionsCorRoxo">
                            </label>


                            <button style="float: right; margin-right: 20px;" id="salvar" type="button" class="btn btn-success">Salvar</button> 
                            <button  style="float: right; margin-right: 5px;" class="btn" data-dismiss="modal">Fechar</button>
                        </div>

                        <!-- FIM form favorito -->
                    </fieldset>
    <?php
} else {
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
