<?php

Class Login extends CI_Controller
{

    function __construct()
    {
	parent::__construct();
	$this->load->model('login_model', 'loginmodel');
	date_default_timezone_set('America/Sao_Paulo');

	/*
	 * Importando biblioteca de autenticação Google
	 */
	$this->load->helper('openid');
    }

    public function index()
    {
	$data['titulo'] = 'Login';
	$logado = $this->session->userdata('logado');
	if ($logado == true)
	{
	    redirect(site_url());
	}

	#$user  = $this->security->xss_clean(strip_tags($this->input->post('username')));
	$user = $this->security->xss_clean(strip_tags($this->input->post('username')));
	$senha = $this->security->xss_clean(strip_tags(md5($this->input->post('password'))));


	$this->loginmodel->validate($user, $senha, $this->input->get('voltar'));

	$this->load->view('login/login', $data);
    }

    /*
     * Teste de login com GOOGLE
     */

    public function _google()
    {
	echo '<h1>Welcome</h1>';
	echo '<br/>id : ' . $this->session->userdata('id');
	echo '<br/>Name : ' . $this->session->userdata('nome');
	echo '<br/>Email : ' . $this->session->userdata('email');
	echo '<br/>You are login with : ' . $this->session->userdata('servidor');
	echo '<br/>Logout from <a href="' . site_url('login/sair/?voltar=' . current_url()) . '">' . $this->session->userdata('servidor') . '</a>';
    }

    public function loginGoogle()
    {
	define('CALLBACK_URL', site_url('login/getGoogleData/?voltar=' . $this->input->get('voltar')));

	// Creating new instance
	$openid = new LightOpenID;
	$openid->identity = 'https://www.google.com/accounts/o8/id';
	//setting call back url
	$openid->returnUrl = CALLBACK_URL;
	//finding open id end point from google
	$endpoint = $openid->discover('https://www.google.com/accounts/o8/id');
	$fields = '?openid.ns=' . urlencode('http://specs.openid.net/auth/2.0') .
		'&openid.return_to=' . urlencode($openid->returnUrl) .
		'&openid.claimed_id=' . urlencode('http://specs.openid.net/auth/2.0/identifier_select') .
		'&openid.identity=' . urlencode('http://specs.openid.net/auth/2.0/identifier_select') .
		'&openid.mode=' . urlencode('checkid_setup') .
		'&openid.ns.ax=' . urlencode('http://openid.net/srv/ax/1.0') .
		'&openid.ax.mode=' . urlencode('fetch_request') .
		'&openid.ax.required=' . urlencode('email,firstname,lastname') .
		'&openid.ax.type.firstname=' . urlencode('http://axschema.org/namePerson/first') .
		'&openid.ax.type.lastname=' . urlencode('http://axschema.org/namePerson/last') .
		'&openid.ax.type.email=' . urlencode('http://axschema.org/contact/email');
	header('Location: ' . $endpoint . $fields);
    }

    public function getGoogleData()
    {
	$openid_sig = $this->input->get('openid_sig');
	
	if (!empty($openid_sig) && strlen($openid_sig)>20)
	{
	    if (!empty($this->input->get('openid_ext1_value_firstname')) && !empty($this->input->get('openid_ext1_value_lastname')) && !empty($this->input->get('openid_ext1_value_email')))
	    {
		$primeiro_nome = $_GET['openid_ext1_value_firstname'];
		$segundo_nome = $_GET['openid_ext1_value_lastname'];
		$email = $_GET['openid_ext1_value_email'];
		$status = 1;

		 $userdata = $this->loginmodel->validandoUserGoogle($primeiro_nome, $segundo_nome, $email, 'Google', $status);
		if ($userdata)
		{
		    redirect($this->input->get('voltar'));
		}
		else
		{
		    // Alguma coisa esta faltando, voltar a estaca 1
		    print "Erro - Alguma coisa esta faltando, voltar a estaca 1";
		}
	    }
	}
	/*
	 * #http://localhost/biblia/login/getGoogleData/?voltar=http://localhost/biblia/home/index/ara/at/Gn/3
	 * 
	 * &openid.ns=http://specs.openid.net/auth/2.0
	 * &openid.mode=id_res
	 * &openid.op_endpoint=https://www.google.com/accounts/o8/ud
	 * &openid.response_nonce=2014-08-06T12:35:57ZG8xC3VRKuOu7sQ
	 * &openid.return_to=http://localhost/biblia/login/getGoogleData/?voltar=http://localhost/biblia/home/index/ara/at/Gn/3
	 * &openid.assoc_handle=1.AMlYA9VqEKoyoQt1oU9464gu75YpOO6WehQzQNLaI04jVMjNfbtrpD-54j6Eipyt
	 * &openid.signed=op_endpoint,claimed_id,identity,return_to,response_nonce,assoc_handle,ns.ext1,ext1.mode,ext1.type.firstname,ext1.value.firstname,ext1.type.lastname,ext1.value.lastname,ext1.type.email,ext1.value.email
	 * &openid.sig=2GNlKrK4N5gblwpenmykRSsm9V8
	 * &openid.identity=https://www.google.com/accounts/o8/id?id=AItOawn6-Dz5jre0PujEdSwQZf3-tB2RlN7xUvA
	 * &openid.claimed_id=https://www.google.com/accounts/o8/id?id=AItOawn6-Dz5jre0PujEdSwQZf3-tB2RlN7xUvA
	 * &openid.ns.ext1=http://openid.net/srv/ax/1.0
	 * &openid.ext1.mode=fetch_response
	 * &openid.ext1.type.firstname=http://axschema.org/namePerson/first
	 * * &openid.ext1.value.firstname=Everson
	 * &openid.ext1.type.lastname=http://axschema.org/namePerson/last
	 * * &openid.ext1.value.lastname=Teixeira
	 * &openid.ext1.type.email=http://axschema.org/contact/email
	 * * &openid.ext1.value.email=falaeverson@gmail.com#
	 * 
	 * http://localhost/biblia/login/getGoogleData/?voltar=http://localhost/biblia/home/index/ara/at/Gn/3&openid.ns=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0&openid.mode=id_res&openid.op_endpoint=https%3A%2F%2Fwww.google.com%2Faccounts%2Fo8%2Fud&openid.response_nonce=2014-08-06T13%3A05%3A04ZtFSU2pUY6czkCg&openid.return_to=http%3A%2F%2Flocalhost%2Fbiblia%2Flogin%2FgetGoogleData%2F%3Fvoltar%3Dhttp%3A%2F%2Flocalhost%2Fbiblia%2Fhome%2Findex%2Fara%2Fat%2FGn%2F3&openid.assoc_handle=1.AMlYA9Vj0B0v79cY6auLjbuBcmS6FIXzAY5kfdmeDVTWZGV_kDZ6njVnCDB0CrXo&openid.signed=op_endpoint%2Cclaimed_id%2Cidentity%2Creturn_to%2Cresponse_nonce%2Cassoc_handle%2Cns.ext1%2Cext1.mode%2Cext1.type.firstname%2Cext1.value.firstname%2Cext1.type.lastname%2Cext1.value.lastname%2Cext1.type.email%2Cext1.value.email&openid.sig=2GNlKrK4N5gblwpenmykRSsm9V8%3D&openid.identity=https%3A%2F%2Fwww.google.com%2Faccounts%2Fo8%2Fid%3Fid%3DAItOawn6-Dz5jre0PujEdSwQZf3-tB2RlN7xUvA&openid.claimed_id=https%3A%2F%2Fwww.google.com%2Faccounts%2Fo8%2Fid%3Fid%3DAItOawn6-Dz5jre0PujEdSwQZf3-tB2RlN7xUvA&openid.ns.ext1=http%3A%2F%2Fopenid.net%2Fsrv%2Fax%2F1.0&openid.ext1.mode=fetch_response&openid.ext1.type.firstname=http%3A%2F%2Faxschema.org%2FnamePerson%2Ffirst&openid.ext1.value.firstname=Everson&openid.ext1.type.lastname=http%3A%2F%2Faxschema.org%2FnamePerson%2Flast&openid.ext1.value.lastname=Teixeira&openid.ext1.type.email=http%3A%2F%2Faxschema.org%2Fcontact%2Femail&openid.ext1.value.email=falaeverson%40gmail.com#
	 */
    }

    public function sair()
    {

	$this->session->sess_destroy();
	redirect($this->input->get('voltar'));
    }

}
