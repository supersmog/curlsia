<?php
require_once("funciones_curl.php");
require("cliente.php");


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


$login="http://www.programaasi.mx/siaMexicali/validausuario.php";
$data_login="usuario=md032ca&clave=md032ca&tipo=1";
//
///** Descargar solicitudes colocadas */
////

//descarga_archivo_sindata($login,$data_login,"http://www.programaasi.mx/siaMexicali/consolusu.php?fi=2018-11-01&ff=2018-11-30&tip=men&en=11","paginas/colocadas_noviembre.html");
//descarga_archivo_sindata($login,$data_login,"http://www.programaasi.mx/siaMexicali/consolusu.php?fi=2018-12-01&ff=2018-12-31&tip=men&en=12","paginas/colocadas_diciembre.html");
descarga_archivo_sindata($login,$data_login,"http://www.programaasi.mx/siaMexicali/consolusu.php?fi=2019-01-01&ff=2019-01-31&tip=men&en=1","paginas/colocadas_enero.html");
descarga_archivo_sindata($login,$data_login,"http://www.programaasi.mx/siaMexicali/consolusu.php?fi=2019-02-01&ff=2019-02-31&tip=men&en=2","paginas/colocadas_febrero.html");
descarga_archivo_sindata($login,$data_login,"http://www.programaasi.mx/siaMexicali/consolusu.php?fi=2019-03-01&ff=2019-03-31&tip=men&en=3","paginas/colocadas_marzo.html");
descarga_archivo_sindata($login,$data_login,"http://www.programaasi.mx/siaMexicali/consolusu.php?fi=2019-04-01&ff=2019-04-31&tip=men&en=4","paginas/colocadas_abril.html");
descarga_archivo_sindata($login,$data_login,"http://www.programaasi.mx/siaMexicali/consolusu.php?fi=2019-05-01&ff=2019-05-31&tip=men&en=5","paginas/colocadas_mayo.html");
descarga_archivo_sindata($login,$data_login,"http://www.programaasi.mx/siaMexicali/consolusu.php?fi=2019-06-01&ff=2019-06-31&tip=men&en=6","paginas/colocadas_junio.html");
descarga_archivo_sindata($login,$data_login,"http://www.programaasi.mx/siaMexicali/consolusu.php?fi=2019-07-01&ff=2019-07-31&tip=men&en=7","paginas/colocadas_julio.html");
descarga_archivo_sindata($login,$data_login,"http://www.programaasi.mx/siaMexicali/consolusu.php?fi=2019-08-01&ff=2019-08-31&tip=men&en=8","paginas/colocadas_agosto.html");
descarga_archivo_sindata($login,$data_login,"http://www.programaasi.mx/siaMexicali/consolusu.php?fi=2019-09-01&ff=2019-09-30&tip=men&en=9","paginas/colocadas_septiembre.html");
descarga_archivo_sindata($login,$data_login,"http://www.programaasi.mx/siaMexicali/consolusu.php?fi=2019-10-01&ff=2019-10-31&tip=men&en=10","paginas/colocadas_octubre.html");
descarga_archivo_sindata($login,$data_login,"http://www.programaasi.mx/siaMexicali/consolusu.php?fi=2019-11-01&ff=2019-11-31&tip=men&en=11","paginas/colocadas_noviembre.html");
descarga_archivo_sindata($login,$data_login,"http://www.programaasi.mx/siaMexicali/consolusu.php?fi=2019-12-01&ff=2019-12-31&tip=men&en=12","paginas/colocadas_diciembre.html");


descarga_archivo_sindata($login,$data_login,"http://www.programaasi.mx/siaMexicali/consolusu.php?fi=2019-01-01&ff=2019-01-31&tip=men&en=1","paginas/colocadas_enero_20.html");
descarga_archivo_sindata($login,$data_login,"http://www.programaasi.mx/siaMexicali/consolusu.php?fi=2019-02-01&ff=2019-02-31&tip=men&en=2","paginas/colocadas_febrero_20.html");


//Descargar liberaciones de diversos reportes

