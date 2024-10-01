<?php

use WHMCS\Database\Capsule;

add_hook('ClientAreaHeadOutput', 1, function($vars) {
    $promoText = Capsule::table('tbladdonmodules')
        ->where('module', 'promobar')
        ->where('setting', 'promoText')
        ->value('value');

    $bgColor = Capsule::table('tbladdonmodules')
        ->where('module', 'promobar')
        ->where('setting', 'bgColor')
        ->value('value');

    $textColor = Capsule::table('tbladdonmodules')
        ->where('module', 'promobar')
        ->where('setting', 'textColor')
        ->value('value');

    return '
    <style>
        .promo-bar {
            background-color: ' . htmlspecialchars($bgColor) . ';
            color: ' . htmlspecialchars($textColor) . ';
            text-align: center;
            padding: 10px;
            font-size: 16px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 9999;
        }
        body {
            margin-top: 50px; /* Adjust this margin to avoid overlay issues with the promo bar */
        }
    </style>
    <div class="promo-bar">' . htmlspecialchars($promoText) . '</div>';
});
