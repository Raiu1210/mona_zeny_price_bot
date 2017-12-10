<?php
    require 'Zaif.php';

    require_once('twitteroauth/autoload.php');
    require_once('twitteroauth/src/TwitterOAuth.php');
    require_once(dirname(__FILE__) . '/config.php');
    require_once("./phpQuery-onefile.php");
    use Abraham\TwitterOAuth\TwitterOAuth;
 
    date_default_timezone_set('Asia/Tokyo');
    $price = Zaif::pub("last_price","mona_jpy");
    $mona = $price->last_price;
    $now = date("Y/m/d H:i");
    // print($now);
    
    // print($message);
    
    $html = file_get_contents("https://coinmarketcap.com/currencies/bitzeny/");
    $html2 = file_get_contents("https://info.finance.yahoo.co.jp/fx/detail/?code=USDJPY=FX");

    $price_zeny_d = phpQuery::newDocument($html)->find("#quote_price")->find(".text-large2")->text();

    $doller = phpQuery::newDocument($html2)->find("#USDJPY_detail_ask")->text();
    // print($doller);

    $z = (float) $price_zeny_d;
    $d = (float) $doller;

    $zeny = round($z*$d, 3);
    // print($zeny);

    $message = "${now}\nMonaとZenyの取引価格\nMona:${mona}円\nZeny:${zeny}円\n";
     // print($message);

 
// つぶやく
    $connection = new TwitterOAuth(consumer_key, consumer_secret, access_token, access_token_secret);
    $request = $connection->post("statuses/update", array("status"=> $message ));
?>
