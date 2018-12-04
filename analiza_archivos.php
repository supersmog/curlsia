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
    // print_r($aDataTableHeaderHTML);
     
     $fecha_presupuesto=$aDataTableHeaderHTML[5];
     $nombre_cliente=$aDataTableHeaderHTML[8];
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
     $iva=$aDataTableHeaderHTML[49];
     $excedente=$aDataTableHeaderHTML[58];
     $interes=$aDataTableHeaderHTML[64];
     $iva_interes=$aDataTableHeaderHTML[67];
     $financiado=$aDataTableHeaderHTML[70];
     $amortizacion=$aDataTableHeaderHTML[73];
     $num_pagos=$aDataTableHeaderHTML[71];




     
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
     echo $precio_sin_iva."\n";
     echo $iva."\n";
     echo $monto_financiar."\n";
     echo $excedente."\n";
     echo $interes."\n";
     echo $iva_interes."\n";
     echo $financiado."\n";
     echo $amortizacion."\n";
     echo $num_pagos."\n";
}

analiza_archivo_presupuesto("presupuestos/QR000033-1.html");
?>