//Liberaciones reporte contabilidad 
//descarga_archivo_condata($login,$data_login,"http://www.programaasi.mx/siaMexicali/liberacion/reportes/liberaciones_Conta.php","Cual=-1&idCoordinacion=-1&idDistribuidor=-1&pdto=10&orderby=1&fechaInicial=2018-09-01&model=1&xml=0&fechaFinal=2020-12-31","paginas/liberacionesconta.html");
/*
//Liberaciones reporte tecnico 
*/
//descarga_archivo_condata($login,$data_login,"http://www.programaasi.mx/siaMexicali/liberacion/reportes/liberaciones2.php","Cual=&idCoordinacion=-1&equipo=-1&idDistribuidor=-1&pdto=10&orderby=1&fechaLib=2018-09-01&model=1&xml=1&fechaInicial=2018-09-01&fechaFinal=2020-12-31&dAtencion=1","paginas/liberaciones_tec.html");
//
////reporte confirmacion de liberaciones  
// 
////Yucatan
////descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/liberacion/reportes/reporteAfectadas.php?generar=1&zona1=01&fechaInicial=2018-09-01&fechaFinal=2019-01-31&distribuidor=0&programa=0","paginas/confirma_lib_yucatan1.html");
descarga_archivo_sindata($login,$data_login,"http://www.programaasi.mx/siaMexicali/liberacion/reportes/reporteAfectadasExcel.php?fechaInicial=2018-09-01&fechaFinal=2020-12-31&zona1=01&distribuidor=0&programa=0","paginas/confirma_lib_yucatan.xls");
descarga_archivo_sindata($login,$data_login,"http://www.programaasi.mx/siaMexicali/liberacion/reportes/reporteAfectadasExcel.php?fechaInicial=2018-09-01&fechaFinal=2020-12-31&zona1=08&distribuidor=0&programa=0","paginas/confirma_lib_yucatan_motul.xls");
//
//
////Camp2ch1
////descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/liberacion/reportes/reporteAfectadas.php?generar=1&zona1=04&fechaInicial=2018-09-01&fechaFinal=2019-01-31&distribuidor=0&programa=0","paginas/confirma_lib_campeche1.html");
descarga_archivo_sindata($login,$data_login,"http://www.programaasi.mx/siaMexicali/liberacion/reportes/reporteAfectadasExcel.php?fechaInicial=2018-09-01&fechaFinal=2020-12-31&zona1=04&distribuidor=0&programa=0","paginas/confirma_lib_campeche.xls");
//
//
////Quintana 2oo1
////descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/liberacion/reportes/reporteAfectadas.php?generar=1&zona1=12&fechaInicial=2018-09-01&fechaFinal=2019-01-31&distribuidor=0&programa=0&paginaAct=1","paginas/confirma_lib_quintanaroo1.html");
descarga_archivo_sindata($login,$data_login,"http://www.programaasi.mx/siaMexicali/liberacion/reportes/reporteAfectadasExcel.php?fechaInicial=2018-09-01&fechaFinal=2020-12-31&zona1=12&distribuidor=0&programa=0","paginas/confirma_lib_quintanaroo.xls");
descarga_archivo_sindata($login,$data_login,"http://www.programaasi.mx/siaMexicali/liberacion/reportes/reporteAfectadasExcel.php?fechaInicial=2018-09-01&fechaFinal=2020-12-31&zona1=22&distribuidor=0&programa=0","paginas/confirma_lib_quintanaroorv.xls");
//
//
//
////  Reporte de liberaciones simple
//
// //Yucatan
////descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/liberacion/reportes/liberacion.php?generar=1&zona1=01&fechaInicial=2018-09-01&fechaFinal=2019-01-31","paginas/liberaciones_simple_yucatan.html");
descarga_archivo_sindata($login,$data_login,"www.programaasi.mx/siaMexicali/liberacion/reportes/liberacion(Excel).php?fechaInicial=2018-09-01&fechaFinal=2020-12-31&zona1=01","paginas/liberaciones_simple_yucatan.xls");
descarga_archivo_sindata($login,$data_login,"www.programaasi.mx/siaMexicali/liberacion/reportes/liberacion(Excel).php?fechaInicial=2018-09-01&fechaFinal=2020-12-31&zona1=08","paginas/liberaciones_simple_yucatan_motul.xls");
//
////Campeche
////descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/liberacion/reportes/liberacion.php?generar=1&zona1=04&fechaInicial=2018-09-01&fechaFinal=2019-01-31","paginas/liberaciones_simple_campeche.html");
descarga_archivo_sindata($login,$data_login,"www.programaasi.mx/siaMexicali/liberacion/reportes/liberacion(Excel).php?fechaInicial=2018-09-01&fechaFinal=2020-12-31&zona1=04","paginas/liberaciones_simple_campeche.xls");
//
////Quintana Roo
///descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/liberacion/reportes/liberacion.php?generar=1&zona1=12&fechaInicial=2018-09-01&fechaFinal=2019-01-31","paginas/liberaciones_simple_quintanaroo.html");
descarga_archivo_sindata($login,$data_login,"www.programaasi.mx/siaMexicali/liberacion/reportes/liberacion(Excel).php?fechaInicial=2018-09-01&fechaFinal=2020-12-31&zona1=12","paginas/liberaciones_simple_quintanaroo.xls");
//
////  Reporte de liberaciones descarga PA
//
////Yucatan
//***********descarga_archivo_sindata($login,$data_login,"http://www.programaasi.mx/siaMexicali/liberacion/reportes/ReporteLiberacionesPrint.php?mes=10&anio=2019&tipounidad=0&zona=YU","paginas/liberaciones_pa_yucatan_oct.html");
// //descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/liberacion/reportes/ReporteLiberacionesPrint.php?mes=11&anio=2018&tipounidad=0&zona=YU","paginas/liberaciones_pa_yucatan_nov.html");
// //descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/liberacion/reportes/ReporteLiberacionesPrint.php?mes=12&anio=2018&tipounidad=0&zona=YU","paginas/liberaciones_pa_yucatan_dic.html");
// //descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/liberacion/reportes/ReporteLiberacionesPrint.php?mes=01&anio=2019&tipounidad=0&zona=YU","paginas/liberaciones_pa_yucatan_ene.html");
 //descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/liberacion/reportes/ReporteLiberacionesPrint.php?mes=02&anio=2019&tipounidad=0&zona=YU","paginas/liberaciones_pa_yucatan_feb.html");
 //descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/liberacion/reportes/ReporteLiberacionesPrint.php?mes=03&anio=2019&tipounidad=0&zona=YU","paginas/liberaciones_pa_yucatan_mar.html");
