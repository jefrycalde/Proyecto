<?php

class Delete extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	function eliminarGral($tabla,$where)
	{
		return $this->db->delete($tabla, $where);
	}

	function delUser($id)
	{
		return $this->db->delete('tb_usuarios', array('id' => $id));
	}

	function delMovimientosFallidos($idVenta)
	{
		return $this->db->delete('tb_movimientosventas', array('idVenta' => $idVenta));
	}
	function delMovimientosCompraFail($idCompra)
	{
		return $this->db->delete('tb_movimientosventas', array('idCompra' => $idCompra));
	}

	function delMovimiento($idVenta,$idItem)
	{
		return $this->db->delete('tb_movimientosventas', array('idVenta' => $idVenta,'idInventario'=>$idItem));
	}

	function truncar($tabla)
	{
		$this->db->truncate($tabla);
	}

	function delDepartamento($id)
	{
		return $this->db->delete('tb_departamentos', array('id' => $id));
	}

	function delProveedor($id)
	{
		return $this->db->delete('tb_proveedores', array('id' => $id));
	}

	function delCliente($id)
	{
		return $this->db->delete('tb_clientes', array('id' => $id));
	}

	function delInventario($id)
	{
		return $this->db->delete('tb_inventario', array('id' => $id));
	}
}
?>
