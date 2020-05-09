<?php
ob_start();
session_start();

function curl_get($url) {

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true
    ]);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;

}

function curl_post($url, $params) {

    $postData = '';
    foreach($params as $k => $v) {
        $postData .= $k . '='.$v.'&';
    }
    rtrim($postData, '&');

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData
    ]);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;

}

if (isset($_POST['sorgula'])) {

    if ($_POST['jeton'] != $_SESSION['jeton']) {

        echo 'Jeton geçerli değil.';

    } elseif (!ctype_digit($_POST['vkn']) or strlen($_POST['vkn']) < 10 or strlen($_POST['vkn']) > 10) {

        echo 'Girilen vergi kimlik numarası geçerli değil.';

    } elseif ($_POST['vd'] == NULL) {

        echo 'Seçilen vergi dairesi geçerli değil.';

    } else {

        $data = [
            'vkn' => $_POST['vkn'],
            'vd' => $_POST['vd']
        ];

        $post = curl_post('https://www.my-api.tk/vkn.php', $data);
        $decode = json_decode($post, true);

        if ($decode['hata'] == 1) {

            echo $decode['mesaj'];

        } else {

            echo '<b>Durum:</b> ' . $decode['data']['status'] . ' - <b>Ünvan:</b> ' . $decode['data']['title'];

        }

    }

    $_SESSION['jeton'] = rand(100000, 999999);

}

$_SESSION['jeton'] = rand(100000, 999999);
$token = $_SESSION['jeton'];
?>
