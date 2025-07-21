<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// --- Configuration ---
$client_id = 'YOUR TWITCH CLIENT ID';
$client_secret = 'YOUR TWITCH CLIENT SECRET';
$cache_file = 'twitch_cache.json';
$cache_duration = 600; // 10 minutes

$usernames = [
'Blazin_Irish', 'sour_diesel01', 'Sally_Budz', 'SpiderMANdingo', 'roughmonkey4846', 'Munchkin9998', 'shadow420smokez', 'EmptyChevy94', 'adhdsessionz', 'MaddyJo1225', 'RealOldFashionedGames', 'DopeParsley', 'DiciestZebra', 'Zenkara70', 'vampwolf93', 'Wognutz', 'NiHiLASM_', 'Kill_Buzz', 'Lunar_Silver_TTV', 'CallMeLabz', 'Coffin_Earth666', 'ttvwar420', 'kronictheboss420', 'TheLostInTheSauce', 'Stefxx96'
];

// --- Check cache ---
if (file_exists($cache_file) && (time() - filemtime($cache_file)) < $cache_duration) {
    header('Content-Type: application/json');
    echo file_get_contents($cache_file);
    exit;
}

// --- Get access token ---
function getAccessToken($client_id, $client_secret) {
    $ch = curl_init("https://id.twitch.tv/oauth2/token");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'grant_type' => 'client_credentials'
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    if (!$response) {
        return ['error' => 'Curl error: ' . curl_error($ch)];
    }
    curl_close($ch);
    return json_decode($response, true);
}

$auth = getAccessToken($client_id, $client_secret);
if (!isset($auth['access_token'])) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to get Twitch access token', 'details' => $auth]);
    exit;
}
$token = $auth['access_token'];

// --- Prepare headers for Twitch API ---
$headers = [
    "Client-ID: $client_id",
    "Authorization: Bearer $token"
];

// --- Get user data ---
$users_data = [];
$chunks = array_chunk($usernames, 100);

foreach ($chunks as $chunk) {
    $query = http_build_query(['login' => $chunk], '', '&', PHP_QUERY_RFC3986);
    $url = "https://api.twitch.tv/helix/users?$query";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    if (!$result) continue;
    $users = json_decode($result, true)['data'];
    foreach ($users as $user) {
        $users_data[$user['login']] = [
            'name' => $user['display_name'],
            'profile_image_url' => $user['profile_image_url'],
            'url' => 'https://www.twitch.tv/' . $user['login'],
            'id' => $user['id'],
            'online' => false
        ];
    }
    curl_close($ch);
}

// --- Get stream info (who is live) ---
$user_ids = array_column($users_data, 'id');
$live_query = http_build_query(['user_id' => $user_ids], '', '&');
$stream_url = "https://api.twitch.tv/helix/streams?$live_query";

$ch = curl_init($stream_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$stream_response = curl_exec($ch);
if ($stream_response) {
    $streams = json_decode($stream_response, true)['data'];
    foreach ($streams as $stream) {
        foreach ($users_data as $key => $data) {
            if ($data['id'] === $stream['user_id']) {
                $users_data[$key]['online'] = true;
            }
        }
    }
}
curl_close($ch);

// --- Save to cache ---
file_put_contents($cache_file, json_encode($users_data));

// --- Output ---
header('Content-Type: application/json');
echo json_encode($users_data);
