<div class="container">
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">

                <!-- div class="brand visible-desktop">B&iacute;blia<i class="icon-fire icon-white"></i></div -->

                <!-- VISÃO PHONE E TABLET-->
                <div class="visible-phone visible-tablet fixed-top">
                    <div class="row">

                        <a class="btn btn-small" href="#myModalVersao" role="button" data-toggle="modal"><b><?php print ucfirst($versao_atual_mobille); ?></b></a>
                        <a class="btn btn-small" href="#myModalTestamento" role="button" data-toggle="modal"><b><?php print ucfirst($testamento_atual_mobille); ?></b></a>
                        <a class="btn btn-small" href="#myModalLivro" role="button" data-toggle="modal"><b><?php print ucfirst($livro_atual_mobille); ?></b></a>
                        <a class="btn btn-small" href="#myModalCapitulo" role="button" data-toggle="modal"><b><?php print $capitulo_atual; ?></b></a>

                        <div class="pull-right">
                            <div class="btn-group">
                                <a href="#myModalMenu" role="button" title="Menu" class="btn btn-small" data-toggle="modal"><i class="icon-user"></i></a>
                                <a title="Home" class="btn btn-small" onclick="window.location = '<?php print site_url(); ?>'"><i class="icon-home"></i></a>
                            </div>
                            <!-- Button to trigger modal -->
                            <a href="#myModal" role="button" title="Pesquisar" class="btn btn-small" data-toggle="modal"><i class="icon-search"></i></a>

                        </div>
                    </div>
                </div>



                <!--  VISÃO DESKTOP -->
                <div class="visible-desktop">
                    <!-- VERSÃO-->

                    <div class="btn-group">
                        <button class="btn btn-small"><i class="icon-chevron-left"></i></button>
                        <button class="btn btn-small" data-toggle="dropdown">
                            <?php print $versao_atual; ?>
                        </button>
                        <ul class="dropdown-menu well-small">
                            <!-- Links de menu dropdown -->
                            <?php print $versao_lista; ?>
                        </ul>
                        <button class="btn btn-small"><i class="icon-chevron-right"></i></button>
                    </div>

                    <!-- TESTAMENTO -->
                    <div class="btn-group">
                        <button class="btn btn-small"><i class="icon-chevron-left"></i></button>
                        <button class="btn btn-small" data-toggle="dropdown">
                            <?php print $testamento_atual; ?>
                        </button>
                        <ul class="dropdown-menu well-small">
                            <!-- Links de menu dropdown -->
                            <?php print $testamento_lista; ?>
                        </ul>
                        <button class="btn btn-small"><i class="icon-chevron-right"></i></button>
                    </div>

                    <!-- LIVRO -->
                    <div class="btn-group">
                        <button class="btn btn-small"><i class="icon-chevron-left"></i></button>
                        <button class="btn btn-small" data-toggle="dropdown">
                            <?php print $livro_atual; ?>
                        </button>
                        <ul class="dropdown-menu well-small">
                            <!-- Links de menu dropdown -->
                            <?php print $livros_lista; ?>
                        </ul>
                        <button class="btn btn-small"><i class="icon-chevron-right"></i></button>
                    </div>

                    <!-- CAPITULO -->
                    <div class="btn-group">
                        <!-- Btn Anterior -->
                        <button class="btn btn-small"><i class="icon-chevron-left"></i></button>
                        
                        <!-- Btn Capitulo -->
                        <button class="btn btn-small" data-toggle="dropdown">
                            Capitulo <?php print $capitulo_atual; ?>
                        </button>
                        <ul class="dropdown-menu well-small">
                            <!-- Links de menu dropdown -->
                            <?php print $capitulo_lista; ?>
                        </ul>

                        <!-- CAPITULO Lido e marcado-->
                        <?php
                        if ($user_id > 0) {

                            if ($countHistorico == 0) {
                                ?>
                                <a href="<?php
                                print site_url('home/hist_cap_lido/' . $linha->vrs_id . '/'
                                                . $linha->tes_id . '/' . $linha->liv_id . '/' . $linha->ver_capitulo . '/?volta=' . current_url());
                                ?>" 
                                   class="btn btn-small"><i class="icon-tag"></i> Nao lido</a>
                                   <?php
                               } else {
                                   ?>
                                <a href="<?php
                                print site_url('home/hist_cap_lido/' . $linha->vrs_id
                                                . '/' . $linha->tes_id . '/' . $linha->liv_id . '/' . $linha->ver_capitulo . '/?volta=' . current_url());
                                ?>" 
                                   class="btn btn-success btn-small"><i class="icon-tags icon-white"></i> Lido</a>
                                   <?php
                               }

                            if ($countMarcadorLeitura->marcador_leitura_user == current_url()) {
                                   ?>

                                <a class="btn btn-danger btn-small disabled"><i class="icon-bookmark icon-white"></i> Marcado</a>

                                <?php
                            } else {
                                ?>

                                <a onclick="if (!confirm('Esta acao removera a ultima marcacao. Deseja continuar?'))
                                            return false;"  href="<?php
                                   print site_url('home/marcarLeitura/?link='
                                                   . current_url());
                                   ?>" class="btn btn-small"><i class="icon-bookmark"></i> Marcar</a>

                                <?php
                            }
                        }
                        ?>
                        <!-- Btn Proximo -->
                        <button class="btn btn-small"><i class="icon-chevron-right"></i></button>
                    </div>

                    <!-- Btn Menu, Pesquisa e Home-->
                    <div class="pull-right">
                        <div class="btn-group">
                            <!--  Btn menu modal-->
                            <a href="#myModalMenu" role="button" title="Menu" class="btn btn-small" data-toggle="modal">
                                <i class="icon-user"></i> <?php #print $this->session->userdata('nome');   ?></a>
                            <!-- Btn Home -->
                            <a title="Home" class="btn btn-small" onclick="window.location = '<?php print site_url(); ?>'"><i class="icon-home"></i></a>

                            <!-- Btn pesquisa modal -->
                            <a href="#myModal" role="button" title="Pesquisar" class="btn btn-small" data-toggle="modal"><i class="icon-search"></i></a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de VERSÃO -->
