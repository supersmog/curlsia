<?php

require("cliente.php");

function analiza_archivo_colocadas($file)
{
   
    $cliente1=new cliente();
    if (!file_exists($file)){
      exit("File not found");
    }
    $htmlContent=file_get_contents($file);
    $DOM=new DOMDocument();
    //echo $htmlContent;
    @$DOM->loadHTML($htmlContent);
    $Header = $DOM->getElementsByTagName('td');
    $Detail = $DOM->getElementsByTagName('td');
    foreach($Header as $NodeHeader)
    {
        $aDataTableHeaderHTML[]=trim($NodeHeader->textContent);
       // echo $aDataTableHeaderHTML;
    }
    //print_r($aDataTableHeaderHTML);
    $total_filas=$aDataTableHeaderHTML[10];
    //echo $total_filas;
    $iteracion=($total_filas*10)+20;
    $linea=0;
    for($i=21;$i<=$iteracion;$i=$i+10)
    {
        $concatenar="";
        for($z=0;$z<10;$z=$z+1)
        {
            if($z==0)
            $concatenar="'";
            //$concatenar=$aDataTableHeaderHTML[$i+$z];
            else if($z<9)
            $concatenar=$concatenar.$aDataTableHeaderHTML[$i+$z]."','";
            else
            $concatenar=$concatenar.$aDataTableHeaderHTML[$i+$z]."";

        }
        $concatenar=$concatenar."'";
                //$concatenar=$aDataTableHeaderHTML[$i].",".$aDataTableHeaderHTML[$i+1].",".$aDataTableHeaderHTML[$i+2].",".$aDataTableHeaderHTML[$i+3].",".$aDataTableHeaderHTML[$i+4].",".$aDataTableHeaderHTML[$i+5].",".$aDataTableHeaderHTML[$i+6].",".$aDataTableHeaderHTML[$i+7].",".$aDataTableHeaderHTML[$i+8].",".$aDataTableHeaderHTML[$i+9];
        //echo "$concatenar\n";
        $sql="insert into colocadas_sia (solicitud, fecha_registro, subprograma, id_estatus, rpu, nombre, colonia, direccion, id_proveedor) values(".$concatenar.")";
        $resp=$cliente1->insertar($sql);
        if($resp)
        {
            echo "Se guardo correctamente";
        }
        else{
            echo "No se pudo guardar";
        }
        echo "$sql\n";
       
    }

}

