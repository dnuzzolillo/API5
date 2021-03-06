<?php
/**
 * Created by PhpStorm.
 * User: seven-11
 * Date: 23/08/2016
 * Time: 10:00
 */

function getPage($html_brand, $params)
{
    #
    # $params : debe ser un arreglo tipo
    # [
    #    'varname1' => val3,
    #    'varname2' => val2,
    #    'varname3' => val1,
    # ]
    # que seran pasados como POST
    #

    $ch = curl_init();

    ini_set('user_agent', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1');

    $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
    $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
    $header[] = "Cache-Control: max-age=0";
    $header[] = "Connection: keep-alive";
    $header[] = "Keep-Alive: 300";
    $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
    $header[] = "Accept-Language: en-us,en;q=0.5";
    $header[] = "Pragma: ";

    if (is_array($params)) {
        $post = $params;
    } else {
        $post = [];
    }

    $ch = curl_init('http://www.domain.com');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $agents = array(
        'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1',
        'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1.9) Gecko/20100508 SeaMonkey/2.0.4',
        'Mozilla/5.0 (Windows; U; MSIE 7.0; Windows NT 6.0; en-US)',
        'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_7; da-dk) AppleWebKit/533.21.1 (KHTML, like Gecko) Version/5.0.5 Safari/533.21.1'
    );

    $options = array(
        CURLOPT_USERPWD 	   => "system:manager",
        CURLOPT_URL            => $html_brand,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,  //verificacin peer del certificado
        CURLOPT_HEADER         => false,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING       => "",
        CURLOPT_AUTOREFERER    => true,
        CURLOPT_CONNECTTIMEOUT => 120,
        CURLOPT_TIMEOUT        => 120,
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_HTTPHEADER     => $header,
        CURLOPT_USERAGENT      => $agents[array_rand($agents)]
        ,CURLOPT_POSTFIELDS     => $post
    );
    curl_setopt_array( $ch, $options );
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ( $httpCode != 200 and  $httpCode != 302){
        $error = "<br>Ha ocurrido un error de conexión con el servidor  (\"REF:191-GETPAGE\")($httpCode). Por favor intente mas tarde.<br>.";
        echo $error;
        echo $html_brand;
        curl_close($ch);
        exit;
    }

    curl_close($ch);
    return $response;
}

//echo getPage('https://www.wineshop.it/en/wine-and-co/italy-of-wine/'.$_GET["r"]);
//echo getPage('http://cne.gov.ve/web/registro_electoral/ce.php?nacionalidad=V&cedula='.$_GET["r"]);