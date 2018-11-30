<?php
require_once("funciones_curl.php");
require("cliente.php");


function descarga_archivo($url_login,$url_archivo,$data_login,$data_archivo,$nombre_archivo)
{
    login($url,$data);
    grab_page("http://www.programaasibc.com.mx/siaMexicali/index.php");
    guardar_pagina($url_archivo,$nombre_archivo);

}

function analiza_archivo2($file)
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



?>