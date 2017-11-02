<?php
date_default_timezone_set('Asia/Tbilisi');

$user = 'your_username';
$pass = 'your_password';

$agents = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36';

// start from login page
$url = 'https://tbconline.ge/tbcrd/login';

$header = array();	
$header[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
$header[] = "Accept-Encoding: gzip, deflate, br";
$header[] = "Accept-Language: en-US,en;q=0.8,ka;q=0.6";
$header[] = "Cache-Control: max-age=0";
$header[] = "Connection: keep-alive";
$header[] = "Host: tbconline.ge";
$header[] = "Upgrade-Insecure-Requests: 1";
$header[] = "User-Agent: ".$agent;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookie.txt');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

$content = curl_exec($ch);
curl_close($ch);

// redirect login page with post
$url = 'https://tbconline.ge/ibs/delegate/rest/auth/v1/login';

$post_data = array(
	"username" => $user,
	"password" => $pass,
	"language" => "ka",
	"rememberUserName" => false
);
$post_data = json_encode($post_data);

$header = array();

$header[] = "Accept: application/json, text/plain, */*";
$header[] = "Accept-Encoding: gzip, deflate, br";
$header[] = "Accept-Language: en-US,en;q=0.8,ka;q=0.6";
$header[] = "common: [object Object]";
$header[] = "Connection: keep-alive";
$header[] = "Content-Length: ".strlen($post_data);
$header[] = "Content-Type: application/json;charset=UTF-8";
$header[] = "Host: tbconline.ge";
$header[] = "Origin: https://tbconline.ge";
$header[] = "Referer: https://tbconline.ge/tbcrd/login";
$header[] = "User-Agent: ".$agent;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookie.txt');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

$content = curl_exec($ch);
curl_close($ch);

$token = substr($content, strpos($content, 'Rest-Action-Token:')+19);
$token = substr($token, 0, 36);

// redirect logincheck page
$url = 'https://tbconline.ge/ibs/delegate/rest/auth/v1/loginCheck';
$header = array();

$header[] = "Accept: application/json, text/plain, */*";
$header[] = "Accept-Encoding: gzip, deflate, br";
$header[] = "Accept-Language: en-US,en;q=0.8,ka;q=0.6";
$header[] = "common: [object Object]";
$header[] = "Connection: keep-alive";
$header[] = "Content-Length: 0";
$header[] = "Host: tbconline.ge";
$header[] = "Origin: https://tbconline.ge";
$header[] = "Referer: https://tbconline.ge/tbcrd/home";
$header[] = "Rest-Action-Token: ".$token;
$header[] = "User-Agent: ".$agent;
$header[] = "x-dtreferer:https://tbconline.ge/tbcrd/login";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookie.txt');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

$content = curl_exec($ch);
curl_close($ch);

// get payment history
$url = 'https://tbconline.ge/ibs/delegate/rest/transaction/v1/history';

$start_date = strtotime(date("d-m-Y")) * 1000;
$end_date = $start_date + 86400000;

$post_data = array(
	"fromDate" => $start_date,
	"toDate" => $end_date
);
$post_data = json_encode($post_data);

$header = array();

$header[] = "Accept: application/json, text/plain, */*";
$header[] = "Accept-Encoding: gzip, deflate, br";
$header[] = "Accept-Language: en-US,en;q=0.8,ka;q=0.6";
$header[] = "common: [object Object]";
$header[] = "Connection: keep-alive";
$header[] = "Content-Length: ".strlen($post_data);
$header[] = "Content-Type:application/json;charset=UTF-8";
$header[] = "Host: tbconline.ge";
$header[] = "Origin: https://tbconline.ge";
$header[] = "Referer: https://tbconline.ge/tbcrd/transactions/statements";
$header[] = "Rest-Action-Token: ".$token;
$header[] = "User-Agent: ".$agent;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookie.txt');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

$content = curl_exec($ch);
curl_close($ch);

$trans = json_decode($content, true);

// delete cookie
unlink(__DIR__.'/cookie.txt');

// start working on transactions
echo '<table align="center" width="90%">
<tr>
	<td>ID</td>
	<td>Date</td>
	<td>Subject</td>
	<td>Amount</td>
	<td>Currency</td>
</tr>
';
foreach($trans as $row) {
	$un_id = $row['id'];
	$date = $row['date'];
	$desc = $row['description'];
	$price = $row['amount'];
	$cur = $row['currency'];
	
	$seconds = $date / 1000;
	$date_new = date("d/m/Y", $seconds);
	
?>
<tr>
	<td><?php echo $un_id; ?></td>
	<td><?php echo $date_new; ?></td>
	<td><?php echo $desc; ?></td>
	<td><?php echo $price; ?></td>
	<td><?php echo $cur; ?></td>
</tr>
<?php
}

echo '</table>';
?>
