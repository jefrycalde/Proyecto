<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mcaja extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
  }

   public function index()
  {
    $idUser = $this->session->userdata('idUser');
    $rol= $this->session->userdata('rol');
    $user=$this->consultas->getUsers($idUser);
    $data = array();
    $dataHeader['titulo']="Ofertas";
    $dataSidebar = array();
    $dataSidebar['classInventario']="";
    $dataSidebar['classVentas']="";
    $dataSidebar['classUsuarios']="";
    $dataSidebar['classMovimientos']="";

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
    $data['monedaString']=$this->consultas->getMonedaString();
    $data['cajas'] = $this->consultas->getCajas();
    $dataSidebar['tema']="$tema";
    $this->load->view('header',$dataHeader);
    $this->load->view('sidebar',$dataSidebar);
    $this->load->view('cajas/entradas-salidas',$data);
    $dataFooter=array(
      'scripts'=> "<script src='".base_url()."js/admin.js'></script>
                   <script src='".base_url()."js/cajas.js'></script>"
    );
    $dataFooter['scripts'].="<script src='".base_url()."js/tema.js'></script>";
    $this->load->view('footer',$dataFooter);
  }

  public function guardaMovimiento()
  {
  	$data = array(
  		'monto' =>$this->input->post('monto'),
  		'razon' =>$this->input->post('razon'),
  		'id_caja'=>$this->input->post('id'),
  		'tipo' =>$this->input->post('tipo'),
  		'id_usuario' => $this->session->userdata('idUser')

  	);
  	$this->insertar->newMovimientoCaja($data);
  }

}

?>