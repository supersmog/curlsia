
<?php
require_once 'PHPExcel/Classes/PHPExcel.php';
function carga_presupuestos($archivo)
{

	//vacia tabla
    $bd = new SQLite3('Yucatan.db');
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
		//$scc=$sheet->getCell("D".$row)->getValue();
		$sp=$sheet->getCell("D".$row)->getValue();
		$status=$sheet->getCell("E".$row)->getValue();
		$proveedor=$sheet->getCell("F".$row)->getValue();
		$financiamiento=$sheet->getCell("G".$row)->getValue();
		$capital=$sheet->getCell("H".$row)->getValue();
		$interes=$sheet->getCell("I".$row)->getValue();
		$iva=$sheet->getCell("J".$row)->getValue();
		$fecha_registro=$sheet->getCell("K".$row)->getValue();
		$coordinacion=$sheet->getCell("L".$row)->getValue();
		$fecha_liberacion=$sheet->getCell("M".$row)->getValue();
		$tipo_financiamiento=$sheet->getCell("N".$row)->getValue();
		$sustitucion=$sheet->getCell("O".$row)->getValue();
		$concatenar="('$rpu','$solicitud','$presupuesto','$sp','$status','$proveedor','$financiamiento','$capital','$interes','$iva','$fecha_registro','$coordinacion','$fecha_liberacion','$tipo_financiamiento','$sustitucion')";
		$sql="INSERT INTO presupuestos(rpu, solicitud, presupuesto,programa,estatus,distribuidor,financiamiento,capital,interes,iva,fecha_registro,coordinacion,fecha_liberacion,tipo_financiamiento,sustitucion)
		VALUES$concatenar";
		echo $sql;
		$results = $bd->query($sql);

	
	
	}

		

}


carga_presupuestos("paginas/presupuestos.xls");

?>
 
