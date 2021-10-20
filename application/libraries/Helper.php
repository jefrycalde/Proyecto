<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Helper
{
	var $CI;

	public function __construct()
	{
		date_default_timezone_set("America/Mexico_City");
		$this->CI =& get_instance();

	}
	public function validarDatos($dFis)
	{

		$datosfac = $this->CI->consultas->getDatosFacturacion();

		foreach ($datosfac as $dFac){
			$rfc = $dFac['rfc'];
			$regimen = $dFac['regimen'];
			$nombre = $dFac['nombre'];
			$calle = $dFac['calle'];
			$noExterior = $dFac['noExterior'];
			$noInterior = $dFac['noInterior'];
			$colonia = $dFac['colonia'];
			$localidad = $dFac['localidad'];
			$municipio = $dFac['municipio'];
			$estado = $dFac['estado'];
			$pais = $dFac['pais'];
			$codigoPostal = $dFac['codigoPostal'];
		}

		$error = '';

		//		if (!preg_match($rfc , $dFis['rfc'])) {
		//			$error .= 'El RFC no es correcto.';
		//		}

		if (!preg_match("/".$regimen."/i", $dFis['regimen'])) {

			if (!preg_match("/".$nombre."/i", $dFis['nombre'])) {
				$error .= 'El Nombre de la empresa no es correcto: ' . $dFis['nombre'] . '. ';
			}
			if (!preg_match("/".$calle."/i", $dFis['calle'])) {
				$error .= 'El nombre de la Calle no es correcto: ' . $dFis['calle'] . '. ';
			}
			if ($dFis['noExterior'] != '') {
				if (!preg_match("/".$noExterior."/", $dFis['noExterior'])) {
					$error .= 'El Número Exterior no es correcto: ' . $dFis['noExterior'] . '. ';
				}
			}
			if ($dFis['noInterior'] != '') {
				if (!preg_match("/".$noInterior."/", $dFis['noInterior'])) {
					$error .= 'El Número Interior no es correcto: ' . $dFis['noInterior'] . '. ';
				}
			}
			if (!preg_match("/".$colonia."/i", $dFis['colonia'])) {
				$error .= 'El nombre de la Colonia no es correcto: ' . $dFis['colonia'] . '. ';
			}
			if ($dFis['localidad'] != '') {
				if (!preg_match("/".$localidad."/i" , $dFis['localidad'])) {
					$error .= 'El nombre de la Localidad no es correcto: ' . $dFis['localidad'] . '. ';
				}
			}
			if (!preg_match("/".$municipio."/i", $dFis['municipio'])) {
				$error .= 'El nombre del Municipio no es correcto: ' . $dFis['municipio'] . '. ';
			}
			if (!preg_match("/".$estado."/i", $dFis['estado'])) {
				$error .= 'El nombre del Estado no es correcto: ' . $dFis['estado'] . '. ';
			}
			if (!preg_match("/".$pais."/i", $dFis['pais'])) {
				$error .= 'El nombre del País no es correcto: ' . $dFis['pais'] . '. ';
			}
			if (!preg_match("/".$codigoPostal."/", $dFis['codigoPostal'])) {
				$error .= 'El Código Postal no es correcto: ' . $dFis['codigoPostal'] . '. ';
			}
		}
		return $error;
	}

	public function token($arr)
	{
		// $this->CI->load->library('encrypt');

		$string = '';
		foreach ($arr as $val):
			$string .= $val . ';';
		endforeach;
		// $token = $this->CI->encrypt->encode($string);
		$token = md5($string);

		return $token;
	}

	public function decode($token)
	{
		$this->CI->load->library('encrypt');

		$string = $this->CI->encrypt->decode($token);

		return $string;
	}


	public function validacionesRepo($idRepo, $ronda)
	{
		$op_reposicion_cheque = $this->CI->consultas->getOpReposicionChequeByRepo($idRepo);
		$miRepo = $this->CI->consultas->getReposicion($idRepo);
		$miCheque = $this->CI->consultas->getCheque($op_reposicion_cheque->idCheque);

		$btn = 'btn-default';
		$prog = 0;
		$content = '<ul>';
		$validaciones = $this->CI->consultas->getValidacionesRepoByRonda($idRepo, $ronda);

		$check=0;
		$vRevisor=0;
		$vN2=0;
		$vN3=0;
		$vN4=0;
		$vN5=0;
		// $validacionesRonda = $this->CI->consultas->getValidacionesRepoByRonda($miRepo['id'],$ronda);
		foreach ($validaciones as $key2) {
			$user = $this->CI->consultas->getUsuariosById2($key2['idRevisor']);
			$rolRevisor = $this->CI->consultas->getUsuariosById2($key2['idRevisor'])->rol;
			if ($key2['idRevisor']==$miCheque['idRevisor'] || $rolRevisor==3 || $rolRevisor==4 || $rolRevisor=5) {
				$check++;
			}
			if($key2['idRevisor']==$miCheque['idRevisor']){ $vRevisor++; }
			if($rolRevisor==2){ $vN2++; }
			if($rolRevisor==3){ $vN3++; }
			if($rolRevisor==4){ $vN4++; }
			if($rolRevisor==5){ $vN5++; }
			$textRevisor='';
			$estilo="";
			if($check==1){$textRevisor=' (revisor)';}
			if($check==2){$textRevisor=' (cuentas por pagar)'; $estilo="style='color:#FF8000'";}
			if($check==3){$textRevisor=' (administración)'; $estilo="style='color:#2E2EFE'";}
			if($check==4){$textRevisor=' (gerencia)'; $estilo="class='text-success'";}
			$content .= '<li '.$estilo.'>Verificada por ' . $user->nombre . $textRevisor.'</li>';
		}

		// ¿Validada?
		$rol = $this->CI->session->userdata('rol');
		$rolRevisor = $this->CI->consultas->getUsuariosById2($miCheque['idRevisor'])->rol;

		$aceptada=FALSE;
		if($check==4){$aceptada=TRUE;}

		if ($aceptada) {
			$btn = 'btn-success';
		}

		$content .= '</ul>';
		$button = '<button type="button" class="btn ' . $btn . ' popDown" data-container="body" data-toggle="popover"
		data-placement="bottom" data-content="' . $content . '">' . $check . '/4 </button>';
		$datos = array(
			'button' => $button,
			'aceptada'=>$aceptada,
			'vN2'=>$vN2,
			'vN3'=>$vN3,
			'vN4'=>$vN4,
			'vN5'=>$vN5
		);
		return $datos;
		// return $button;
	}

	public function validacionesComp($idComp, $ronda)
	{
		$miComprobacion = $this->CI->consultas->getComprobacion($idComp);
		$op_cheque_comprobacion = $this->CI->consultas->getOpComprobacionChequeByComp($idComp);
		$miCheque = $this->CI->consultas->getCheque($op_cheque_comprobacion->idCheque);

		$btn = 'btn-default';
		$prog = 0;
		$content = '<ul>';

		$validaciones = $this->CI->consultas->getValidacionesCompByRonda($idComp, $ronda);

		$check=0;
		$vRevisor=0;
		$vN3=0;

		foreach ($validaciones as $key2) {
			$user = $this->CI->consultas->getUsuariosById2($key2['idRevisor']);
			$rolRevisor = $this->CI->consultas->getUsuariosById2($key2['idRevisor'])->rol;
			if ($key2['idRevisor']==$miCheque['idRevisor'] || $rolRevisor==3 || $rolRevisor==4 || $rolRevisor=5) {
				$check++;
			}
			if($key2['idRevisor']==$miCheque['idRevisor']){ $vRevisor++; }
			if($rolRevisor==3){ $vN3++; }
			$textRevisor='';
			$estilo="";
			if($check==1){$textRevisor=' (revisor)';}
			if($check==2){$textRevisor=' (cuentas por pagar)'; $estilo="class='text-success'";}
			$content .= '<li '.$estilo.'>Verificada por ' . $user->nombre . $textRevisor.'</li>';
		}
		// ¿Validada?
		$rol = $this->CI->session->userdata('rol');
		$rolRevisor = $this->CI->consultas->getUsuariosById2($miCheque['idRevisor'])->rol;

		$aceptada=FALSE;
		if($check>1){$aceptada=TRUE;}

		if ($aceptada) {
			$btn = 'btn-success';
		}

		$content .= '</ul>';
		$button = '<button type="button" class="btn ' . $btn . ' popDown" data-container="body" data-toggle="popover"
		data-placement="bottom" data-content="' . $content . '">' . $check . '/2 </button>';
		$datos = array(
			'button' => $button,
			'aceptada'=>$aceptada,
			'vN3'=>$vN3,
			'check'=>$check
		);
		return $datos;
	}

	public function validacionesPagoProv($idPagroProv, $ronda)
	{
		$op_proveedor_cheque = $this->CI->consultas->getOpChequePagoProveedorbyIdPagoProveedor($idPagroProv);
		$miPago = $this->CI->consultas->getPagoProveedores($op_proveedor_cheque->id_pagoproveedor);
		$miCheque = $this->CI->consultas->getCheque($op_proveedor_cheque->id_cheque);

		$btn = 'btn-default';
		$prog = 0;
		$content = '<ul>';
		$validaciones = $this->CI->consultas->getValidacionesPagoProvByRonda($idPagroProv, $ronda);
		// ***************************************************************
		$check=0;
		$vRevisor=0;
		$vN2=0;
		$vN3=0;
		$vN4=0;
		$vN5=0;
		// $validacionesRonda = $this->CI->consultas->getValidacionesRepoByRonda($miRepo['id'],$ronda);
		foreach ($validaciones as $key2) {
			$user = $this->CI->consultas->getUsuariosById2($key2['idrevisor']);
			$rolRevisor = $this->CI->consultas->getUsuariosById2($key2['idrevisor'])->rol;
			if ($key2['idrevisor']==$miCheque['idRevisor'] || $rolRevisor==3 || $rolRevisor==4 || $rolRevisor=5) {
				$check++;
			}
			if($key2['idrevisor']==$miCheque['idRevisor']){ $vRevisor++; }
			if($rolRevisor==2){ $vN2++; }
			if($rolRevisor==3){ $vN3++; }
			if($rolRevisor==4){ $vN4++; }
			if($rolRevisor==5){ $vN5++; }
			$textRevisor='';
			$estilo="";
			if($check==1){$textRevisor=' (revisor)';}
			if($check==2){$textRevisor=' (cuentas por pagar)'; $estilo="style='color:#FF8000'";}
			if($check==3){$textRevisor=' (administración)'; $estilo="style='color:#2E2EFE'";}
			if($check==4){$textRevisor=' (gerencia)'; $estilo="class='text-success'";}
			$content .= '<li '.$estilo.'>Verificada por ' . $user->nombre . $textRevisor.'</li>';
		}

		// ¿Validada?
		$rol = $this->CI->session->userdata('rol');
		$rolRevisor = $this->CI->consultas->getUsuariosById2($miCheque['idRevisor'])->rol;

		$aceptada=FALSE;
		if($check==4){$aceptada=TRUE;}

		if ($aceptada) {
			$btn = 'btn-success';
		}

		$content .= '</ul>';
		$button = '<button type="button" class="btn ' . $btn . ' popDown" data-container="body" data-toggle="popover"
		data-placement="bottom" data-content="' . $content . '">' . $check . '/4 </button>';
		$datos = array(
			'button' => $button,
			'aceptada'=>$aceptada,
			'vN2'=>$vN2,
			'vN3'=>$vN3,
			'vN4'=>$vN4,
			'vN5'=>$vN5
		);
		return $datos;
		// return $button;
	}

	public function validacionesCheque($idCheque, $ronda)
	{
		$miCheque = $this->CI->consultas->getCheque($idCheque);

		$btn = 'btn-default';
		$prog = 0;
		$content = '<ul>';
		$rol = $this->CI->session->userdata('rol');
		$validaciones = $this->CI->consultas->getValidacionesChequeByRonda($idCheque, $ronda);

		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		$check=0;
		$vRevisor=0;
		$vN2=0;
		$vN3=0;
		$vN4=0;
		$vN5=0;
		// $validacionesRonda = $this->CI->consultas->getValidacionesRepoByRonda($miRepo['id'],$ronda);
		foreach ($validaciones as $key2) {
			$user = $this->CI->consultas->getUsuariosById2($key2['idRevisor']);
			$rolRevisor = $this->CI->consultas->getUsuariosById2($key2['idRevisor'])->rol;
			if ($key2['idRevisor']==$miCheque['idRevisor'] || $rolRevisor==3 || $rolRevisor==4 || $rolRevisor=5) {
				$check++;
			}
			if($key2['idRevisor']==$miCheque['idRevisor']){ $vRevisor++; }
			if($rolRevisor==2){ $vN2++; }
			if($rolRevisor==3){ $vN3++; }
			if($rolRevisor==4){ $vN4++; }
			if($rolRevisor==5){ $vN5++; }
			$textRevisor='';
			$estilo="";
			if($check==1){$textRevisor=' (revisor)';}
			if($check==2){$textRevisor=' (cuentas por pagar)'; $estilo="style='color:#FF8000'";}
			if($check==3){$textRevisor=' (administración)'; $estilo="style='color:#2E2EFE'";}
			if($check==4){$textRevisor=' (gerencia)'; $estilo="class='text-success'";}
			$content .= '<li '.$estilo.'>Verificada por ' . $user->nombre . $textRevisor.'</li>';
		}

		// ¿Validada?
		$rol = $this->CI->session->userdata('rol');
		// $rolRevisor = $this->CI->consultas->getUsuariosById2($miCheque['idRevisor'])->rol;

		$aceptada=FALSE;
		if($check==4){$aceptada=TRUE;}
		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

		if ($aceptada) {
			$btn = 'btn-success';
		}
		$content .= '</ul>';
		$button = '<button type="button" class="btn ' . $btn . ' popDown" data-container="body" data-toggle="popover"
		data-placement="bottom" data-content="' . $content . '">' . $check . '/4 </button>';
		$datos = array(
			'button' => $button,
			'aceptada'=>$aceptada,
			'vN2'=>$vN2,
			'vN3'=>$vN3,
			'vN4'=>$vN4,
			'vN5'=>$vN5
		);
		return $datos;
		// return $button;
	}

	/* /?? ?? ??\ */
	public function periodo()
	{
		$w = date('N'); // numero del dia de la semana lunes=1 martes=2 miercoles=3 jueves=4 viernes=5 sabado=6 domingo=7
		$h = date('H'); // hora cerrada ejemplo 9:15am = 9 ,  2:14pm = 14
		$t_dia = 60 * 60 * 24;
		// Si es miércoles a partir de las 10AM; Si es jueves en adelante; Si es lunes antes de las 10AM
		/* Faltaba la última condición, el error se daba si se cargaban facturas en lunes entre las 0:00 y las 10:00 */
		if (($w == 3 && $h >= 10) || ($w > 3) || ($w == 1 && $h < 10)) {
			$entrega = 'MARTES';
			// Inicio: Fecha del último miércoles a partir de mañana
			$inicio = date('Y-m-d 10:00:00', strtotime('last wednesday', strtotime('tomorrow')));
			// Fin: Fecha 5 días después de $inicio
			$fin = date('Y-m-d H:i:s', strtotime($inicio) + ($t_dia * 5));
		} else {
			$entrega = 'JUEVES';
			// Fin: Fecha del siguiente miércoles a partir de ayer
			$fin = date('Y-m-d 10:00:00', strtotime('next wednesday', strtotime('yesterday')));
			// Inicio: Fecha 2 días antes de $fin
			$inicio = date('Y-m-d H:i:s', strtotime($fin) - ($t_dia * 2));
		}
		return array('inicio' => $inicio, 'fin' => $fin);
	}



	public function notificarPaquete($idPaq, $tipo)
	{
		$debug = '';
		if ($this->CI->session->userdata('debug')) {
			$debug = $this->CI->session->userdata('debug');
		}
		/* Datos */
		$coment = '';
		$paq = $this->CI->consultas->getPaquete($idPaq);

		// $debug .= print_r($paq, true).'<br>';

		$nombre = date('d/m/Y', strtotime($paq['inicio'])) . ' - ' . date('d/m/Y', strtotime($paq['fin']));

		if ($tipo == 'cerrar') {
			$titulo = 'Nuevo paquete [' . $nombre . ']';
			$mensaje = 'Paquete pendiente de revisión';

			$usuarios = $this->CI->consultas->getUsersByRol(4);
		} else if ($tipo == 'rechazar') {
			$titulo = 'Paquete rechazado [' . $nombre . ']';
			$mensaje = 'El paquete fue rechazado';

			$usuarios = $this->CI->consultas->getUsersByRol(3);
		} else if ($tipo == 'aceptar') {
			$rol = $this->CI->session->userdata('rol');
			if ($rol == 4) {
				$titulo = 'Nuevo paquete [' . $nombre . ']';
				$mensaje = 'Paquete pendiente de revisión';

				$usuarios = $this->CI->consultas->getUsersByRol(5);
			} else if ($rol == 5) {
				$titulo = 'Paquete aceptado [' . $nombre . ']';
				$mensaje = 'Paquete aceptado por Gerencia';

				$usuarios = $this->CI->consultas->getUsersByRol(3);
			}
		}

		/* Registrar */
		if (!empty($usuarios)) {

			// $debug .= print_r($usuarios, true).'<br>';

			foreach ($usuarios as $row) {
				$not = array(
					'idUsuario' => $row['id'],
					'titulo' => $titulo,
					'mensaje' => $mensaje,
					// 'link' => 'resumen/index/'.$paq['id'],
					'tipo' => 'paquete',
					'id_tipo' => $idPaq,
					'fecha' => date('Y-m-d H:i:s')
				);

				// $debug .= print_r($not, true).'<br>';

				$id = $this->CI->insertar->newNotificacion($not);
				if (is_numeric($id)) {
					$this->email(
					$row['email'],
					$titulo,
					$mensaje . '<br><br><a href="' . base_url() . 'notificacion/ver/' . $id . '">Acceder al sistema</a>'
				);
			}
		}
	}

	$this->CI->session->set_userdata(array('debug' => $debug));
	// if(!is_numeric($id)){
	// 	echo $id.'<br>';
	// }
}


public function notificarCheque($idCheque, $tipo)
{
	$coment = '';
	$miCheque = $this->CI->consultas->getCheque($idCheque);
	$titulo = "";
	$mensaje = "";
	$id = "";
	$usuario = $this->CI->consultas->getUsuariosById2($miCheque['idUsuario']);
	$revisor = $this->CI->consultas->getUsuariosById2($miCheque['idRevisor']);
	if ($tipo == 'guardar') {
		$not = array(
			'idUsuario' => $usuario->id,
			'titulo' => 'Acuse solicitud de cheque [' . $miCheque['nombre'] . ']',
			'mensaje' => 'Acuse solicitud de cheque',
			'tipo' => 'cheque',
			'id_Tipo' => $idCheque,
			'fecha' => date('Y-m-d H:i:s')
		);
		$id = $this->CI->insertar->newNotificacion($not);

		$this->email($usuario->email,
		'Acuse solicitud de cheque [' . $miCheque['nombre'] . ']',
		'Acuse solicitud de cheque'.
		'<br><br><a href="' . base_url() . 'cheque/ver/' . $id . '">Acceder al sistema</a>');

		$not['idUsuario'] =$revisor->id;
		$not['titulo'] ='Nueva solicitud de cheque pendiente de revisión [' . $miCheque['nombre'] . ']';
		$not['mensaje'] ='Nueva solicitud de cheque pendiente de revisión';

		// =============================================================================================================
		$rol = $this->CI->session->userdata('rol');
		if($rol==5){
			$usuarios = $this->CI->consultas->getUsersByRol(3);
		}
		else{  // ==
			$id = $this->CI->insertar->newNotificacion($not);

			$this->email($revisor->email,
			'Nueva solicitud de cheque pendiente de revisión [' . $miCheque['nombre'] . ']',
			'Nueva solicitud de cheque pendiente de revisión'.
			'<br><br><a href="' . base_url() . 'cheque/ver/' . $id . '">Acceder al sistema</a>');
		} // ==
		// =============================================================================================================


	}
	else if ($tipo == 'rechazar') {
		$not = array(
			'idUsuario' => $miCheque['idUsuario'],
			'titulo' => 'Aviso de cheque rechazado [' . $miCheque['nombre'] . ']',
			'mensaje' => 'Solicitud de cheque rechazado',
			'tipo' => 'cheque',
			'id_Tipo' => $idCheque,
			'fecha' => date('Y-m-d H:i:s')
		);
		$id = $this->CI->insertar->newNotificacion($not);

		$this->email($usuario->email,
		'Aviso de cheque rechazado [' . $miCheque['nombre'] . ']',
		'Solicitud de cheque rechazado'.
		'<br><br><a href="' . base_url() . 'cheque/ver/' . $id . '">Acceder al sistema</a>');

	} else if ($tipo == 'aceptar') {
		// ====================================================================================
		$ronda=1;
		if($misValidaciones = $this->CI->consultas->getValidacionesCheques($miCheque['id']))
		{
			foreach ($misValidaciones as $key) {
				if ($key['validado']==0) {
					$ronda = $ronda+1;
				}
			}
		}
		$check=0;
		$vRevisor=0;
		$vN3=0;
		$vN4=0;
		$vN5=0;
		$validacionesRonda = $this->CI->consultas->getValidacionesChequeByRonda($miCheque['id'],$ronda);
		foreach ($validacionesRonda as $key2) {
			$rolRevisor = $this->CI->consultas->getUsuariosById2($key2['idRevisor'])->rol;
			if ($key2['idRevisor']==$miCheque['idRevisor'] || $rolRevisor==3 || $rolRevisor==4 || $rolRevisor=5) {
				$check++;
			}
			if($key2['idRevisor']==$miCheque['idRevisor']){ $vRevisor++; }
			if($rolRevisor==3){ $vN3++; }
			if($rolRevisor==4){ $vN4++; }
			if($rolRevisor==5){ $vN5++; }
		}
		// //
		$rolRevisor = $this->CI->consultas->getUsuariosById2($miCheque['idRevisor'])->rol;
		$rolSolicitante = $this->CI->consultas->getUsuariosById2($miCheque['idUsuario'])->rol;
		$rol = $this->CI->session->userdata('rol');
		if(   $check<2   &&   ($rol==$rolRevisor && $rol==2 && $vRevisor<2)     ||     ($rol==$rolRevisor && $rol==4 && $vRevisor<2)     ||     ($rol==$rolRevisor && $rol==5 && $vRevisor<2)     ){
			if($rolSolicitante!=3){
				$usuarios = $this->CI->consultas->getUsersByRol(3);
			}
		}
		// //
		$titulo = 'Cheque aceptado [' . $miCheque['nombre'] . ']';
		$mensaje = 'Solicitud de cheque aceptada';
		$not = array(
			'idUsuario' => $miCheque['idUsuario'],
			'titulo' => $titulo,
			'mensaje' => $mensaje,
			'tipo' => 'cheque',
			'id_Tipo' => $idCheque,
			'fecha' => date('Y-m-d H:i:s')
		);
		$id = $this->CI->insertar->newNotificacion($not);

		$this->email($usuario->email,
		'Cheque aceptado [' . $miCheque['nombre'] . ']',
		'Solicitud de cheque aceptada'.
		'<br><br><a href="' . base_url() . 'cheque/ver/' . $id . '">Acceder al sistema</a>');
	}
	// ====================================================================================
	else if ($tipo == 'aplazar') {
		$usuario = $this->CI->consultas->getUsuariosById2($miCheque['idUsuario']);

		$not = array(
			'idUsuario' => $usuario->id,
			'titulo' => 'Cheque aplazado por falta de validaci&oacute;n a tiempo [' . $miCheque['nombre'] . ']',
			'mensaje' => 'Cheque aplazado por falta de validaci&oacute;n a tiempo',
			'tipo' => 'aplazarCheque2',
			'id_Tipo' => $idCheque,
			'fecha' => date('Y-m-d H:i:s')
		);
		$id = $this->CI->insertar->newNotificacion($not);

		$this->email($usuario->email,
		'Cheque aplazado por falta de validaci&oacute;n a tiempo [' . $miCheque['nombre'] . ']',
		'Cheque aplazado por falta de validaci&oacute;n a tiempo'.
		'<br><br><a href="' . base_url() . 'cheque/ver/' . $id . '">Acceder al sistema</a>');
	}
	else if ($tipo == 'fin') {
		$usuario = $this->CI->consultas->getUsuariosById2($miCheque['idUsuario']);

		$not = array(
			'idUsuario' => $usuario->id,
			'titulo' => 'Cheque en proceso de pago [' . $miCheque['nombre'] . ']',
			'mensaje' => 'Cheque en proceso de pago',
			'tipo' => 'cheque',
			'id_Tipo' => $idCheque,
			'fecha' => date('Y-m-d H:i:s')
		);
		$id = $this->CI->insertar->newNotificacion($not);
		$this->email($usuario->email,
		'Cheque en proceso de pago [' . $miCheque['nombre'] . ']',
		'Cheque en proceso de pago'.
		'<br><br><a href="' . base_url() . 'cheque/ver/' . $id . '">Acceder al sistema</a>');
	}

	/* Registrar */
	if (!empty($usuarios)) {
		foreach ($usuarios as $row) {
			$not = array(
				'idUsuario' => $row['id'],
				'titulo' => 'Cheque pendiente de aprobación [' . $miCheque['nombre'] . ']',
				'mensaje' => 'Cheque pendiente de aprobación',
				// 'link' => $link,
				'tipo' => 'cheque',
				'id_Tipo' => $idCheque,
				'fecha' => date('Y-m-d H:i:s')
			);
			$id = $this->CI->insertar->newNotificacion($not);
			$this->email(
			$row['email'],
			'Cheque pendiente de aprobaci&oacute;n',
			$mensaje . '<br><br><a href="' . base_url() . 'notificacion/ver/' . $id . '">Acceder al sistema</a>'
		);
	}
}


}



public function notificarRepo($idRepo, $tipo)
{
	/* Datos */
	$coment = '';
	$miRepo = $this->CI->consultas->getReposicion($idRepo);
	$op_reposicion_cheque = $this->CI->consultas->getOpReposicionChequeByRepo($idRepo);
	$miCheque = $this->CI->consultas->getCheque($op_reposicion_cheque->idCheque);
	$titulo = "";
	$mensaje = "";
	$id = "";
	if ($tipo == 'guardar') {
		$usuario = $this->CI->consultas->getUsuariosById2($miCheque['idUsuario']);
		$revisor = $this->CI->consultas->getUsuariosById2($miCheque['idRevisor']);
		$not = array(
			'idUsuario' => $usuario->id,
			'titulo' => 'Acuse de reposición [' . $miRepo['nombre'] . ']',
			'mensaje' => 'Acuse de reposición',
			'tipo' => 'reposicion',
			'id_Tipo' => $idRepo,
			'fecha' => date('Y-m-d H:i:s')
		);
		$id = $this->CI->insertar->newNotificacion($not);
		$this->email($usuario->email,
		'Acuse de reposición [' . $miRepo['nombre'] . ']','Acuse de reposición'.
		'<br><br><a href="' . base_url() . 'notificacion/ver/' . $id . '">Acceder al sistema</a>');
		$rol = $this->CI->session->userdata('rol');
		if($rol==5){
			$usuarios = $this->CI->consultas->getUsersByRol(3);
		}
		else{  // ==
			$not['idUsuario'] =$revisor->id;
			$not['titulo'] ='Nueva reposición pendiente de revisión [' . $miRepo['nombre'] . ']';
			$not['mensaje'] ='Reposición pendiente de revisión';

			$id = $this->CI->insertar->newNotificacion($not);

			$this->email($revisor->email,
			'Nueva reposición [' . $miRepo['nombre'] . ']',
			'Reposición pendiente de revisión'.
			'<br><br><a href="' . base_url() . 'notificacion/ver/' . $id . '">Acceder al sistema</a>');
		} // ==
	}
	else if ($tipo == 'rechazar') {
		$not = array(
			'idUsuario' => $miCheque['idUsuario'],
			'titulo' => 'Reposición rechazada [' . $miRepo['nombre'] . ']',
			'mensaje' => 'Reposición rechazada',
			'tipo' => 'reposicion',
			'id_Tipo' => $idRepo,
			'fecha' => date('Y-m-d H:i:s')
		);
		$id = $this->CI->insertar->newNotificacion($not);

		$usuario = $this->CI->consultas->getUsuariosById2($miCheque['idUsuario']);
		$revisor = $this->CI->consultas->getUsuariosById2($miCheque['idRevisor']);

		$this->email($usuario->email,
		'Reposición rechazada [' . $miRepo['nombre'] . ']',
		'Reposición rechazada'.
		'<br><br><a href="' . base_url() . 'notificacion/ver/' . $id . '">Acceder al sistema</a>');


	} else if ($tipo == 'aceptar') {
		$ronda=1;
		if($misValidaciones = $this->CI->consultas->getValidacionesRepo($miRepo['id']))
		{
			foreach ($misValidaciones as $key) {
				if ($key['validado']==0) {
					$ronda = $ronda+1;
				}
			}
		}
		$check=0;
		$vRevisor=0;
		$vN3=0;
		$vN4=0;
		$vN5=0;
		$validacionesRonda = $this->CI->consultas->getValidacionesRepoByRonda($miRepo['id'],$ronda);
		foreach ($validacionesRonda as $key2) {
			$rolRevisor = $this->CI->consultas->getUsuariosById2($key2['idRevisor'])->rol;
			if ($key2['idRevisor']==$miCheque['idRevisor'] || $rolRevisor==3 || $rolRevisor==4 || $rolRevisor=5) {
				$check++;
			}
			if($key2['idRevisor']==$miCheque['idRevisor']){ $vRevisor++; }
			if($rolRevisor==3){ $vN3++; }
			if($rolRevisor==4){ $vN4++; }
			if($rolRevisor==5){ $vN5++; }
		}
		// //
		$rolRevisor = $this->CI->consultas->getUsuariosById2($miCheque['idRevisor'])->rol;
		$rolSolicitante = $this->CI->consultas->getUsuariosById2($miCheque['idUsuario'])->rol;
		$rol = $this->CI->session->userdata('rol');
		if(   $check<2   &&   ($rol==$rolRevisor && $rol==2 && $vRevisor<2)     ||     ($rol==$rolRevisor && $rol==4 && $vRevisor<2)     ||     ($rol==$rolRevisor && $rol==5 && $vRevisor<2)     ){
			if($rolSolicitante!=3){
				$usuarios = $this->CI->consultas->getUsersByRol(3);
			}
		}
		// //
		$titulo = 'Reposición aceptada [' . $miRepo['nombre'] . ']';
		$mensaje = 'Reposición aceptada';
		$not = array(
			'idUsuario' => $miCheque['idUsuario'],
			'titulo' => $titulo,
			'mensaje' => $mensaje,
			'tipo' => 'reposicion',
			'id_Tipo' => $idRepo,
			'fecha' => date('Y-m-d H:i:s')
		);
		$id = $this->CI->insertar->newNotificacion($not);

		$usuario = $this->CI->consultas->getUsuariosById2($miCheque['idUsuario']);
		$revisor = $this->CI->consultas->getUsuariosById2($miCheque['idRevisor']);

		$this->email($usuario->email,
		'Reposición aceptada [' . $miRepo['nombre'] . ']',
		'Reposición aceptada'.
		'<br><br><a href="' . base_url() . 'notificacion/ver/' . $id . '">Acceder al sistema</a>');

		// *************************************************************************************
		// *************************************************************************************
		// Si la reposicion ya tiene mas de una validacion; cheque=guardado
		if($check>1 && $miCheque['guardado']==0)
		{
			$data3 = array(
				'guardado' => '1',
				'fechaGuardado' => date('Y/m/d H:i:s')
			);
			$where3 = array(
				'id' => $op_reposicion_cheque->idCheque
			);
			$this->CI->insertar->setCheque($data3, $where3);
		}
		// -----------------------------------------------------

		// *************************************************************************************
		// *************************************************************************************

	} else if ($tipo == 'fin') {
		$usuario = $this->CI->consultas->getUsuariosById2($miCheque['idUsuario']);
		$not = array(
			'idUsuario' => $usuario->id,
			'titulo' => 'Reposición en proceso de pago [' . $miRepo['nombre'] . ']',
			'mensaje' => 'Reposición en proceso de pago',
			'tipo' => 'reposicion',
			'id_Tipo' => $idRepo,
			'fecha' => date('Y-m-d H:i:s')
		);
		$id = $this->CI->insertar->newNotificacion($not);

		$usuario = $this->CI->consultas->getUsuariosById2($miCheque['idUsuario']);
		$revisor = $this->CI->consultas->getUsuariosById2($miCheque['idRevisor']);

		$this->email($usuario->email,
		'Reposición en proceso de pago [' . $miRepo['nombre'] . ']',
		'Reposición en proceso de pago'.
		'<br><br><a href="' . base_url() . 'notificacion/ver/' . $id . '">Acceder al sistema</a>');

	} else if ($tipo == 'aplazar') {
		$usuario = $this->CI->consultas->getUsuariosById2($miCheque['idUsuario']);
		$not = array(
			'idUsuario' => $usuario->id,
			'titulo' => 'Reposición aplazada por falta de validación a tiempo [' . $miRepo['nombre'] . ']',
			'mensaje' => 'Reposición aplazada por falta de validación a tiempo',
			'tipo' => 'aplazar_tiempo',
			'id_Tipo' => $idRepo,
			'fecha' => date('Y-m-d H:i:s')
		);
		$id = $this->CI->insertar->newNotificacion($not);

		$this->email($usuario->email,
		'Reposición aplazada por falta de validaci&oacute;n a tiempo [' . $miRepo['nombre'] . ']',
		'Reposición aplazada por falta de validaci&oacute;n a tiempo'.
		'<br><br><a href="' . base_url() . 'notificacion/ver/' . $id . '">Acceder al sistema</a>');
	}

	/* Registrar */
	if (!empty($usuarios)) {
		foreach ($usuarios as $row) {
			$not = array(
				'idUsuario' => $row['id'],
				'titulo' => 'Reposición pendiente de aprobación',
				'mensaje' => 'Reposición pendiente de aprobación',
				'tipo' => 'reposicion',
				'id_Tipo' => $idRepo,
				'fecha' => date('Y-m-d H:i:s')
			);
			$id = $this->CI->insertar->newNotificacion($not);
			$this->email(
			$row['email'],
			$titulo,
			$mensaje . '<br><br><a href="' . base_url() . 'notificacion/ver/' . $id . '">Acceder al sistema</a>'
		);
	}
}


}

public function notificarProv($idProv, $tipo)
{
	/* Datos */
	$coment = '';
	$miProv = $this->CI->consultas->getPagoProveedores($idProv);
	$op_proveedores_cheque = $this->CI->consultas->getOpChequePagoProveedorbyIdPagoProveedor($idProv);
	$miCheque = $this->CI->consultas->getCheque($op_proveedores_cheque->id_cheque);
	$titulo = "";
	$mensaje = "";
	$id = "";
	if ($tipo == 'guardar') {
		$usuario = $this->CI->consultas->getUsuariosById2($miCheque['idUsuario']);
		$revisor = $this->CI->consultas->getUsuariosById2($miCheque['idRevisor']);
		$not = array(
			'idUsuario' => $usuario->id,
			'titulo' => 'Acuse de Pago a Proveedor [' . $miCheque['nombre'] . ']',
			'mensaje' => 'Acuse de Pago a Proveedor',
			'tipo' => 'pago',
			'id_Tipo' => $idProv,
			'fecha' => date('Y-m-d H:i:s')
		);
		$id = $this->CI->insertar->newNotificacion($not);

		$this->email($usuario->email,
		'Acuse de pago a proveedores [' . $miCheque['nombre'] . ']','Acuse de pago a proveedores'.
		'<br><br><a href="' . base_url() . 'notificacion/ver/' . $id . '">Acceder al sistema</a>');
		// =============================================================================================================
		$rol = $this->CI->session->userdata('rol');
		if($rol==5){
			$usuarios = $this->CI->consultas->getUsersByRol(3);
		}
		// =============================================================================================================
		else{  // ==
			$not['idUsuario'] =$revisor->id;
			$not['titulo'] ='Nuevo pago a proveedor [' . $miCheque['nombre'] . ']';
			$not['mensaje'] ='Pago a Proveedor pendiente de revisión';

			$id = $this->CI->insertar->newNotificacion($not);
			$this->email($revisor->email,
			'Nuevo pago a proveedor [' . $miCheque['nombre'] . ']',
			'Pago a Proveedor pendiente de revisión'.
			'<br><br><a href="' . base_url() . 'notificacion/ver/' . $id . '">Acceder al sistema</a>');
		} // ==

	}
	else if($tipo=='aplazar'){
		$usuario = $this->CI->consultas->getUsuariosById2($miCheque['idUsuario']);

		$not=array(
			'idUsuario' => $usuario->id,
			'titulo' => 'Pago a proveedor aplazado por falta de validacion a tiempo ['.$miCheque['nombre'].']',
			'mensaje' => 'Pago a proveedor aplazado por falta de validacion a tiempo',
			'tipo' => 'aplazar_tiempo',
			'id_Tipo' => $idProv,
			'fecha' => date('Y-m-d H:i:s')
		);
		$id = $this->CI->insertar->newNotificacion($not);
		$this->email($usuario->email,
		'Pago a proveedor aplazado por falta de validacion a tiempo [' . $miCheque['nombre'] . ']',
		'Pago a proveedor aplazado por falta de validacion a tiempo'.
		'<br><br><a href="' . base_url() . 'notificacion/ver/' . $id . '">Acceder al sistema</a>');
	}
	else if($tipo=='rechazar'){
		$not=array(
			'idUsuario' => $miCheque['idUsuario'],
			'titulo' => 'Pago a Proveedor rechazado [' . $miCheque['nombre'] . ']',
			'mensaje' => 'Pago a Proveedor rechazado',
			'tipo' => 'pago',
			'id_Tipo' => $idProv,
			'fecha' => date('Y-m-d H:i:s')
		);
		$id = $this->CI->insertar->newNotificacion($not);

		$usuario = $this->CI->consultas->getUsuariosById2($miCheque['idUsuario']);
		$this->email($usuario->email,
		'Pago a Proveedor rechazado [' . $miCheque['nombre'] . ']',
		'Pago a Proveedor rechazado'.
		'<br><br><a href="' . base_url() . 'notificacion/ver/' . $id . '">Acceder al sistema</a>');

	}


	else if ($tipo == 'aceptar') {
		// ====================================================================================
		$ronda=1;
		if($misValidaciones = $this->CI->consultas->getValidacionesPagoProv($miProv['id']))
		{
			foreach ($misValidaciones as $key) {
				if ($key['validado']==0) {
					$ronda = $ronda+1;
				}
			}
		}
		$check=0;
		$vRevisor=0;
		$vN3=0;
		$vN4=0;
		$vN5=0;
		$validacionesRonda = $this->CI->consultas->getValidacionesPagoProvByRonda($miProv['id'],$ronda);
		foreach ($validacionesRonda as $key2) {
			$rolRevisor = $this->CI->consultas->getUsuariosById2($key2['idrevisor'])->rol;
			if ($key2['idrevisor']==$miCheque['idRevisor'] || $rolRevisor==3 || $rolRevisor==4 || $rolRevisor=5) {
				$check++;
			}
			if($key2['idrevisor']==$miCheque['idRevisor']){ $vRevisor++; }
			if($rolRevisor==3){ $vN3++; }
			if($rolRevisor==4){ $vN4++; }
			if($rolRevisor==5){ $vN5++; }
		}
		// //
		$rolRevisor = $this->CI->consultas->getUsuariosById2($miCheque['idRevisor'])->rol;
		$rolSolicitante = $this->CI->consultas->getUsuariosById2($miCheque['idUsuario'])->rol;
		$rol = $this->CI->session->userdata('rol');
		if(   $check<2   &&   ($rol==$rolRevisor && $rol==2 && $vRevisor<2)     ||     ($rol==$rolRevisor && $rol==4 && $vRevisor<2)     ||     ($rol==$rolRevisor && $rol==5 && $vRevisor<2)     ){
			if($rolSolicitante!=3){
				$usuarios = $this->CI->consultas->getUsersByRol(3);
			}
		}
		// //

		$titulo = 'Pago a proveedor aceptado [' . $miCheque['nombre'] . ']';
		$mensaje = 'Pago a proveedor aceptado';
		$not = array(
			'idUsuario' => $miCheque['idUsuario'],
			'titulo' => $titulo,
			'mensaje' => $mensaje,
			'tipo' => 'pago',
			'id_Tipo' => $miProv['id'],
			'fecha' => date('Y-m-d H:i:s')
		);
		$id = $this->CI->insertar->newNotificacion($not);

		$usuario = $this->CI->consultas->getUsuariosById2($miCheque['idUsuario']);
		$this->email($usuario->email,
		'Pago a proveedor aceptado [' . $miCheque['nombre'] . ']',
		'Pago a proveedor aceptado'.
		'<br><br><a href="' . base_url() . 'notificacion/ver/' . $id . '">Acceder al sistema</a>');


		if($check>1 && $miCheque['guardado']==0)
		{
			$data3 = array(
				'guardado' => 1,
				'fechaGuardado' => date('Y/m/d H:i:s')
			);
			$where3 = array(
				'id' => $op_proveedores_cheque->id_cheque
			);
			$this->CI->insertar->setCheque($data3, $where3);

		}

	}


	else if ($tipo == 'fin') {
		// 	$titulo='Reposición aceptada para pago ['.$miRepo['nombre'].']';
		// 	$mensaje='Reposición aceptada para pago';
		// 	$link='pdf/index/reposiciones/'.$idRepo.'/true/true';
		// 	$usuarios=array( $this->CI->consultas->getUser( $miRepo['emailUsuario'] ) );
		$usuario = $this->CI->consultas->getUsuariosById2($miCheque['idUsuario']);
		$not = array(
			'idUsuario' => $usuario->id,
			'titulo' => 'Pago a Proveedor en proceso de pago [' . $miCheque['nombre'] . ']',
			'mensaje' => 'Pago a Proveedor en proceso de pago',
			'tipo' => 'pago',
			'id_Tipo' => $idProv,
			'fecha' => date('Y-m-d H:i:s')
		);
		$id = $this->CI->insertar->newNotificacion($not);
		$this->email($usuario->email,
		'Pago a Proveedor en proceso de pago [' . $miCheque['nombre'] . ']',
		'Pago a Proveedor en proceso de pago'.
		'<br><br><a href="' . base_url() . 'notificacion/ver/' . $id . '">Acceder al sistema</a>');
	}

	/* Registrar */
	if (!empty($usuarios)) {
		foreach ($usuarios as $row) {
			$not = array(
				'idUsuario' => $row['id'],
				'titulo' => 'Pago a proveedor pendiente de aprobaci&oacute;n',
				'mensaje' => 'Pago a proveedor pendiente de aprobaci&oacute;n',
				// 'link' => $link,
				'tipo' => 'pago',
				'id_Tipo' => $idProv,
				'fecha' => date('Y-m-d H:i:s')
			);
			$id = $this->CI->insertar->newNotificacion($not);
			$this->email(
			$row['email'],
			'Pago a proveedor pendiente de aprobaci&oacute;n',
			$mensaje . '<br><br><a href="' . base_url() . 'notificacion/ver/' . $id . '">Acceder al sistema</a>'
		);
	}
}


}

public function notificarComprobacion($idComprobacion, $tipo)
{
	$miComprobacion = $this->CI->consultas->getComprobacion($idComprobacion);
	$opChequeComp = $this->CI->consultas->getOpComprobacionChequebyId($idComprobacion);
	$miCheque = $this->CI->consultas->getCheque($opChequeComp->idCheque);
	/* Datos */
	$coment = '';
	$titulo = "";
	$mensaje = "";
	$id = "";
	$usuario = $this->CI->consultas->getUsuariosById2($miCheque['idUsuario']);
	$revisor = $this->CI->consultas->getUsuariosById2($miCheque['idRevisor']);

	if ($tipo == 'guardar') {
		$not = array(
			'idUsuario' => $usuario->id,
			'titulo' => 'Acuse de comprobación de gastos [' . $miCheque['nombre'] . ']',
			'mensaje' => 'Acuse de comprobación de gastos',
			'tipo' => 'comprobacion',
			'id_Tipo' => $idComprobacion,
			'fecha' => date('Y-m-d H:i:s')
		);
		$id = $this->CI->insertar->newNotificacion($not);

		$this->email($usuario->email,
		'Acuse de comprobaci&oacute;n de gastos [' . $miCheque['nombre'] . ']',
		'cuse de comprobaci&oacute;n de gastos'.
		'<br><br><a href="' . base_url() . 'notificacion/ver/' . $id . '">Acceder al sistema</a>');

		$not['idUsuario'] =$revisor->id;
		$not['titulo'] ='Nueva comprobación pendiente de revisi&oacute;n [' . $miCheque['nombre'] . ']';
		$not['mensaje'] ='Comprobación pendiente de revisi&oacute;n';

		// =============================================================================================================
		$rol = $this->CI->session->userdata('rol');
		if($rol==5){
			$usuarios = $this->CI->consultas->getUsersByRol(3);
		}
		else{  // ==
			$id = $this->CI->insertar->newNotificacion($not);
			$this->email($revisor->email,
			'Nueva comprobación pendiente de revisi&oacute;n [' . $miCheque['nombre'] . ']',
			'Nueva comprobación pendiente de revisi&oacute;n'.
			'<br><br><a href="' . base_url() . 'notificacion/ver/' . $id . '">Acceder al sistema</a>');
		} // ==
		// =============================================================================================================


	}


	else if ($tipo == 'rechazar') {
		$not = array(
			'idUsuario' => $miCheque['idUsuario'],
			'titulo' => 'Comprobaci&oacute;n rechazada [' . $miCheque['nombre'] . ']',
			'mensaje' => 'Comprobaci&oacute;n rechazada',
			'tipo' => 'comprobacion',
			'id_Tipo' => $idComprobacion,
			'fecha' => date('Y-m-d H:i:s')
		);
		$id = $this->CI->insertar->newNotificacion($not);
		$this->email($usuario->email,
		'Comprobaci&oacute;n rechazada [' . $miCheque['nombre'] . ']',
		'Comprobaci&oacute;n rechazada'.
		'<br><br><a href="' . base_url() . 'notificacion/ver/' . $id . '">Acceder al sistema</a>');

	} else if ($tipo == 'aceptar') {
		// ====================================================================================
		$ronda=1;
		if($misValidaciones = $this->CI->consultas->getValidacionesComp($miComprobacion['id']))
		{
			foreach ($misValidaciones as $key) {
				if ($key['validado']==0) {
					$ronda = $ronda+1;
				}
			}
		}
		$check=0;
		$vRevisor=0;
		$vN3=0;
		$validacionesRonda = $this->CI->consultas->getValidacionesCompByRonda($idComprobacion,$ronda);
		foreach ($validacionesRonda as $key2) {
			$rolRevisor = $this->CI->consultas->getUsuariosById2($key2['idRevisor'])->rol;
			if ($key2['idRevisor']==$miCheque['idRevisor'] || $rolRevisor==3 || $rolRevisor==4 || $rolRevisor=5) {
				$check++;
			}
			if($key2['idRevisor']==$miCheque['idRevisor']){ $vRevisor++; }
			if($rolRevisor==3){ $vN3++; }
		}
		// ====================================================================================
		$rol = $this->CI->session->userdata('rol');
		// $rolRevisor = $this->consultas->getUsuariosById2($miCheque['idRevisor'])->rol;
		$rolSolicitante = $this->CI->consultas->getUsuariosById2($miCheque['idUsuario'])->rol;
		// $idUsuariox="";
		if($rol!=3 && $check<2 && $rolSolicitante!=3){
			$usuarios = $this->CI->consultas->getUsersByRol(3);
		}

		$titulo = 'Comprobación aceptada [' . $miCheque['nombre'] . ']';
		$mensaje = 'Comprobación aceptada';
		$not = array(
			'idUsuario' => $miCheque['idUsuario'],
			'titulo' => $titulo,
			'mensaje' => $mensaje,
			'tipo' => 'comprobacion',
			'id_Tipo' => $idComprobacion,
			'fecha' => date('Y-m-d H:i:s')
		);
		$id = $this->CI->insertar->newNotificacion($not);

		$this->email($usuario->email,
		'Comprobación aceptada [' . $miCheque['nombre'] . ']',
		'Comprobación aceptada'.
		'<br><br><a href="' . base_url() . 'notificacion/ver/' . $id . '">Acceder al sistema</a>');

		if ($check>1 || $rol==3) {
			$data3 = array(
				'guardado' => '1',
				'fechaGuardado' => date('Y/m/d H:i:s')
			);
			$op_cheque_comprobacion = $this->CI->consultas->getOpComprobacionChequeByComp($idComprobacion);
			$where3 = array(
				'id' => $op_cheque_comprobacion->idCheque
			);
			$this->CI->insertar->setCheque($data3, $where3);
		}
	}

	// else if($tipo=='fin'){
	// 	$titulo='Reposición aceptada para pago ['.$miRepo['nombre'].']';
	// 	$mensaje='Reposición aceptada para pago';
	// 	$link='pdf/index/reposiciones/'.$idRepo.'/true/true';
	// 	$usuarios=array( $this->CI->consultas->getUser( $miRepo['emailUsuario'] ) );
	// }

	/* Registrar */
	if (!empty($usuarios)) {
		foreach ($usuarios as $row) {
			$not = array(
				'idUsuario' => $row['id'],
				'titulo' => 'Comprobaci&oacute;n pendiente de aprobaci&oacute;n',
				'mensaje' => 'Comprobaci&oacute;n pendiente de aprobaci&oacute;n',
				// 'link' => $link,
				'tipo' => 'comprobacion',
				'id_Tipo' => $idComprobacion,
				'fecha' => date('Y-m-d H:i:s')
			);
			$id = $this->CI->insertar->newNotificacion($not);
			$this->email(
			$row['email'],
			'Comprobaci&oacute;n pendiente de aprobaci&oacute;n',
			$mensaje . '<br><br><a href="' . base_url() . 'notificacion/ver/' . $id . '">Acceder al sistema</a>'
		);
	}
}


}

public function email($para, $titulo, $mensaje)
{
	$this->CI->load->library('email');

	$this->CI->email->from('gastos@vecopias.com.mx', 'Gquick');
	$this->CI->email->to($para);

	$this->CI->email->subject($this->Unaccent($titulo));
	$this->CI->email->message($this->Unaccent($mensaje));

	$this->CI->email->send();
	return $this->CI->email->print_debugger();
}

/* ============================================================================== */
public function miSubproyectos($Proyecto)
{
	if( empty($Proyecto) ){
		die();
	}
	foreach ($Proyecto as $subProyecto) {
		$existeProyecto = "";
		$datosNuevoProyecto = array(
			'ListId' => strtoupper($subProyecto['ListId']),
			'ListIdFather' => strtoupper($Proyecto['ListId']),
			'Name' => strtoupper($subProyecto['Name']),
			'CompanyName' => strtoupper($subProyecto['CompanyName']),
			'Currency' => strtoupper($subProyecto['Currency']),
			'SubNivel' => strtoupper($subProyecto['SubNivel']),
			'visible'=>'1',
			'presupuesto'=>0.0
		);
		$datosActualizarProyecto = array(
			'ListIdFather' => strtoupper($Proyecto['ListId']),
			'Name' => strtoupper($subProyecto['Name']),
			'CompanyName' => strtoupper($subProyecto['CompanyName']),
			'Currency' => strtoupper($subProyecto['Currency']),
			'SubNivel' => strtoupper($subProyecto['SubNivel']),
			'visible'=>'1'
		);
		$existeProyecto = $this->CI->consultas->getProyectoById2($subProyecto['ListId']);
		if ($existeProyecto) {
			$miProyecto = $this->CI->consultas->getProyectoByListId($subProyecto['ListId']);
			$this->CI->insertar->updateCliente($datosActualizarProyecto, $miProyecto->id);
		} else {
			$this->CI->insertar->insertarClientes($datosNuevoProyecto);
		}
		$this->miSubproyectos($subProyecto);
	}
}
/* ============================================================================== */

public function subirxml()
{
	$this->CI->insertar->limpiarVisibles();
	if ($xmlClientes = @simplexml_load_file('xml/CustomersProjects.xml')) {

			$objCustomers = $xmlClientes->Customer;

			foreach ($objCustomers as $objCustomer) {
				$existeProyecto = "";
				$datosNuevoCliente = array(
					'ListId' => strtoupper($objCustomer['ListId']),
					'ListIdFather' => '',
					'Name' => strtoupper($objCustomer['Name']),
					'CompanyName' => strtoupper($objCustomer['CompanyName']),
					'Currency' => strtoupper($objCustomer['Currency']),
					'SubNivel' => strtoupper($objCustomer['SubNivel']),
					'visible'=>'1',
					'presupuesto'=>0.0
				);
				$datosActualizarCliente = array(
					'ListIdFather' => '',
					'Name' => strtoupper($objCustomer['Name']),
					'CompanyName' => strtoupper($objCustomer['CompanyName']),
					'Currency' => strtoupper($objCustomer['Currency']),
					'SubNivel' => strtoupper($objCustomer['SubNivel']),
					'visible'=>'1'
				);
				$existeProyecto = $this->CI->consultas->getProyectoById2($objCustomer['ListId']);
				if ($existeProyecto) {
					$miCliente = $this->CI->consultas->getProyectoByListId($objCustomer['ListId']);
					$this->CI->insertar->updateCliente($datosActualizarCliente, $miCliente->id);
				} else {
					$this->CI->insertar->insertarClientes($datosNuevoCliente);
				}
				// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
				$this->miSubproyectos($objCustomer);
				// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			}
	}
}

public function clientes()
{
	// if(strpos(current_url(), "comprobacion")){
	// 	$controller='comprobacion';
	// }
	// else
	if (strpos(current_url(), "cheque")) {
		$controller = 'cheque';
	} else if (strpos(current_url(), "reposiciones")) {
		$controller = 'reposiciones_/reposiciones';
	} else if (strpos(current_url(), "comprobaciones")) {
		$controller = 'comprobaciones_/comprobaciones';
	} else if (strpos(current_url(), "proveedores")) {
		$controller = 'proveedores_/proveedores';
	}


	//		if( $xmlClientes = @simplexml_load_file('xml/Customers&Projects.xml') ):
	if (true){

		//	        $objCustomers = $xmlClientes->Customer;
		$clientes = $this->CI->consultas->mostrarClientes();

		$html = '<div class="box">';
		$html .= '<div class="row">';

		$html .= '<div class="col-md-12">';
		$html .= '<div class="title">';
		$html .= "<h2>Lista de Clientes</h2>";
		$html .= '</div>';
		$html .= '</div>';

		$html .= '<div class="col-md-12">';
		$html .= '<table class="table table-hover" >';
		$html .= '<thead>';
		$html .= '<tr>';
		$html .= '<th>Compañia</th>';
		$html .= '<th>Moneda</th>';
		$html .= '<th>Acciones</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';

		$config = $this->CI->consultas->getConfig();
		// $configPresupuesto = $config['presupuesto'];

		foreach ($clientes as $objCustomer){
			$html .= '<tr>';
			$html .= '<td>' . strtoupper($objCustomer['Name']) . '</td>';
			$html .= '<td>' . strtoupper($objCustomer['Currency']) . '</td>';
			$html .= '<td>
			<a title="Ver proyectos" class="btn btn-primary" href="' . base_url() . $controller . '/proyectos/' . $objCustomer['ListId'] . '" >
			<i class="fa fa-folder"></i></a> </td>';
			$html .= '</tr>';

		}

		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '</div>';

		$html .= "</div>";
		$html .= "</div>";


		//liberamos el objeto de la memoria
		unset($xmlClientes);

	}else{
		$html .= '<div class="col-md-12">';
		$html .= '<div class="alert alert-danger" role="alert">
		No se puede leer el XML.</div>';
		$html .= '</div>';
	}

	return $html;
}

public function proyectos($id)
{
	// if(strpos(current_url(), "comprobacion")!==false){
	// 	$controller='comprobacion';
	// 	$function='comprobaciones';
	// }
	// else
	if (strpos(current_url(), "cheque") !== false) {
		$controller = 'cheque';
		$function = 'cheques';
	} else if (strpos(current_url(), "reposiciones") !== false) {
		$controller = 'reposiciones_/reposiciones';
		$function = 'lista';
	} else if (strpos(current_url(), "comprobaciones") !== false) {
		$controller = 'comprobaciones_/comprobaciones';
		$function = 'lista';
	} else if (strpos(current_url(), "proveedores") !== false) {
		$controller = 'proveedores_/proveedores';
		$function = 'lista';
	}

	$ban = $banH = false;
	$html = '<div class="box">';
	$html .= '<div class="row">';

	if (!empty($id)){

		//			if( $xmlClientes = @simplexml_load_file('xml/Customers&Projects.xml') ):

			$proyectos = $this->CI->consultas->getProyectoByListIdArray($id);

			$html .= '<div class="col-md-12">';
			$html .= '<div class="title">';
			$html .= "<h2>Lista de Proyectos</h2>";
			$html .= '</div>';
			$html .= '</div>';

			$html .= '<div class="col-md-12">';
			$html .= '<table class="table table-hover" >';
			$html .= '<thead>';
			$html .= '<tr>';
			$html .= '<th>Proyecto</th>';
			$html .= '<th>Compañia</th>';
			$html .= '<th>Acciones</th>';
			$html .= '</tr>';
			$html .= '</thead>';
			$html .= '<tbody>';

			$miConfig = $this->CI->consultas->getConfig();
			$PresupuestoActivo = false;
			if($miConfig['presupuesto']==1){
				$PresupuestoActivo = true;
			}

			foreach ($proyectos as $objCustomer){

					if ( $objCustomer['ListIdFather'] == $id
					// && (!$PresupuestoActivo	|| $objCustomer['presupuesto'] > 0)
					 ) {
						$email = $this->CI->session->userdata('idUser');
						$rol = $this->CI->session->userdata('rol');
						$Name = $this->Slug($objCustomer['Name']);
						$ListId = $objCustomer['ListId'];
						// ------------------------------------------------------------------------
						$subproyectos = $this->CI->consultas->getProyectoByListIdArray($objCustomer['ListId']);
						if(count($subproyectos)==0){
							if($PresupuestoActivo){
								if($objCustomer['presupuesto']<1){
									$link="";
								}
							}
							$link = 'href="' . base_url() . $controller . '/' . $function . '/' . $Name . '/' . $ListId . '"';
						}
						else{
							$link = count($subproyectos).' href="' . base_url() . $controller . '/proyectos/' . $ListId . '"';
						}
						// ------------------------------------------------------------------------
						if($PresupuestoActivo && $objCustomer['presupuesto']<1 && count($subproyectos)==0){
							$btn = 'btn-warning';

							$html .= '<tr>';
							$html .= '<td>' . mb_strtoupper($objCustomer['Name'], 'UTF-8') . '</td>';
							$html .= '<td>' . mb_strtoupper($objCustomer['CompanyName'], 'UTF-8') . '</td>';
							$html .= '<td> <a title="Este proyecto tiene presupuesto en cero o negativo o no se le ha asignado. Por favor, contacte a un administrador." class="btn ' . $btn . ' ">
							<i class="fa fa-exclamation-triangle"></i></a></td>';
							$html .= '</tr>';
						}
						else{
						$btn = 'btn-primary';


						$html .= '<tr>';
						$html .= '<td>' . mb_strtoupper($objCustomer['Name'], 'UTF-8') . '</td>';
						$html .= '<td>' . mb_strtoupper($objCustomer['CompanyName'], 'UTF-8') . '</td>';
						$html .= '<td>
						<a title="Ver reposiciones" class="btn ' . $btn . '" ' . $link . '>
						<i class="fa fa-folder"></i></a> </td>';
						$html .= '</tr>';
					}
					// elseif ($objCustomer['ListIdFather'] == $id )
					// {
					// 	$email = $this->CI->session->userdata('idUser');
					// 	$rol = $this->CI->session->userdata('rol');
					// 	$Name = $this->Slug($objCustomer['Name']);
					// 	$ListId = $objCustomer['ListId'];
					//
					// 	$link = 'href="' . base_url() . $controller . '/' . $function . '/' . $Name . '/' . $ListId . '"';
					// 	$btn = 'btn-primary';
					// 	$btn2 = 'btn-warning fa-lg';
					//
					//
					// 	$html .= '<tr>';
					// 	$html .= '<td>' . mb_strtoupper($objCustomer['Name'], 'UTF-8') . '</td>';
					// 	$html .= '<td>' . mb_strtoupper($objCustomer['CompanyName'], 'UTF-8') . '</td>';
					// 	$html .= '<td> <a title="Este proyecto tiene presupuesto en cero o negativo o no se le ha asignado. Por favor, contacte a un administrador." class="btn ' . $btn2 . ' ">
					// 	<i class="fa fa-exclamation-triangle"></i></a></td>';
					// 	$html .= '</tr>';
					//
					// }

					if ($banH){
						$ban = false;
						break;
					}
			}

			if ($ban){
				$html .= '<div class="col-md-12">';
				$html .= '<div class="alert alert-danger" role="alert">
				No hay proyectos en esta empresa.</div>';
				$html .= '</div>';
			}

	}
	$html .= '</tbody>';
	$html .= '</table>';
	$html .= '</div>';

	//liberamos el objeto de la memoria
	unset($xmlClientes);


}

	else{

		$html .= '<div class="col-md-12">';
		$html .= '<div class="title">';
		$html .= "<h2>Lista de Proyectos</h2>";
		$html .= '</div>';
		$html .= '</div>';

		$html .= '<div class="col-md-12">';
		$html .= '<div class="alert alert-danger" role="alert">
		Esta empresa no existe, consulte con el administrador.</div>';
		$html .= '</div>';

	}

	$html .= "</div>";
	$html .= "</div>";

	return $html;
}










public function Slug($string, $slug = '-', $extra = null)
{
	return strtolower(trim(preg_replace('~[^0-9a-z' . preg_quote($extra, '~') . ']+~i', $slug, $this->Unaccent($string)), $slug));
}

public function Unaccent($string)
{
	// if (extension_loaded('intl') === true)
	// {
	// 	$string = Normalizer::normalize($string, Normalizer::FORM_KD);
	// }
	if (strpos($string = htmlentities($string, ENT_QUOTES, 'UTF-8'), '&') !== false) {
		$string = html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|caron|cedil|circ|grave|lig|orn|ring|slash|tilde|uml);~i', '$1', $string), ENT_QUOTES, 'UTF-8');
	}
	return $string;
}

/*!
@function num2letras ()
@abstract Dado un n?mero lo devuelve escrito.
@param $num number - N?mero a convertir.
@param $fem bool - Forma femenina (true) o no (false).
@param $dec bool - Con decimales (true) o no (false).
@result string - Devuelve el n?mero escrito en letra.

*/
public function num2letras($num, $fem = false, $dec = true)
{
	$matuni[2] = "dos";
	$matuni[3] = "tres";
	$matuni[4] = "cuatro";
	$matuni[5] = "cinco";
	$matuni[6] = "seis";
	$matuni[7] = "siete";
	$matuni[8] = "ocho";
	$matuni[9] = "nueve";
	$matuni[10] = "diez";
	$matuni[11] = "once";
	$matuni[12] = "doce";
	$matuni[13] = "trece";
	$matuni[14] = "catorce";
	$matuni[15] = "quince";
	$matuni[16] = "dieciseis";
	$matuni[17] = "diecisiete";
	$matuni[18] = "dieciocho";
	$matuni[19] = "diecinueve";
	$matuni[20] = "veinte";
	$matunisub[2] = "dos";
	$matunisub[3] = "tres";
	$matunisub[4] = "cuatro";
	$matunisub[5] = "quin";
	$matunisub[6] = "seis";
	$matunisub[7] = "sete";
	$matunisub[8] = "ocho";
	$matunisub[9] = "nove";

	$matdec[2] = "veint";
	$matdec[3] = "treinta";
	$matdec[4] = "cuarenta";
	$matdec[5] = "cincuenta";
	$matdec[6] = "sesenta";
	$matdec[7] = "setenta";
	$matdec[8] = "ochenta";
	$matdec[9] = "noventa";
	$matsub[3] = 'mill';
	$matsub[5] = 'bill';
	$matsub[7] = 'mill';
	$matsub[9] = 'trill';
	$matsub[11] = 'mill';
	$matsub[13] = 'bill';
	$matsub[15] = 'mill';
	$matmil[4] = 'millones';
	$matmil[6] = 'billones';
	$matmil[7] = 'de billones';
	$matmil[8] = 'millones de billones';
	$matmil[10] = 'trillones';
	$matmil[11] = 'de trillones';
	$matmil[12] = 'millones de trillones';
	$matmil[13] = 'de trillones';
	$matmil[14] = 'billones de trillones';
	$matmil[15] = 'de billones de trillones';
	$matmil[16] = 'millones de billones de trillones';

	//Zi hack
	$float = explode('.', $num);
	$num = $float[0];

	$num = trim((string)@$num);
	if ($num[0] == '-') {
		$neg = 'menos ';
		$num = substr($num, 1);
	} else
	$neg = '';
	while ($num[0] == '0') $num = substr($num, 1);
	if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num;
	$zeros = true;
	$punt = false;
	$ent = '';
	$fra = '';
	for ($c = 0; $c < strlen($num); $c++) {
		$n = $num[$c];
		if (!(strpos(".,'''", $n) === false)) {
			if ($punt) break;
			else {
				$punt = true;
				continue;
			}

		} elseif (!(strpos('0123456789', $n) === false)) {
			if ($punt) {
				if ($n != '0') $zeros = false;
				$fra .= $n;
			} else

			$ent .= $n;
		} else

		break;

	}
	$ent = '     ' . $ent;
	if ($dec and $fra and !$zeros) {
		$fin = ' coma';
		for ($n = 0; $n < strlen($fra); $n++) {
			if (($s = $fra[$n]) == '0')
			$fin .= ' cero';
			elseif ($s == '1')
			$fin .= $fem ? ' una' : ' un';
			else
			$fin .= ' ' . $matuni[$s];
		}
	} else
	$fin = '';
	if ((int)$ent === 0) return 'Cero ' . $fin;
	$tex = '';
	$sub = 0;
	$mils = 0;
	$neutro = false;
	while (($num = substr($ent, -3)) != '   ') {
		$ent = substr($ent, 0, -3);
		if (++$sub < 3 and $fem) {
			$matuni[1] = 'una';
			$subcent = 'as';
		} else {
			$matuni[1] = $neutro ? 'un' : 'uno';
			$subcent = 'os';
		}
		$t = '';
		$n2 = substr($num, 1);
		if ($n2 == '00') {
		} elseif ($n2 < 21)
		$t = ' ' . $matuni[(int)$n2];
		elseif ($n2 < 30) {
			$n3 = $num[2];
			if ($n3 != 0) $t = 'i' . $matuni[$n3];
			$n2 = $num[1];
			$t = ' ' . $matdec[$n2] . $t;
		} else {
			$n3 = $num[2];
			if ($n3 != 0) $t = ' y ' . $matuni[$n3];
			$n2 = $num[1];
			$t = ' ' . $matdec[$n2] . $t;
		}
		$n = $num[0];
		if ($n == 1) {
			$t = ' ciento' . $t;
		} elseif ($n == 5) {
			$t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t;
		} elseif ($n != 0) {
			$t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t;
		}
		if ($sub == 1) {
		} elseif (!isset($matsub[$sub])) {
			if ($num == 1) {
				$t = ' mil';
			} elseif ($num > 1) {
				$t .= ' mil';
			}
		} elseif ($num == 1) {
			$t .= ' ' . $matsub[$sub] . '?n';
		} elseif ($num > 1) {
			$t .= ' ' . $matsub[$sub] . 'ones';
		}
		if ($num == '000') $mils++;
		elseif ($mils != 0) {
			if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub];
			$mils = 0;
		}
		$neutro = true;
		$tex = $t . $tex;
	}
	$tex = $neg . substr($tex, 1) . $fin;
	//Zi hack --> return ucfirst($tex);
	$end_num = ucfirst($tex) . ' pesos ' . $float[1] . '/100 M.N.';
	return $end_num;
}

