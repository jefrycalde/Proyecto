<?php

class Insertar extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	function insertarGral($tabla,$data)
	{
		$this->db->insert($tabla, $data);
		return $this->db->insert_id();
	}
	function updateGral($tabla,$data,$where)
	{
		$this->db->update($tabla, $data,$where);
		return $this->db->insert_id();
	}

	function newProveedor($data)
	{
		return $this->db->insert('tb_proveedores', $data);
	}
	function setProveedor($data,$where)
	{
		return $this->db->update('tb_proveedores', $data,$where);
	}

	function newCliente($data)
	{
		return $this->db->insert('tb_clientes', $data);
	}
	function setCliente($data,$where)
	{
		return $this->db->update('tb_clientes', $data,$where);
	}

	function newProducto($data)
	{
		return $this->db->insert('tb_inventario', $data);
	}
	function setProducto($data,$where)
	{
		return $this->db->update('tb_inventario', $data,$where);
	}

	function newUser($data)
	{
		return $this->db->insert('tb_usuarios', $data);
	}

	function newDepartamento($data)
	{
		$this->db->insert('tb_departamentos', $data);
		return $this->db->insert_id();
	}
	function setDepartamento($data,$where)
	{
		return $this->db->update('tb_departamentos', $data,$where);
	}

	function setUser($data,$where)
	{
		return $this->db->update('tb_usuarios', $data,$where);
	}
	function newVenta($data)
	{
		$this->db->insert('tb_ventas', $data);
		return $this->db->insert_id();
	}

	function setVenta($data,$where)
	{
		return $this->db->update('tb_ventas',$data,array('id'=>$where));
	}

	function newMovimientoVenta($data)
	{
		return $this->db->insert('tb_movimientosventas', $data);
	}

	function updateMovimientoVenta($data,$where)
	{
		return $this->db->update('tb_movimientosventas', $data,$where);
	}

	public function setConfig($data)
	{
		return $this->db->update('tb_config', $data);
	}

	public function newOferta($data)
	{
		$this->db->insert('tb_ofertas', $data);
		return $this->db->insert_id();
		/*$row = $this->db->query('SELECT LAST_INSERT_ID() AS id')->row();
		return $row->id;*/
	}

	public function setOferta($data,$id)
	{
		$this->db->where('id',$id);
		$this->db->update('tb_ofertas',$data);
	}

	public function dropOfertaInventario($id)
	{
		$this->db->delete('tb_ofertas_inventario', array('id_oferta' => $id));
	}

	public function newOfertaInventario($data)
	{
		return $this->db->insert('tb_ofertas_inventario', $data);
	}

	public function newMovimientoTemporal($data)
	{
		return $this->db->insert('tb_temporal_venta', $data);
	}

	public function dropMovimientoTemporal($id_venta)
	{
		$this->db->where('id_venta',$id_venta);
		$this->db->delete('tb_temporal_venta');
	}



	public function newCompraInventario($data)
	{
		$this->db->insert('tb_compra_inventario',$data);
	}

	public function newCaja($data)
	{
		$this->db->insert('tb_cajas',$data);
	}

	public function newMovimientoCaja($data)
	{
		$this->db->insert('tb_caja_movimiento',$data);
	}

	public function actualizarClienteVenta($idVenta,$idCliente){
		$datos = array(
			'idCliente' => $idCliente
		);
		$where = array(
			'id' => $idVenta
		);
		return $this->db->update('tb_ventas', $datos , $where);
	}

}
?>
