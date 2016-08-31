<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{

    private $vrs = 'ara';
    private $tes = 'at';
    private $liv = 'Gn';
    private $cap = 1;
    private $ver = 1;
    private $qt_cap = 0;

    function __construct()
    {
	parent::__construct();

	$this->load->model('biblia_model', 'query');
    }

    /**
     * 
     * Id_ver	Versoẽs				    Qt versiculos
     * 1	    -	Almeida Revisada Imprensa Bíblica   >	    29840
     * 2	    -	Almeida Corrigida e Revisada Fiel     >	    29831
     * 3	    -	Nova Versão Internacional	          >	    29841
     * 4	    -	Sociedade Bíblica Britânica	          >	    29746
     * 5	    -	Almeida Revista e Atualizada	          >      30907
     * 6	    -	Não Identificada		          >	    31076
     * 
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index($vrs = 'ara', $tes = 'at', $liv = 'Gn', $cap = 1, $ver = 0)
    {
	$this->vrs = $vrs;
	$this->tes = $tes;
	$this->liv = $liv;
	$this->cap = $cap;
	$this->ver = $ver;

	# Listando textos da Bíblia
	$versao_row = $this->query->row_versoes($this->vrs);
	$testamento_row = $this->query->row_testamentos($this->tes);
	$livro_row = $this->query->row_livros($this->liv);

	if ($this->session->userdata('logado') == true)
	{
	    $user_id = $this->session->userdata('id');
	}
	else
	{
	    $user_id = 0;
	}

	$versiculo = '';
	$versiculo_lista = $this->query->lista_versiculos($versao_row->vrs_id, $testamento_row->tes_id, $livro_row->liv_id, $this->cap);
	foreach ($versiculo_lista as $key => $linha)
	{
	    $data['linha'] = $linha;

	    # Criando pilha de versiculos
	    $versiculo .= ' ' . $linha->ver_versiculo . ' ' . $linha->ver_texto;
	}

	# Verificando se o capitulo esta no historico
	$data['countHistorico'] = $this->query->count_hist_cap_lido($user_id, $data['linha']->vrs_id, $data['linha']->tes_id, $data['linha']->liv_id, $data['linha']->ver_capitulo);

	# Renderizando texto grifados
	$verRenderizado = $this->_grifando_favoritos($versao_row->vrs_id, $testamento_row->tes_id, $livro_row->liv_id, $this->cap, $versiculo);

	$data['versiculos_lista'] = $verRenderizado;

	# Fim. listando textos da Bíblia

	$data['titulo'] = 'Bíblia - ' . $this->liv . ' ' . $this->cap;
	$this->load->view('include/header', $data);
	$this->_topo_menu($this->vrs, $this->tes, $this->liv, $this->cap, $this->ver);
	$this->load->view('index_view', $data);
	#$this->load->view('include/footer', $data);
	$this->load->view('include/javascript', $data);
    }

    function search()
    {
	$pesquisa = $this->input->get('pesquisa');
	$lugarPesquisa = $this->input->get('lugarPesquisa');
	$vrsPesquisada = $this->input->get('vrsPesquisada');

	$data['pesquisa'] = $pesquisa;
	$data['lugarPesquisa'] = $lugarPesquisa;
	$data['vrsPesquisada'] = $vrsPesquisada;

	$data['titulo'] = 'Biblia - Pesquisa';
	$this->load->view('include/header', $data);
	$this->_topo_menu();
	$this->load->view('search_view', $data);
	#$this->load->view('include/footer', $data);
	$this->load->view('include/javascript', $data);
    }

    function search_load()
    {
		$pesquisa = $this->input->get('pesquisa');
		$lugarPesquisa = $this->input->get('lugarPesquisa');
		$vrsPesquisada = $this->input->get('vrsPesquisada');
		$init = $this->input->post('init');
		$max = $this->input->post('max');

		$result = array(
		    'totalResults' => 0,
		    'dados' => null
		);
		$result["totalResults"] = count($this->query->versiculos_search($pesquisa, $lugarPesquisa, $vrsPesquisada));

		$versiculo_lista = $this->query->versiculos_search_load($pesquisa, $lugarPesquisa, $vrsPesquisada, $max, $init);
		foreach ($versiculo_lista as $key => $linha)
		{
		    $linha->ver_texto = highlight_phrase($linha->ver_texto, $pesquisa, '<span class="text-error">', '</span>');

		    if (!empty($linha->grif_cor))
		    {
			$linha->grif_cor = 'text-' . $linha->grif_cor;
		    }

		    $arr[] = $linha;
		}

		$result["dados"] = $arr;

		echo json_encode($result);
    }

    public function userVerGrifados()
    {

	if (!$this->session->userdata('id'))
	{
	    redirect('login/index');
	}
	$result = $this->query->lista_favoritos_grifados();

	$data['versiculos_lista'] = '';
	$data['versiculos_lista'] .= '<p><span class="label label-inverse"><b>' . count($result) . '</b> versiculos grifados</span></p>';
	foreach ($result as $key => $linha)
	{
	    $data['linha'] = $linha;
	    $data['versiculos_lista'] .= $this->load->view('blocos/lista_meus_grifos_view', $data, true);
	}



	$data['titulo'] = 'Bíblia - ' . $this->session->userdata('nome');
	$this->load->view('include/header', $data);
	$this->_topo_menu($this->vrs, $this->tes, $this->liv, $this->cap, $this->ver);
	$this->load->view('favoritos_view', $data);
	#$this->load->view('include/footer', $data);
	$this->load->view('include/javascript', $data);
    }

    function removerFavoritoGrifado()
    {
	if ($this->session->userdata('logado') == true)
	{
	    $fav_id = $this->input->get('fav_id');
	    $voltar = $this->input->get('voltar');

	    $result = $this->query->_removerFavoritoGrifado($this->session->userdata('id'), $fav_id);

	    if ($result)
	    {
		redirect($voltar);
	    }
	    else
	    {
		print $result;
	    }
	}
	else
	{
	    print 'Falta logar';
	}
    }

    /*
     * Salvando os favoritos e editando
     */

    function favorito()
    {
	$user_id = $this->session->userdata('id');

	if ($this->session->userdata('logado') == true)
	{
	    $fav_id = $this->input->post('fav_id');

	    if ($fav_id > 0)
	    {
		$comentario = $this->input->post('comentario');
		$cor = $this->input->post('cor');

		$result = $this->query->editando_favorito($user_id, $fav_id, $comentario, $cor);
	    }
	    else
	    {
		$vrs = $this->input->post('vrs');
		$tes = $this->input->post('tes');
		$liv = $this->input->post('liv');
		$capitulo = $this->input->post('capitulo');
		$texto = $this->input->post('texto');
		$comentario = $this->input->post('comentario');
		$cor = $this->input->post('cor');

		$result = $this->query->insert_favorito($user_id, $vrs, $tes, $liv, $capitulo, $texto, $comentario, $cor);
	    }

	    if ($result)
	    {
		$txt = '<small class="label label-success">Salvo com sucesso !</small>';
		print $txt;
	    }
	    else
	    {
		$txt = '<small class="label label-important">Erro ao salvar.</small>';
		print $txt;
	    }
	}
	else
	{
	    print '<small class="label label-important">Falta logar.</small>';
	}
    }

    /*
     * Esta funcação é invocada dentro do modal de edição de versiculos favoritos
     */

    function editar_favoritos($fav_id)
    {
	if ($fav_id > 0 && $this->session->userdata('logado') == true)
	{
	    $user_id = $this->session->userdata('id');
	    $data['dados'] = $this->query->row_favoritos($fav_id, $user_id);

	    print $this->load->view('blocos/form_edicao_versiculo_view', $data, true);
	}
    }

    function _grifando_favoritos($vrs, $tes, $liv, $cap, $texto)
    {
	$versiculo = strip_tags($texto);
	$userid = $this->session->userdata('id');
	$versiculo_lista = $this->query->lista_favoritos($userid, $vrs, $tes, $liv, $cap);

	if (!empty($versiculo_lista))
	{
	    foreach ($versiculo_lista as $key => $linha)
	    {
		if ($linha->fav_user_id == $userid)
		{
		    # link para remover marcação de favoritos
		    $url = site_url('home/removerFavoritoGrifado/?fav_id=' . $linha->fav_id . '&voltar=' . current_url());

		    # Link para edição da marcação do texto
		    $url_fav = site_url('home/editar_favoritos/' . $linha->fav_id);

		    # Criando marcação de textos
		    $versiculo = highlight_phrase(
			    $versiculo
			    , $linha->fav_texto
			    , '<span class="' . $linha->fav_cor . '">'
			    , ' <a href="' . $url_fav . '" data-toggle="modal" data-target="#modalEdicaoFavorito"><i class="icon-pencil icon-white"></i></a>'
			    . ' <a onclick="if (!confirm(\'Tem certeza que deseja excluir?\')) return false;"  href="' . $url . '">'
			    . ' <i class="icon-remove icon-white"></i></a>'
			   # . '<a id="exibeComentariVer" data-toggle="popover" data-placement="bottom" '
			   # . 'data-content="'.(empty($linha->fav_comentario) ? "Nenhum comentário" : $linha->fav_comentario).'"'
			   # . 'data-original-title="Nome do favorito"> '
			   # . '<i class="icon-eye-open icon-white"></i></a> '
			    . '</span> '
			    #.empty($linha->fav_comentario) ? "Nenhum comentário" : $linha->fav_comentario
		    );
		}
	    }
	}

	/*
	 * Personalizando os numeros de versiculos
	 */
	$c = 0;
	for ($c = 1; $c < 176; $c++)
	{
	    if ($c == 1)
	    {
		$br = "";
	    }
	    else
	    {
		$br = "<br />";
	    }
	    $seach[] = " $c ";
	    $seach1[] = ">$c ";
	    $replace[] = " $br<small class=\"versiculoNumero\">$c</small> ";
	    $replace1[] = " >$br<small class=\"versiculoNumero\">$c</small> ";
	}

	$versiculo = str_replace($seach, $replace, $versiculo);
	$versiculo = str_replace($seach1, $replace1, $versiculo);

	return $versiculo;
    }

    //---------------------------------------------------------

    /*
     * Salvando capitulo como lido
     */
    function hist_cap_lido($vrs, $tes, $liv, $cap)
    {
	$this->vrs = $vrs;
	$this->tes = $tes;
	$this->liv = $liv;
	$this->cap = $cap;

	if ($this->session->userdata('logado') == true)
	{
	    $user_id = $this->session->userdata('id');

	    $this->query->insert_delete_hist_cap_lido($user_id, $this->vrs, $this->tes, $this->liv, $this->cap);

	    redirect($this->input->get('volta'));
	}
    }

    /*
     * Salvando capitulo como lido
     */

    function marcarLeitura()
    {
	$link = $this->input->get('link');

	if ($this->session->userdata('logado') == true)
	{
	    $user_id = $this->session->userdata('id');

	    $this->query->insert_marcarLeitura($user_id, $link);

	    redirect($link);
	}
    }

    function _topo_menu($vrs = 'ara', $tes = 'at', $liv = 'Gn', $cap = 1, $ver = 1)
    {
	$versao_row = $this->query->row_versoes($vrs);
	$testamento_row = $this->query->row_testamentos($tes);
	$livro_row = $this->query->row_livros($liv);

	if ($this->session->userdata('logado') == true)
	{
	    $data['user_id'] = $this->session->userdata('id');
	}
	else
	{
	    $data['user_id'] = $this->session->userdata('id');
	}

	# Recuperando marcador de leitura
	$data['countMarcadorLeitura'] = $this->query->row_marcarLeitura($data['user_id']);

	$data['versao_lista'] = $this->_versao_lista($vrs, $tes, $liv, $cap, $ver);
	$data['versao_atual'] = $versao_row->vrs_nome;
	$data['versao_atual_mobille'] = $versao_row->vrs_abreviado;
	
	$data['testamento_lista'] = $this->_testamento_lista($vrs, $tes, $liv, $cap);
	$data['testamento_atual'] = $testamento_row->tes_nome;
	$data['testamento_atual_mobille'] = $testamento_row->tes_abreviado;

	$data['livros_lista'] = $this->_livros_lista($vrs, $tes, $liv, $cap);
	$data['livro_atual'] = $livro_row->liv_nome;
	$data['livro_atual_mobille'] = $livro_row->liv_abreviado;

	$data['capitulo_lista'] = $this->_capitulos_lista($vrs, $tes, $liv, $cap, $versao_row->vrs_id, $livro_row->liv_id);
	$data['capitulo_atual'] = $cap;

	$data['btn_cap_ante'] = $this->_capitulo_ante($vrs, $tes, $liv, $cap);

	$data['btn_cap_prox'] = $this->_capitulo_prox($vrs, $tes, $liv, $cap, $this->qt_cap);

	$this->load->view('include/topo', $data);
    }

    /*
     * Criando link do PROXIMO capitulo
     */

    function _capitulo_prox($vrs, $tes, $liv, $cap, $total_cap)
    {
	if ($cap < $total_cap)
	{
	    $ancap = $cap + 1;
	    $data = 'onclick="window.location=\'' .
		    site_url('home/index/'
			    . $vrs . '/'
			    . $tes . '/'
			    . $liv . '/'
			    . $ancap
			    . '\'"');
	    return "<button $data class=\"btn  btn-mini\"><i class=\"icon-arrow-right\"></i></button>";
	}
	else
	{
	    return "<button class=\"btn btn-mini disabled\"><i class=\"icon-arrow-right\"></i></button>";
	}
    }

    //---------------------------------------------------------

    /*
     * Criando link do capitulo ANTERIOR
     */

    function _capitulo_ante($vrs, $tes, $liv, $cap)
    {
	if ($cap > 1)
	{
	    $ancap = $cap - 1;

	    $data = 'onclick="window.location=\'' .
		    site_url('home/index/'
			    . $vrs . '/'
			    . $tes . '/'
			    . $liv . '/'
			    . $ancap
			    . '\'"');

	    return "<button $data class=\"btn btn-mini\"><i class=\"icon-arrow-left\"></i></button>";
	}
	else
	{
	    return "<button class=\"btn btn-mini disabled\"><i class=\"icon-arrow-left\"></i></button>";
	}
    }

    //---------------------------------------------------------

    /*
     * Listando CAPITULOS de acodo com a leitura
     */

    function _capitulos_lista($vrs, $tes, $liv, $cap, $vrsid, $livid)
    {
	$data = '';
	$c = 0;
	$capitulo_lista = $this->query->lista_livros_cap($vrsid, $livid);
	foreach ($capitulo_lista as $key => $linha)
	{
	    $c++;
	    $data .= "<a class=\"btn "
		    . (($linha->ver_capitulo == $cap) ? 'btn-warning disabled' : '')
		    . " btn-small input-mini\"  href=\""
		    . site_url('home/index/'
			    . $vrs . '/'
			    . $tes . '/'
			    . $liv . '/'
			    . $linha->ver_capitulo
			    . '/')
		    . "\">$linha->ver_capitulo</a>";

	    if ($c == 5)
	    {
		$data .= "<br />";
		$c = 0;
	    }

	    # Total de capitulo
	    $this->qt_cap++;
	}

	return $data;
    }

    //---------------------------------------------------------

    /*
     * Listando LIVROS de acodo com a leitura
     */
    function _livros_lista($vrs, $tes, $liv, $cap)
    {
	$data = '';
	$l = 0;
	$livros_lista = $this->query->lista_livros($tes);
	foreach ($livros_lista as $key => $linha)
	{
	    $l++;
	    $data .= "<a class=\"btn "
		    . (($linha->liv_abreviado == $liv) ? 'btn-success disabled' : '')
		    . " btn-small input-medium\" href=\""
		    . site_url('home/index/'
			    . $vrs . '/'
			    . (($linha->liv_tes_id == 1) ? 'at' : 'nt')
			    . '/'
			    . $linha->liv_abreviado
			    . '/'
			    . 1
			    . '/')
		    . "\">$linha->liv_nome</a>";

	    if ($l == 3)
	    {
		$data .= "<br />";
		$l = 0;
	    }
	}
	return $data;
    }

    //---------------------------------------------------------

    /*
     * Listando VERSAO de acodo com a leitura
     */
    function _versao_lista($vrs, $tes, $liv, $cap, $ver = 1)
    {
	$data = '';
	$i = 0;
	$versao_lista = $this->query->lista_versoes();
	foreach ($versao_lista as $key => $linha)
	{
	    $data.= "<a class=\"btn "
		    . (($linha->vrs_abreviado == $vrs) ? 'btn-danger disabled' : '')
		    . " btn-small input-xlarge\"  href=\""
		    . site_url('home/index/'
			    . $linha->vrs_abreviado
			    . '/'
			    . $tes
			    . '/'
			    . $liv
			    . '/'
			    . $cap
			    . '/' . $ver)
		    . "\">$linha->vrs_nome</a><br />";
	    $i++;
	}
	return $data;
    }

    //---------------------------------------------------------

    /*
     * Listando TESTAMENTO de acodo com a leitura
     */
    function _testamento_lista($vrs, $tes, $liv, $cap)
    {

	$data = '';
	$testamento_lista = $this->query->lista_testamentos();
	foreach ($testamento_lista as $key => $linha)
	{
	    $data .= "<a class=\"btn "
		    . (($linha->tes_abreviado == $tes) ? 'btn-info disabled' : '')
		    . " btn-small input-xlarge\" href=\"" . site_url('home/index/'
			    . $vrs
			    . '/'
			    . $linha->tes_abreviado
			    . '/'
			    . (($linha->tes_id == 1) ? 'Gn' : 'Mt'))
		    . "\">$linha->tes_nome</a><br />";
	}
	return $data;
    }

    //---------------------------------------------------------
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */