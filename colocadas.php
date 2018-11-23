<?php
require("conectaBD.php");
//Iniciar sesion en una pagina web:
//$fp=fopen("texto1.html","w");
$data = array('usuario' => 'md032', 'clave' => 'yucatan', 'tipo' => '1');
$cokies='cookies.txt';
$cokies='cookies.txt';
$cliente = curl_init();
curl_setopt($cliente, CURLOPT_URL, "http://www.programaasibc.com.mx/siaMexicali/validausuario.php");
//curl_setopt($cliente, CURLOPT_POST, 1);
//curl_setopt($cliente, CURLOPT_POSTFIELDS, "usuario=md032&clave=yucatan&tipo=1;");

curl_setopt($cliente, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($cliente, CURLOPT_SSL_VERIFYPEER, false);

curl_setopt($cliente, CURLOPT_COOKIEJAR, $cokies);
curl_setopt($cliente, CURLOPT_COOKIEFILE, $cokies);
curl_setopt($cliente, CURLOPT_RETURNTRANSFER, true);
curl_setopt($cliente, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.12) Gecko/2009070611 Firefox/3.0.12");

//curl_setopt($cliente, CURLOPT_FILE,$fp);
curl_exec($cliente);
curl_close($cliente);
//fclose($fp);
//print_r($remoto);


//$fpS=fopen("texto2.html","w");
$cliente = curl_init();
curl_setopt($cliente, CURLOPT_URL, "http://www.programaasibc.com.mx/siaMexicali/validausuario.php");
curl_setopt($cliente,CURLOPT_POSTFIELDS,http_build_query($data));
curl_setopt($cliente, CURLOPT_POST, true);
curl_setopt($cliente, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($cliente, CURLOPT_SSL_VERIFYPEER, false);
//$clientepag = curl_init();
//curl_setopt($cliente,CURLOPT_URL,"http://www.programaasibc.com.mx/siaMexicali/registro/datoscliente.php?RPU=773150304635&upid=1540563970&medio=&buenpag=");
curl_setopt($cliente, CURLOPT_COOKIEJAR, $cokies);
curl_setopt($cliente, CURLOPT_COOKIEFILE, $cokies);
curl_setopt($cliente, CURLOPT_RETURNTRANSFER, true);
curl_setopt($cliente, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.12) Gecko/2009070611 Firefox/3.0.12");

//curl_setopt($cliente, CURLOPT_FILE,$fpS);
echo curl_exec($cliente);


curl_setopt($cliente, CURLOPT_POST, true);
curl_setopt($cliente, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($cliente, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($cliente, CURLOPT_COOKIEJAR, $cokies);
curl_setopt($cliente, CURLOPT_COOKIEFILE, $cokies);
curl_setopt($cliente,CURLOPT_URL,"http://www.programaasibc.com.mx/siaMexicali/registro/datoscliente.php?RPU=773150304635&upid=1540563970&medio=&buenpag=");
curl_setopt($cliente, CURLOPT_RETURNTRANSFER, true);
curl_setopt($cliente, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.12) Gecko/2009070611 Firefox/3.0.12");

echo curl_exec($cliente);

curl_close($cliente);
//fclose($fpS);


?>
