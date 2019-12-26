<!DOCTYPE html>
<html>
<head>
	<title>Leer Archivo Excel</title>
</head>
<body>
<h1>Leer Archivo Excel</h1>
<?php
require_once 'PHPExcel/Classes/PHPExcel.php';
$archivo = "paginas/confirma_lib_yucatan.xls";
$inputFileType = PHPExcel_IOFactory::identify($archivo);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($archivo);
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();
for ($row = 4; $row <= $highestRow; $row++){ 
		echo $row."|";
		echo $sheet->getCell("A".$row)->getValue()."|";
		echo $sheet->getCell("B".$row)->getValue()."|";
		echo $sheet->getCell("C".$row)->getValue()."|";
		echo $sheet->getCell("D".$row)->getValue()."|";
		echo $sheet->getCell("E".$row)->getValue()."|";
		echo $sheet->getCell("F".$row)->getValue()."|";
		echo $sheet->getCell("G".$row)->getValue()."|";
		echo $sheet->getCell("H".$row)->getValue()."|";
		echo $sheet->getCell("I".$row)->getValue()."|";
		echo $sheet->getCell("J".$row)->getValue()."|";
		echo $sheet->getCell("K".$row)->getValue()."|";
		echo $sheet->getCell("L".$row)->getValue()."|";
		echo $sheet->getCell("M".$row)->getValue()."|";
		echo $sheet->getCell("N".$row)->getValue()."|";
		echo $sheet->getCell("O".$row)->getValue()."|";
		echo $sheet->getCell("P".$row)->getValue()."|";
		echo $sheet->getCell("Q".$row)->getValue();
		echo "\n";
}
?>
</body>
</html>