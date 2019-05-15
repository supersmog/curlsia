select colocadas_sia.solicitud, colocadas_sia.fecha_registro,
colocadas_sia.subprograma, colocadas_sia.id_estatus,colocadas_sia.rpu,
colocadas_sia.nombre,proveedores.nombre_comercial,presupuestos.monto_financiar
 from colocadas_sia,login_distribuidor,proveedores,presupuestos where
  colocadas_sia.id_proveedor=login_distribuidor.login 
  and login_distribuidor.id_proveedor=proveedores.id_proveedor
  and presupuestos.solicitud=colocadas_sia.solicitud
  
  
select colocadas_sia.solicitud, colocadas_sia.fecha_registro,
colocadas_sia.subprograma, colocadas_sia.id_estatus,colocadas_sia.rpu,
colocadas_sia.nombre,proveedores.nombre_comercial,presupuestos.monto_financiar
 from colocadas_sia left join login_distribuidor on colocadas_sia.id_proveedor=login_distribuidor.login 
 left join proveedores on login_distribuidor.id_proveedor=proveedores.id_proveedor
 left join presupuestos on presupuestos.solicitud=colocadas_sia.solicitud
where  colocadas_sia.solicitud like 'YU0%'
order by colocadas_sia.solicitud 
