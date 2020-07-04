select `a`.`id` AS `id`,`a`.`rpu` AS `rpu`,
`a`.`solicitud` AS `solicitud`,`a`.`presupuesto` AS `presupuesto`,
`a`.`scc` AS `scc`,`a`.`sp` AS `sp`,
`a`.`proveedor` AS `proveedor`,`a`.`financiamiento` AS `financiamiento`,
`b`.`capital` AS `capital`,`a`.`fecha_liberacion` AS `fecha_liberacion`,
date_format(`a`.`fecha_liberacion`,'%M') AS `mes_liberacion`,
date_format(`a`.`fecha_liberacion`,'%Y') AS `anio_liberacion`,
`a`.`fecha_registro` AS `fecha_registro`,`a`.`boleta` AS `boleta`,
b.capital,
b.interes, b.iva,
`a`.`acopio` AS `acopio`,`a`.`tipo_sup` AS `tipo_sup`,`a`.`zona` AS `zona`
 from (`confirma_liberaciones` `a` join `liberaciones_simple` `b`) 
where `a`.`solicitud` = `b`.`solicitud`
