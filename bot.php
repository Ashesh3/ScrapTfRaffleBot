<?php

/* Simple scrap.tf Raffle script in PHP

Usage:
1. Host in any webserver
2. Make list.txt in the same directory with the content "XO12," (without quotes but with that comma)
3. Set a cron job or manually visit this script after some time
4. If it throws an error, just to go scrap.tf and enter any raffle manually and continue using it.
5. Logger

-Features:
+ Instant Entry
+ Anti Ban
+ Easy to use


Enjoy and **** Jesse XD
*/
include ("simple_html_dom.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

$file = "list.txt";
$fopen = fopen($file, 'r');

    $fread = fread($fopen,filesize($file));

    fclose($fopen);

    $remove = "\n";

    $split = explode($remove, $fread);

    $array[] = null;
    $tab = "\t";

    foreach ($split as $string)
    {
        $row = explode(",", $string);
        array_push($array,$row);
    }

$GLOBALS['c'] = "Cookie: scr_session=xxxxx;cookie=11"; //Your Scrap.tf cookies
header('Content-type: text/html; charset=utf-8');

$csf="";
function shouldi($id)
{
     $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://scrap.tf/raffles/" . $id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

    $headers = array();
    $headers[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:56.0) Gecko/20100101 Firefox/56.0";
    $headers[] = "Referer: https://scrap.tf/raffles";
    $headers[] = "Upgrade-Insecure-Requests: 1";
    $headers[] = $GLOBALS['c'];

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    $data = curl_exec($ch);
		$html1 = str_get_html($data);
		$user = $html1->find("b[class=label usr-label]")[0]->plaintext;
		$data = $html1->find("div[class=well-padding]")[0];
		$data .= $html1->find("div[class=raffle-message]")[0];
		$data .= $html1->find("div[class=row raffle-box-row]")[0];
		$data .= $html1->find("div[class=row raffle-opts-row]")[0];
	
	//You can add your own checks ;)
    $match[0] = (stripos($data, "banned")) ? true : false;
    $match[1] = stripos($data, "honeypot") ? true : false;
    $match[2] = stripos($data, "do not") ? true : false;
    $match[3] = stripos($data, " bot ") ? true : false;
    $match[4] = stripos($data, "cannot") ? true : false;
    $match[5] = stripos($data, "exceptions") ? true : false;
    $match[6] = stripos($data, "don't") ? true : false;
    $match[7] = stripos($data, "owner") ? true : false;
    $match[8] = ($user=="Mod") ? true : false;
    $match[9] = stripos($data, "BANNED!") ? true : false;
    $match[10] = stripos($data, "<h1>") ? true : false;
    $match[11] = stripos($data, "<h2>") ? true : false;
    $match[12] = stripos($data, "<h3>") ? true : false;
    $match[13] = stripos($data, "Jesse") ? true : false;
    $match[14] = stripos($data, "bots") ? true : false;
    $match[15] = stripos($data, "ban") ? true : false;
    $match[16] = stripos($data, "cannot") ? true : false;
    $match[17] = stripos($data, "b a n n e d") ? true : false;
	  $match[18] = stripos($data, "b a n") ? true : false;
	  $match[19] = stripos($data, "d o n' t") ? true : false;
		$match[20] = stripos($data, "n o t") ? true : false;
		$match[21] = ($user=="Staff") ? true : false;
	  $match[22] = ($user=="Owner") ? true : false;
    $match[23] = stripos($data, " bots ") ? true : false;
		
		$should[0]=stripos($data, "Enter Raffle") ? true : false;
		$should[1]=stripos($data, "ScrapTF.Raffles.EnterRaffle") ? true : false;
		$should[2]=stripos($data, "raffle-enter") ? true : false;
		$should[3] =stripos($data, "This public raffle is free to enter by anyone") ? true : false;
		$count[0]=true;
	  $count[1]=true;
		$count[6]=true;
		if($match[0] || $match[1] || $match[22] || $match[8] || $match[21])
			$count[6]=false;
		$num=0;
    for ($i = 0;$i < sizeof($match);$i++) 
			if ($match[$i]==true)
			{
				$count[0]=false;
				$num++;
			}
	
    for ($i = 0;$i < sizeof($should);$i++) 
			if ($should[$i]==false)
			{
				$count[1]=false;
				$num++;
			}

	$count[2]=$num;
	$count[3]=$user;
	$count[4]=$match;
	$count[5]=$should;
 	return $count;

}

function gethash($id)
{

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://scrap.tf/raffles/" . $id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

    $headers = array();
    $headers[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:56.0) Gecko/20100101 Firefox/56.0";
    $headers[] = "Referer: https://scrap.tf/raffles";
    $headers[] = "Upgrade-Insecure-Requests: 1";
    $headers[] = $GLOBALS['c'];

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    $result1 = curl_exec($ch);
    if (curl_errno($ch))
    {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    $html1 = str_get_html($result1);
    $ret = $html1->find('#raffle-enter');
    $hash = $ret[0]->onclick;
    $hash = explode("'", $hash);
    if (sizeof($hash) > 3) $hash = $hash[3];
    else return false;
    return $hash;

}
function getcsrf($id)
{

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://scrap.tf/raffles/" . $id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

    $headers = array();
    $headers[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:56.0) Gecko/20100101 Firefox/56.0";
    $headers[] = "Referer: https://scrap.tf/raffles";
    $headers[] = "Upgrade-Insecure-Requests: 1";
    $headers[] = $GLOBALS['c'];

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    $result1 = curl_exec($ch);
    if (curl_errno($ch))
    {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    $html1 = str_get_html($result1);
    $ret = $html1->find('input[name=csrf]');
    $hash = $ret[0]->value;
    return $hash;
}

function enter($id, $hash, $csrf)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://scrap.tf/ajax/viewraffle/EnterRaffle");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "csrf=" . $csrf . "&captcha=&hash=" . $hash . "&raffle=" . $id . "");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    $headers = array();
    $headers[] = "Accept: application/json, text/javascript, */*; q=0.01";
    $headers[] = "Accept-Encoding: identity, deflate, br";
    $headers[] = "Accept-Language: en-US,en;q=0.5";
    $headers[] = "Connection: close";
    $headers[] = "Content-Length: 162";
    $headers[] = "Content-Type: application/x-www-form-urlencoded; charset=UTF-8";
    $headers[] = $GLOBALS['c'];
    $headers[] = "Referer: https://scrap.tf/raffles/" . $id;
    $headers[] = "User-Agent: runscope/0.1,Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:56.0) Gecko/20100101 Firefox/56.0";
    $headers[] = "X-Requested-With: XMLHttpRequest";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch))
    {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    return $result;

}
function getList()
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://scrap.tf/ajax/raffles/Paginate");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if (!isset($_GET['last'])) $last = "";
    else $last = $_GET['last'];
    curl_setopt($ch, CURLOPT_POSTFIELDS, "start=$last&sort=0&puzzle=0&csrf=bcfb1d699465e5096b5df14f4d13e6e52c626bc4c8cbdb87a394f9a5ca0904b8"); // You may need to change your csrf, you can get it by submitting any raffle and checking it in network tab of inspect element in Chomr
    curl_setopt($ch, CURLOPT_POST, 1);

    $headers = array();
    $headers[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:56.0) Gecko/20100101 Firefox/56.0";
    $headers[] = "Referer: https://scrap.tf/raffles";
    $headers[] = "Content-Type: application/x-www-form-urlencoded; charset=UTF-8";
    $headers[] = $GLOBALS['c'];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    $result1 = curl_exec($ch);

    $result = json_decode($result1, true) ["html"];
    echo "<button  id=\"bb\" style=\"height:200px;width:200px\" onclick=\"location.href=location.origin+location.pathname+'?last=" . json_decode($result1, true) ["lastid"] . "';\">" . json_decode($result1, true) ["lastid"] . "</button><br>";

    if (curl_errno($ch))
    {
        echo 'Error:' . curl_error($ch);
    }

    curl_close($ch);
    return $result;
}

