<?php

class Consultas extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function consultasIniciales()
	{
		$sqlUsuarios = "SELECT id FROM tb_usuarios";
		$queryUsuarios = $this->db->query($sqlUsuarios);
		$usuarios=$queryUsuarios->num_rows();

		$sqlArticulos = "SELECT id FROM tb_inventario";
		$queryArticulos = $this->db->query($sqlArticulos);
		$articulos=$queryArticulos->num_rows();

		$hoy=date('Y-m-d');
		$sqlRecaudado = "SELECT sum(Total) as suma
		FROM tb_ventas
		WHERE Fecha >= '$hoy'
		AND tipoMovimiento =0";
		$queryRecaudado = $this->db->query($sqlRecaudado);
		$recaudado=$queryRecaudado->row();
		$recaudado=$recaudado->suma;
		$valores=array(
			'articulos'=>$articulos,
			'recaudado'=>$recaudado,
			'usuarios'=>$usuarios,
		);
		return $valores;
	}

	function isUser($user, $pass)
	{
		$sql = "SELECT * FROM tb_usuarios WHERE username = ? ";
		$query = $this->db->query( $sql, array($user) );
		if ($query->num_rows() > 0) {
			$sql = "SELECT * FROM tb_usuarios WHERE username = ? and pass = ? ";
			$query = $this->db->query($sql, array($user,$pass) );
			if ($query->num_rows() > 0) {
				return '1';
			} else {
				return 'Contraseña incorrecta';
			}
		} else {
			return 'Usuario no encontrado';
		}
	}

	public function getTabla($tabla)
	{
		$this->db->select("*");
		$this->db->from($tabla);
		$consulta = $this->db->get();
		return $consulta->result_array();
	}

	public function getTablaWhere($tabla,$where)
	{
		$this->db->select("*");
		$this->db->from($tabla);
		$this->db->where($where);
		$consulta = $this->db->get();
		return $consulta->result_array();
	}

	function findIdUser($user, $pass)
	{
		$sql = "SELECT * FROM tb_usuarios WHERE username = ? AND pass= ? ";
		$query = $this->db->query($sql,array($user,$pass));
		return $query->row();
	}

	function existeUsername($user)
	{
		$sql = "SELECT id FROM tb_usuarios WHERE username = ? ";
		$query = $this->db->query($sql,array($user));
		if ($query->num_rows() == 0) {
			return false;
		}
		return true;
	}



	function getConfigs()
	{
		$sql = "SELECT * FROM tb_config limit 1";
		$query = $this->db->query($sql);
		return $r=$query->row();
	}

	function configTema()
	{
		$sql = "SELECT tema FROM tb_config limit 1";
		$query = $this->db->query($sql);
		$r=$query->row();
		return $r->tema;
	}

	function configImpuesto()
	{
		$sql = "SELECT impuesto FROM tb_config limit 1";
		$query = $this->db->query($sql);
		$r=$query->row();
		return $r->impuesto;
	}

	function configNombreEmpresa()
	{
		$sql = "SELECT nombreEmpresa FROM tb_config limit 1";
		$query = $this->db->query($sql);
		$r=$query->row();
		return $r->nombreEmpresa;
	}
	function configLogo()
	{
		$sql = "SELECT logo FROM tb_config limit 1";
		$query = $this->db->query($sql);
		$r=$query->row();
		return $r->logo;
	}

	function getInventario($codigo="")
	{
		if($codigo!="")
		{
			$sql = "SELECT  inv.id,inv.codigo,inv.descripcion,inv.costo,inv.precio,inv.precioMayoreo,inv.cantidadMayoreo,inv.idDepartamento,inv.cantidad,inv.idProveedor,dep.departamento,inv.idTipo,tv.nombreTipo, tp.nombre as proveedor,inv.stockCritico
			FROM tb_inventario inv
			inner join tb_departamentos dep on inv.idDepartamento = dep.id
			inner join tb_tipos tv on inv.idTipo = tv.id
			inner join tb_proveedores tp on inv.idProveedor = tp.id
			WHERE codigo = ?
			ORDER BY inv.descripcion ASC";
			$query = $this->db->query( $sql,array($codigo) );
			return $query->row_array();
		}
		else{
			$sql = "SELECT  inv.id,inv.codigo,inv.descripcion,inv.costo,inv.precio,inv.precioMayoreo,inv.cantidadMayoreo,inv.idDepartamento,inv.cantidad,inv.idProveedor,dep.departamento,inv.idTipo,tv.nombreTipo, tp.nombre as proveedor,inv.stockCritico
			FROM tb_inventario inv
			inner join tb_departamentos dep on inv.idDepartamento = dep.id
			inner join tb_tipos tv on inv.idTipo = tv.id
			inner join tb_proveedores tp on inv.idProveedor = tp.id
			ORDER BY inv.descripcion ASC";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	}

	function getInventariobyId($id)
	{
		$sql = "SELECT  *
		FROM tb_inventario
		WHERE id = ?";
		$query = $this->db->query( $sql, array($id) );
		return $query->row_array();
	}

	function getVentas()
	{
		$sql = "SELECT  vts.id,vts.idUsuario,vts.Total,vts.Fecha,u.nombre as nombreUsuario,vts.tipoPago,c.nombre as cliente
		FROM tb_ventas vts
		inner join tb_usuarios u on vts.idUsuario = u.id
		inner join tb_clientes c on vts.idCliente = c.id
		WHERE vts.Total>0
		AND vts.tipoMovimiento=0";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	function getVentasByTipo($tipo)
	{
		$sql = "SELECT  vts.id,vts.idUsuario,vts.Total,vts.Fecha,u.nombre as nombreUsuario,vts.tipoPago
		FROM tb_ventas vts
		inner join tb_usuarios u on vts.idUsuario = u.id
		WHERE vts.Total>0
		AND vts.tipoMovimiento=?";
		$query = $this->db->query($sql,array($tipo));
		return $query->result_array();
	}

	
	

	public function getItemsDeVentas($idVenta)
	{
		$sql = "SELECT mv.*, inv.descripcion, inv.precio,inv.codigo
		FROM  tb_movimientosventas	mv
		inner join tb_inventario inv on inv.id = mv.idInventario
		WHERE mv.idVenta = ? ";
		$query = $this->db->query( $sql,array($idVenta) );
		return $query->result_array();
	}

	public function getMovimientoVentaById($idVenta)
	{
		$sql = "SELECT * FROM tb_movimientosventas WHERE id = ? ";
		$query = $this->db->query( $sql,array($idVenta) );
		return $query->row_array();
	}

	function getTbVentasById($idVenta)
	{
		$sql = "SELECT * FROM tb_ventas WHERE id=?";
		$query = $this->db->query($sql,array($idVenta));
		return $query->row_array();
	}


	function getDepartamentos($idDepartamento=0)
	{
		if($idDepartamento>0){
			$sql = "SELECT * FROM tb_departamentos WHERE id= ? ";
			$query = $this->db->query($sql , array($idDepartamento) );
			return $query->row_array();
		}
		else {
			$sql = "SELECT * FROM tb_departamentos ORDER BY id ASC";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	}


	function getTipoVenta()
	{
		$sql = "SELECT * FROM tb_tipos ORDER BY id ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function comprobarCodigo($codigo="")
	{
		$sql = "SELECT id FROM tb_inventario WHERE codigo = ?";
		$query = $this->db->query($sql , array($codigo));
		if ($query->num_rows() == 0) {
			return false;
		}
		return true;
	}

	function getInventarioByCodigo($codigo="")
	{
		$sql = "SELECT * FROM tb_inventario WHERE codigo = ?";
		$query = $this->db->query($sql , array($codigo));
		return $query->row_array();
	}

	public function getUsers($id=0)
	{
		if($id!=0)
		{
			$sql = "SELECT u.*,r.rol
			FROM tb_usuarios u
			inner join tb_roles r on u.idRol = r.id
			Where u.id= ?
			ORDER BY u.nombre ASC";
			$query = $this->db->query( $sql, array($id) );
			return $query->row_array();
		}
		$sql = "SELECT u.*,r.rol
		FROM tb_usuarios u
		inner join tb_roles r on u.idRol = r.id
		ORDER BY u.nombre ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getClientes($id=0)
	{
		if($id!=0)
		{
			$sql = "SELECT * FROM tb_clientes Where id= ?	ORDER BY nombre ASC";
			$query = $this->db->query($sql, array($id) );
			return $query->row_array();
		}
		$sql = "SELECT * FROM tb_clientes ORDER BY nombre ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getProveedores($idProv=0){
		if($idProv>0){
			$sql = "SELECT * FROM tb_proveedores WHERE id= ?	ORDER BY nombre ASC";
			$query = $this->db->query( $sql, array($idProv) );
			return $query->row_array();
		}
		else {
			$sql = "SELECT * FROM tb_proveedores	ORDER BY nombre ASC";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	}



	public function getRoles()
	{
		$sql = "SELECT * FROM tb_roles";
		$query = $this->db->query($sql);
		return $query->result_array();
	}



	public function comprobarItemEnVenta($idVenta,$idItem)
	{
		$sql = "SELECT * FROM tb_movimientosventas WHERE idVenta = ? AND idInventario = ? ";
		$query = $this->db->query($sql, array($idVenta,$idItem) );
		if ($query->num_rows() == 0) {
			return false;
		}
		return true;
	}

	public function comprobarItemEnCompra($idCompra,$idItem)
	{
		$sql = "SELECT * FROM tb_movimientosventas WHERE idCompra = ? AND idInventario = ? ";
		$query = $this->db->query($sql, array($idCompra,$idItem) );
		if ($query->num_rows() == 0) {
			return false;
		}
		return true;
	}

	public function getMovimientoVenta($idVenta,$idItem)
	{
		$sql = "SELECT * FROM tb_movimientosventas WHERE idVenta = ? AND idInventario= ? ";
		$query = $this->db->query($sql, array($idVenta,$idItem) );
		return $query->row_array();
	}

	public function getMovimientoCompra($idCompra,$idItem)
	{
		$sql = "SELECT * FROM tb_movimientosventas WHERE idCompra = ? AND idInventario= ? ";
		$query = $this->db->query($sql, array($idCompra,$idItem) );
		return $query->row_array();
	}

	public function getMovimientoVentaAll($idVenta)
	{
		$sql = "SELECT mvs.id, mvs.idVenta, mvs.idInventario,mvs.cantidad,mvs.costoUnitario, inv.codigo,inv.descripcion,inv.precio,mvs.cantidadOfertas
		FROM tb_movimientosventas mvs
		left outer join tb_ventas vts on mvs.idVenta=vts.id
		left outer join tb_inventario inv on mvs.idInventario=inv.id
		WHERE mvs.idVenta = ?";
		$query = $this->db->query($sql, array($idVenta) );
		return $query->result_array();
	}

	public function getMovimientosData($codigo="")
	{
		if($codigo==""){
			$sql = "SELECT mvs.id,mvs.idVenta,mvs.cantidad, vts.Fecha,inv.codigo,inv.descripcion,us.nombre as usuario, vts.tipoPago, mvs.tipo,mvs.fechaEntrada
			FROM tb_movimientosventas mvs
			left outer join tb_ventas vts on mvs.idVenta=vts.id
			left outer join tb_inventario inv on mvs.idInventario=inv.id
			left outer join tb_usuarios us on vts.idUsuario=us.id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		else{
			$sql = "SELECT mvs.id,mvs.idVenta,mvs.cantidad, vts.Fecha,inv.codigo,inv.descripcion,us.nombre as usuario,vts.tipoPago,mvs.fechaEntrada
			FROM tb_movimientosventas mvs
			left outer join tb_ventas vts on mvs.idVenta=vts.id
			left outer join tb_inventario inv on mvs.idInventario=inv.id
			left outer join tb_usuarios us on vts.idUsuario=us.id
			WHERE inv.codigo=?";
			$query = $this->db->query($sql, array($codigo) );
			return $query->result_array();
		}
	}

	public function getVentaById($idVenta)
	{
		$sql = "SELECT v.*,c.nombre as cliente FROM tb_ventas v inner join tb_clientes c on v.idCliente = c.id WHERE v.id = ?";
		$query = $this->db->query($sql, array($idVenta) );
		return $query->row_array();
	}




	function getMaxIdVentasByUser($idUsuario)
	{
		$sql = "SELECT * FROM tb_ventas WHERE idUsuario = ? ORDER BY id DESC limit 1";
		$query = $this->db->query($sql,array($idUsuario) );
		if ($query->num_rows() == 0) {
			return 0;
		}
		else{
			return $query->row_array();
		}
	}

	function isTempVenta($idVenta)
	{
		$query = $this->db->get_where('tb_temporal_venta', array('id_venta' => $idVenta));
		return $query->num_rows()>0?TRUE:FALSE;
	}

	function getNextIdVentas()
	{
		$sql = "SELECT MAX(id)+1 as id FROM tb_ventas";
		$query = $this->db->query($sql,array($idUsuario) );
		if ($query->num_rows() == 0) {
			return 0;
		}
		else{
			return $query->row_array();
		}
	}



	public function recaudacionByUserHoy($idUser=0)
	{
		if($idUser!=0){
			$hoy=date('Y-m-d');
			$sqlRecaudado = "SELECT sum(Total) as suma FROM tb_ventas WHERE Fecha >= ? and idUsuario = ? ";
			$queryRecaudado = $this->db->query($sqlRecaudado,array($hoy,$idUser) );
			$recaudado=$queryRecaudado->row();
			$recaudado=$recaudado->suma;
			if($recaudado<=0)$recaudado=0;
			return $recaudado;
		}
	}




	function getVentasPeriodo($fecha1="",$fecha2="")
	{
		$sql = "SELECT  vts.id,vts.idUsuario,vts.Total,vts.Fecha,u.nombre as nombreUsuario,vts.tipoPago,c.nombre as cliente
		FROM tb_ventas vts
		inner join tb_usuarios u on vts.idUsuario = u.id
		inner join tb_clientes c on vts.idCliente = c.id
		WHERE vts.Total>0
		and  vts.Fecha > ?
		and vts.Fecha <= ?
		AND vts.tipoMovimiento = 0";
		$query = $this->db->query($sql,array($fecha1." 00:00:00",$fecha2." 23:59:59") );
		return $query->result_array();
	}

	function getVentasTipoPeriodo($tipo, $fecha1="",$fecha2="")
	{
		$sql = "SELECT  vts.id,vts.idUsuario,vts.Total,vts.Fecha,u.nombre as nombreUsuario,vts.tipoPago
		FROM tb_ventas vts
		inner join tb_usuarios u on vts.idUsuario = u.id
		WHERE vts.Total>0
		and  vts.Fecha > ?
		and vts.Fecha <= ?
		and vts.tipoMovimiento <= ?";
		$query = $this->db->query($sql,array($fecha1." 00:00:00",$fecha2." 23:59:59",$tipo) );
		return $query->result_array();
	}






	public function recaudacionByUser($fecha1,$fecha2,$idUser=0)
	{
		if($idUser!=0){
			$hoy=date('Y-m-d');
			$sqlRecaudado = "SELECT sum(Total) as suma
			FROM tb_ventas
			WHERE idUsuario = ?
			and  Fecha > ?
			and Fecha<= ? ";
			$queryRecaudado = $this->db->query($sqlRecaudado,array($idUser,$fecha1." 00:00:00",$fecha2." 23:59:59") );
			$recaudado=$queryRecaudado->row();
			$recaudado=$recaudado->suma;
			if($recaudado<=0)$recaudado=0;
			return $recaudado;
		}
	}

	public function recaudacionByUserType($fecha1,$fecha2,$idUser=0,$tipo=0)
	{
		if($idUser!=0){
			$hoy=date('Y-m-d');
			$sqlRecaudado = "SELECT sum(Total) as suma
			FROM tb_ventas
			WHERE idUsuario = ?
			and  Fecha > ?
			and Fecha<= ?
			and tipoPago = ?";
			$queryRecaudado = $this->db->query($sqlRecaudado,array($idUser,$fecha1." 00:00:00",$fecha2." 23:59:59",$tipo) );
			$recaudado=$queryRecaudado->row();
			$recaudado=$recaudado->suma;
			if($recaudado<=0)$recaudado=0;
			return $recaudado;
		}
	}

	public function getCantidadByProducto($idProducto=0)
	{
		$sql = "SELECT cantidad FROM tb_inventario
		WHERE id = ? ";
		$query = $this->db->query($sql,array($idProducto));
		$r=$query->row();
		return $r->cantidad;
	}

	public function getMonedaString()
	{
		$sql = "SELECT monedaString FROM tb_config";
		$query = $this->db->query($sql);
		$r=$query->row();
		return $r->monedaString;
	}

	public function getTiketera()
	{
		$sql = "SELECT tiketera FROM tb_config";
		$query = $this->db->query($sql);
		$r=$query->row();
		return $r->tiketera;
	}

	public function getOfertas()
	{
		$sql = "SELECT * FROM tb_ofertas";
		return $this->db->query($sql)->result_array();
	}

	public function findIdOferta($id)
	{
		$sql ="SELECT * FROM tb_ofertas WHERE id = ?";
		return $this->db->query($sql,array($id))->row();
	}

	public function findIdOfertaProducto($id)
	{
		$sql ="SELECT * FROM tb_ofertas_inventario oi
		JOIN tb_inventario i ON i.id = oi.id_inventario
		WHERE oi.id_oferta = ?";
		return $this->db->query($sql,array($id))->result_array();
	}

	public function getOfertaInventario($idInventario)
	{
		$sql ="SELECT * FROM tb_ofertas_inventario oi
		JOIN tb_inventario i ON i.id = oi.id_inventario
		JOIN tb_ofertas o ON o.id = oi.id_oferta
		WHERE oi.id_inventario = ?";
		return $this->db->query($sql,array($idInventario))->result_array();
	}

	public function getOfertaInventarioCampos($idInventario)
	{
		$sql ="SELECT oi.id_inventario,oi.id_oferta,i.precio, o.precio as precio_oferta FROM tb_ofertas_inventario oi
		JOIN tb_inventario i ON i.id = oi.id_inventario
		JOIN tb_ofertas o ON o.id = oi.id_oferta
		WHERE oi.id_inventario = ?";
		return $this->db->query($sql,array($idInventario))->result_array();
	}


	public function getAllOfertaInventario(){
		$sql ="SELECT * FROM tb_ofertas_inventario";
		return $this->db->query($sql)->result_array();
	}

	public function isOferta($ids)
	{
		$sql = "SELECT o.id from tb_ofertas o INNER JOIN tb_ofertas_inventario oi ON oi.id_oferta=o.id LEFT JOIN tb_inventario i on i.id = oi.id_inventario where oi.id_inventario in(".$ids.") group by o.id HAVING count(*) > 1";
		//$sql = "SELECT DISTINCT(id_oferta) AS idoferta FROM tb_ofertas_inventario WHERE id_inventario IN (".$ids.") GROUP BY id_oferta HAVING COUNT(*) = 2";
		$query = $this->db->query($sql);
		return $query->num_rows()>0?$query->row_array():NULL;
	}



	public function getVentaTempByUser($id_user){
		$sql = "SELECT DISTINCT * FROM tb_temporal_venta WHERE id_usuario = ?";
		return $this->db->query($sql,array($id_user));
	}





	public function getCajas()
	{
		return $this->db->get('tb_cajas')->result_array();
	}

	// public function getMovimientoCajas()
	// {
	// 	$this->db->join('tb_cajas', 'tb_cajas.id = tb_caja_movimiento.id_caja');
	// 	$this->db->join('tb_usuarios', 'tb_usuarios.id = tb_caja_movimiento.id_usuario');
	// 	return $this->db->get('tb_caja_movimiento')->result_array();
	// }

	function getMovimientosCaja()
	{
		$sql = "SELECT  mc.*,u.nombre as nombreUsuario
		FROM tb_movimientos_caja mc
		inner join tb_usuarios u on mc.idUsuario = u.id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getMovimientosCajaPeriodo($fecha1="",$fecha2="")
	{
		$sql = "SELECT  mc.*,u.nombre as nombreUsuario
		FROM tb_movimientos_caja mc
		inner join tb_usuarios u on mc.idUsuario = u.id
		where  mc.fecha > '$fecha1 00:00:00'
		and mc.fecha<='$fecha2 23:59:59'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function ofertasConElemento($idItem)
	{
		$sql = "SELECT DISTINCT oi.* , o.precio
		FROM tb_ofertas_inventario oi
		JOIN tb_ofertas o ON o.id = oi.id_oferta
		WHERE id_inventario = ?
		AND o.estatus = 1
		ORDER BY o.precio ASC";
		$query = $this->db->query($sql,array($idItem));
		if ($query->num_rows() == 0) {
			return false;
		}
		return $query->result_array();
	}

	public function getElementosDeOferta($idOferta)
	{
		$sql ="SELECT oi.*,i.precio
		FROM tb_ofertas_inventario oi
		JOIN tb_inventario i ON i.id = oi.id_inventario
		WHERE oi.id_oferta = ?";
		$resultado = $this->db->query($sql,array($idOferta));
		return  $resultado->result_array();
	}


	function conprobarElementoEnVenta($idVenta,$idElemento)
	{
		$sql = "SELECT inv.precio
		FROM tb_movimientosventas mvts
		inner join tb_inventario inv on inv.id = mvts.idInventario
		WHERE mvts.idVenta = ?
		AND mvts.idInventario = ?
		AND mvts.cantidadOfertas > 0";
		$query = $this->db->query($sql,array($idVenta,$idElemento));
		if ($query->num_rows() == 0) {
			return 0;
		}
		$respuesta = $query->row_array();
		return $respuesta["precio"];
	}



	public function comprobarClaveAdmin($clave)
	{
		$sql = "SELECT id FROM tb_usuarios WHERE idRol = 1 and pass=? ";
		$query = $this->db->query($sql,array($clave));
		if ($query->num_rows() == 0) {
			return false;
		}
		return true;
	}

	public function getImpresoraUsuario($idUsario)
	{
		$sql = "SELECT * FROM tb_usuario_impresora WHERE idUsuario = ?";
		$query = $this->db->query($sql, array($idUsario) );
		if ($query->num_rows() == 0) {
			return false;
		}
		$r = $query->row_array();
		return $r["idImpresora"];
	}

	public function getTiketeraByUsuario($idUsuario)
	{
		$sql = "SELECT i.impresora
		FROM tb_usuario_impresora ui
		inner join tb_impresoras i on i.id = ui.idImpresora
		WHERE ui.idUsuario = ?";
		$query = $this->db->query($sql, array($idUsuario) );
		if ($query->num_rows() == 0) {
			// ========================================================
			$sql = "SELECT i.impresora
			FROM tb_impresoras i
			limit 1";
			$query = $this->db->query($sql);
			$r = $query->row_array();
			return $r["impresora"];
			// ========================================================
		}
		$r = $query->row_array();
		return $r["impresora"];
	}

	function getClienteByIdVenta($idVenta)
	{
		$sql = "SELECT c.nombre
		FROM tb_ventas v
		inner join tb_clientes c on v.idCliente = c.id
		WHERE v.id=?";
		$query = $this->db->query($sql,array($idVenta));
		if ($query->num_rows() == 0) {
			return 0;
		}
		$respuesta = $query->row_array();
		return $respuesta["nombre"];
	}

	

	public function getAbonosByidVenta($idVenta)
	{
		$sql = "SELECT
		u.nombre as usuario,
		ab.fecha,
		ab.monto
		FROM tb_abonos ab
		inner join tb_usuarios u on ab.idUsuario = u.id
		where ab.idVenta = ?
		";
		$query = $this->db->query($sql,array($idVenta));
		return $query->result_array();
	}
	/***********************************************************
	* Devoluciones
	************************************************************/
	public function getElmentoEnDevolucion($idmv)
	{
		$sql = "SELECT cantidad as cantidadimv
		FROM  tb_devoluciones_temporal
		WHERE idMovimientoVenta = ?";
		$query = $this->db->query( $sql,array($idmv) );
		if ($query->num_rows() == 0) {
			return 0;
		}
		return $query->row()->cantidadimv;
	}

	public function getExisteEnDevolucion($idmv)
	{
		$sql = "SELECT *
		FROM  tb_devoluciones_temporal
		WHERE idMovimientoVenta = ?";
		$query = $this->db->query( $sql,array($idmv) );
		if ($query->num_rows() == 0) {
			return false;
		}
		return $query->row();
	}

	public function getDevolucionByUser($idUsuario)
	{
		$sql = "SELECT *
		FROM  tb_devoluciones_temporal
		WHERE idUsuario = ?";
		$query = $this->db->query( $sql,array($idUsuario) );
		return $query->result_array();
	}

	public function getTotalByVentaByMovimientosVentas($idVenta)
	{
		$sql = "SELECT sum(cantidad * costoUnitario) as suma FROM tb_movimientosventas WHERE idVenta=?";
		$query = $this->db->query($sql,array($idVenta));
		if ($query->num_rows() == 0) {
			return 0;
		}
		$respuesta = $query->row_array();
		return $respuesta["suma"];
	}
}
?>
