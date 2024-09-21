<?php

$typeofreq = $_SERVER['REQUEST_METHOD'];
if ($typeofreq == 'POST') {
    $formdata = $_POST;

    $type = $formdata['type'];


    // $json_data = json_decode(file_get_contents('data.json'), true);
    if ($type == 'login') {
        $username = $formdata['username'];
        $password = $formdata['password'];

        $json_file = file_get_contents("data.json");
        $json_data = json_decode($json_file, true);
        $is_user_in_db = array_key_exists($username, $json_data);
        if ($is_user_in_db) {
            $user_data = $json_data[$username];
            if ($user_data['password'] == $password) {
                $panel_content = @file_get_contents("../frontend/panel/index.html");
                if ($panel_content === false) {
                    echo "Error: Unable to load panel content.";
                } else {
                    echo str_replace("YOUR_USERNAME", $username, $panel_content);
                }
                $dirr = dirname();

                echo file_get_contents($dirr."frontend/panel/login.html").'<script>alert(`password is incorrect`)</script>';
            } else {
                echo file_get_contents("../frontend/panel/login.html").'<script>alert(`password is incorrect`)</script>';
            }
        } else {
            echo file_get_contents("frontend/panel/login.html")."<script>alert(`no account with username $username`)</script>";
        }
    } else if ($type == 'register') {

        $username = $formdata['username'];
        $password = $formdata['password'];
        $pconfirm = $formdata['confirm-password'];

        $json_file = file_get_contents("data.json");
        $json_data = json_decode($json_file, true);
        $is_user_in_db = array_key_exists($username, $json_data);
        if ($is_user_in_db) {
            echo 'Username already exists';
        } else {
            $json_data[$username] = array(
                "username" => $username,
                "password" => $password,
                "confirm-password" => $pconfirm
            );
            $json_data_encode = json_encode($json_data);
            file_put_contents("data.json", $json_data_encode);
            echo file_get_contents("../frontend/panel/login.html").'<script>alert(`registered successfully`)</script>';
        }
    } else if ($type == 'coin-example') {
        $service = $formdata['service'];
        $type = $formdata['type'];
        $username = $formdata['username'];
        $amount = $formdata['amount'];

        // proccess

        echo file_get_contents("../frontend/panel/coin.html")."
<script>
localStorage.setItem('coins', '0');
window[sensitiveVariables.coinsValue] = 0;
window[sensitiveVariables.updateScore]();
showMessage('Withdraw succsessful', true);
</script>
";
    } else {
        $panel_content = @file_get_contents("../frontend/panel/index.html");
        if ($panel_content === false) {
            echo "Error: Unable to load panel content.";
        } else {
            echo $panel_content;
        }
    }
}