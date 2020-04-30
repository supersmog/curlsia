<?php

//require("cliente.php");
require("descarga_archivos.php");

function descarga_presupuestos()
{
    $login="http://www.programaasi.mx/siaMexicali/validausuario.php";
    $data_login="usuario=md032ca&clave=md032ca&tipo=1";
    $consulta=new cliente();
    //$sql="select solicitud,subprograma,rpu  from colocadas_sia where id_estatus in ('INE','IMP','PIN','PEX','REX','PSU','PLI','LSC')";
    $sql="select solicitud,subprograma,rpu from  afectan_presupuesto
    where not exists(select 1 from presupuestos where
    afectan_presupuesto.solicitud=presupuestos.solicitud
    and afectan_presupuesto.id_estatus in ('INE','IMP','PIN','PEX','REX','PSU','PLI','LSC'))";
    $solicitud=$consulta->listado($sql);
    foreach($solicitud as $row){
        // Si es solicitud de RF
        $soli1=substr($row['solicitud'],0,8);
        $soli2=substr($row['solicitud'],9,2);
        $url_extra="ns=$soli1&nsx=$soli2";
        $archivo="presupuestos/".$row['solicitud'].".html";
      
        
        for ($x = 1; $x<=3; $x++){
            echo "valor $x";
            switch($x)
            {
                case 1: // Refrigerador
                    {
                        $url="http://www.programaasi.mx/siaMexicali/presup_refri.php?$url_extra";
                        descarga_archivo_sindata($login,$data_login,$url,$archivo);
                        if(filesize($archivo)>617)
                        {
                            echo "Guardado RF";
                            $x=4;
        
                        }
                    break;
        
                    }
                case 2: //Aire Acondicionado
                    {
                        $url="http://www.programaasi.mx/siaMexicali/presup_equipo.php?$url_extra";
                        descarga_archivo_sindata($login,$data_login,$url,$archivo);
                        if(filesize($archivo)>649)
                            {
                                echo "Guardado AA\n";
                                $x=4;
            
                            }
                        break;
        
                    }
                case 3: //LED Lavadoras Fotovoltaicos
                    {
                        $url="http://www.programaasi.mx/siaMexicali/presup_programas.php?$url_extra";
                        descarga_archivo_sindata($login,$data_login,$url,$archivo);
                        if(filesize($archivo)>617)
                            {
                                echo "Guardado FT,LD,LV\n";
                                $x=4;
            
                            }
                        break;
        
        
                    }
                    
        
            }
        


    //    //intenta descargar de RF
    //    $url="http://www.programaasi.mx/siaMexicali/presup_refri.php?$url_extra";
    //    descarga_archivo_sindata($login,$data_login,$url,$archivo);
    //    $tamanio=filesize($archivo);
    //    if($tamanio>617)
    //    {
    //        echo "Descarga correcta";
    //    }
    //   

     
    
    }


    }
}
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
    //echo count($aDataTableHeaderHTML);
    $totalfilas2=count($aDataTableHeaderHTML)-10;
    $total_filas=$aDataTableHeaderHTML[$totalfilas2];
    //echo $totalfilas3;
   //   
   // $total_filas=$aDataTableHeaderHTML[10];
    //$total_filas=288;
    echo $total_filas;
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
       // echo "$concatenar\n";
        $sql="insert into colocadas_sia_tmp (solicitud, fecha_registro, subprograma, id_estatus, rpu, nombre, colonia, direccion, id_proveedor) values(".$concatenar.")";
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
     $bonificacion=$aDataTableHeaderHTML[66];
     $interes=$aDataTableHeaderHTML[72];
     $iva_interes=$aDataTableHeaderHTML[75];
     $monto_financiar2=$aDataTableHeaderHTML[69];
     $financiado=$aDataTableHeaderHTML[78];
     $amortizacion=$aDataTableHeaderHTML[81];
     $num_pagos=substr($aDataTableHeaderHTML[79],0,2);
     $fecha_presupuesto=obtiene_fecha($fecha_presupuesto);
     $precio_sin_iva=substr($precio_sin_iva,1,9);
     $iva=substr($iva,17,8);
     $monto_financiar=substr($monto_financiar2,16,10);
     $excedente=substr($excedente,16,7);
     $interes=substr($interes,17,8);
     $iva_interes=substr($iva_interes,16,7);
     $financiado=substr($financiado,17,9);
     $amortizacion=substr($amortizacion,17,6);

     


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

