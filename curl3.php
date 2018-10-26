<html>
<title>Prueba curl con funciones</title>

<body>

<?


//funcion que hace la peticion usando curl, dependiendo de la url, realiza la peticion y devuelve el puntero o lo guarda en un archivo
function cfe_curl($rpu,$tipo)
{

  if($tipo==1){
      $url = "http://10.4.22.18/sicomdw/principal.php?o=607&opcion=genera&txtRPU=$rpu";
      $fp=fopen("/tmp/texto1.html","w");
      $handler=curl_init();
      curl_setopt($handler,CURLOPT_URL,$url);
      curl_setopt($handler,CURLOPT_FILE,$fp);
      $response = curl_exec ($handler);
      curl_close($handler);
      fclose($fp);
  };

  if($tipo==2){
    $url="http://10.19.158.70/cobranza/consulta9.php?o=00&opcion=genera&txtRPU=$rpu";
    $handler2=curl_init();
    curl_setopt($handler2,CURLOPT_URL,$url);
    $response = curl_exec ($handler2);
    curl_close($handler2);

  };
  
    if($tipo==0){
    $url = "http://10.19.158.70/sicomdw/principal.php?o=607&opcion=genera&txtRPU=$rpu";
      $fp=fopen("/tmp/texto1.html","w");
      $handler=curl_init();
      curl_setopt($handler,CURLOPT_URL,$url);
      curl_setopt($handler,CURLOPT_FILE,$fp);
      $response = curl_exec ($handler);
      curl_close($handler);
      fclose($fp);

  };
    return $response;

}


$rpu=$_REQUEST[rpu];
$tipo=$_REQUEST[tipo];

$respuesta=cfe_curl($rpu,$tipo);


//si solicitan la url 1, se abre el archivo y se imprime a partir de la informacion
if($tipo<=1)
{
  $linea=0;
  $path = "/tmp/texto1.html";
  if (!file_exists($path))
      exit("File not found");
  $file = fopen($path, "r");
  if ($file) {
      while (($line = fgets($file)) !== false) {
        if($linea>200){

                    echo $line;
        }

          $linea++;
      }
      if (!feof($file)) {
          echo "Error: EOF not found\n";
      }
      fclose($file);
  }

}
if($tipo==2){
  echo $respuesta;
}



?>

</body>
</html>