function analiza_archivo_presupuesto1($file)
{
    $cliente=new cliente();
    if (!file_exists($file)){
      exit("File not found");
    }
    $htmlContent=file_get_contents($file);
    $DOM=new DOMDocument();
    //echo $htmlContent;
    @$DOM->loadHTML($htmlContent);
    $Header = $DOM->getElementsByTagName('td');
    $Detail = $DOM->getElementsByTagName('td');
    foreach($Header as $NodeHeader)
    {
        $aDataTableHeaderHTML[]=trim($NodeHeader->textContent);
        //echo $aDataTableHeaderHTML;
    }
     print_r($aDataTableHeaderHTML);
     
     //$fecha_presupuesto=substr($aDataTableHeaderHTML[5],23,10);
     $fecha_presupuesto=substr($aDataTableHeaderHTML[12],23,10);
     $nombre_cliente=$aDataTableHeaderHTML[15];
     //$nombre_cliente=$aDataTableHeaderHTML[8];
     $dirección_cliente=$aDataTableHeaderHTML[10];
     $rpu=$aDataTableHeaderHTML[12];
     $telefono=$aDataTableHeaderHTML[14];
     $presupuesto=$aDataTableHeaderHTML[16];
     $marca_instalar=$aDataTableHeaderHTML[26];
     $modelo_instalar=$aDataTableHeaderHTML[27];
     $capacidad_instalar=$aDataTableHeaderHTML[28];
     $monto_financiar=$aDataTableHeaderHTML[29];
     $marca_retirar=$aDataTableHeaderHTML[37];
     $capacidad_retirar=$aDataTableHeaderHTML[38];
     $modelo_retirar=$aDataTableHeaderHTML[39];
     $solicitud=$aDataTableHeaderHTML[42];
     $precio_sin_iva=$aDataTableHeaderHTML[46];
     $iva=ltrim($aDataTableHeaderHTML[49]);
     $excedente=$aDataTableHeaderHTML[58];
     $interes=$aDataTableHeaderHTML[64];
     $iva_interes=$aDataTableHeaderHTML[67];
     $financiado=$aDataTableHeaderHTML[70];
     $amortizacion=$aDataTableHeaderHTML[73];
     $num_pagos=substr($aDataTableHeaderHTML[71],0,2);




     
     echo $fecha_presupuesto."\n";
     echo $nombre_cliente."\n";
     echo $rpu."\n";
     echo $presupuesto."\n";
     echo $telefono."\n";
     echo $marca_instalar."\n";
     echo $modelo_instalar."\n";
     echo $capacidad_instalar."\n";
     echo $marca_retirar."\n";
     echo $modelo_retirar."\n";
     echo $capacidad_retirar."\n";
     echo $solicitud."\n";
     echo substr($precio_sin_iva,1,9)."\n";
     echo substr($iva,17,8)."\n";
     echo substr($monto_financiar,1,10)."\n";
     echo substr($excedente,16,7)."\n";
     echo substr($interes,17,8)."\n";
     echo substr($iva_interes,16,7)."\n"; //23
     echo substr($financiado,17,9)."\n";  //26
     echo substr($amortizacion,17,6)."\n"; //23
     echo $num_pagos."\n";
}
function analiza_archivo_presupuesto($file)
{
    $cliente=new cliente();
    if (!file_exists($file)){
      exit("File not found");
    }
    $htmlContent=file_get_contents($file);
    $DOM=new DOMDocument();
    //echo $htmlContent;
    @$DOM->loadHTML($htmlContent);
    $Header = $DOM->getElementsByTagName('td');
    $Detail = $DOM->getElementsByTagName('td');
    foreach($Header as $NodeHeader)
    {
        $aDataTableHeaderHTML[]=trim($NodeHeader->textContent);
        //echo $aDataTableHeaderHTML;
    }
     print_r($aDataTableHeaderHTML);
     
     
     $fecha_presupuesto=substr($aDataTableHeaderHTML[12],23,10);
     $nombre_cliente=$aDataTableHeaderHTML[15];
     $dirección_cliente=$aDataTableHeaderHTML[17];
     $rpu=$aDataTableHeaderHTML[19];
     $telefono=$aDataTableHeaderHTML[21];
     $presupuesto=$aDataTableHeaderHTML[23];
     $marca_instalar=$aDataTableHeaderHTML[31];
     $modelo_instalar=$aDataTableHeaderHTML[32];
     $capacidad_instalar=$aDataTableHeaderHTML[33];
     $monto_financiar=$aDataTableHeaderHTML[34];
     $marca_retirar=$aDataTableHeaderHTML[42];
     $capacidad_retirar=$aDataTableHeaderHTML[43];
     $modelo_retirar=$aDataTableHeaderHTML[44];
     $solicitud=$aDataTableHeaderHTML[47];
     $precio_sin_iva=$aDataTableHeaderHTML[51];
     $iva=ltrim($aDataTableHeaderHTML[54]);
     $excedente=$aDataTableHeaderHTML[63];
     $interes=$aDataTableHeaderHTML[69];
     $iva_interes=$aDataTableHeaderHTML[72];
     $financiado=$aDataTableHeaderHTML[75];
     $amortizacion=$aDataTableHeaderHTML[78];
     $num_pagos=substr($aDataTableHeaderHTML[76],0,2);




     
     echo $fecha_presupuesto."\n";
     echo $nombre_cliente."\n";
     echo $rpu."\n";
     echo $presupuesto."\n";
     echo $telefono."\n";
     echo $marca_instalar."\n";
     echo $modelo_instalar."\n";
     echo $capacidad_instalar."\n";
     echo $marca_retirar."\n";
     echo $modelo_retirar."\n";
     echo $capacidad_retirar."\n";
     echo $solicitud."\n";
     echo substr($precio_sin_iva,1,9)."\n";
     echo substr($iva,17,8)."\n";
     echo substr($monto_financiar,1,10)."\n";
     echo substr($excedente,16,7)."\n";
     echo substr($interes,17,8)."\n";
     echo substr($iva_interes,16,7)."\n"; //23
     echo substr($financiado,17,9)."\n";  //26
     echo substr($amortizacion,17,6)."\n"; //23
     echo $num_pagos."\n";
}

