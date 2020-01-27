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



obtiene los nuevos registros diarios
SELECT * FROM colocadas_sia_tmp WHERE NOT EXISTS 
(SELECT 1 FROM colocadas_sia WHERE colocadas_sia.solicitud = colocadas_sia_tmp.solicitud)

inicial para actualizar estatus
SELECT colocadas_sia_tmp.solicitud, colocadas_sia_tmp.id_estatus,colocadas_sia.id_estatus
    from colocadas_sia_tmp,colocadas_sia where colocadas_sia.solicitud=colocadas_sia_tmp.solicitud


### actualizar los estatus de las solicitudes
UPDATE colocadas_sia SET id_estatus=(SELECT colocadas_sia_tmp.id_estatus
    from colocadas_sia_tmp where colocadas_sia.solicitud=colocadas_sia_tmp.solicitud) 

### inserta los nuevos registros en la tabla colocadas_sia
INSERT INTO colocadas_sia (solicitud, fecha_registro, subprograma, id_estatus, rpu, nombre, colonia, direccion, id_proveedor)
SELECT solicitud, fecha_registro, subprograma, id_estatus, rpu, nombre, colonia, direccion, id_proveedor FROM colocadas_sia_tmp WHERE NOT EXISTS 
(SELECT 1 FROM colocadas_sia WHERE colocadas_sia.solicitud = colocadas_sia_tmp.solicitud)