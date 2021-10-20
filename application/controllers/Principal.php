<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Principal extends CI_Controller
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
    if(!$idUser)
    {
      $dataHeader['titulo']="Login";
      $this->load->view('header',$dataHeader);
      $data['error'] ="";
      $this->load->view('login',$data);
      $dataFooter=array(
        'scripts'=> ""
      );
      $this->load->view('footer',$dataFooter);
      return false;
    }
    else if($rol=="1" || $rol=="3") // Administrador
    {
      $data['msj'] ="";
      $dataHeader['titulo']="Admin";
      $dataSidebar = array();
      $dataSidebar['classInventario']="";
      $dataSidebar['classVentas']="";
      $dataSidebar['classMovimientos']="";
      $dataSidebar['classUsuarios']="";

      $dataSidebar['classInventarioGeneral']="active";
      $dataSidebar['classInventarioModificar']="";
      $dataSidebar['classInventarioAgregar']="";
      $dataSidebar['classInventarioNuevo']="";
      $dataSidebar['classInventarioCBarras']="";
      $dataSidebar['classConfiguraciones']="";
      $dataSidebar['classProveedores']="";
      $dataSidebar['classClientes']="";

      $tema = $this->consultas->configTema();
      $dataSidebar['tema']="$tema";
      $dataSidebar['usuario']=$user;
      $consultasWitget=$this->consultas->consultasIniciales();
      $data=array_merge($data,$consultasWitget);
      $data['listaUsuarios']=$this->consultas->getUsers();
      $data['monedaString']=$this->consultas->getMonedaString();
      $this->load->view('header',$dataHeader);
      $this->load->view('sidebar',$dataSidebar);
      $this->load->view('admin-inicio',$data);
      $dataFooter=array(
        'scripts'=> "<script src='".base_url()."js/admin.js'></script>"
      );
      $dataFooter['scripts'].="<script src='".base_url()."js/tema.js'></script>";
      $this->load->view('footer',$dataFooter);
    }
    else if($rol=="2") // Simple vendedor mortal
    {
      $data = array();
      $dataHeader['titulo']="Punto de Venta";
      $tema = $this->consultas->configTema();
      $dataSidebar['tema']="$tema";
      $dataSidebar['usuario']=$user;

      $data['configs']=$this->consultas->getConfigs();

      $data['impuesto_si']="hidden";
      if ($data['configs']->impuesto==1) {
        $data['impuesto_si']="";
      }
      $data['monedaString']=$this->consultas->getMonedaString();
      $data['clientes']=$this->consultas->getClientes();
      $data['idVenta'] = $this->getIdVenta();




      $this->load->view('header',$dataHeader);
      $this->load->view('sidebar',$dataSidebar);
      $this->load->view('main', $data);
      $dataFooter=array(
        'scripts'=> "<script src='".base_url()."js/pventa.js'></script>"
      );
      $this->load->view('footer',$dataFooter);
    }
  }

  private function getIdVenta()
  {
    $idUser = $this->session->userdata('idUser');
    // // obtener el ultimo id de ventas del mismo usuario
    $maxIdVentas = $this->consultas->getMaxIdVentasByUser($idUser);

    /*print_r($maxIdVentas);
    die;*/

    $dataVenta = array(
      'idUsuario' => $idUser,
    );

    if(!$this->consultas->isTempVenta($maxIdVentas['id']))
    {

    if($maxIdVentas!=0)
    {
      if($maxIdVentas['Total']<=0)
      {
        $this->delete->delMovimientosFallidos($maxIdVentas['id']);
      }
      if($maxIdVentas['Total']<=0)
      {
        return $maxIdVentas['id'];
      }
      else{
        $idVenta = $this->insertar->newVenta($dataVenta);
        return $idVenta;
      }
    }
      // asignar nueva venta a este usuario
    $idVenta = $this->insertar->newVenta($dataVenta);

    }
    else
    {
      $idVenta = $this->insertar->newVenta($dataVenta);
    }
    return $idVenta;
  }


  public function logout()
  {
    $this->session->sess_destroy();
    redirect(base_url(), 'refresh');
  }

  public function tema()
  {
    $tema = $this->input->post('tema');
    $tema = array('tema' => $tema );
    $this->insertar->setConfig($tema);
  }



  public function formatoMonedaGuatemala()
  {
    $numero =   $tema = $this->input->post('numero');
    if($numero<1){
      die("0");
    }
    echo number_format($numero,2);
  }
}
?>
