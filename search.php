<html>

<head>
    <link rel="stylesheet" href="/main.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
<form class="search_form" action="/search.php" >
  <input type="text" placeholder="Search.." name="q">
  <button type="submit">Go!</button>
</form>
    <table>
        <tr>
            <th>Title</th>
            <th>Action</th>
        </tr>
        <?php
        $url = "https://me0xn4hy3i.execute-api.us-east-1.amazonaws.com/staging/api/resolve/resolveYoutubeSearch?search=" . urlencode($_GET["q"]);
        $search_raw = file_get_contents($url);
        $search_json = json_decode($search_raw, true);
        foreach ($search_json["data"] as $item) {
            echo "<tr><td>" . $item["title"] . "</td>";
            echo "<td><a href=download.php?q=".urlencode($_GET["q"])."&type=mp3&id=" . $item["videoId"] . ">Get MP3</a><br><a href=download.php?q=".urlencode($_GET["q"])."&type=480&id=" . $item["videoId"] . ">Get MP4 480p</a></td></tr>";
        }
        ?>
    </table>
    <p><a href=index.php>Back to Home</a></p>
</body>

</html>