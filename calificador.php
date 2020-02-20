<?php

require_once("funciones_curl.php");
require("cliente.php");

//sql a usar SELECT rpu FROM clientes WHERE cve_municipio LIKE 'Y036'
function descarga_archivo_sindata($url_login,$data_login,$url_archivo,$nombre_archivo)
{
    login($url_login,$data_login);
    grab_page("http://www.programaasi.mx/siaMexicali/index.php");
    guardar_pagina($url_archivo,$nombre_archivo);

}


function descarga_potenciales($municipio)
{
    $login="http://www.programaasi.mx/siaMexicali/validausuario.php";
    $data_login="usuario=md032ca&clave=md032ca&tipo=1";
    $consulta=new cliente();
    $sql="SELECT rpu FROM CFE.clientes WHERE cve_municipio LIKE '$municipio'";
    $solicitud=$consulta->listado($sql);
    foreach($solicitud as $row){
        $archivo="potenciales/".$row['rpu'].".html";
        $rpu=$row['rpu'];
        $url="http://www.programaasi.mx/siaMexicali/registro/procesaws.php?RPU=$rpu";
        descarga_archivo_sindata($login,$data_login,$url,$archivo);
        echo "Guardado con exito \n";
    }

}


function analisis_potenciales($rpu)
{
        $consulta=new cliente(); 
        $file="potenciales/$rpu.html";
         $htmlContent="";
         $htmlContent=file_get_contents($file);
         $DOM=new DOMDocument();
         //echo $htmlContent;
         @$DOM->loadHTML($htmlContent);
         $Header = $DOM->getElementsByTagName('td');
         $Detail = $DOM->getElementsByTagName('td');
         foreach($Header as $NodeHeader)
         {
            $aDataTableHeaderHTML[]=trim($NodeHeader->textContent);
            
         }

          $buen_pagador=$aDataTableHeaderHTML[7];
          $cumple_aa=$aDataTableHeaderHTML[16];
          $cumple_rf=$aDataTableHeaderHTML[20];
          $cumple_at=$aDataTableHeaderHTML[18];
          $fecha_alta=$aDataTableHeaderHTML[23];
          $anios_servicio=$aDataTableHeaderHTML[25];
          $sql="";
          $sql="insert into CFE.calificados(rpu,buen_pago,AA,RF,AT,fecha_alta,anios_servicio) values ('$rpu','$buen_pagador','$cumple_aa','$cumple_rf','$cumple_at','$fecha_alta','$anios_servicio')";
          $resp=$consulta->insertar($sql);
          if($resp)
          {
              echo "Se guardo correctamente";
          }
          else{
              echo "No se pudo guardar";
          }
          echo " - $sql \n";

}

function analiza_potenciales($cve_municipio)
{
    $consulta=new cliente();
    $sql="SELECT rpu FROM CFE.clientes WHERE cve_municipio LIKE '$cve_municipio'";
    $solicitud=$consulta->listado($sql);
    foreach($solicitud as $row){
        $rpu=$row['rpu'];
        analisis_potenciales($rpu);
        //  $file="potenciales/$rpu.html";
        //  $htmlContent="";
        //  $htmlContent=file_get_contents($file);
        //  $DOM=new DOMDocument();
        //  //echo $htmlContent;
        //  @$DOM->loadHTML($htmlContent);
        //  $Header = $DOM->getElementsByTagName('td');
        //  $Detail = $DOM->getElementsByTagName('td');
        //  foreach($Header as $NodeHeader)
        //  {
        //     $aDataTableHeaderHTML[]=trim($NodeHeader->textContent);
            
        //  }

        //   $buen_pagador=$aDataTableHeaderHTML[7];
        //   $cumple_aa=$aDataTableHeaderHTML[16];
        //   $cumple_rf=$aDataTableHeaderHTML[20];
        //   $cumple_at=$aDataTableHeaderHTML[18];
        //   $fecha_alta=$aDataTableHeaderHTML[23];
        //   $anios_servicio=$aDataTableHeaderHTML[25];
        //   $sql="";
        //   $sql="insert into CFE.calificados(rpu,buen_pago,AA,RF,AT,fecha_alta,anios_servicio) values ('$rpu','$buen_pagador','$cumple_aa','$cumple_rf','$cumple_at','$fecha_alta','$anios_servicio')";
        //   $resp=$consulta->insertar($sql);
        //   if($resp)
        //   {
        //       echo "Se guardo correctamente";
        //   }
        //   else{
        //       echo "No se pudo guardar";
        //   }
        //   echo " - $sql \n";

          


    }

}

// //analiza potenciales
// $rpu="807010100438";
// $file="potenciales/$rpu.html";
// $htmlContent=file_get_contents($file);
// $DOM=new DOMDocument();
// //echo $htmlContent;
// @$DOM->loadHTML($htmlContent);
// $Header = $DOM->getElementsByTagName('td');
// $Detail = $DOM->getElementsByTagName('td');
// foreach($Header as $NodeHeader)
// {
//    $aDataTableHeaderHTML[]=trim($NodeHeader->textContent);
   
// }
// //print_r($aDataTableHeaderHTML);
// $buen_pagador=$aDataTableHeaderHTML[7];
// $cumple_aa=$aDataTableHeaderHTML[16];
// $cumple_rf=$aDataTableHeaderHTML[20];
// $cumple_at=$aDataTableHeaderHTML[18];
// $fecha_alta=$aDataTableHeaderHTML[23];
// $anios_servicio=$aDataTableHeaderHTML[25];

// echo "1. $buen_pagador\n";
// echo "AA .$cumple_aa\n";
// echo "RF .$cumple_rf\n";
// echo "AT .$cumple_at\n";
// echo "Fecha alta .$fecha_alta\n";
// echo "Anios .$anios_servicio\n";

// $sql="insert into cfe.calificados(rpu,buen_pago,AA,RF,AT,fecha_alta,anios_servicio) values 
// ('$rpu','$buen_pagador','$cumple_aa','$cumple_rf','$cumple_at','$fecha_alta','$anios_servicio')";
// echo $sql;
descarga_potenciales('Y052');
analiza_potenciales('Y052');

?>