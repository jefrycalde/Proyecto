<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Movimientos extends CI_Controller
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
    $dataHeader['titulo']="Movimientos";
    $dataSidebar = array();
    $dataSidebar['classInventario']="";
    $dataSidebar['classVentas']="";
    $dataSidebar['classUsuarios']="";
    $dataSidebar['classMovimientos']="active";

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
    $movimientos = $this->consultas->getMovimientosData();
    $data['movimientos']=$movimientos;

    $this->load->view('header',$dataHeader);
    $this->load->view('sidebar',$dataSidebar);
    $this->load->view('movimientos',$data);
    $dataFooter=array(
      'scripts'=> "<script src='".base_url()."js/movimientos.js'></script>"
    );
    $dataFooter['scripts'].="<script src='".base_url()."js/tema.js'></script>";
    $this->load->view('footer',$dataFooter);
  }



  public function verDetalle()
  {
    $idVenta = $this->input->post('idVenta');
    $detalleItem = $this->consultas->getItemsDeVentas($idVenta);
    $detalleVenta = $this->consultas->getVentaById($idVenta);
    $vendedor=$this->consultas->getUsers($detalleVenta['idUsuario']);
    $data=array(
      'detalle'=>$detalleItem,
      'detalleVenta'=>$detalleVenta,
      'vendedor'=>$vendedor
    );
    $this->load->view('inventario/_detalle',$data);
  }



}
?>
