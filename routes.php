<?php
$routes = [
    "/" => "dashboard.php",
    "/admin" => "admin/dashboard.php",
    "/it" => "it/dashboard.php",
    "/pengajuan" => "pengajuan/index.php",
    "/login" => "login/login.php",
    "/user" => "user/index.php",
];

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (array_key_exists($url, $routes)) {
    include $routes[$url];
    # code...
} else {
    http_response_code(404);
    echo '404 NOT FOUND';
}

?>