<div id="myModalVersao" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-body">
        <div class="well-small">
            <?php print $versao_lista; ?>
        </div>
    </div>
</div>

<!-- Modal de TESTAMENTO -->
<div id="myModalTestamento" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-body">
        <div class="well-small">
            <?php print $testamento_lista; ?>
        </div>
    </div>
</div>

<!-- Modal de LIVRO -->
<div id="myModalLivro" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-body">
        <div class="well-small">
            <?php print $livros_lista; ?>
        </div>
    </div>
</div>

<!-- Modal de CAPITULO -->
<div id="myModalCapitulo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-body">
        <div class="well-small">
            <?php print $capitulo_lista; ?>
        </div>
    </div>
</div>



<!-- Modal de login -->
<div id="myModalMenu" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-body">
        <!-- div class="">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div -->

        <div class="well-small">
            <?php
            if ($this->session->userdata('logado') == true) {
                ?>
                <center>
                    <div class="row">
                        <a class="btn btn-small input-large" href="<?php print site_url(); ?>"><i class="icon-book"></i> Bíblia</a>
                        <a class="btn btn-small input-large" href="<?php print site_url('home/userVerGrifados'); ?>"><i class="icon-star-empty"></i> Versiculos grifados</a>
                    </div><br />

                    <?php
                    if (!empty($countMarcadorLeitura->marcador_leitura_user)) {
                        ?>
                        <div class="row">
                            <a class="btn btn-small input-large" href="<?php print $countMarcadorLeitura->marcador_leitura_user; ?>"><i class="icon-bookmark"></i> Ir para Capítulo marcado</a>
                        </div><br />
                        <?php
                    }
                    ?>

                    <div class="row">
                        <a class="btn btn-small input-large" href=""><?php print $this->session->userdata('nome'); ?></a>
                        <a class="btn btn-small input-large btn-danger" href="<?php print site_url('login/sair/?voltar=' . current_url()); ?>">Sair</a>
                    </div>
                </center>
                <?php
            } else {
                print $this->load->view('include/btn_login');
            }
            ?>
        </div>

    </div>
