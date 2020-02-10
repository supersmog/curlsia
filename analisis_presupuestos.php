<?php
require_once("funciones_curl.php");

function descarga_archivo_sindata($url_login,$data_login,$url_archivo,$nombre_archivo)
{
    login($url_login,$data_login);
    grab_page("http://www.programaasi.mx/siaMexicali/index.php");
    guardar_pagina($url_archivo,$nombre_archivo);

}

function descarga_archivo_condata($url_login,$data_login,$url_archivo,$data_archivo,$nombre_archivo)
{
    login($url_login,$data_login);
    grab_page("http://www.programaasi.mx/siaMexicali/index.php");
    guardar_pagina_data($url_archivo,$nombre_archivo,$data_archivo);

}

$login="http://www.programaasi.mx/siaMexicali/validausuario.php";
$data_login="usuario=md032ca&clave=md032ca&tipo=1";
$url_extra="ns=ML000270&nsx=2";
$archivo="presupuestos/ml000270-2.html";

//intenta descargar de RF

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


}

// switch($intentos)
// {
//     case 1:
//         {
//             //intenta descargar como RF
//             $url="http://www.programaasi.mx/siaMexicali/presup_refri.php?$url_extra";
//             descarga_archivo_sindata($login,$data_login,$url,$archivo);
//             if($tamanio=filesize($archivo)>617)
//             {

//             }
            
//         }
// }

// $url="http://www.programaasi.mx/siaMexicali/presup_refri.php?$url_extra";
// descarga_archivo_sindata($login,$data_login,$url,$archivo);
// $tamanio=filesize($archivo);
// if($tamanio>617)
// {
//     echo "Descarga correcta y $tamanio";
//     $break;
// }
// else
// {
//     //descarga nuevos subprogramas
//     $url="http://www.programaasi.mx/siaMexicali/presup_programas.php?$url_extra";


// }




?>