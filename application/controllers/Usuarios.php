<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    if($this->session->userdata('rol')!=1){
      redirect(base_url());
    }
  }

  public function index()
  {
    $idUser = $this->session->userdata('idUser');
    $rol= $this->session->userdata('rol');
    $user=$this->consultas->getUsers($idUser);
    $data = array();
    $dataHeader['titulo']="Usuarios";
    $dataSidebar = array();
    $dataSidebar['classInventario']="";
    $dataSidebar['classVentas']="";
    $dataSidebar['classMovimientos']="";
    $dataSidebar['classUsuarios']="active";

    $dataSidebar['classInventarioGeneral']="";
    $dataSidebar['classInventarioModificar']="";
    $dataSidebar['classInventarioAgregar']="";
    $dataSidebar['classInventarioNuevo']="";
    $dataSidebar['classInventarioCBarras']="";
    $dataSidebar['classConfiguraciones']="";
    $dataSidebar['classProveedores']="";
    $dataSidebar['classClientes']="";
    $dataSidebar['usuario']=$user;
    $tema = $this->consultas->configTema();
    $dataSidebar['tema']="$tema";

    $data['usuarios']=$this->consultas->getUsers();
    $this->load->view('header',$dataHeader);
    $this->load->view('sidebar',$dataSidebar);
    $this->load->view('usuarios',$data);
    $dataFooter=array(
      'scripts'=> "<script src='".base_url()."js/admin.js'></script>"
    );
    $dataFooter['scripts'].="<script src='".base_url()."js/tema.js'></script>";
    $this->load->view('footer',$dataFooter);
  }

  public function addHtml($idUser='0')
  {
    $nombre="";
    $alias="";
    $idRol=0;
    $pass="";
    $textoBoton="Agregar";
    $idForm="formAddUser";
    $myUser =array(
      'id'=>'',
      'nombre'=>'',
      'username'=>'',
      'pass'=>'',
      'idRol'=>'',
      'direccion'=>'',
      'telefono'=>'');

      if($idUser!=0){
        $myUser = $this->consultas->getUsers($idUser);
        $nombre=$myUser['nombre'];
        $alias=$myUser['username'];
        $idRol=$myUser['idRol'];
        $pass=$myUser['pass'];
        $textoBoton="Modificar";
        $idForm="formModUser";
      }

      $data=array(
        'idForm'=>$idForm,
        'idUser'=>$idUser,
        'nombre'=>$nombre,
        'alias'=>$alias,
        'idRol'=>$idRol,
        'pass'=>$this->desencriptar($pass),
        'textoBoton'=>$textoBoton,
        'roles'=>$this->consultas->getRoles(),
        'usuario'=>$myUser,
      );
      $this->load->view('_addUser',$data);
    }

    public function addUser()
    {
      $username = $this->input->post('alias');
      if($this->consultas->existeUsername($username)){
        echo "x1";
        die();
      }
      $datos = array(
        'nombre'=>$this->input->post('nombre'),
        'username'=>$username,
        'pass'=>$this->encriptar($this->input->post('pass')),
        'idRol'=>$this->input->post('idrol'),
        'direccion'=>$this->input->post('direccion'),
        'telefono'=>$this->input->post('telefono')
      );
      $this->insertar->newUser($datos);
    }


    public function modUser()
    {
      $idUser = $this->input->post('idu');
      $datos = array(
        'nombre'=>$this->input->post('nombre'),
        // 'username'=>$this->input->post('alias'),
        'pass'=>$this->encriptar($this->input->post('pass')),
        'idRol'=>$this->input->post('idrol'),
        'direccion'=>$this->input->post('direccion'),
        'telefono'=>$this->input->post('telefono')
      );

      if($datos['idRol']!=1){
        $datos['username']=$this->input->post('alias');
      }

      $where = array(
        'id'=>$idUser
      );
      $this->insertar->setUser($datos,$where);
    }

    public function delUsuario()
    {
      $idUser = $this->input->post('idu');
      $this->delete->delUser($idUser);
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

    //desencriptar
    function desencriptar($string) {
      $key=$this->config->item('mi_key');
      $result = '';
      $string = base64_decode($string);
      for($i=0; $i<strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key))-1, 1);
        $char = chr(ord($char)-ord($keychar));
        $result.=$char;
      }
      return $result;
    }





  }
  ?>
