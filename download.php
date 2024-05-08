<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<?php
$URL_CREATE_TASK = "https://ab.cococococ.com/ajax/download.php?copyright=0&&format=" . $_GET["type"] . "&url=https://www.youtube.com/watch?v=" . $_GET["id"] . "&api=dfcb6d76f2f6a9894gjkege8a4ab232222";
$ch = curl_init($URL_CREATE_TASK);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$resp = curl_exec($ch);
curl_close($ch);
$query_id = json_decode($resp, true)["id"];
$URL_GET_TASK_STATUS = "https://p.oceansaver.in/ajax/progress.php?id=" . $query_id;
$last_resp_json = ["download_url" => NULL];
while ($last_resp_json["download_url"] == NULL) {
    $ch = curl_init($URL_GET_TASK_STATUS);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $last_resp = curl_exec($ch);
    global $last_resp_json;
    $last_resp_json = json_decode($last_resp, true);
    file_put_contents('php://stderr', print_r($last_resp_json, TRUE));
    curl_close($ch);
    sleep(10);
}
$options = array(
          CURLOPT_FILE    => fopen("temp_data/".$_GET["id"], 'w'),
          CURLOPT_TIMEOUT =>  28800, // set this to 8 hours so we dont timeout on big files
          CURLOPT_URL     => $last_resp_json["download_url"]
        );
        $ch = curl_init();
        curl_setopt_array($ch, $options);
        curl_exec($ch);
        curl_close($ch);

echo '<video controls src=/temp_data/'.$_GET["id"].'></video>';
echo '<object type="application/x-shockwave-flash" data="dewplayer.swf" width="200" height="200" id="dewplayer" name="dewplayer">
<param name="movie" value="dewplayer.swf" />
<param name="flashvars" value="mp3=/temp_data/'.$_GET["id"].'" />
<param name="wmode" value="transparent" />
</object>
';
echo '<br><a href=/temp_data/'.$_GET["id"].'>Download</a>';
echo '<p><a href=/search.php?q='.urlencode($_GET["q"]).'>Back to search</a></p>';
?>
</body>
</html>


