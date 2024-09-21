<?php

$siter = "http://127.0.0.1:6666";

$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $appname = $_POST['appname'];
    $appurl = $_POST['appurl'];
    $apptype = $_POST['apptype'];
    $index_html = $_POST['userCode'];

    $json = file_get_contents('../backend/data.json');
    $json_data = json_decode($json, true);

    if (!array_key_exists($username, $json_data)) {
        echo file_get_contents("../frontend/panel/create.html",true).'
        <script>
        alert("Username already exists.");
        </script>';
    }
    else if ($json_data[$username]['password'] == $password) {
        if (!json_decode(file_get_contents($siter.'/renderIndex?username='.$username))) {
            $json_to_post = [
                username => $username,
                sitename => $appname,
                index_html => $index_html
            ];
            $json_to_post = json_encode($json_to_post);
            
            $options = [
                'http' => [
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($json_to_post),
                ],
            ];

            $context = stream_context_create($options);
            $result = file_get_contents($siter, false, $context);

            echo file_get_contents("../frontend/panel/index.html",true).'
            <script>
            alert("App created successfully.");
            </script>';
            
        }
    }
}
?>