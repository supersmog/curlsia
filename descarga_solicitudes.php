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

function descarga_solicitudes()
{
    $login="http://www.programaasibc.com.mx/siaMexicali/validausuario.php";
    $data_login="usuario=md032ca&clave=md032ca&tipo=1";
    $consulta=new cliente();
        $sql="select solicitud,subprograma,rpu from  afectan_presupuesto
    where not exists(select 1 from solicitudes_registro where
    afectan_presupuesto.solicitud=solicitudes_registro.solicitud
    and afectan_presupuesto.id_estatus in ('IMP','PIN','PEX','REX','PSU','PLI','LSC'))";
    $solicitud=$consulta->listado($sql);
    foreach($solicitud as $row){
        // Si es solicitud de RF
        $soli1=substr($row['solicitud'],0,8);
        $soli2=substr($row['solicitud'],9,2);
        $url_extra="solicitud=$soli1&solixtra=$soli2";
        $archivo="registros/".$row['solicitud'].".html";
        $url="http://www.programaasibc.com.mx/siaMexicali/contratos/ImpresionSol.php?tabla=1&fecha_supervision=&$url_extra";
        descarga_archivo_sindata($login,$data_login,$url,$archivo);
  
    
    }


}

function analiza_archivo_solicitud($file,$solicitud)
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
     $telefono_empresa_cliente=$aDataTableHeaderHTML[82];
     $nombre_referencia1=$aDataTableHeaderHTML[86];
     $parentesco_referencia1=$aDataTableHeaderHTML[88];
     $direccion_referencia1=$aDataTableHeaderHTML[90];
     $telefono_referencia1=$aDataTableHeaderHTML[92];
     $nombre_referencia2=$aDataTableHeaderHTML[96];
     $parentesco_referencia2=$aDataTableHeaderHTML[98];
     $direccion_referencia2=$aDataTableHeaderHTML[100];
     $telefono_referencia2=$aDataTableHeaderHTML[102];
     $nombre_aval=$aDataTableHeaderHTML[122];
     $rfc_aval=$aDataTableHeaderHTML[124];
     $curp_aval=$aDataTableHeaderHTML[126];
     $direccion_aval=$aDataTableHeaderHTML[128];
     $colonia_aval=$aDataTableHeaderHTML[130];
     $telefono_aval=$aDataTableHeaderHTML[132];

     echo "###Datos Cliente##\n";
     echo "$nombre_cliente\n";
     echo "$rfc_cliente\n";
     echo "$curp_cliente\n";
     echo "$dirección_cliente\n";
     echo "$colonia_cliente\n";
     echo "$tel_casa_cliente\n";
     echo "$tel_ofi_cliente\n";
     echo "$tel_cel_cliente\n";
     echo "###Trabajo Cliente##\n";
     echo "$empresa_cliente\n";
     echo "$puesto_empresa_cliente\n";
     echo "$direccion_empresa_cliente\n";
     echo "$telefono_empresa_cliente\n";
     echo "###Referencia1 Cliente##\n";
     echo "$nombre_referencia1\n";
     echo "$parentesco_referencia1\n";
     echo "$direccion_referencia1\n";
     echo "$telefono_referencia1\n";
     echo "###Referencia2 Cliente##\n";
     echo "$nombre_referencia2\n";
     echo "$parentesco_referencia2\n";
     echo "$direccion_referencia2\n";
     echo "$telefono_referencia2\n";
     echo "###Aval Cliente##\n";
     echo "$nombre_aval\n";
     echo "$rfc_aval\n";
     echo "$curp_aval\n";
     echo "$direccion_aval\n";
     echo "$colonia_aval\n";
     echo "$telefono_aval\n";


 $sql="INSERT INTO yucatan.solicitudes_registro
 (solicitud, nombre_cliente, rfc_cliente, curp_cliente, direccion_cliente, colonia_cliente, 
 tel_casa_cliente, tel_ofi_cliente, tel_cel_cliente, trabajo_cliente, puesto_cliente, direccion_empresa_cliente, 
 tel_empresa_cliente, nombre_referencia1, parentesco_referencia1, direccion_referencia1, telefono_referencia1,
 nombre_referencia2, parentesco_referencia, direccion_referencia2, telefono_referencia2, nombre_aval, 
 rfc_aval, curp_aval, direccion_aval, colonia_aval, telefono_aval)
 VALUES('$solicitud','$nombre_cliente','$rfc_cliente','$curp_cliente', '$dirección_cliente','$colonia_cliente',
 '$tel_casa_cliente','$tel_ofi_cliente', '$tel_cel_cliente', '$empresa_cliente','$puesto_empresa_cliente','$direccion_empresa_cliente', 
 '$telefono_empresa_cliente','$nombre_referencia1','$parentesco_referencia1','$direccion_referencia1','$telefono_referencia1',
 '$nombre_referencia2','$parentesco_referencia2','$direccion_referencia2','$telefono_referencia2','$nombre_aval',
 '$rfc_aval','$curp_aval','$direccion_aval','$colonia_aval','$telefono_aval')";
 //echo $sql;

        $resp=$cliente->insertar($sql);
        if($resp)
        {
            echo "Se guardo correctamente";
        }
        else{
            echo "No se pudo guardar";
        }

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


function cargas_solicitudes()
{
    $consulta=new cliente();
   //vaciamos la tabla
   //$sql="delete  from colocadas_sia  where fecha_registro>'2018-10-31'";
   //$elimina=$consulta->eliminar($sql);


   $sql="select solicitud,subprograma,rpu from  afectan_presupuesto
   where not exists(select 1 from solicitudes_registro where
   afectan_presupuesto.solicitud=solicitudes_registro.solicitud
   and afectan_presupuesto.id_estatus in ('IMP','PIN','PEX','REX','PSU','PLI','LSC'))";

    $solicitud=$consulta->listado($sql);
    foreach($solicitud as $row){
        // Si es solicitud de RF
   
        $archivo="registros/".$row['solicitud'].".html";
        analiza_archivo_solicitud($archivo,$row['solicitud']);



    
    }

}

//$login="http://www.programaasibc.com.mx/siaMexicali/validausuario.php";
//$data_login="usuario=md032ca&clave=md032ca&tipo=1";
//////

//descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/contratos/ImpresionSol.php?tabla=1&fecha_supervision=&solicitud=YU001014&solixtra=1","paginas/solicitud_YU001014-1.html");
//descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/contratos/ImpresionSol.php?tabla=1&fecha_supervision=&solicitud=YU001013&solixtra=1","paginas/solicitud_YU001012-1.html");
//analiza_archivo_solicitud("paginas/solicitud_YU001014-1.html","YU001014-1");
//analiza_archivo_solicitud("paginas/solicitud_YU00101-1.html","YU00101-1");
descarga_solicitudes();
cargas_solicitudes();


?>