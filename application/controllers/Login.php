<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    // if($this->session->userdata('rol')){
    //   redirect(base_url());
    // }
  }


  public function index()
  {
    $user = $this->input->post('usuario');
    // La funcion encriptar() sirve para encriptar la contraseña y despues de encriptar la compara para que las contraseñas cioncidan
    $pass = $this->encriptar($this->input->post('pass'));

    $isUser = $this->consultas->isUser($user, $pass);
    if($isUser=="1")
    {
      $idUser= $this->consultas->findIdUser($user, $pass);
      $data = array(
        'idUser' => $idUser->id,
        'rol' => $idUser->idRol
      );
      $this->session->set_userdata($data);
      redirect(base_url());
    }
    else{
      $dataHeader['titulo']="Login";
      $data['error'] =$isUser;
      $this->load->view('header',$dataHeader);
      $this->load->view('login',$data);
      $dataFooter=array(
        'scripts'=> ""
      );
      $this->load->view('footer',$dataFooter);
    }
  }


  // encriptar
  function encriptar($string) {
    $key=$this->config->item('mi_key');
    $result = '';
    for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)+ord($keychar));
      $result.=$char;
    }
    return base64_encode($result);
  }
}