//Campeche
//descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/liberacion/reportes/ReporteLiberacionesPrint.php?mes=11&anio=2018&tipounidad=0&zona=CM","paginas/liberaciones_pa_campeche_nov.html");
//descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/liberacion/reportes/ReporteLiberacionesPrint.php?mes=10&anio=2018&tipounidad=0&zona=CM","paginas/liberaciones_pa_campeche_oct.html");
//descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/liberacion/reportes/ReporteLiberacionesPrint.php?mes=12&anio=2018&tipounidad=0&zona=CM","paginas/liberaciones_pa_campeche_dic.html");
//descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/liberacion/reportes/ReporteLiberacionesPrint.php?mes=01&anio=2019&tipounidad=0&zona=CM","paginas/liberaciones_pa_campeche_ene.html");
//descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/liberacion/reportes/ReporteLiberacionesPrint.php?mes=02&anio=2019&tipounidad=0&zona=CM","paginas/liberaciones_pa_campeche_feb.html");
//descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/liberacion/reportes/ReporteLiberacionesPrint.php?mes=03&anio=2019&tipounidad=0&zona=CM","paginas/liberaciones_pa_campeche_mar.html");

//Quintana Roo
//descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/liberacion/reportes/ReporteLiberacionesPrint.php?mes=10&anio=2018&tipounidad=0&zona=QR","paginas/liberaciones_pa_quintanaroo_oct.html");
//descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/liberacion/reportes/ReporteLiberacionesPrint.php?mes=11&anio=2018&tipounidad=0&zona=QR","paginas/liberaciones_pa_quintanaroo_nov.html");
//descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/liberacion/reportes/ReporteLiberacionesPrint.php?mes=12&anio=2018&tipounidad=0&zona=QR","paginas/liberaciones_pa_quintanaroo_dic.html");
//descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/liberacion/reportes/ReporteLiberacionesPrint.php?mes=01&anio=2019&tipounidad=0&zona=QR","paginas/liberaciones_pa_quintanaroo_ene.html");
//descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/liberacion/reportes/ReporteLiberacionesPrint.php?mes=02&anio=2019&tipounidad=0&zona=QR","paginas/liberaciones_pa_quintanaroo_feb.html");
//descarga_archivo_sindata($login,$data_login,"http://www.programaasibc.com.mx/siaMexicali/liberacion/reportes/ReporteLiberacionesPrint.php?mes=03&anio=2019&tipounidad=0&zona=QR","paginas/liberaciones_pa_quintanaroo_mar.html");

  
//descarga_presupuestos();



?>