<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller
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
    $dataHeader['titulo']="Clientes";
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
    $dataSidebar['classProveedores']="";
    $dataSidebar['classClientes']="active";
    $dataSidebar['usuario']=$user;
    $tema = $this->consultas->configTema();
    $dataSidebar['tema']="$tema";

    $data['clientes']=$this->consultas->getClientes();
    $this->load->view('header',$dataHeader);
    $this->load->view('sidebar',$dataSidebar);
    $this->load->view('clientes',$data);
    $dataFooter=array(
      'scripts'=> "<script src='".base_url()."js/clientes.js'></script>"
    );
    $dataFooter['scripts'].="<script src='".base_url()."js/tema.js'></script>";
    $this->load->view('footer',$dataFooter);
  }

  public function addHtml($idCliente='0')
  {
    $nombre="";
    $textoBoton="Agregar";
    $idForm="formAddCliente";
    $myCliente =array(
      'id'=>'',
      'nombre'=>'',
      'identidad'=>'',
      'direccion'=>'',
      'telefono'=>'',
      'correo'=>'');

      if($idCliente!=0){
        $myCliente = $this->consultas->getClientes($idCliente);
        $nombre=$myCliente['nombre'];
        $textoBoton="Modificar";
        $idForm="formModCliente";
      }

      $data=array(
        'idForm'=>$idForm,
        'idCliente'=>$idCliente,
        'nombre'=>$nombre,
        'textoBoton'=>$textoBoton,
        'roles'=>$this->consultas->getRoles(),
        'cliente'=>$myCliente,
      );
      $this->load->view('_addCliente',$data);
    }

    public function addCliente()
    {
      $datos = array(
        'nombre'=>$this->input->post('nombre'),
        'identidad'=>strtoupper($this->input->post('identidad')),
        'direccion'=>$this->input->post('direccion'),
        'telefono'=>$this->input->post('telefono'),
        'correo'=>$this->input->post('correo'),
      );
      $this->insertar->newCliente($datos);
    }


    public function modCliente()
    {
      $idCliente = $this->input->post('idc');
      $datos = array(
        'nombre'=>$this->input->post('nombre'),
        'identidad'=>strtoupper($this->input->post('identidad')),
        'direccion'=>$this->input->post('direccion'),
        'telefono'=>$this->input->post('telefono'),
        'correo'=>$this->input->post('correo')
      );
      $where = array(
        'id'=>$idCliente
      );
      $this->insertar->setCliente($datos,$where);
    }

    public function delCliente()
    {
      $idCliente = $this->input->post('idc');
      $this->delete->delCliente($idCliente);
    }





  }
  ?>
