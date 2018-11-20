<?php
 
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

function analiza_archivo($file)
{
     
    if (!file_exists($file)){
      exit("File not found");
    }
    $linea=0;
      $fp=fopen($file,"r");
      if ($fp) {
        while (($line = fgets($fp)) !== false) {
          if($linea>60){
  
                      echo ($line);
          }
  
            $linea++;
        }
        if (!feof($fp)) {
            echo "Error: EOF not found\n";
        }
        fclose($fp);
    }
}

function analiza_archivo2($file)
{
     
    if (!file_exists($file)){
      exit("File not found");
    }
    $htmlContent=file_get_contents("octubre.html");
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
    print_r($aDataTableHeaderHTML);

}


// login("http://www.programaasibc.com.mx/siaMexicali/validausuario.php","usuario=md032&clave=yucatan&tipo=1");
// grab_page("http://www.programaasibc.com.mx/siaMexicali/index.php");

//echo grab_page("http://www.programaasibc.com.mx/siaMexicali/consolusu.php?fi=2018-10-01&ff=2018-11-30&tip=men&en=10");
//guardar_pagina("http://www.programaasibc.com.mx/siaMexicali/consolusu.php?fi=2018-10-01&ff=2018-10-30&tip=men&en=10","octubre.txt");
//guardar_pagina("http://www.programaasibc.com.mx/siaMexicali/consolusu.php?fi=2018-11-01&ff=2018-11-30&tip=men&en=11","noviembre.html");
analiza_archivo2("octubre.html");
?>