function analiza_archivo_presupuesto_aa($file)
{
    $cliente=new cliente();
    if (!file_exists($file)){
      exit("File not found");
    }
    $htmlContent=file_get_contents($file);
    $DOM=new DOMDocument();
    //echo $htmlContent;
    @$DOM->loadHTML($htmlContent);
    $Header = $DOM->getElementsByTagName('td');
    $Detail = $DOM->getElementsByTagName('td');
    foreach($Header as $NodeHeader)
    {
        $aDataTableHeaderHTML[]=trim($NodeHeader->textContent);
        //echo $aDataTableHeaderHTML;
    }
     print_r($aDataTableHeaderHTML);
     
     
     $fecha_presupuesto=substr($aDataTableHeaderHTML[12],23,10);
     $nombre_cliente=$aDataTableHeaderHTML[15];
     $dirección_cliente=$aDataTableHeaderHTML[17];
     $rpu=$aDataTableHeaderHTML[19];
     $telefono=$aDataTableHeaderHTML[21];
     $presupuesto=$aDataTableHeaderHTML[23];
     $marca_instalar=$aDataTableHeaderHTML[31];
     $modelo_instalar=$aDataTableHeaderHTML[32];
     $capacidad_instalar=$aDataTableHeaderHTML[33];
     $monto_financiar=$aDataTableHeaderHTML[34];
     $marca_retirar=$aDataTableHeaderHTML[42];
     $capacidad_retirar=$aDataTableHeaderHTML[43];
     $modelo_retirar=$aDataTableHeaderHTML[44];
     $solicitud=$aDataTableHeaderHTML[47];
     $precio_sin_iva=$aDataTableHeaderHTML[51];
     $iva=ltrim($aDataTableHeaderHTML[54]);
     $excedente=$aDataTableHeaderHTML[63];
     $interes=$aDataTableHeaderHTML[69];
     $iva_interes=$aDataTableHeaderHTML[72];
     $financiado=$aDataTableHeaderHTML[75];
     $amortizacion=$aDataTableHeaderHTML[78];
     $num_pagos=substr($aDataTableHeaderHTML[76],0,2);




     
     echo $fecha_presupuesto."\n";
     echo $nombre_cliente."\n";
     echo $rpu."\n";
     echo $presupuesto."\n";
     echo $telefono."\n";
     echo $marca_instalar."\n";
     echo $modelo_instalar."\n";
     echo $capacidad_instalar."\n";
     echo $marca_retirar."\n";
     echo $modelo_retirar."\n";
     echo $capacidad_retirar."\n";
     echo $solicitud."\n";
     echo substr($precio_sin_iva,1,9)."\n";
     echo substr($iva,17,8)."\n";
     echo substr($monto_financiar,1,10)."\n";
     echo substr($excedente,16,7)."\n";
     echo substr($interes,17,8)."\n";
     echo substr($iva_interes,16,7)."\n"; //23
     echo substr($financiado,17,9)."\n";  //26
     echo substr($amortizacion,17,6)."\n"; //23
     echo $num_pagos."\n";
}
analiza_archivo_presupuesto_aa("presupuestos/YU000133-1.html");
?>