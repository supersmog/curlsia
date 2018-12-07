<?php

require("cliente.php");
//require("descarga_archivos.php");

function obtiene_fecha($fecha)
{
    $fecha_obt=$fecha;
    $fecha_temp=explode('/',$fecha_obt);
    $fecha_result=$fecha_temp[2].'-'.$fecha_temp[1].'-'.$fecha_temp[0];
    return $fecha_result;
}

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
    print_r($aDataTableHeaderHTML);
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
        echo "$concatenar\n";
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


function analiza_archivo_presupuesto_rf($file)
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
     $monto_financiar2=$aDataTableHeaderHTML[66];
     $financiado=$aDataTableHeaderHTML[75];
     $amortizacion=$aDataTableHeaderHTML[78];
     $num_pagos=substr($aDataTableHeaderHTML[76],0,2);


     $fecha_presupuesto=obtiene_fecha($fecha_presupuesto);
     $precio_sin_iva=substr($precio_sin_iva,1,9);
     $iva=substr($iva,17,8);
     $monto_financiar=substr($monto_financiar2,16,10);
     $excedente=substr($excedente,16,7);
     $interes=substr($interes,17,8);
     $iva_interes=substr($iva_interes,16,7);
     
     $financiado=substr($financiado,17,9);
     $amortizacion=substr($amortizacion,17,6);

     
     //echo $fecha_presupuesto."\n";
     //echo $nombre_cliente."\n";
     //echo $rpu."\n";
     //echo $presupuesto."\n";
     //echo $telefono."\n";
     //echo $marca_instalar."\n";
     //echo $modelo_instalar."\n";
     //echo $capacidad_instalar."\n";
     //echo $marca_retirar."\n";
     //echo $modelo_retirar."\n";
     //echo $capacidad_retirar."\n";
     //echo $solicitud."\n";
     //echo substr($precio_sin_iva,1,9)."\n";
     //echo substr($iva,17,8)."\n";
     //echo substr($monto_financiar,1,10)."\n";
     //echo substr($excedente,16,7)."\n";
     //echo substr($interes,17,8)."\n";
     //echo substr($iva_interes,16,7)."\n"; //23
     //echo substr($financiado,17,9)."\n";  //26
     //echo substr($amortizacion,17,6)."\n"; //23
     //echo $num_pagos."\n";

     $sp="RF";
     $activo=1;
     $sql="INSERT INTO
     presupuestos (fecha,nombre,rpu,num_presupuesto,telefono,marca_ins,modelo_ins,capacidad_ins,
       marca_ret,modelo_ret,capacidad_ret,solicitud,instalacion,precio_sin_iva,iva_equipo,monto_financiar,
       excedente,interes,iva_interes,total_financiamiento,amortizacion,pagos,subprograma,activo)
     VALUES (
       '$fecha_presupuesto', '$nombre_cliente','$rpu','$presupuesto','$telefono','$marca_instalar',
       '$modelo_instalar','$capacidad_instalar','$marca_retirar','$modelo_retirar','$capacidad_retirar',
       '$solicitud','0','$precio_sin_iva','$iva','$monto_financiar','$excedente','$interes',
       '$iva_interes','$financiado','$amortizacion','$num_pagos','$sp','$activo'
     )";
        $resp=$cliente->insertar($sql);
        if($resp)
        {
            echo "Se guardo correctamente";
        }
        else{
            echo "No se pudo guardar";
        }
echo $sql;
}

function analiza_archivo_presupuesto_rf_lib($file)
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
     
     
     $fecha_presupuesto=substr($aDataTableHeaderHTML[5],23,10);
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
     $antiguedad=$aDataTableHeaderHTML[40];
     $solicitud=$aDataTableHeaderHTML[42];
     $precio_sin_iva=$aDataTableHeaderHTML[46];
     $iva=ltrim($aDataTableHeaderHTML[49]);
     $monto_financiar2=$aDataTableHeaderHTML[61];
     $excedente=$aDataTableHeaderHTML[58];
     $interes=$aDataTableHeaderHTML[64];
     $iva_interes=$aDataTableHeaderHTML[67];
     $financiado=$aDataTableHeaderHTML[70];
     $amortizacion=$aDataTableHeaderHTML[73];
     $num_pagos=substr($aDataTableHeaderHTML[71],0,2);
