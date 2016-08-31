<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Biblia_Model extends CI_Model
{

    function __construct()
    {
	parent::__construct();
    }

    # salvando os Favoritos

    function insert_favorito($userid, $vrs, $tes, $liv, $capitulo, $texto, $comentario, $cor)
    {
	$this->fav_user_id = $userid;
	$this->fav_vrs_id = $vrs;
	$this->fav_tes_id = $tes;
	$this->fav_liv_id = $liv;
	$this->fav_capitulo = $capitulo;
	$this->fav_texto = $texto;
	$this->fav_comentario = $comentario;
	$this->fav_cor = $cor == '0' ? 'optionsCorVermelho' : $cor;

	$this->fav_texto = str_replace("\n", "", $this->fav_texto);
	$this->fav_texto = str_replace("\r", "", $this->fav_texto);

	/*
	  $where = array('grif_user_id' => $id_user, 'grif_ver_id' => $id_ver);

	  $qt = $this->db->where('grif_user_id', $id_user)
	  ->where('grif_ver_id', $id_ver)
	  ->count_all_results('grifados');
	 */
	$qt = 0;
	if ($qt > 0)
	{
	    return $this->db->delete('favoritos', $where);
	}
	else
	{
	    return $this->db->insert('favoritos', $this);
	}
    }

    # editando os Favoritos

    function editando_favorito($userid, $fav_id, $comentario, $cor)
    {
	$this->fav_comentario = $comentario;
	$cor == '0' ? '' : $this->fav_cor = $cor;

	return $this->db->update('favoritos', $this, array('fav_id' => $fav_id, 'fav_user_id' => $userid));
    }

    /*
     * Esta função cadastra capitulos no historico de lidos, como também os exclui
     */

    function insert_delete_hist_cap_lido($userid, $vrs, $tes, $liv, $cap)
    {
	$this->hcl_user_id = $userid;
	$this->hcl_vrs = $vrs;
	$this->hcl_tes = $tes;
	$this->hcl_liv = $liv;
	$this->hcl_cap = $cap;

	$qtH = $this->count_hist_cap_lido($this->hcl_user_id, $this->hcl_vrs, $this->hcl_tes, $this->hcl_liv, $this->hcl_cap);

	if ($qtH > 0)
	{
	    $where = array(
		'hcl_user_id' => $this->hcl_user_id,
		'hcl_vrs' => $this->hcl_vrs,
		'hcl_tes' => $this->hcl_tes,
		'hcl_liv' => $this->hcl_liv,
		'hcl_cap' => $this->hcl_cap
	    );
	    return $this->db->delete('hist_cap_lido', $where);
	}
	else
	{
	    return $this->db->insert('hist_cap_lido', $this);
	}
    }

    function count_hist_cap_lido($userid, $vrs, $tes, $liv, $cap)
    {
	$this->db->where('hcl_user_id', $userid);
	$this->db->where('hcl_vrs', $vrs);
	$this->db->where('hcl_tes', $tes);
	$this->db->where('hcl_liv', $liv);
	$this->db->where('hcl_cap', $cap);

	return $this->db->count_all_results('hist_cap_lido');
    }

    function insert_marcarLeitura($userid, $link)
    {
	$this->marcador_leitura_user = $link;

	return $this->db->update('user', $this, array('id_user' => $userid));
    }

    function row_marcarLeitura($userid)
    {

	$this->db->where('id_user', $userid);

	$query = $this->db->get('user');

	return $query->row();
    }

    /*
     * Selecionando versiculos
     */

    function lista_versiculos($vrs = 5, $tes = 1, $liv = 1, $cap = 1, $ver = 1)
    {
	#$this->db->limit($limit, $start);
	$this->db->where('ver_vrs_id', $vrs)
		->where('ver_liv_id', $liv)
		->where('ver_tes_id', $tes)
		->where('ver_capitulo', $cap)
		#->where_not_in('vrs_abreviado', 'nai')
		#->where('ver_versiculo', $ver)
		->join('livros', 'livros.liv_id = versiculos.ver_liv_id', 'left')
		->join('testamentos', 'testamentos.tes_id = versiculos.ver_tes_id', 'left')
		->join('versoes', 'versoes.vrs_id = versiculos.ver_vrs_id', 'left')
		->order_by('ver_versiculo', 'ASC')
		->from('versiculos');

	$query = $this->db->get();

	return $query->result();
    }

    function lista_favoritos($useid = 0, $vrs = 5, $tes = 1, $liv = 1, $cap = 1)
    {
	#$this->db->limit($limit, $start);
	$this->db->where('fav_user_id', $useid)
		->where('fav_vrs_id', $vrs)
		->where('fav_liv_id', $liv)
		->where('fav_tes_id', $tes)
		->where('fav_capitulo', $cap)
		->from('favoritos');

	$query = $this->db->get();

	return $query->result();
    }

    /*
     * Selecionando versiculos grifado
     */

    function lista_favoritos_grifados()
    {
	#$this->db->limit($limit, $start);
	$this->db->where('fav_user_id', $this->session->userdata('id'))
		->join('versoes', 'versoes.vrs_id = favoritos.fav_vrs_id')
		->join('livros', 'livros.liv_id = favoritos.fav_liv_id')
		->join('testamentos', 'testamentos.tes_id = favoritos.fav_tes_id')
		->order_by('fav_id', 'DESC')
		->from('favoritos');

	$query = $this->db->get();

	return $query->result();
    }

    function row_favoritos($fav_id, $user_id)
    {
	$this->db->where('fav_id', $fav_id)
		->where('fav_user_id', $user_id)
		->from('favoritos');

	$query = $this->db->get();

	return $query->row();
    }

    /*
     * Selecionando versiculos
     */

    function versiculos_search($busca, $tes = 0, $vrs = 0)
    {
	#$this->db->limit($limit, $start);
	$array = array('ver_texto' => $busca);

	if ($tes != 'td')
	{
	    $this->db->where('tes_abreviado', $tes);
	}
	if ($vrs != 'todas')
	{
	    $this->db->where('vrs_abreviado', $vrs);
	}

	$this->db #->where_not_in('vrs_abreviado', 'nai')
		->like($array)
		->join('livros', 'livros.liv_id = versiculos.ver_liv_id')
		->join('testamentos', 'testamentos.tes_id = versiculos.ver_tes_id')
		->join('versoes', 'versoes.vrs_id = versiculos.ver_vrs_id')
		->join('grifados', 'grifados.grif_ver_id = versiculos.ver_id', 'left')
		->order_by('vrs_id', 'ASC')
		->from('versiculos');

	$query = $this->db->get();

	return $query->result();
    }

    function versiculos_search_load($busca, $tes = 0, $vrs = 0, $limit = 300, $start = 0)
    {

	$array = array('ver_texto' => $busca);

	if ($tes != 'td')
	{
	    $this->db->where('tes_abreviado', $tes);
	}
	if ($vrs != 'todas')
	{
	    $this->db->where('vrs_abreviado', $vrs);
	}

	$this->db #->where_not_in('vrs_abreviado', 'nai')
		->like($array)
		->join('livros', 'livros.liv_id = versiculos.ver_liv_id')
		->join('testamentos', 'testamentos.tes_id = versiculos.ver_tes_id')
		->join('versoes', 'versoes.vrs_id = versiculos.ver_vrs_id')
		->join('grifados', 'grifados.grif_ver_id = versiculos.ver_id', 'left')
		->limit($limit, $start)
		->order_by('vrs_id', 'ASC');


	$query = $this->db->get('versiculos');

	return $query->result();
    }

    function row_versiculos($vrs = 5, $tes = 1, $liv = 1, $cap = 1, $ver = 1)
    {
	$this->db->where('ver_vrs_id', $vrs)
		->where('ver_liv_id', $liv)
		->where('ver_tes_id', $tes)
		->where('ver_capitulo', $cap)
		#->where_not_in('vrs_abreviado', 'nai')
		->join('livros', 'livros.liv_id = versiculos.ver_liv_id')
		->join('testamentos', 'testamentos.tes_id = versiculos.ver_tes_id')
		->join('versoes', 'versoes.vrs_id = versiculos.ver_vrs_id')
		->from('versiculos');

	$query = $this->db->get();

	return $query->row();
    }

    //------------------------------------------------

    /*
     * Selecionando livros
     */

    function lista_livros($tes_abr = 'at')
    {
	$this->db->where('tes_abreviado', $tes_abr)
		->join('testamentos', 'testamentos.tes_id = livros.liv_tes_id')
		->from('livros');

	$query = $this->db->get();

	return $query->result();
    }

    function lista_livros_cap($vrs = 5, $liv = 1)
    {
	$this->db->distinct('ver_capitulo')
		->select('ver_capitulo')
		->where('ver_vrs_id', $vrs)
		->where('ver_liv_id', $liv)
		->order_by('ver_capitulo', 'ASC')
		->from('versiculos');

	$query = $this->db->get();

	return $query->result();
    }

    function row_livros($abreviacao = 'Gn')
    {
	$this->db->where('liv_abreviado', $abreviacao)
		->join('testamentos', 'testamentos.tes_id = livros.liv_tes_id')
		->from('livros');

	$query = $this->db->get();

	return $query->row();
    }

    //------------------------------------------------

    /*
     * Selecionando testamentos
     */

    function lista_testamentos()
    {
	$query = $this->db->get('testamentos');

	return $query->result();
    }

    function row_testamentos($abreviacao = 'at')
    {
	$this->db->where('tes_abreviado', $abreviacao)
		->from('testamentos');
	$query = $this->db->get();

	return $query->row();
    }

    //------------------------------------------------

    /*
     * Selecionando versões
     */
    function lista_versoes()
    {
	$query = $this->db->where_not_in('vrs_abreviado', 'nai')
		->order_by('vrs_nome', 'asc')
		->get('versoes');

	return $query->result();
    }

    function row_versoes($abreviacao = 'ara')
    {
	$this->db->where('vrs_abreviado', $abreviacao)
		#->where_not_in('vrs_abreviado', 'nai')
		->order_by('vrs_nome', 'asc')
		->from('versoes');

	$query = $this->db->get();

	return $query->row();
    }

    //-------------------------------------------------

    function _removerFavoritoGrifado($id_user, $id_fav)
    {

	$this->grif_user_id = $id_user;
	$this->grif_ver_id = $id_fav;

	$where = array('fav_user_id' => $id_user, 'fav_id' => $id_fav);

	$qt = $this->db->where('fav_user_id', $id_user)
		->where('fav_id', $id_fav)
		->count_all_results('favoritos');

	if ($qt > 0)
	{
	    return $this->db->delete('favoritos', $where);
	}
	else
	{
	    return 0;
	}
    }

    function update()
    {

	$this->ver_vrs_id = 6;
	$where = "ver_liv_id between 40 and 66";
	$where = "ver_vrs_id=0";

	#$this->db->update('versiculos', $this, $where);
    }

    function count_ver()
    {
	$this->db->where('ver_vrs_id', 6);
	#$this->db->where('ver_liv_id', 1);
	#$this->db->where('ver_capitulo', 1);
	return $this->db->count_all_results('versiculos');
    }

    function query_row_conteudo($id, $cat)
    {
	$this->db->where('id_conteudo', $id)
		->where('id_cat_conteudo', $cat)
		->from('admin_conteudo');
	$query = $this->db->get();

	$query = $query->row();

	return $query;
    }

    function delete_img_conteudo($id, $id_cat)
    {
	$this->capa_conteudo = '';
	$this->db->update('admin_conteudo', $this, array('id_conteudo' => $id, 'id_cat_conteudo' => $id_cat));
	redirect('admin/home/conteudo/form/' . $id_cat . '/' . $id);
    }

    function status_conteudo($id, $id_cat, $status)
    {
	$this->status_conteudo = $status;
	$this->db->update('admin_conteudo', $this, array('id_conteudo' => $id, 'id_cat_conteudo' => $id_cat));
	redirect('admin/home/conteudo/list/' . $id_cat);
    }

    function count_conteudo()
    {

	return $this->db->count_all('admin_conteudo');
    }

    function verif_existencia_galeria($idcat, $idcont)
    {
	return $this->db->where('id_cat_img', $idcat)
			->where('id_con_img', $idcont)
			->count_all_results('admin_galerias');
    }

}
