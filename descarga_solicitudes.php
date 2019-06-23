<?php
require_once("funciones_curl.php");
require("cliente.php");


function descarga_archivo_sindata($url_login,$data_login,$url_archivo,$nombre_archivo)
{
    login($url_login,$data_login);
    grab_page("http://www.programaasibc.com.mx/siaMexicali/index.php");
    guardar_pagina($url_archivo,$nombre_archivo);

}

function descarga_archivo_condata($url_login,$data_login,$url_archivo,$data_archivo,$nombre_archivo)
{
    login($url_login,$data_login);
    grab_page("http://www.programaasibc.com.mx/siaMexicali/index.php");
    guardar_pagina_data($url_archivo,$nombre_archivo,$data_archivo);

}

function analiza_archivo_solicitud($file)
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
     $nombre_cliente=$aDataTableHeaderHTML[35];
     $rfc_cliente=$aDataTableHeaderHTML[37];
     $curp_cliente=$aDataTableHeaderHTML[39];
     $dirección_cliente=$aDataTableHeaderHTML[41];
     $colonia_cliente=$aDataTableHeaderHTML[43];
     $tel_casa_cliente=$aDataTableHeaderHTML[45];
     $tel_ofi_cliente=$aDataTableHeaderHTML[47];
     $tel_cel_cliente=$aDataTableHeaderHTML[49];

     $empresa_cliente=$aDataTableHeaderHTML[76];
     $puesto_empresa_cliente=$aDataTableHeaderHTML[78];
     $direccion_empresa_cliente=$aDataTableHeaderHTML[80];



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

 /* function descarga_presupuestos()
{
    $login="http://www.programaasibc.com.mx/siaMexicali/validausuario.php";
    $data_login="usuario=md032ca&clave=md032ca&tipo=1";
    $consulta=new cliente();
    $sql="select solicitud,subprograma,rpu  from colocadas_sia where id_estatus in ('INE','IMP','PIN','PEX','REX','PSU','PLI','LSC')";
    $solicitud=$consulta->listado($sql);
    foreach($solicitud as $row){
        // Si es solicitud de RF
        $soli1=substr($row['solicitud'],0,8);
        $soli2=substr($row['solicitud'],9,2);
        $url_extra="ns=$soli1&nsx=$soli2";
        $archivo="presupuestos/".$row['solicitud'].".html";
       
        switch($row['subprograma']){
            case 'RF': 
            {
                $url="http://www.programaasibc.com.mx/siaMexicali/presup_refri.php?$url_extra";
                descarga_archivo_sindata($login,$data_login,$url,$archivo);
                break;
            }
            case 'AA':
            {
                $url="http://www.programaasibc.com.mx/siaMexicali/presup_equipo.php?$url_extra";
                descarga_archivo_sindata($login,$data_login,$url,$archivo);
                break;
            }

        }
     
    
    }


} */ //descarga_presupuestos();


$login="http://www.programaasibc.com.mx/siaMexicali/validausuario.php";
$data_login="usuario=md032ca&clave=md032ca&tipo=1";
//

descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/contratos/ImpresionSol.php?tabla=1&fecha_supervision=&solicitud=YU000015&solixtra=2","paginas/solicitud_yu000015-2.html");
analiza_archivo_solicitud("paginas/solicitud_yu000015-2.html");

//descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/consolusu.php?fi=2019-05-01&ff=2019-05-31&tip=men&en=5","paginas/colocadas_mayo.html");
//descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/consolusu.php?fi=2019-04-01&ff=2019-04-31&tip=men&en=4","paginas/colocadas_abril.html");
//descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/consolusu.php?fi=2019-03-01&ff=2019-03-31&tip=men&en=3","paginas/colocadas_marzo.html");
//descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/consolusu.php?fi=2019-06-01&ff=2019-06-31&tip=men&en=6","paginas/colocadas_junio.html");


//Descargar liberaciones de diversos reportes

//Liberaciones reporte contabilidad 
//descarga_archivo_condata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/liberacion/reportes/liberaciones_Conta.php","Cual=-1&idCoordinacion=-1&idDistribuidor=-1&pdto=10&orderby=1&fechaInicial=2018-09-01&model=1&xml=0&fechaFinal=2019-12-31","paginas/liberacionesconta.html");
/*
//Liberaciones reporte tecnico 
*/
//descarga_archivo_condata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/liberacion/reportes/liberaciones2.php","Cual=&idCoordinacion=-1&equipo=-1&idDistribuidor=-1&pdto=10&orderby=1&fechaLib=2018-09-01&model=1&xml=1&fechaInicial=2018-09-01&fechaFinal=2019-12-31&dAtencion=1","paginas/liberaciones_tec.html");



?>