public function valida_en_sat($data)
{
	header('Content-Type: text/plain');
	if (!class_exists('SoapClient'))
	{

		die ("No se ha instalado el modulo SOAP en el servidor.");

	}
	if (!array_key_exists('rfc', $data)) {
		return 'Dato faltante: rfc';
	} else if (!array_key_exists('rfc_receptor', $data)) {
		return 'Dato faltante: rfc_receptor';
	} else if (!array_key_exists('total', $data)) {
		return 'Dato faltante: total';
	} else if (!array_key_exists('uuid', $data)) {
		return 'Dato faltante: uuid';
	}
	error_reporting(E_ALL);
	// require_once('nusoap/nusoap.php');
	$this->CI->load->library("Nusoap_lib");
	error_reporting(E_ALL & ~(E_STRICT | E_NOTICE | E_WARNING | E_DEPRECATED));
	$url = "https://consultaqr.facturaelectronica.sat.gob.mx/consultacfdiservice.svc?wsdl";


	// **************************************************************************************
	try{

		$opts = array(
			'http'=>array(
				'user_agent' => 'PHPSoapClient'
			)
		);

		$context = stream_context_create($opts);
		$soapclient = new SoapClient($url,
		array('trace'=>true,
		'stream_context' => $context,
		'cache_wsdl' => WSDL_CACHE_NONE));

	}
	catch(Exception $e){
		// echo $e->getMessage()."...";
		echo "Problemas de conexion con el SAT";
	}
	// **************************************************************************************
	// $soapclient = new nusoap_client($url, $esWSDL = true);
	$soapclient->soap_defencoding = 'UTF-8';
	$soapclient->decode_utf8 = false;

	$rfc_emisor = utf8_encode($data['rfc']);
	$rfc_receptor = utf8_encode($data['rfc_receptor']);
	$impo = (double)$data['total'];
	$impo = sprintf("%.6f", $impo);
	$impo = str_pad($impo, 17, "0", STR_PAD_LEFT);

	$uuid = strtoupper($data['uuid']);

	$factura = "?re=$rfc_emisor&rr=$rfc_receptor&tt=$impo&id=$uuid";
	// $array = array('debug' => $factura);
	// $this->CI->session->set_userdata($array);
	$prm = array('expresionImpresa' => $factura);


	// $buscar = $soapclient->call('Consulta', $prm);
	// =======================================================================0=
	$buscar=$soapclient->Consulta($prm);
	// =======================================================================0=

	// if (substr($buscar['ConsultaResult']['CodigoEstatus'], 0, 1) == 'S') {
	if (substr($buscar->ConsultaResult->CodigoEstatus,0,1) == 'S') {
		return true;
	} else {
		echo substr($buscar->ConsultaResult->CodigoEstatus,0,1);
		return false;
	}
}

public function notificarPagosProv($idProv, $tipo)
{
	echo $idProv;
	echo $tipo;


}


}
