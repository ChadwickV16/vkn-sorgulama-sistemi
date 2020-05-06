<?php require 'processing.php'; ?>
<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>VKN Sorgula</title>
</head>
<body>
<form method="POST">
    <input type="number" name="vkn" placeholder="Vergi Kimlik Numarası">
    <select name="vd">
        <option selected disabled>-Vergi Dairesi-</option>
        <?php
        preg_match_all('@<td>(.*?)</td>@si', curl_get('https://test.bugraozkan.com.tr/vkn'), $vd);

        foreach ($vd[1] as $fetch) {

            $replace = str_replace('<span style="color: black;">VERGİ</span>', 'VERGİ', $fetch);

            echo '<option value="' . $replace . '">' . $replace . '</option>';

        }
        ?>
    </select>
    <input type="hidden" name="jeton" value="<?=$token?>">
    <button type="submit" name="sorgula">Sorgula</button>
</form>
</body>
</html>
