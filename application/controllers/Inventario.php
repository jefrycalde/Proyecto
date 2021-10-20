<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inventario extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    if($this->session->userdata('rol')!=1 && $this->session->userdata('rol')!=3){
      redirect(base_url());
    }
  }


  public function index()
  {
    $idUser = $this->session->userdata('idUser');
    $rol= $this->session->userdata('rol');
    $user=$this->consultas->getUsers($idUser);
    $data = array();
    $dataHeader['titulo']="Inventario";
    $dataSidebar = array();
    $dataSidebar['classInventario']="active";
    $dataSidebar['classVentas']="";
    $dataSidebar['classUsuarios']="";
    $dataSidebar['classMovimientos']="";

    $dataSidebar['classInventarioGeneral']="active";
    $dataSidebar['classInventarioModificar']="";
    $dataSidebar['classInventarioAgregar']="";
    $dataSidebar['classInventarioNuevo']="";
    $dataSidebar['classInventarioCBarras']="";
    $dataSidebar['classConfiguraciones']="";
    $dataSidebar['classProveedores']="";
    $dataSidebar['classClientes']="";
    $dataSidebar['usuario']=$user;

    $tema = $this->consultas->configTema();
    $inventario = $this->consultas->getInventario();
    $data['inventario']=$inventario;
    $data['monedaString']=$this->consultas->getMonedaString();
    $dataSidebar['tema']="$tema";
    $this->load->view('header',$dataHeader);
    $this->load->view('sidebar',$dataSidebar);
    $this->load->view('inventario/inventario',$data);
    $dataFooter=array(
      'scripts'=> "<script src='".base_url()."js/admin.js'></script>"
    );
    $dataFooter['scripts'].="<script src='".base_url()."js/tema.js'></script>";
    $this->load->view('footer',$dataFooter);
  }

  public function delInventario()
  {
    $idProv = $this->input->post('idp');
    $this->delete->delInventario($idProv);
  }


}
?>
