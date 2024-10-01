<?php

if (!defined('WHMCS')) {
    die('Access Denied');
}

use WHMCS\Database\Capsule;

function promobar_config() {
    return [
        'name' => 'Promo Bar by Sysconfig',
        'description' => 'You can dynamically show promo/offer notices to clienarea.',
        'author' => 'Sysconfig.pro',
        'version' => '1.0.1',
    ];
}

function promobar_activate() {
    return [
        'status' => 'success',
        'description' => 'Promo Bar module activated successfully.',
    ];
}

function promobar_deactivate() {
    return [
        'status' => 'success',
        'description' => 'Promo Bar module deactivated successfully.',
    ];
}

function promobar_output($vars) {
    // Get current settings from the database
    $promoText = Capsule::table('tbladdonmodules')
        ->where('module', 'promobar')
        ->where('setting', 'promoText')
        ->value('value') ?? 'Welcome to our hosting service! Get 20% off on your next purchase.';

    $bgColor = Capsule::table('tbladdonmodules')
        ->where('module', 'promobar')
        ->where('setting', 'bgColor')
        ->value('value') ?? '#ffcc00';

    $textColor = Capsule::table('tbladdonmodules')
        ->where('module', 'promobar')
        ->where('setting', 'textColor')
        ->value('value') ?? '#000000';

    // Handle form submission to update settings
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        Capsule::table('tbladdonmodules')
            ->updateOrInsert(
                ['module' => 'promobar', 'setting' => 'promoText'],
                ['value' => $_POST['promoText']]
            );

        Capsule::table('tbladdonmodules')
            ->updateOrInsert(
                ['module' => 'promobar', 'setting' => 'bgColor'],
                ['value' => $_POST['bgColor']]
            );

        Capsule::table('tbladdonmodules')
            ->updateOrInsert(
                ['module' => 'promobar', 'setting' => 'textColor'],
                ['value' => $_POST['textColor']]
            );

        echo '<div class="alert alert-success">Settings updated successfully!</div>';

        $promoText = $_POST['promoText'];
        $bgColor = $_POST['bgColor'];
        $textColor = $_POST['textColor'];
    }

    echo '
    <form method="post" action="">
        <h2>Promo Bar Settings</h2>
        <div class="form-group">
            <label for="promoText">Promo Text:</label>
            <textarea class="form-control" id="promoText" name="promoText" rows="3">' . htmlspecialchars($promoText) . '</textarea>
        </div>
        <div class="form-group">
            <label for="bgColor">Background Color (Hex Code):</label>
            <input type="text" class="form-control" id="bgColor" name="bgColor" value="' . htmlspecialchars($bgColor) . '" placeholder="#ffcc00">
        </div>
        <div class="form-group">
            <label for="textColor">Text Color (Hex Code):</label>
            <input type="text" class="form-control" id="textColor" name="textColor" value="' . htmlspecialchars($textColor) . '" placeholder="#000000">
        </div>
        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>';
}