$fecha_presupuesto=obtiene_fecha($fecha_presupuesto);
$precio_sin_iva=substr($precio_sin_iva,1,9);
$iva=substr($iva,17,8);
$monto_financiar=substr($monto_financiar2,16,10);
$excedente=substr($excedente,16,7);
$interes=substr($interes,17,8);
$iva_interes=substr($iva_interes,16,7);
$financiado=substr($financiado,17,9);
$amortizacion=substr($amortizacion,17,6);
     //echo $fecha_presupuesto."\n";
     //echo $nombre_cliente."\n";
     //echo $rpu."\n";
     //echo $presupuesto."\n";
     //echo $telefono."\n";
     //echo $marca_instalar."\n";
     //echo $modelo_instalar."\n";
     //echo $capacidad_instalar."\n";
     //echo $marca_retirar."\n";
     //echo $modelo_retirar."\n";
     //echo $capacidad_retirar."\n";
     //echo $solicitud."\n";
     //echo $precio_sin_iva."\n";
     //echo $iva."\n";
     //echo $monto_financiar."\n";
     //echo $excedente."\n";
     //echo $interes."\n";
     //echo $iva_interes."\n"; //23
     //echo $financiado."\n";  //26
     //echo $amortizacion."\n"; //23
     //echo $num_pagos."\n";
     $sp="RF";
     $activo=1;
     $sql="INSERT INTO
     presupuestos (fecha,nombre,rpu,num_presupuesto,telefono,marca_ins,modelo_ins,capacidad_ins,
       marca_ret,modelo_ret,capacidad_ret,solicitud,instalacion,precio_sin_iva,iva_equipo,monto_financiar,
       excedente,interes,iva_interes,total_financiamiento,amortizacion,pagos,subprograma,activo)
     VALUES (
       '$fecha_presupuesto', '$nombre_cliente','$rpu','$presupuesto','$telefono','$marca_instalar',
       '$modelo_instalar','$capacidad_instalar','$marca_retirar','$modelo_retirar','$capacidad_retirar',
       '$solicitud','0','$precio_sin_iva','$iva','$monto_financiar','$excedente','$interes',
       '$iva_interes','$financiado','$amortizacion','$num_pagos','$sp','$activo'
     )";
        $resp=$cliente->insertar($sql);
        if($resp)
        {
            echo "Se guardo correctamente";
        }
        else{
            echo "No se pudo guardar";
        }
