select colocadas_sia.solicitud, colocadas_sia.fecha_registro,
colocadas_sia.subprograma, colocadas_sia.id_estatus,colocadas_sia.rpu,
colocadas_sia.nombre,proveedores.nombre_comercial,presupuestos.monto_financiar
 from colocadas_sia,login_distribuidor,proveedores,presupuestos where
  colocadas_sia.id_proveedor=login_distribuidor.login 
  and login_distribuidor.id_proveedor=proveedores.id_proveedor
  and presupuestos.solicitud=colocadas_sia.solicitud
