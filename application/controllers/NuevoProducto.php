<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class NuevoProducto extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    if($this->session->userdata('rol')!=1){
      redirect(base_url());
    }
  }


  public function index($msj=0)
  {
    $idUser = $this->session->userdata('idUser');
    $rol= $this->session->userdata('rol');
    $user=$this->consultas->getUsers($idUser);
    $data = array();
    $tema = $this->consultas->configTema();
    $inventario = $this->consultas->getInventario();
    $departamentos = $this->consultas->getDepartamentos();
    $tiposVanta = $this->consultas->getTipoVenta();
    $proveedores = $this->consultas->getProveedores();
    $dataSidebar = array();
    $dataHeader['titulo']="Inventario";
    $dataSidebar['classInventario']="active";
    $dataSidebar['classVentas']="";
    $dataSidebar['classUsuarios']="";
    $dataSidebar['classMovimientos']="";

    $dataSidebar['classInventarioGeneral']="";
    $dataSidebar['classInventarioModificar']="";
    $dataSidebar['classInventarioAgregar']="";
    $dataSidebar['classInventarioNuevo']="active";
    $dataSidebar['classInventarioCBarras']="";
    $dataSidebar['classConfiguraciones']="";
    $dataSidebar['classProveedores']="";
    $dataSidebar['classClientes']="";
    $dataSidebar['tema']="$tema";
    $dataSidebar['usuario']=$user;

    $data['inventario']=$inventario;
    $data['departamentos']=$departamentos;
    $data['tiposVenta']=$tiposVanta;
    $data['proveedores']=$proveedores;
    $data['monedaString']=$this->consultas->getMonedaString();


    $this->load->view('header',$dataHeader);
    $this->load->view('sidebar',$dataSidebar);
    $this->load->view('inventario/nuevoProducto',$data);
    $dataFooter=array(
      'scripts'=> "<script src='".base_url()."js/admin.js'></script>"
    );
    $dataFooter['scripts'].="<script src='".base_url()."js/tema.js'></script>";
    $this->load->view('footer',$dataFooter);
  }


  public function verificarProducto()
  {
    $codigo = $this->input->post('codigo');
    echo $this->consultas->comprobarCodigo($codigo);
  }


  public function addDepartamento()
  {
    $nombre = strtoupper($this->input->post('nombre'));
    $datos = array(
      'departamento' => $nombre,
    );

    $DepartamentoS = $this->consultas->getDepartamentos();
    foreach ($DepartamentoS as $key) {
      if($key['departamento']==$nombre){
        die("x");
      }
    }

    $idDep = $this->insertar->newDepartamento($datos);
    $respuesta=array(
      'nombre'=>$nombre,
      'id'=>$idDep
    );
    echo json_encode($respuesta);
  }



  public function addNewItem()
  {
    $codigo = $this->input->post('codigo');
    $descripcion = $this->input->post('descripcion');
    $costo = $this->input->post('costo');
    $precio = $this->input->post('precio');
    $pmayoreo = $this->input->post('pmayoreo');
    $cmayoreo = $this->input->post('cmayoreo');
    $departamento = $this->input->post('departamento');
    $tipoVenta = $this->input->post('tipoVenta');
    $idProveedor = $this->input->post('proveedor');
    $stockCritico = $this->input->post('stockCritico');
    $cantidad = $this->input->post('cantidad');

    $datos = array(
      'codigo' => $codigo,
      'descripcion' => $descripcion,
      'costo' => $costo,
      'precio' => $precio,
      'precioMayoreo' => $pmayoreo,
      'cantidadMayoreo' => $cmayoreo,
      'idDepartamento' => $departamento,
      'idtipo'=>$tipoVenta,
      'idProveedor'=>$idProveedor,
      'stockCritico'=>$stockCritico,
      'cantidad'=>$cantidad
    );

    if(     $this->consultas->comprobarCodigo($codigo)     ){
      die("2"); // codigo 2 significa que el codigo ya existe en la BD
    }
    $this->insertar->newProducto($datos);
    echo "1"; // codigo 1 significa que termino con normalidad
  }


  public function gencodebar()
  {
    
    $prefixBarCode = "1";
    // Longitud del hash para el código 
    $hashLenght = 9;
    // Crear los 12 dígitos aleatorios para el código 
    $barCode = $prefixBarCode . $this->createhash($hashLenght);
    // Crear el dígito verificador del código 
    $verifyNumber = $this->getVerifyNumber($barCode);
    // El codigo EAN13
    $ean13barCode = $barCode . $verifyNumber;

    if(     $this->consultas->comprobarCodigo($ean13barCode)     )
    {
      $ean13barCode=$this->gencodebar();
    }
    else {
      echo $ean13barCode;
    }
  }




  // ====================================================================================
  function createhash($length){
    $tokens = array("0","1","2","3","4","5","6","7","8","9");
    $hashcode = "";
    for($c = 0; $c < $length; $c++){
      srand((double)microtime() * 100000000000);
      $pass = $tokens[rand(0,count($tokens) - 1)];
      $hashcode = $hashcode.$pass;
    }
    return $hashcode;
  }



  function getVerifyNumber($code){
    // Separa los 12 dígitos en elementos de un arreglo
    $addOdd=0;
    $addEven=0;
    $arrayBarCode = str_split($code);
    // Invertir el arreglo (El ultimo elemento ahora es el primero)
    $arrayBarCodeReverse = array_reverse($arrayBarCode);
    // Consecutivamente, el primer elemento del arreglo es del conjunto A, el segundo del conjunto B
    for ($i=0; $i<(count($arrayBarCodeReverse) / 2); $i++){
      // Sumar los elementos del conjunto A
      // [0*2],[1*2],[2*2]…[i*2] => [0],[2],[4]…[i*2]
      $addOdd += $arrayBarCodeReverse[$i*2];
      // Sumar los elementos del conjunto B
      // [(0*2)+1],[(1*2)+1],[(2*2)+1]…[(i*2)+1] => [1],[3],[5]…[]
      $addEven += $arrayBarCodeReverse[($i*2)+1];
    }
    // Suma total
    $addTotal = ($addOdd * 3) + $addEven;
    // Regresa el dígito que complementa la decena mas cercana en la suma total
    return(substr(10 - substr($addTotal,-1,1),-1,1));
  }
  // ====================================================================================


}
?>
