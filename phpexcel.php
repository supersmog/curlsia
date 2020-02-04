
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
			$sql="INSERT INTO yucatan.confirma_liberaciones_tmp(rpu, solicitud, presupuesto,scc,sp,proveedor,financiamiento,bono,fecha_liberacion,usuario,fecha_registro,boleta,acopio,tipo_sup,zona)
			VALUE$concatenar";
			//echo $sql;
			$resp=$liberacion->insertar($sql);
			if($resp)
			{
				echo "Se guardo correctamente";
			}
			else{
				echo "No se pudo guardar";
			}
	


}
}

vaciar_tabla('confirma_liberaciones_tmp');
actualiza_confirma_liberaciones("paginas/confirma_lib_yucatan.xls","Merida");
actualiza_confirma_liberaciones("paginas/confirma_lib_yucatan_motul.xls","Motul");
// $archivo = "paginas/confirma_lib_yucatan_motul.xls";
// $inputFileType = PHPExcel_IOFactory::identify($archivo);
// $objReader = PHPExcel_IOFactory::createReader($inputFileType);
// $objPHPExcel = $objReader->load($archivo);
// $sheet = $objPHPExcel->getSheet(0); 
// $highestRow = $sheet->getHighestRow(); 
// $highestColumn = $sheet->getHighestColumn();
// echo $highestRow;
// $liberacion=new cliente();

// for ($row = 4; $row <= $highestRow; $row++){ 
// 	$concatenar="";
		
// 			$rpu=$sheet->getCell("A".$row)->getValue();
// 			$solicitud=$sheet->getCell("B".$row)->getValue();
// 			$presupuesto=$sheet->getCell("C".$row)->getValue();
// 			$scc=$sheet->getCell("D".$row)->getValue();
// 			$sp=$sheet->getCell("E".$row)->getValue();
// 			$proveedor=$sheet->getCell("F".$row)->getValue();
// 			$financiamiento=$sheet->getCell("G".$row)->getValue();
// 			$bono=$sheet->getCell("H".$row)->getValue();
// 			$fecha_liberacion=$sheet->getCell("I".$row)->getValue();
// 			$usuario=$sheet->getCell("J".$row)->getValue();
// 			$fecha_registro=$sheet->getCell("K".$row)->getValue();
// 			$boleta=$sheet->getCell("L".$row)->getValue();
// 			$acopio=$sheet->getCell("M".$row)->getValue();
// 			$tipo_sup=$sheet->getCell("N".$row)->getValue();
// 			$sicom=$sheet->getCell("O".$row)->getValue();
// 			$afecta_sicom=$sheet->getCell("P".$row)->getValue();
// 			$observacion=$sheet->getCell("Q".$row)->getValue();
// 		$concatenar="('$rpu','$solicitud','$presupuesto','$scc','$sp','$proveedor','$financiamiento','$bono','$fecha_liberacion','$usuario','$fecha_registro','$boleta','$acopio','$tipo_sup')";
// 		$sql="INSERT INTO yucatan.confirma_liberaciones_tmp(rpu, solicitud, presupuesto,scc,sp,proveedor,financiamiento,bono,fecha_liberacion,usuario,fecha_registro,boleta,acopio,tipo_sup)
// 		VALUE$concatenar";
// 		//echo $sql;
// 		$resp=$liberacion->insertar($sql);
//         if($resp)
//         {
//             echo "Se guardo correctamente";
//         }
//         else{
//             echo "No se pudo guardar";
//         }
		
	
// 		echo "\n";
		
// }



?>