echo $sql;




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
     
     
     $fecha_presupuesto=substr($aDataTableHeaderHTML[15],6,10);
     $nombre_cliente=$aDataTableHeaderHTML[18];
     $dirección_cliente=$aDataTableHeaderHTML[20];
     $rpu=$aDataTableHeaderHTML[22];
     $telefono=$aDataTableHeaderHTML[24];
     $presupuesto=$aDataTableHeaderHTML[26];
     $marca_instalar=$aDataTableHeaderHTML[33];
     $modelo_instalar=$aDataTableHeaderHTML[34];
     $capacidad_instalar=$aDataTableHeaderHTML[35];
     $monto_financiar=$aDataTableHeaderHTML[36];
     $marca_retirar=$aDataTableHeaderHTML[44];
     $capacidad_retirar=$aDataTableHeaderHTML[45];
     $modelo_retirar=$aDataTableHeaderHTML[46];
     $solicitud=$aDataTableHeaderHTML[49];
     $instalacion=substr($aDataTableHeaderHTML[53],18,8);
     $precio_sin_iva=$aDataTableHeaderHTML[60];
     $iva=ltrim($aDataTableHeaderHTML[63]);
     $preciofinal=$aDataTableHeaderHTML[72];
     $excedente=$aDataTableHeaderHTML[75];
     $interes=$aDataTableHeaderHTML[81];
     $iva_interes=$aDataTableHeaderHTML[84];
     $financiado=$aDataTableHeaderHTML[87];
     $amortizacion=$aDataTableHeaderHTML[90];
     $num_pagos=substr($aDataTableHeaderHTML[88],0,2);
     $sp="AA";
     $activo=1;
     $solicitud=substr($presupuesto,0,10);
     $sql="INSERT INTO
     presupuestos (fecha,nombre,rpu,num_presupuesto,telefono,marca_ins,modelo_ins,capacidad_ins,
       marca_ret,modelo_ret,capacidad_ret,solicitud,instalacion,precio_sin_iva,iva_equipo,monto_financiar,
       excedente,interes,iva_interes,total_financiamiento,amortizacion,pagos,subprograma,activo)
     VALUES (
       '$fecha_presupuesto', '$nombre_cliente','$rpu','$presupuesto','$telefono','$marca_instalar',
       '$modelo_instalar','$capacidad_instalar','$marca_retirar','$modelo_retirar','$capacidad_retirar',
       '$solicitud','$instalacion','$precio_sin_iva','$iva','$preciofinal','$excedente','$interes',
       '$iva_interes','$financiado','$amortizacion','$num_pagos','$sp','$activo'
     )";
         $resp=$cliente->insertar($sql);
         if($resp)
         {
             echo "Se guardo correctamente";
         }
         else{
             echo "No se pudo guardar";
         }
         
     //echo $fecha_presupuesto."\n";
     //echo $nombre_cliente."\n";
     //echo $rpu."\n";
     //echo $presupuesto."\n";
     //echo $telefono."\n";
     //echo $marca_instalar."\n";
     //echo $modelo_instalar."\n";
     //echo $capacidad_instalar."\n";
     //echo $marca_retirar."\n";
     //echo $modelo_retirar."\n";
     //echo $capacidad_retirar."\n";
     //echo $solicitud."\n";
     //echo $precio_sin_iva."\n";
     //echo $iva."\n";
     //echo substr($instalacion,19,7)."\n";
     //echo $monto_financiar."\n";
     //echo $excedente."\n";
     //echo $preciofinal."\n";
     //echo $interes."\n";
     //echo $iva_interes."\n"; //23
     //echo $financiado."\n";  //26
     //echo $amortizacion."\n"; //23
     //echo $num_pagos."\n";


}
function analiza_archivo_presupuesto_aa_lib($file)
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
     
     
     $fecha_presupuesto=substr($aDataTableHeaderHTML[14],6,10);
     $nombre_cliente=$aDataTableHeaderHTML[17];
     $dirección_cliente=$aDataTableHeaderHTML[19];
     $rpu=$aDataTableHeaderHTML[21];
     $telefono=$aDataTableHeaderHTML[23];
     $presupuesto=$aDataTableHeaderHTML[25];
     $marca_instalar=$aDataTableHeaderHTML[34];
     $modelo_instalar=$aDataTableHeaderHTML[35];
     $capacidad_instalar=$aDataTableHeaderHTML[36];
     $monto_financiar=$aDataTableHeaderHTML[37];
     $marca_retirar=$aDataTableHeaderHTML[45];
     $capacidad_retirar=$aDataTableHeaderHTML[46];
     $modelo_retirar=$aDataTableHeaderHTML[47];
     $solicitud=$aDataTableHeaderHTML[50];
     $instalacion=substr($aDataTableHeaderHTML[54],18,8);
     $precio_sin_iva=$aDataTableHeaderHTML[61];
     $iva=ltrim($aDataTableHeaderHTML[64]);
     $preciofinal=$aDataTableHeaderHTML[73];
     $excedente=$aDataTableHeaderHTML[75];
     $interes=$aDataTableHeaderHTML[82];
     $iva_interes=$aDataTableHeaderHTML[85];
     $financiado=$aDataTableHeaderHTML[88];
     $amortizacion=$aDataTableHeaderHTML[91];
     $num_pagos=substr($aDataTableHeaderHTML[89],0,2);

     //echo $fecha_presupuesto."\n";
     //echo $nombre_cliente."\n";
     //echo $rpu."\n";
     //echo $presupuesto."\n";
     //echo $telefono."\n";
     //echo $marca_instalar."\n";
     //echo $modelo_instalar."\n";
     //echo $capacidad_instalar."\n";
     //echo $marca_retirar."\n";
     //echo $modelo_retirar."\n";
     //echo $capacidad_retirar."\n";
     //echo $solicitud."\n";
     //echo $precio_sin_iva."\n";
     //echo $iva."\n";
     //echo substr($instalacion,19,7)."\n";
     //echo $monto_financiar."\n";
     //echo $excedente."\n";
     //echo $preciofinal."\n";
     //echo $interes."\n";
     //echo $iva_interes."\n"; //23
     //echo $financiado."\n";  //26
     //echo $amortizacion."\n"; //23
     //echo $num_pagos."\n";
     $sp="AA";
     $activo=1;
     $solicitud=substr($presupuesto,0,10);
     $sql="INSERT INTO
     presupuestos (fecha,nombre,rpu,num_presupuesto,telefono,marca_ins,modelo_ins,capacidad_ins,
       marca_ret,modelo_ret,capacidad_ret,solicitud,instalacion,precio_sin_iva,iva_equipo,monto_financiar,
       excedente,interes,iva_interes,total_financiamiento,amortizacion,pagos,subprograma,activo)
     VALUES (
       '$fecha_presupuesto', '$nombre_cliente','$rpu','$presupuesto','$telefono','$marca_instalar',
       '$modelo_instalar','$capacidad_instalar','$marca_retirar','$modelo_retirar','$capacidad_retirar',
       '$solicitud','$instalacion','$precio_sin_iva','$iva','$preciofinal','$excedente','$interes',
       '$iva_interes','$financiado','$amortizacion','$num_pagos','$sp','$activo'
     )";
        $resp=$cliente->insertar($sql);
        if($resp)
        {
            echo "Se guardo correctamente";
        }
        else{
            echo "No se pudo guardar";
        }
