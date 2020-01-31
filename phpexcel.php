
<?php
require_once("funciones_curl.php");
require("cliente.php");
require_once 'PHPExcel/Classes/PHPExcel.php';
$archivo = "paginas/confirma_lib_yucatan.xls";
$inputFileType = PHPExcel_IOFactory::identify($archivo);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($archivo);
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();
$liberacion=new cliente();
//sql=INSERT INTO yucatan.liberaciones_simple
//(rpu, solicitud_pa, solicitud, solixtrasia, presupuesto, programa, sufijo_sicom, fecha_sicom, fecha_alta_lib, fecha_pago, financiado, capital, interes, iva, dif_total, dif_capital, dif_ineteres, dif_iva, id_promo)
//VALUES('', '', '', 0, '', 0, 0, '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0);


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
		$concatenar="('$rpu','$solicitud','$presupuesto','$scc','$sp','$proveedor')";
		echo $concatenar;
		//echo $sheet->getCell("A".$row)->getValue()."|";
		//echo $sheet->getCell("B".$row)->getValue()."|";
		//echo $sheet->getCell("C".$row)->getValue()."|";
		//echo $sheet->getCell("D".$row)->getValue()."|";
		//echo $sheet->getCell("E".$row)->getValue()."|";
		//echo $sheet->getCell("F".$row)->getValue()."|";
		//echo $sheet->getCell("G".$row)->getValue()."|";
		//echo $sheet->getCell("H".$row)->getValue()."|";
		//echo $sheet->getCell("I".$row)->getValue()."|";
		//echo $sheet->getCell("J".$row)->getValue()."|";
		//echo $sheet->getCell("K".$row)->getValue()."|";
		//echo $sheet->getCell("L".$row)->getValue()."|";
		//echo $sheet->getCell("M".$row)->getValue()."|";
		//echo $sheet->getCell("N".$row)->getValue()."|";
		//echo $sheet->getCell("O".$row)->getValue()."|";
		//echo $sheet->getCell("P".$row)->getValue()."|";
		//echo $sheet->getCell("Q".$row)->getValue();
		echo "\n";
		
}



?>
