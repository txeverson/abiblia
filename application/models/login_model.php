<?php

Class Login_Model extends CI_Model
{

    function __construct()
    {
	parent::__construct();
    }

    # VALIDA USUÁRIO

    function validate($email, $senha, $voltar)
    {
	#$login = explode('@', 'eversonteixeira@cosibra.com.br', 2);
	#print_r($login[0]);
	$this->db->where('email_user', $email)
		->where('senha_user', $senha)
		->where('status_user', 1)
		->from('user'); // Verifica o status do usuário

	$query = $this->db->get();

	if ($query->num_rows == 1)
	{
	    $query = $query->row();
	    $dados = array(
		'id' => $query->id_user,
		'nome' => $query->name_user,
		'login' => $query->login_user,
		'status' => $query->status_user,
		'logado' => true,
	    );
	    $this->session->set_userdata($dados);

	    redirect($query->marcador_leitura_user);
	    # redirect($voltar);
	}
	else
	{
	    # redirect(base_url('welcome'));
	    $this->session->set_flashdata('erroLogin', '<div class="alert alert-error">Erro ao fazer login</div>');
	}
    }

    function validandoUserGoogle($primeiro_nome, $segundo_nome, $email, $oauth_provider_user, $status)
    {
	$this->db->where('email_user', $email)
		->where('oauth_provider_user', $oauth_provider_user)
		->from('user'); // Verifica o status do usuário

	$query = $this->db->get();

	if (!empty($query->num_rows))
	{
	    # O usuario ja cadastrado
	    $query = $query->row();

	    # Criando a session
	    $dados = array(
		'id' => $query->id_user,
		'nome' => $query->name_user,
		'login' => $query->login_user,
		'email' => $query->email_user,
		'servidor' => $query->oauth_provider_user,
		'status' => $query->status_user,
		'logado' => true,
	    );
	    $this->session->set_userdata($dados);

	    return true;
	}
	else
	{

	    /*
	     * Cadastrando usuario pelo Google
	     */
	    $this->name_user = "$primeiro_nome $segundo_nome";
	    $this->login_user = strtolower($primeiro_nome);
	    $this->oauth_provider_user = $oauth_provider_user;
	    $this->email_user = strtolower($email);
	    $this->status_user = $status;

	    $this->db->insert('user', $this);

	    $this->db->where('email_user', $email)
		    ->where('oauth_provider_user', $oauth_provider_user)
		    ->from('user'); // Verifica o status do usuário

	    $query = $this->db->get();

	    if (!empty($query->num_rows))
	    {
		# O usuario ja cadastrado
		$query = $query->row();

		# Criando a session
		$dados = array(
		    'id' => $query->id_user,
		    'nome' => $query->name_user,
		    'login' => $query->login_user,
		    'email' => $query->email_user,
		    'servidor' => $query->oauth_provider_user,
		    'status' => $query->status_user,
		    'logado' => true,
		);
		$this->session->set_userdata($dados);

		return true;
	    }
	}

	return false;
    }

    function logado()
    {
	$logado = $this->session->userdata('logado');

	if ($logado == false)
	{
	    redirect();
	}
    }

}