$result = getList();
$html = str_get_html($result);
$tmp;
$times = 0;
$timess = 0;
foreach ($html->find(".panel-raffle") as $e)
{

    $times++;
    if (!($e->style != "") && $timess < 100)
    {
        $e1 = str_get_html($e->innertext);
        $e2 = $e1->find("a");
        $tmp = $e2[0]->href;
        $tmp = explode("/", $tmp);
        if ($tmp[1] == "raffles") $id = $tmp[2];

        echo "<hr><br>" . "Found Open Raffle!<br>" . "ID: $id <br>";
				$botcheck = shouldi($id);
				if(!in_array($id, $array[1]))
				{
						if (!$botcheck[0] || !$botcheck[1])
						{
								//HONEYPOT?
								file_put_contents($file, $id.",", FILE_APPEND);
								file_put_contents("log.log","ID: ".$id."/nRisk: ".$botcheck[2]."\nRisks: ".var_export($botcheck[4], true)."\n\n ".var_export($botcheck[5], true)."-----------\n\n", FILE_APPEND);
								
								if(($botcheck[2] > 4) || $botcheck[6]==false){
								echo "Creator: ".$botcheck[3]." <br>";
								echo "Risk: ".$botcheck[2]."<br>";
								die("Saved from ban! phew -> ".$id);
								}

						}
						$hash = gethash($id);
						if (!$hash)
						{
								echo "Already entered<br>";
								echo "<hr><br>";

						}
						else
						{

								echo "Hash: " . $hash . "<br>";
								echo "Creator: ".$botcheck[3]." <br>";
								echo "Risk: ".$botcheck[2]."<br>";
								$csrf = getcsrf($id);
								echo "style: " . $e->style . "<br>";
								echo "Csrf: " . $csrf . "<br>";
								echo "Trying to enter :p <br>";
								echo "Result: " . enter($id, $hash, $csrf) . "<br>";
								$timess++;
						}
						flush();
						sleep(5);
						continue;

				}
				else
				{
						$e1 = str_get_html($e->innertext);
						$e2 = $e1->find("a");
						$tmp = $e2[0]->href;
						$tmp = explode("/", $tmp);
						if ($tmp[1] == "raffles") $id = $tmp[2];
						echo "<hr>ID: " . $id . " already entered! [" . $e->style . "]<br>";
						flush();
				}
	}
}
echo "<br><hr>Total Raffles checked: $times";
echo "<script>setInterval(document.getElementById(\"bb\").click(),1000);</script>";

?>
