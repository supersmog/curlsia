<?php
 require("cliente.php");
//Upload a blank cookie.txt to the same directory as this file with a CHMOD/Permission to 777
function login($url,$data){
    $fp = fopen("cookie.txt", "w");
    fclose($fp);
    $login = curl_init();
    curl_setopt($login, CURLOPT_COOKIEJAR, "cookie.txt");
    curl_setopt($login, CURLOPT_COOKIEFILE, "cookie.txt");
    curl_setopt($login, CURLOPT_TIMEOUT, 40000);
    curl_setopt($login, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($login, CURLOPT_URL, $url);
    curl_setopt($login, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($login, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($login, CURLOPT_POST, TRUE);
    curl_setopt($login, CURLOPT_POSTFIELDS, $data);
    ob_start();
    return curl_exec ($login);
    ob_end_clean();
    curl_close ($login);
    unset($login);    
}                  
 
function grab_page($site){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 40);
    curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
    curl_setopt($ch, CURLOPT_URL, $site);
    ob_start();
    return curl_exec ($ch);
    ob_end_clean();
    curl_close ($ch);
}
function guardar_pagina($site,$file)
{
    $fp= $fp=fopen("$file","w");
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 40);
    curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
    curl_setopt($ch, CURLOPT_URL, $site);
    curl_setopt($ch,CURLOPT_FILE,$fp);
    ob_start();
    return curl_exec ($ch);
    fclose($fp);
    ob_end_clean();
    curl_close ($ch);
}
 
function post_data($site,$data){
    $datapost = curl_init();
        $headers = array("Expect:");
    curl_setopt($datapost, CURLOPT_URL, $site);
        curl_setopt($datapost, CURLOPT_TIMEOUT, 40000);
    curl_setopt($datapost, CURLOPT_HEADER, TRUE);
        curl_setopt($datapost, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($datapost, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($datapost, CURLOPT_POST, TRUE);
    curl_setopt($datapost, CURLOPT_POSTFIELDS, $data);
        curl_setopt($datapost, CURLOPT_COOKIEFILE, "cookie.txt");
    ob_start();
    return curl_exec ($datapost);
    ob_end_clean();
    curl_close ($datapost);
    unset($datapost);    
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


//$resp=$cliente->listado("select * from status_sia");
//foreach($resp as $row){
  //  echo $row['descripcion'];
   // echo "\n";

//}
//$resp=$cliente->insertar("insert into status_sia values ('LPC','Liberada por autorizar','si','si','si')");
if($resp){
    $resp1=$cliente->listado("select * from status_sia");
}else{
    echo "No se pudo guardar";
}
// login("http://www.programaasibc.com.mx/siaMexicali/validausuario.php","usuario=md032ca&clave=md032ca&tipo=1");
 //grab_page("http://www.programaasibc.com.mx/siaMexicali/index.php");

//echo grab_page("http://www.programaasibc.com.mx/siaMexicali/consolusu.php?fi=2018-10-01&ff=2018-11-30&tip=men&en=10");
//guardar_pagina("http://www.programaasibc.com.mx/siaMexicali/consolusu.php?fi=2018-09-01&ff=2018-09-30&tip=men&en=09","septiembre.html");
//guardar_pagina("http://www.programaasibc.com.mx/siaMexicali/consolusu.php?fi=2018-10-01&ff=2018-10-30&tip=men&en=10","octubre.html");
//guardar_pagina("http://www.programaasibc.com.mx/siaMexicali/consolusu.php?fi=2018-11-01&ff=2018-11-30&tip=men&en=11","noviembre.html");
analiza_archivo2("septiembre.html");
analiza_archivo2("octubre.html");
analiza_archivo2("noviembre.html");

?>