echo $sql;
}
function cargas_presupuestos()
{
    $consulta=new cliente();
    //$sql="select solicitud,subprograma,rpu  from colocadas_sia where id_estatus in ('INE','IMP','PIN','PEX','REX','PSU','PLI')";
    $sql="select afectan_presupuesto.solicitud,afectan_presupuesto.subprograma,afectan_presupuesto.rpu,
    presupuestos.solicitud as credito,afectan_presupuesto.id_estatus
     from afectan_presupuesto left join
    presupuestos on afectan_presupuesto.solicitud=presupuestos.solicitud
    and afectan_presupuesto.id_estatus in ('INE','IMP','PIN','PEX','REX','PSU','PLI','LSC')";
    $solicitud=$consulta->listado($sql);
    foreach($solicitud as $row){
        // Si es solicitud de RF
   
        $archivo="presupuestos/".$row['solicitud'].".html";
       if($row['credito']=="" and $row['id_estatus']<>'LSC')
       {
            switch($row['subprograma']){
                case 'RF': 
                {
                    analiza_archivo_presupuesto_rf($archivo);
                 
                    break;
                }
                case 'AA':
                {
                    analiza_archivo_presupuesto_aa($archivo);
                    break;
                }
    
            }
        }
        else
        {
            switch($row['subprograma']){
                case 'RF': 
                {
                    analiza_archivo_presupuesto_rf_lib($archivo);
                 
                    break;
                }
                case 'AA':
                {
                    analiza_archivo_presupuesto_aa_lib($archivo);
                    break;
                }
    
            }
        }    
     
    
    }

}
function actualiza_afectan_presupuesto()
{
    $solicitudes=new cliente();
    $sql="UPDATE presupuestos SET estatus = (select colocadas_sia.id_estatus
    from colocadas_sia where presupuestos.solicitud=colocadas_sia.solicitud)";
    // actualiza los estatus de las solicitudes en los presupuestos
    $resultado=$solicitudes->modificar($sql);

    // actualiza si afecta o no el presupuesto
    $sql="update presupuestos set presupuestos.activo=0 where
    presupuestos.estatus not in ('INE','IMP','PIN','PEX','REX','PSU','PLI','LSC')";
    $resultado=$solicitudes->modificar($sql);

}



//analiza_archivo_presupuesto_aa_lib("presupuestos/QR000071-2.html");
//analiza_archivo_presupuesto_aa("presupuestos/YU000111-1.html");
//analiza_archivo_colocadas("paginas/colocadas_septiembre.html");
//analiza_archivo_colocadas("paginas/colocadas_octubre.html");
//analiza_archivo_colocadas("paginas/colocadas_noviembre.html");
//analiza_archivo_colocadas("paginas/colocadas_diciembre.html");

//analiza_archivo_presupuesto_rf("presupuestos/QR000039-4.html");
//cargas_presupuestos();
actualiza_afectan_presupuesto();
?>