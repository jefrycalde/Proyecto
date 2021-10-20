<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedores extends CI_Controller
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
    $dataSidebar['classUsuarios']="";

    $dataSidebar['classInventarioGeneral']="";
    $dataSidebar['classInventarioModificar']="";
    $dataSidebar['classInventarioAgregar']="";
    $dataSidebar['classInventarioNuevo']="";
    $dataSidebar['classInventarioCBarras']="";
    $dataSidebar['classConfiguraciones']="";
    $dataSidebar['classProveedores']="active";
    $dataSidebar['classClientes']="";
    $dataSidebar['usuario']=$user;
    $tema = $this->consultas->configTema();
    $dataSidebar['tema']="$tema";

    $data['proveedores']=$this->consultas->getProveedores();
    $this->load->view('header',$dataHeader);
    $this->load->view('sidebar',$dataSidebar);
    $this->load->view('proveedores',$data);
    $dataFooter=array(
      'scripts'=> "<script src='".base_url()."js/proveedores.js'></script>"
    );
    $dataFooter['scripts'].="<script src='".base_url()."js/tema.js'></script>";
    $this->load->view('footer',$dataFooter);
  }

  public function addHtml($idProv='0')
  {
    $nombre="";
    $textoBoton="Agregar";
    $idForm="formAddProv";

    $rfc="";
    $telefono="";

    $myProv =array(
      'id'=>'',
      'rfc'=>'',
      'telefono'=>'',
    );

    if($idProv!=0){
      $myProv = $this->consultas->getProveedores($idProv);
      $nombre=$myProv['nombre'];
      $rfc=$myProv['rfc'];
      $telefono=$myProv['telefono'];
      $textoBoton="Modificar";
      $idForm="formModProv";
    }

    $data=array(
      'idForm'=>$idForm,
      'idProv'=>$idProv,
      'nombre'=>$nombre,
      'rfc'=>$rfc,
      'telefono'=>$telefono,
      'proveedor'=>$myProv,
      'textoBoton'=>$textoBoton,
    );
    $this->load->view('_addProv',$data);
  }

  public function addProv()
  {
    $datos = array(
      'nombre'=>strtoupper($this->input->post('nombre')),
      'rfc'=>strtoupper($this->input->post('rfc')),
      'telefono'=>$this->input->post('tel')
    );
    $this->insertar->newProveedor($datos);
  }


  public function modProv()
  {
    $idProv = $this->input->post('idp');
    $datos = array(
      'nombre'=>strtoupper($this->input->post('nombre')),
      'rfc'=>strtoupper($this->input->post('rfc')),
      'telefono'=>$this->input->post('tel')
    );
    $where = array(
      'id'=>$idProv
    );
    $this->insertar->setProveedor($datos,$where);
  }

  public function delProveedor()
  {
    $idProv = $this->input->post('idp');
    $this->delete->delProveedor($idProv);
  }





}
?>
