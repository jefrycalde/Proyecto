<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pventa extends CI_Controller
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
    $dataHeader['titulo']="Punto de Venta";
    $tema = $this->consultas->configTema();
    $dataSidebar['tema']="$tema";
    $dataSidebar['classInventario']="";
    $dataSidebar['classVentas']="";
    $dataSidebar['classUsuarios']="";
    $dataSidebar['classMovimientos']="";
    $dataSidebar['classCreditos']="";

    $dataSidebar['classInventarioGeneral']="";
    $dataSidebar['classInventarioModificar']="";
    $dataSidebar['classInventarioAgregar']="";
    $dataSidebar['classInventarioNuevo']="";
    $dataSidebar['classInventarioCBarras']="";
    $dataSidebar['classConfiguraciones']="";
    $dataSidebar['classProveedores']="";
    $dataSidebar['classClientes']="";
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



  public function relacionarImpresora()
  {
    $idImpresora = $this->input->post('idImpresora');
    $idVendedor = $this->session->userdata('idUser');
    $this->delete->eliminarGral("tb_usuario_impresora",array('idUsuario' => $idVendedor ));
    $this->insertar->insertarGral("tb_usuario_impresora",array('idUsuario' => $idVendedor,'idImpresora'=>$idImpresora ));
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
    elseif($tipo==2)
    {
      $data['cliente'] = $this->consultas->getClienteByIdVenta($idVenta);
      $data['plazoTipo'] = $this->consultas->getTabla("tb_plazo_tipo");
      $this->load->view('_nuevoCredito',$data);
    }
  }

  
  public function concretarVenta()
  {
    $total=$this->input->post('total');
    $idVenta=$this->input->post('idVenta');
    $recibido=$this->input->post('recibido');
    $impuesto=$this->input->post('impuesto');
    $tipo=$this->input->post('tipo'); // [0]efectivo, [1]tarjeta, [2]credito
    $idTipoPago=$this->input->post('idTipoPago');
    $descuento = $this->input->post('descuento');

    $impuestoPorciento=0;
    $nombreImpuesto="";
    $credito = 0;
    $cambio = 0;
    if($tipo == 0)
    {
      $cambio =$recibido-$total;
    }
    elseif ($tipo == 2)
    {
      $credito = 1;
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
      'Fecha'=>date("Y-m-d H:i:s"),
      'impuestoPorciento'=>$impuestoPorciento,
      'nombreImpuesto'=>$nombreImpuesto,
      'tipoPago' => $idTipoPago,
      'impuestoDescuento' => $descuento,
      'operacionBaucher' => $codigo,
      'credito' => $credito
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
    $codigo = $this->input->post('codigo');
    $cantidad = $this->input->post('cantidad');
    // --
    $xrespuesta = array(
      'xstatus' => 0,
      'cantidad' => $cantidad
    );
    // verificarProducto()
    $exitecodigo =  $this->consultas->comprobarCodigo($codigo);
    if(!$exitecodigo){
      echo json_encode($xrespuesta);
      die();
    }
    // addItemToVenta()
    $item=$this->consultas->getInventarioByCodigo($codigo);
    $idItem = $item['id'];

    $precio=$item['precio'];
    if($cantidad>=$item['cantidadMayoreo']){
      $precio=$item['precioMayoreo'];
    }
    //comprobar si hay mas de este articulo para nadmas sumarlo
    $exysteItemEnVenta = $this->consultas->comprobarItemEnVenta($idVenta,$idItem);
    if($exysteItemEnVenta)
    {

      $movimiento = $this->consultas->getMovimientoVenta($idVenta,$idItem);
      $item = $this->consultas->getInventariobyId($idItem);
      $sumCantidad = $cantidad + $movimiento['cantidad'];
      $dataMovimiento = array(
        'cantidad'=>$sumCantidad,
        'cantidadOfertas'=>$sumCantidad,
        'costoUnitario'=>$precio
      );
      $whereMovimiento = array(
        'id'=>$movimiento['id']
      );
      $this->insertar->updateMovimientoVenta($dataMovimiento,$whereMovimiento);

      $xrespuesta['cantidad'] = $sumCantidad;
    }
    else
    {
      $dataMovimiento = array(
        'idVenta' => $idVenta,
        'idInventario'=>$idItem,
        'cantidad'=>$cantidad,
        'cantidadOfertas'=>$cantidad,
        'costoUnitario'=>$precio
      );

      $temp = array(
        'id_venta' => $idVenta,
        'id_usuario' => $this->session->userdata('idUser')
      );
      $this->insertar->newMovimientoVenta($dataMovimiento);
      $this->insertar->newMovimientoTemporal($temp);

    }
    $xrespuesta['xstatus'] = 1;
    $xrespuesta['idVenta'] = $idVenta;
    $xrespuesta['id'] = $idItem;
    $xrespuesta['codigo'] = $item['codigo'];
    $xrespuesta['descripcion'] = $item['descripcion'];
    $xrespuesta['precio'] = $precio;
    $xrespuesta['precioOferta'] = $item['precio']; // Pendiente revisar!!!!!!!!!
    $xrespuesta['costoUnitario'] = $precio;
    echo json_encode($xrespuesta);
  }


  public function getItem()
  {
    $codigo = $this->input->post('codigo');
    $item = $this->consultas->getInventario($codigo);
    echo json_encode($item);
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


  public function impVenta()
  {
    $idUser = $this->session->userdata('idUser');
    $idVenta = $this->input->post('idVenta');
    $recibido = $this->input->post('recibido');
    $detalleItem = $this->consultas->getItemsDeVentas($idVenta);
    $detalleVenta = $this->consultas->getVentaById($idVenta);
    $nombreEmpresa = $this->consultas->getConfigs();
    $nombreEmpresa = $nombreEmpresa->nombreEmpresa;
    $vendedor = $this->consultas->getUsers($detalleVenta['idUsuario']);
    $moneda=$this->consultas->getMonedaString();

  }

  public function reImpVenta()
  {
    $idVenta = $this->input->post('idVenta');
    $idUser = $this->session->userdata('idUser');
    $detalleItem = $this->consultas->getItemsDeVentas($idVenta);
    $detalleVenta = $this->consultas->getVentaById($idVenta);
    $nombreEmpresa = $this->consultas->getConfigs();
    $nombreEmpresa = $nombreEmpresa->nombreEmpresa;
    $vendedor = $this->consultas->getUsers($detalleVenta['idUsuario']);
    $moneda=$this->consultas->getMonedaString();

  }

  public function buscarpr()
  {
    $inventario = $this->consultas->getInventario();
    $data = array('inventario' => $inventario);
    $data['monedaString']=$this->consultas->getMonedaString();
    $this->load->view('_busqueda',$data);
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
      'fecha' => date("Y-m-d H:i:s"),
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

  public function addClienteHtml()
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
      'correo'=>''
    );

    $data=array(
      'idForm'=>$idForm,
      'idCliente'=>0,
      'nombre'=>$nombre,
      'textoBoton'=>$textoBoton,
      'roles'=>$this->consultas->getRoles(),
      'cliente'=>$myCliente,
    );
    $this->load->view('_addCliente',$data);
  }

  public function addCliente()
  {
    $nombre = $this->input->post('nombre');
    $datos = array(
      'nombre'=>$nombre,
      'identidad'=>$this->input->post('identidad'),
      'direccion'=>$this->input->post('direccion'),
      'telefono'=>$this->input->post('telefono'),
      'correo'=>$this->input->post('correo')
    );
    $idCliente = $this->insertar->newCliente($datos);

    $respuesta=array(
      'nombre'=>$nombre,
      'id'=>$idCliente
    );
    echo json_encode($respuesta);
  }

  public function actualizarClienteVenta()
  {
    $idVenta = $this->input->post('idVenta');
    $idCliente = $this->input->post('idCliente');
    $this->insertar->actualizarClienteVenta($idVenta,$idCliente);
  }

  

}
?>
