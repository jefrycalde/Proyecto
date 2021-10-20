<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AgregarInventario extends CI_Controller
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
    $dataHeader['titulo']="Inventario";
    $dataSidebar = array();
    $dataSidebar['classInventario']="active";
    $dataSidebar['classVentas']="";
    $dataSidebar['classMovimientos']="";
    $dataSidebar['classUsuarios']="";

    $dataSidebar['classInventarioGeneral']="";
    $dataSidebar['classInventarioModificar']="";
    $dataSidebar['classInventarioAgregar']="active";
    $dataSidebar['classInventarioNuevo']="";
    $dataSidebar['classInventarioCBarras']="";
    $dataSidebar['classConfiguraciones']="";
    $dataSidebar['classProveedores']="";
    $dataSidebar['classClientes']="";
    $dataSidebar['usuario']=$user;
    $tema = $this->consultas->configTema();
    $inventario = $this->consultas->getInventario();
    $data['inventario']=$inventario;
    $dataSidebar['tema']="$tema";
    $this->load->view('header',$dataHeader);
    $this->load->view('sidebar',$dataSidebar);
    $this->load->view('inventario/agregarInventario',$data);
    $dataFooter=array(
      'scripts'=> "<script src='".base_url()."js/admin.js'></script>"
    );
    $dataFooter['scripts'].="<script src='".base_url()."js/tema.js'></script>";
    $this->load->view('footer',$dataFooter);
  }

  public function addInventario()
  {
    $codigo = $this->input->post('codigo');
    $encontrado =  $this->consultas->comprobarCodigo($codigo);
    $resultado = array(
      'encontrado' => 0,
      'descripcion'=>'',
      'cantidadActual'=>''
    );
    if($encontrado){
      $item =  $this->consultas->getInventario($codigo);
      $resultado['encontrado']=$encontrado;
      $resultado['descripcion']=$item['descripcion'];
      $resultado['cantidadActual']=$item['cantidad'];
    }
    echo json_encode($resultado);
  }

  public function setItem()
  {
    $codigo = $this->input->post('codigo');
    $cantidad = $this->input->post('cantidad');
    $encontrado =  $this->consultas->comprobarCodigo($codigo);
    if(!$encontrado){
      echo "0";
      die();
    }
    $miItem = $this->consultas->getInventario($codigo);
    $datos = array(
      'cantidad'=>$miItem['cantidad']+$cantidad
    );
    $where = array('id' => $miItem['id'] );
    $this->insertar->setProducto($datos,$where);
    // agregar registro
    $movimiento = array(
      'idVenta' => '0',
      'idInventario' => $miItem['id'],
      'cantidad' => $cantidad,
      'costoUnitario' => 0,
      'tipo' => 1,
    );
    $this->insertar->newMovimientoVenta($movimiento);
    echo "1";
  }




}
?>
