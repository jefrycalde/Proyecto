<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ventas extends CI_Controller
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
    $dataSidebar['classInventario']="";
    $dataSidebar['classVentas']="active";
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
    $ventas = $this->consultas->getVentas();
    $data['ventas']=$ventas;
    $data['monedaString']=$this->consultas->getMonedaString();
    $data['listaUsuarios']=$this->consultas->getUsers();
    $data['movimientosCaja']=$this->consultas->getMovimientosCaja();
    $data['fecha1'] = date('Y-m-d');
    $data['fecha2'] = date('Y-m-d');
    $dataSidebar['tema']="$tema";
    $this->load->view('header',$dataHeader);
    $this->load->view('sidebar',$dataSidebar);
    $this->load->view('ventas',$data);
    $dataFooter=array(
      'scripts'=> ""
    );
    $dataFooter['scripts'].="<script src='".base_url()."plugins/moment/moment.js'></script>";
    $dataFooter['scripts'].='<script src="'.base_url().'plugins/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js"></script>';
    $dataFooter['scripts'].='<script src="'.base_url().'plugins/eonasdan-bootstrap-datetimepicker/src/js/locales/bootstrap-datetimepicker.es.js"></script>';
    $dataFooter['scripts'].="<script src='".base_url()."js/ventas.js'></script>";
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
    $data['monedaString']=$this->consultas->getMonedaString();
    $this->load->view('inventario/_detalle',$data);
  }

  public function resultado()
  {
    $fecha1=$this->input->post('from');
    $fecha2=$this->input->post('to');
    $miFechaActual = date("Y-m-d");

    if($fecha2<$fecha1){
      die("x1"); // la fecha final es menor a la fecha inicial
    }
    // if($fecha1 > $miFechaActual || $fecha2 > $miFechaActual ){
    //   die("x2"); // alguna de las fechas esta pasada del dia actual
    // }
    if($fecha1=="" || $fecha2==""){
      die("x3"); // datos en blanco
    }

    $ventasPeriodo = $this->consultas->getVentasPeriodo($fecha1,$fecha2);

    $idUser = $this->session->userdata('idUser');
    $rol= $this->session->userdata('rol');
    $user=$this->consultas->getUsers($idUser);
    $data = array();
    $dataHeader['titulo']="Inventario";
    $dataSidebar = array();
    $dataSidebar['classInventario']="";
    $dataSidebar['classVentas']="active";
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
    // $ventas = $this->consultas->getVentas();
    $data['ventas']=$ventasPeriodo;
    $data['monedaString']=$this->consultas->getMonedaString();
    $data['listaUsuarios']=$this->consultas->getUsers();
    $data['movimientosCaja']=$this->consultas->getMovimientosCajaPeriodo($fecha1,$fecha2);
    $data['fecha1'] = $fecha1;
    $data['fecha2'] = $fecha2;
    $dataSidebar['tema']="$tema";
    $this->load->view('header',$dataHeader);
    $this->load->view('sidebar',$dataSidebar);
    $this->load->view('ventas',$data);
    $dataFooter=array(
      'scripts'=> ""
    );
    $dataFooter['scripts'].="<script src='".base_url()."plugins/moment/moment.js'></script>";
    $dataFooter['scripts'].='<script src="'.base_url().'plugins/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js"></script>';
    $dataFooter['scripts'].='<script src="'.base_url().'plugins/eonasdan-bootstrap-datetimepicker/src/js/locales/bootstrap-datetimepicker.es.js"></script>';
    $dataFooter['scripts'].="<script src='".base_url()."js/ventas.js'></script>";
    $dataFooter['scripts'].="<script src='".base_url()."js/tema.js'></script>";
    $this->load->view('footer',$dataFooter);

  } // fin resultado()

}
?>
