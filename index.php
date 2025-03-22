<?php
// Security: Block unauthorized requests
if (
    // Check if HTTP_REFERER and HTTP_ORIGIN match allowed domains
    (!isset($_SERVER['HTTP_REFERER']) || !preg_match('/(tv-shihab\.xyz|api\.shihabtv\.xyz)/', $_SERVER['HTTP_REFERER'])) &&
    (!isset($_SERVER['HTTP_ORIGIN']) || !preg_match('/(tv-shihab\.xyz|api\.shihabtv\.xyz)/', $_SERVER['HTTP_ORIGIN'])) ||
    // Check if the User-Agent is missing or empty
    (!isset($_SERVER['HTTP_USER_AGENT']) || empty($_SERVER['HTTP_USER_AGENT']))
) {
    http_response_code(403);
    exit('<body style="background-color:black; color:yellow; font-family:sans-serif; text-align:center;">
            <h1>FUCK OFF STEALERS</h1>
          </body>');
}

// Get the requested MPD URL
$get = $_GET['get'] ?? '';
$mpdUrl = 'https://linearjitp-playback.astro.com.my/dash-wv/linear/' . $get;

// Set headers for the request
$mpdheads = [
    'http' => [
        'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36\r\n",
        'follow_location' => 1,
        'timeout' => 5
    ]
];

$context = stream_context_create($mpdheads);
$res = file_get_contents($mpdUrl, false, $context);

// Forward CORS headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/dash+xml");

echo $res;
?>
