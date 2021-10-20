<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pventa extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
  }

  public function getItem()
  {
    $codigo = $this->input->post('codigo');
    $item = $this->consultas->getInventario($codigo);
    echo json_encode($item);
  }


  public function Importe()
  {
    $codigo = $this->input->post('codigo');
    $cantidad = $this->input->post('cantidad');

    $item = $this->consultas->getInventario($codigo);
    if($cantidad<$item['cantidadMayoreo'])
    {
      $total = $cantidad * $item['precio'];
    }
    else {
      $total = $cantidad * $item['precioMayoreo'];
    }
    echo $total;
  }



  public function formMoviCaja()
  {
    $tipo = $this->input->post('tipo');
    $txtlabel = "Razón de Entrada";
    $txtbutton = "Registrar Entrada";
    if($tipo==2){
      $txtlabel = "Razón de Salida";
      $txtbutton = "Registrar Salida";
    }
    $data = array(
      'tipo' => $tipo,
      'txtlabel' => $txtlabel,
      'txtbutton' => $txtbutton
    );
    $this->load->view('_formMoviCaja',$data);
  }


  public function newMoviCaja()
  {
    $claveAdmin = $this->input->post('key');
    die("sofhdfh ");
    $claveOk = $this->consultas->comprobarClaveAdmin($this->encriptar($claveAdmin));
    if(!$claveOk){
      echo "x";
      die();
    }
    $idUser = $this->session->userdata('idUser');
    $tipo = $this->input->post('tipo');
    $monto = $this->input->post('monto');
    $razon = $this->input->post('razon');
    $datos = array(
      'tipo' => $tipo,
      'monto' => $monto,
      'fecha' => date("Y-m-d h:i:s"),
      'idUsuario' => $idUser,
      'razon' => $razon
    );
    $this->insertar->insertarGral("tb_movimientos_caja",$datos);
    echo 1;
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

  public function NuevaVenta()
  {
    $idUser = $this->session->userdata('idUser');
    // // obtener el ultimo id de ventas del mismo usuario
    $maxIdVentas = $this->consultas->getMaxIdVentasByUser($idUser);
    $dataVenta = array(
      'idUsuario' => $idUser,
    );
    if($maxIdVentas!=0)
    {
      if($maxIdVentas['Total']<=0)
      {
        $this->delete->delMovimientosFallidos($maxIdVentas['id']);
      }
      if($maxIdVentas['Total']<=0)
      {
        echo $maxIdVentas['id'];
        die();
      }
      else{
        $idVenta = $this->insertar->newVenta($dataVenta);
        echo $idVenta;
        die();
      }
    }

    // asignar nueva venta a este usuario
    $idVenta = $this->insertar->newVenta($dataVenta);
    echo $idVenta;
  }

  public function delItemToVenta()
  {
    $idVenta=$this->input->post('idVenta');
    $codigoItem=$this->input->post('codigo');
    $item = $this->consultas->getInventario($codigoItem);
    $this->delete->delMovimiento($idVenta,$item['id']);
    echo "1";
  }

  public function v_recibido()
  {
    $total=$this->input->post('total');
    $idVenta=$this->input->post('idVenta');
    $impuesto=$this->input->post('impuesto');
    $tipo=$this->input->post('tipo');
    $descuento=$this->input->post('descuento');
    $data = array(
      'total'=>$total,
      'idVenta'=>$idVenta,
      'impuesto'=>$impuesto,
      'descuento'=>$descuento,
      'tipo' =>$tipo
    );
    if($impuesto){
      $configs=$this->consultas->getConfigs();
      $data['impuestoPorciento']=$configs->impuestoPorciento;
      $data['nombreImpuesto']=$configs->nombreImpuesto;
    }
    $data['monedaString']=$this->consultas->getMonedaString();
    if($tipo==0)
    {
      $this->load->view('_cobrar',$data);
    }
    elseif($tipo==1)
    {
      $this->load->view('_cobrar2',$data);
    }
  }

  public function concretarVenta()
  {
    $total=$this->input->post('total');
    $idVenta=$this->input->post('idVenta');
    $recibido=$this->input->post('recibido');
    $impuesto=$this->input->post('impuesto');
    $tipo=$this->input->post('tipo');
    $descuento = $this->input->post('descuento');
    $impuestoPorciento=0;
    $nombreImpuesto="";
    if($tipo == 0)
    {
      $cambio =$recibido-$total;
    }
    else
    {
      $cambio = 0;
    }
    $codigo =$this->input->post('codigo');

    $datos=array(
      'total' => $total,
      'idVenta' => $idVenta,
      'recibido' => $recibido,
      'cambio' => $cambio,
      'tipoPago' => $tipo
    );

    if($impuesto){
      $impuestoPorciento=$this->input->post('impuestoPorciento');
      $nombreImpuesto=$this->input->post('nombreImpuesto');
    }

    if($cambio<0 && $tipo==1)
    {
      echo json_encode($datos);
      die();
    }
    $data = array(
      'Total'=>$total,
      'Fecha'=>date("Y-m-d h:i:s"),
      'impuestoPorciento'=>$impuestoPorciento,
      'nombreImpuesto'=>$nombreImpuesto,
      'tipoPago' => $tipo,
      'impuestoDescuento' => $descuento,
      'operacionBaucher' => $codigo
    );

    $where=$idVenta;
    $this->insertar->setVenta($data,$where);
    //descontar productos del inventario
    $listaItemsVenta = $this->consultas->getItemsDeVentas($idVenta);
    foreach ($listaItemsVenta as $itemVenta) {
      $myItem=$this->consultas->getInventariobyId($itemVenta['idInventario']);
      $nuevaCantidad = $myItem['cantidad']-$itemVenta['cantidad'];
      $dataSetItem=array(
        'cantidad'=>$nuevaCantidad
      );
      $whereSetItem=array(
        'id'=>$itemVenta['idInventario']
      );
      $this->insertar->setProducto($dataSetItem,$whereSetItem);
    }
    $this->insertar->dropMovimientoTemporal($idVenta);

    echo json_encode($datos);
  }

  public function verificarProducto()
  {
    $codigo = $this->input->post('codigo');
    echo $this->consultas->comprobarCodigo($codigo);
  }

  public function addItemToVenta()
  {
    $idVenta = $this->input->post('idVenta');
    $idItem = $this->input->post('idItem');
    $cantidad = $this->input->post('cantidad');

    $item=$this->consultas->getInventariobyId($idItem);
    if(!$item){
      $resultado = array(
        'validante'=>'n',
      );
      echo json_encode($resultado);
      die();
    }
    $costo=$item['precio'];
    if($cantidad>=$item['cantidadMayoreo']){
      $costo=$item['precioMayoreo'];
    }
    //comprobar si hay mas de este articulo para nadmas sumarlo
    $exysteItemEnVenta = $this->consultas->comprobarItemEnVenta($idVenta,$idItem);
    if($exysteItemEnVenta)
    {
      $movimiento = $this->consultas->getMovimientoVenta($idVenta,$idItem);
      $item = $this->consultas->getInventariobyId($idItem);
      $sumCantidad = $cantidad + $movimiento['cantidad'];
      if($sumCantidad>$item["cantidad"]){
        $resultado = array(
          'validante'=>'x1',
        );
        echo json_encode($resultado);
        die();
      }
      $dataMovimiento = array(
        'cantidad'=>$sumCantidad,
        'costoUnitario'=>$costo
      );
      $whereMovimiento = array(
        'id'=>$movimiento['id']
      );
      $this->insertar->updateMovimientoVenta($dataMovimiento,$whereMovimiento);
      $resultado = array(
        'validante'=>'r',
        'ncantidad'=>$sumCantidad
      );
      echo json_encode($resultado);
    }
    else {
      if($cantidad>$item["cantidad"]){
        $resultado = array(
          'validante'=>'x1',
        );
        echo json_encode($resultado);
        die();
      }
      $dataMovimiento = array(
        'idVenta' => $idVenta,
        'idInventario'=>$idItem,
        'cantidad'=>$cantidad,
        'costoUnitario'=>$costo
      );
      $this->insertar->newMovimientoVenta($dataMovimiento);
      $resultado = array(
        'validante'=>'x'
      );
      echo json_encode($resultado);
    }
  }


public function buscarIndiceOferta($ofertas,$value,$max = -1,$id_oferta = 0){
  if(isset($ofertas[$value['id_oferta']][$value['id_inventario']])){
    if(count($ofertas[$value['id_oferta']][$value['id_inventario']]) > $max){
      $max = count($ofertas[$value['id_oferta']][$value['id_inventario']]);
      $id_oferta = $value['id_oferta'];
      $this->buscarIndiceOferta($ofertas,$value,$max,$id_oferta);
    }
  }
  return $id_oferta;
}



// public function impVenta()



public function impVenta()
{
  $idVenta = $this->input->post('idVenta');
  $recibido = $this->input->post('recibido');
  $detalleItem = $this->consultas->getItemsDeVentas($idVenta);
  $detalleVenta = $this->consultas->getVentaById($idVenta);
  $nombreEmpresa = $this->consultas->getConfigs();
  $nombreEmpresa = $nombreEmpresa->nombreEmpresa;
  $vendedor = $this->consultas->getUsers($detalleVenta['idUsuario']);
  $moneda=$this->consultas->getMonedaString();


public function buscarpr()
{
  $inventario = $this->consultas->getInventario();
  $data = array('inventario' => $inventario);
  $data['monedaString']=$this->consultas->getMonedaString();
  $this->load->view('_busqueda',$data);
}





public function verificarOferta(){
  return false;
  $itemsventa = $this->consultas->getItemsDeVentas($idVenta);
  //recorremos los items de ventas
  // buscamos el elemento en las promociones

}








}
?>