</div>


<!-- Modal Pesquisa --> 
<script type="text/javascript">
    $(document).ready(function () {
        $("input").blur(function () {
            if ($(this).val() == "")
            {
                $(this).css({"border": "1px solid #F00"});
            }
        });

        $("#botao").click(function () {
            var cont = 0;
            $("#formBusca input").each(function () {
                if ($(this).val() == "")
                {
                    $(this).css({"border": "1px solid #F00"});
                    cont++;
                }
            });
            if (cont == 0)
            {
                $("#formBusca").submit();
            }
        });
    });
</script>
<form id="formBusca" class="navbar-search pull-right" method="get" action="<?php print site_url('home/search/'); ?>">
    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Pesquisar na Bíblia</h3>
        </div>
        <div class="modal-body">

            <input type="text" name="pesquisa" value="<?php print $this->input->get('pesquisa'); ?>" class="span5" placeholder="Digíte sua pesquisa">

            <select name="lugarPesquisa" class="span5">
                <option value="td" <?php print (($this->input->get('lugarPesquisa') == 'td' ) ? 'selected' : ''); ?>>Em todo o Antigo e Novo Testamento</option>
                <option value="at" <?php print (($this->input->get('lugarPesquisa') == 'at' ) ? 'selected' : ''); ?>>Em todo o Antigo Testamento</option>
                <option value="nt" <?php print (($this->input->get('lugarPesquisa') == 'nt' ) ? 'selected' : ''); ?>>Em todo o Novo Testamento</option>
            </select>

            <div class="row-fluid">
                <label class="label">
                    <input type="radio" name="vrsPesquisada" id="optionsRadios1" value="todas" <?php print (($this->input->get('vrsPesquisada') == 'todas' ) ? 'checked' : ''); ?>>
                    Todas
                </label>

                <label class="label">
                    <input type="radio" name="vrsPesquisada" id="optionsRadios3" value="acf" <?php print (($this->input->get('vrsPesquisada') == 'acf' ) ? 'checked' : ''); ?>>
                    Almeida Corrigida e Revisada Fiel ACF
                </label>

                <label class="label">
                    <input type="radio" name="vrsPesquisada" id="optionsRadios1" value="ari" <?php print (($this->input->get('vrsPesquisada') == 'ari' ) ? 'checked' : ''); ?>>
                    Almeida Revisada Imprensa Bíblica ARI
                </label>

                <label class="label">
                    <input type="radio" name="vrsPesquisada" id="optionsRadios2" value="ara" 
                    <?php print ((empty($this->input->get('vrsPesquisada'))) ? 'checked' : ''); ?>
                           <?php print (($this->input->get('vrsPesquisada') == 'ara' ) ? 'checked' : ''); ?>>
                    Almeida Revista e Atualizada ARA
                </label>

                <label class="label">
                    <input type="radio" name="vrsPesquisada" id="optionsRadios1" value="nvi" <?php print (($this->input->get('vrsPesquisada') == 'nvi' ) ? 'checked' : ''); ?>>
                    Nova Versão Internacional NVI
                </label>

                <label class="label">
                    <input type="radio" name="vrsPesquisada" id="optionsRadios1" value="sbb" <?php print (($this->input->get('vrsPesquisada') == 'sbb' ) ? 'checked' : ''); ?>>
                    Sociedade Bíblica Britânica SBB
                </label>
            </div>

        </div>
        <div class="modal-footer">
            <button id="botao" type="button" class="btn btn-primary">Buscar</button>
        </div>
    </div>
</form>