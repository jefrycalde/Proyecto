<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Modificar extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    if($this->session->userdata('rol')!=1){
      redirect(base_url());
    }
  }


  public function m($codigo='')
  {
    // if(strlen($codigo)<13 ){
    //   redirect(base_url()."inventario");
    //   die();
    // }
    $idUser = $this->session->userdata('idUser');
    $rol= $this->session->userdata('rol');
    $user=$this->consultas->getUsers($idUser);
    $data = array();
    $tema = $this->consultas->configTema();
    // $inventario = $this->consultas->getInventario();
    $item = $this->consultas->getInventario($codigo);
    $departamentos = $this->consultas->getDepartamentos();
    $tiposVenta = $this->consultas->getTipoVenta();
    $dataSidebar = array();
    $dataHeader['titulo']="Inventario";
    $dataSidebar['classInventario']="active";
    $dataSidebar['classVentas']="";
    $dataSidebar['classUsuarios']="";
    $dataSidebar['classMovimientos']="";
    $dataSidebar['classCreditos']="";

    $dataSidebar['classInventarioGeneral']="";
    $dataSidebar['classInventarioModificar']="active";
    $dataSidebar['classInventarioAgregar']="";
    $dataSidebar['classInventarioNuevo']="";
    $dataSidebar['classInventarioCBarras']="";
    $dataSidebar['classConfiguraciones']="";
    $dataSidebar['classProveedores']="";
    $dataSidebar['classClientes']="";
    $dataSidebar['tema']="$tema";
    $dataSidebar['usuario']=$user;

    // $data['inventario']=$inventario;
    $data['departamentos']=$departamentos;
    $data['tiposVenta']=$tiposVenta;
    $data['item']=$item;
    $data['monedaString']=$this->consultas->getMonedaString();


    $this->load->view('header',$dataHeader);
    $this->load->view('sidebar',$dataSidebar);
    $this->load->view('inventario/modificar',$data);
    $dataFooter=array(
      'scripts'=> "<script src='".base_url()."js/admin.js'></script>"
    );
    $this->load->view('footer',$dataFooter);
  }

  public function modItem()
  {
    $id = $this->input->post('id');
    $descripcion = $this->input->post('descripcion');
    $costo = $this->input->post('costo');
    $precio = $this->input->post('precio');
    $pmayoreo = $this->input->post('pmayoreo');
    $cmayoreo = $this->input->post('cmayoreo');
    $departamento = $this->input->post('departamento');
    $tipoVenta = $this->input->post('tipoVenta');
    $stockCritico = $this->input->post('stockCritico');
    $datos = array(
      // 'codigo' => $codigo,
      'descripcion' => $descripcion,
      'costo' => $costo,
      'precio' => $precio,
      'precioMayoreo' => $pmayoreo,
      'cantidadMayoreo' => $cmayoreo,
      'idDepartamento' => $departamento,
      'idtipo'=>$tipoVenta,
      'stockCritico'=>$stockCritico
    );
    $where=array(
      'id'=>$id
    );

    $this->insertar->setProducto($datos,$where);
    echo "1"; // codigo 1 significa que termino con normalidad
  }


  public function stockHtml()
  {
    $id=$this->input->post('id');
    $bdg=$this->input->post('bdg');
    $datos = array(
      'id' => $id
    );
    $this->load->view('inventario/_stock',$datos);
  }

  public function newStock()
  {
    $id = $this->input->post('id');
    $nstock = $this->input->post('nstock');
    $stockActual = $this->consultas->getCantidadByProducto($id);
    $nuevoStockDatos = array(
      'cantidad' =>  $nstock
    );
    $nuevoStockDatosWhere=array(
      'id'=>$id
    );
    $diferenciaStock = $nstock-$stockActual;
    $this->insertar->setProducto($nuevoStockDatos,$nuevoStockDatosWhere);

    // agregar registro
    $movimiento = array(
      'idVenta' => '0',
      'idInventario' => $id,
      'cantidad' => $diferenciaStock,
      'costoUnitario' => 0,
      'tipo' => 1,
      'fechaEntrada' => date("Y-m-d h:i:s"),
    );
    $this->insertar->newMovimientoVenta($movimiento);
    echo "1";
  }


}
?>
