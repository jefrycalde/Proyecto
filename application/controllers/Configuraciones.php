<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Configuraciones extends CI_Controller
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
    $dataSidebar = array();
    $dataHeader['titulo']="Inventario";
    $dataSidebar['classInventario']="";
    $dataSidebar['classVentas']="";
    $dataSidebar['classUsuarios']="";
    $dataSidebar['classMovimientos']="";

    $dataSidebar['classInventarioGeneral']="";
    $dataSidebar['classInventarioModificar']="";
    $dataSidebar['classInventarioAgregar']="";
    $dataSidebar['classInventarioNuevo']="";
    $dataSidebar['classInventarioCBarras']="";
    $dataSidebar['classConfiguraciones']="active";
    $dataSidebar['classProveedores']="";
    $dataSidebar['classClientes']="";
    $dataSidebar['tema']="$tema";
    $dataSidebar['usuario']=$user;

    $data['inventario']=$inventario;
    $data['departamentos']=$departamentos;
    $data['tiposVenta']=$tiposVanta;
    $data['nombreEmpresa']=$this->consultas->configNombreEmpresa();
    $data['logo']=$this->consultas->configLogo();
    $data['departamentos']=$this->consultas->getDepartamentos();

    $data['configs']=$this->consultas->getConfigs();

    if ($data['configs']->impuesto==1) {
      $data['impuesto_si']="active";
      $data['impuesto_no']="notActive";
      $data['impuesto_ok']="impuesto_ok";
    }
    else {
      $data['impuesto_si']="notActive";
      $data['impuesto_no']="active";
      $data['impuesto_ok']="impuesto_ok hide";
    }

    $this->load->view('header',$dataHeader);
    $this->load->view('sidebar',$dataSidebar);
    $this->load->view('inventario/configuraciones',$data);
    $dataFooter=array(
      'scripts'=> "<script src='".base_url()."js/configs.js'></script>"
    );
  }






  public function depHtml($idDep=0)
  {
    $nombre="";
    $textoBoton="Agregar";
    $idForm="formAddDep";
    if($idDep>0){
      $myDepartamento = $this->consultas->getDepartamentos($idDep);
      $nombre=$myDepartamento['departamento'];
      $textoBoton="Modificar";
      $idForm="formModDep";
    }
    $data=array(
      'idForm'=>$idForm,
      'idDep'=>$idDep,
      'nombre'=>$nombre,
      'textoBoton'=>$textoBoton,
    );
    $this->load->view('_departamento',$data);
  }



  public function addDepartamento()
  {
    $nombre = $this->input->post('nombre');
    $datos = array(
      'departamento' => strtoupper($nombre),
    );

    $DepartamentoS = $this->consultas->getDepartamentos();
    foreach ($DepartamentoS as $key) {
      if($key['departamento']==$nombre){
        die("2");
      }
    }

    $this->insertar->newDepartamento($datos);
    echo "1";
  }



  public function saveImpuesto()
  {
    $impuesto = $this->input->post('impuesto'); // 0=no | 1=si

    if($impuesto){
      $datosImpuestos=array(
        'impuesto' => $impuesto,
        'nombreImpuesto' => $this->input->post('nombreImpuesto'),
        'impuestoPorciento' => $this->input->post('impuestoPorciento')
      );
    }
    else{
      $datosImpuestos=array(
        'impuesto' => $impuesto
      );
    }

    $this->insertar->setConfig($datosImpuestos);

    echo "1";
  }



  public function modDep()
  {
    $idDep = $this->input->post('idDep');
    $nombre = $this->input->post('nombre');
    $datos = array(
      'departamento' => $nombre,
    );
    $where = array(
      'id'=>$idDep
    );
    $MyDepartamento = $this->consultas->getDepartamentos($idDep);
    $DepartamentoS = $this->consultas->getDepartamentos();

    foreach ($DepartamentoS as $key) {
      if($key['departamento']==$nombre && $nombre!=$MyDepartamento['departamento']){
        die("2");
      }
    }

    $this->insertar->setDepartamento($datos,$where);
    echo "1";
  }

  public function delDep()
  {
    $idDep = $this->input->post('idDep');
    $this->delete->delDepartamento($idDep);
  }



  public function saveName()
  {
    $nombre = $this->input->post('nombre');
    $datos=array(
      'nombreEmpresa'=>$nombre
    );
    $this->insertar->setConfig($datos);
    echo "$nombre"; // codigo 1 significa que termino con normalidad
  }




  public function saveTiketera()
  {
    $tiketera = $this->input->post('tiketera');
    $datos=array(
      'tiketera'=>$tiketera
    );
    $this->insertar->setConfig($datos);
    //echo "$nombre"; // codigo 1 significa que termino con normalidad
  }




  public function saveLogo()
  {
    $file_name = $_FILES['logo']['name'];
    $file_size = $_FILES['logo']['size'];
    $file_tmp = $_FILES['logo']['tmp_name'];
    $file_type = $_FILES['logo']['type'];

    //este es el nombre del archivo
    $nombre = $file_name;
    //este es el archivo temporal
    $imagen_temporal = $file_tmp;
    //este es el tipo de archivo
    $tipo = $file_type;
    //leer el archivo temporal en binario
    $fp = fopen($imagen_temporal, 'r+b');
    $binario_misc = fread($fp, filesize($imagen_temporal));
    fclose($fp);


    $datos=array(
      'logo'=>$binario_misc
    );
    $where=array(
      'id'=>1
    );
    $this->insertar->setConfig($datos,$where);
    echo "1"; // codigo 1 significa que termino con normalidad
  }










}
?>