/*
PR=Refrigerador
PS=Aire Acondicionado
PL=LED
PO=Lavadora
PF=Fotovotaico
*/ 

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
     $bonificacion=$aDataTableHeaderHTML[61];
     $monto_financiar2=$aDataTableHeaderHTML[64];
     $excedente=$aDataTableHeaderHTML[58];
     $interes=$aDataTableHeaderHTML[67];
     $iva_interes=$aDataTableHeaderHTML[70];
     $financiado=$aDataTableHeaderHTML[73];
     $amortizacion=$aDataTableHeaderHTML[76];
     $num_pagos=substr($aDataTableHeaderHTML[74],0,2);
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
     //print_r($aDataTableHeaderHTML);
     
     
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
     //print_r($aDataTableHeaderHTML);
     
     
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
//echo $sql;
}
function vaciar_colocadas($fecha)
{
    $consulta=new cliente();
    //vaciamos la tabla
    $sql="delete  from colocadas_sia  where fecha_registro>'$fecha'";
    echo $sql;
    $elimina=$consulta->eliminar($sql);
    echo "Eliminados despues de $fecha";
}
function vaciar_colocadas_antiguas($fecha)
{
    $consulta=new cliente();
    //vaciamos la tabla
    $sql="delete  from colocadas_sia  where fecha_registro<'$fecha'";
    echo $sql;
    $elimina=$consulta->eliminar($sql);
    echo "Eliminados despues de $fecha";
}

function vaciar_colocadas_tmp()
{
    $solicitudes=new cliente();
    $sql="TRUNCATE `colocadas_sia_tmp`";
    $resultado=$solicitudes->eliminar($sql);
    echo "registros eliminados";
}
function cargas_presupuestos()
{
    $consulta=new cliente();
   //vaciamos la tabla
   //$sql="delete  from colocadas_sia  where fecha_registro>'2018-10-31'";
   //$elimina=$consulta->eliminar($sql);


 $sql="select * from  afectan_presupuesto
    where not exists(select 1 from presupuestos where
    afectan_presupuesto.solicitud=presupuestos.solicitud
    and afectan_presupuesto.id_estatus in ('INE','IMP','PIN','PEX','REX','PSU','PLI','LSC'))";

    $solicitud=$consulta->listado($sql);
    foreach($solicitud as $row){
        // Si es solicitud de RF
   
        $archivo="presupuestos/".$row['solicitud'].".html";
       if($row['id_estatus']<>'LSC')
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
function actualiza_colocadas_sia()
{
    $solicitudes=new cliente();

    
    
    // Inserta los nuevos registros diarios
    $sql="INSERT INTO colocadas_sia (solicitud, fecha_registro, subprograma, id_estatus, rpu, nombre, colonia, direccion, id_proveedor)
    SELECT solicitud, fecha_registro, subprograma, id_estatus, rpu, nombre, colonia, direccion, id_proveedor FROM colocadas_sia_tmp WHERE NOT EXISTS 
    (SELECT 1 FROM colocadas_sia WHERE colocadas_sia.solicitud = colocadas_sia_tmp.solicitud)";
    $resultado=$solicitudes->modificar($sql);

    //Actualiza los estatus de las solicitudes diarias
    $sql="UPDATE colocadas_sia SET id_estatus=(SELECT colocadas_sia_tmp.id_estatus
    from colocadas_sia_tmp where colocadas_sia.solicitud=colocadas_sia_tmp.solicitud)";
    $resultado=$solicitudes->modificar($sql);
    


}




vaciar_colocadas_tmp();
analiza_archivo_colocadas("paginas/colocadas_enero.html");  
analiza_archivo_colocadas("paginas/colocadas_febrero.html");  
analiza_archivo_colocadas("paginas/colocadas_marzo.html");
analiza_archivo_colocadas("paginas/colocadas_abril.html");
 analiza_archivo_colocadas("paginas/colocadas_mayo.html"); 
 analiza_archivo_colocadas("paginas/colocadas_junio.html");
 analiza_archivo_colocadas("paginas/colocadas_julio.html");
 analiza_archivo_colocadas("paginas/colocadas_agosto.html");
 analiza_archivo_colocadas("paginas/colocadas_septiembre.html");
 analiza_archivo_colocadas("paginas/colocadas_octubre.html");
 analiza_archivo_colocadas("paginas/colocadas_noviembre.html");
 analiza_archivo_colocadas("paginas/colocadas_diciembre.html");
//analiza_archivo_colocadas("paginas/colocadas_enero_20.html");  
//analiza_archivo_colocadas("paginas/colocadas_febrero_20.html"); 
actualiza_colocadas_sia();


// $login="http://www.programaasi.mx/siaMexicali/validausuario.php";
// $data_login="usuario=md032ca&clave=md032ca&tipo=1";
// $url_extra="ns=YU001524&nsx=1";
// $archivo="presupuestos/YU001524-1.html";

// //intenta descargar de RF
// $url="http://www.programaasi.mx/siaMexicali/presup_refri.php?$url_extra";
// descarga_archivo_sindata($login,$data_login,$url,$archivo);
// $tamanio=filesize($archivo);
// if($tamanio>617)
// {
//     echo "Descarga correcta y $tamanio";
// }

 //descarga_presupuestos();
// cargas_presupuestos();
// actualiza_afectan_presupuesto();
//analiza_archivo_presupuesto_rf_lib("presupuestos/ML000303-1.html");
?>