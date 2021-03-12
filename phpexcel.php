
<?php
require_once("funciones_curl.php");
require("cliente.php");
require_once 'PHPExcel/Classes/PHPExcel.php';

function vaciar_tabla($tabla)
{
    $solicitudes=new cliente();
    $sql="TRUNCATE `$tabla`";
    $resultado=$solicitudes->eliminar($sql);
    echo "registros eliminados";
}

function actualiza_confirma_liberaciones($archivo,$zona)
{
	$liberacion=new cliente();
	//vacia tabla

	$inputFileType = PHPExcel_IOFactory::identify($archivo);
	$objReader = PHPExcel_IOFactory::createReader($inputFileType);
	$objPHPExcel = $objReader->load($archivo);
	$sheet = $objPHPExcel->getSheet(0); 
	$highestRow = $sheet->getHighestRow(); 
	$highestColumn = $sheet->getHighestColumn();
	
	for ($row = 4; $row <= $highestRow; $row++){ 
		$concatenar="";
		//echo $row."|";
		$rpu=$sheet->getCell("A".$row)->getValue();
		$solicitud=$sheet->getCell("B".$row)->getValue();
		$presupuesto=$sheet->getCell("C".$row)->getValue();
		$scc=$sheet->getCell("D".$row)->getValue();
		$sp=$sheet->getCell("E".$row)->getValue();
		$proveedor=$sheet->getCell("F".$row)->getValue();
		$financiamiento=$sheet->getCell("G".$row)->getValue();
		$bono=$sheet->getCell("H".$row)->getValue();
		$fecha_liberacion=$sheet->getCell("I".$row)->getValue();
		$usuario=$sheet->getCell("J".$row)->getValue();
		$fecha_registro=$sheet->getCell("K".$row)->getValue();
		$boleta=$sheet->getCell("L".$row)->getValue();
		$acopio=$sheet->getCell("M".$row)->getValue();
		$tipo_sup=$sheet->getCell("N".$row)->getValue();
		$sicom=$sheet->getCell("O".$row)->getValue();
		$afecta_sicom=$sheet->getCell("P".$row)->getValue();
		$observacion=$sheet->getCell("Q".$row)->getValue();
		$concatenar="('$rpu','$solicitud','$presupuesto','$scc','$sp','$proveedor','$financiamiento','$bono','$fecha_liberacion','$usuario','$fecha_registro','$boleta','$acopio','$tipo_sup','$zona')";
		$sql="INSERT INTO Yucatan.confirma_liberaciones_tmp(rpu, solicitud, presupuesto,scc,sp,proveedor,financiamiento,bono,fecha_liberacion,usuario,fecha_registro,boleta,acopio,tipo_sup,zona)
		VALUE$concatenar";
		//echo $sql;
		$resp=$liberacion->insertar($sql);
		if($resp)
		{
			echo "Se guardo correctamente";
		}
		else
		{
			echo "No se pudo guardar";
		}
	
	}
		//obtiene los nuevos registros
	//inserta los nuevos registros en la tabla orignal
	$sql="INSERT INTO Yucatan.confirma_liberaciones(rpu, solicitud, presupuesto,scc,sp,proveedor,financiamiento,bono,fecha_liberacion,usuario,fecha_registro,boleta,acopio,tipo_sup,zona)
	SELECT rpu, solicitud, presupuesto,scc,sp,proveedor,financiamiento,bono,fecha_liberacion,usuario,fecha_registro,boleta,acopio,tipo_sup,zona FROM confirma_liberaciones_tmp WHERE NOT EXISTS 
	(SELECT 1 FROM confirma_liberaciones WHERE confirma_liberaciones.solicitud = confirma_liberaciones_tmp.solicitud)";
		$resp=$liberacion->insertar($sql);
		if($resp)
		{
			echo "Se guardo correctamente";
		}
		else
		{
			echo "No se pudo guardar";
		}

}

