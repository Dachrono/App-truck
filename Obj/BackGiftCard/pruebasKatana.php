<?php
    $url='https://api.chockstone.net/katana/v1/domains/hps/chains/93729/user';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Api-Key: 8yEsbyXBsaU'
    ));

    $data = curl_exec($curl);
    echo json_encode($data)
?>