function actualiza_confirma_liberaciones_simple($archivo,$zona)
{
	$liberacion=new cliente();
	//vacia tabla

	$inputFileType = PHPExcel_IOFactory::identify($archivo);
	$objReader = PHPExcel_IOFactory::createReader($inputFileType);
	$objPHPExcel = $objReader->load($archivo);
	$sheet = $objPHPExcel->getSheet(0); 
	$highestRow = $sheet->getHighestRow(); 
	$highestColumn = $sheet->getHighestColumn();
	
	for ($row = 3; $row < ($highestRow-1); $row++){ 
		$concatenar="";
		//echo $row."|";
		$rpu=$sheet->getCell("A".$row)->getValue();
		$solicitud_pa=$sheet->getCell("B".$row)->getValue();
		$solicitud_tmp=$sheet->getCell("C".$row)->getValue();
		//$solicitud_ext=$sheet->getCell("D".$row)->getValue();
		$solicitud=$solicitud_tmp;//."-".$solicitud_ext;
		$presupuesto=$sheet->getCell("D".$row)->getValue();
		$programa=$sheet->getCell("E".$row)->getValue();
		$sufijo_sicom=$sheet->getCell("F".$row)->getValue();
		$fecha_sicom=$sheet->getCell("G".$row)->getValue();
		$fecha_alta_lib=$sheet->getCell("H".$row)->getValue();
		$fecha_pago=$sheet->getCell("I".$row)->getValue();
		$financiado=$sheet->getCell("J".$row)->getValue();
		$capital=$sheet->getCell("K".$row)->getValue();
		$interes=$sheet->getCell("L".$row)->getValue();
		$iva=$sheet->getCell("M".$row)->getValue();
		$dif_total=$sheet->getCell("N".$row)->getValue();
		$dif_capital=$sheet->getCell("O".$row)->getValue();
		$dif_interes=$sheet->getCell("P".$row)->getValue();
		$dif_iva=$sheet->getCell("Q".$row)->getValue();
		$concatenar="('$rpu','$solicitud_pa','$solicitud','$presupuesto','$programa','$sufijo_sicom','$fecha_sicom','$fecha_alta_lib','$fecha_pago','$financiado','$capital','$interes','$iva','$dif_total','$dif_capital','$dif_interes','$dif_iva','$zona')";
		$sql="INSERT INTO Yucatan.liberaciones_simple_tmp(rpu,solicitud_pa, solicitud, presupuesto,programa,sufijo_sicom,fecha_sicom,fecha_alta_lib,fecha_pago,financiado,capital,interes,iva,dif_total,dif_capital,dif_interes,dif_iva,zona) VALUES$concatenar";
		echo $sql;
		$resp=$liberacion->insertar($sql);
		if($resp)
		{
			echo "Se guardo correctamente";
		}
		else{
			echo "No se pudo guardar";
		}

	}
	//obtiene los nuevos registros
	//inserta los nuevos registros en la tabla orignal
	$sql="INSERT INTO Yucatan.liberaciones_simple(rpu,solicitud_pa, solicitud, presupuesto,programa,sufijo_sicom,fecha_sicom,fecha_alta_lib,fecha_pago,financiado,capital,interes,iva,dif_total,dif_capital,dif_interes,dif_iva,zona)
	SELECT rpu,solicitud_pa, solicitud, presupuesto,programa,sufijo_sicom,fecha_sicom,fecha_alta_lib,fecha_pago,financiado,capital,interes,iva,dif_total,dif_capital,dif_interes,dif_iva,zona FROM liberaciones_simple_tmp WHERE NOT EXISTS
	(SELECT 1 FROM liberaciones_simple WHERE liberaciones_simple.solicitud=liberaciones_simple_tmp.solicitud)";
	$resp=$liberacion->insertar($sql);
	if($resp)
	{
		echo "Se guardo correctamente";
	}
	else{
		echo "No se pudo guardar";
	}


}


//vaciar_tabla('confirma_liberaciones_tmp');
//actualiza_confirma_liberaciones("paginas/confirma_lib_yucatan.xls","Merida");
//actualiza_confirma_liberaciones("paginas/confirma_lib_yucatan_motul.xls","Motul");
//actualiza_confirma_liberaciones("paginas/confirma_lib_campeche.xls","Campeche");
//actualiza_confirma_liberaciones("paginas/confirma_lib_quintanaroo.xls","Cancun");
//actualiza_confirma_liberaciones("paginas/confirma_lib_quintanaroorv.xls","Riviera");
//actualiza_confirma_liberaciones("paginas/confirma_lib_yucatan_2021.xls","Merida");
//actualiza_confirma_liberaciones("paginas/confirma_lib_yucatan_motul_2021.xls","Motul");
//actualiza_confirma_liberaciones("paginas/confirma_lib_campeche_2021.xls","Campeche");
//actualiza_confirma_liberaciones("paginas/confirma_lib_quintanaroo_2021.xls","Cancun");
//actualiza_confirma_liberaciones("paginas/confirma_lib_quintanaroorv_2021.xls","Riviera");

vaciar_tabla('liberaciones_simple_tmp');

actualiza_confirma_liberaciones_simple("paginas/liberaciones_simple_yucatan.xls","Merida");
actualiza_confirma_liberaciones_simple("paginas/liberaciones_simple_yucatan_motul.xls","Motul");
actualiza_confirma_liberaciones_simple("paginas/liberaciones_simple_campeche.xls","Campeche");
actualiza_confirma_liberaciones_simple("paginas/liberaciones_simple_quintanaroo.xls","Cancun");
actualiza_confirma_liberaciones_simple("paginas/liberaciones_simple_quintanaroorv.xls","Riviera");
actualiza_confirma_liberaciones_simple("paginas/liberaciones_simple_yucatan_2021.xls","Merida");
actualiza_confirma_liberaciones_simple("paginas/liberaciones_simple_yucatan_motul_2021.xls","Motul");
actualiza_confirma_liberaciones_simple("paginas/liberaciones_simple_campeche_2021.xls","Campeche");
actualiza_confirma_liberaciones_simple("paginas/liberaciones_simple_quintanaroo_2021.xls","Cancun");
actualiza_confirma_liberaciones_simple("paginas/liberaciones_simple_quintanaroorv_2021.xls","Riviera");



?>
