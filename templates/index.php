<?php
/**
 * pUPnP, an PHP UPnP MediaControl
 * 
 * Copyright (C) 2012 Mario Klug
 * 
 * This file is part of pUPnP.
 * 
 * pUPnP is free software: you can redistribute it and/or modify it under the terms of the
 * GNU General Public License as published by the Free Software Foundation, either version 2 of the
 * License, or (at your option) any later version.
 * 
 * pUPnP is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * 
 * See the GNU General Public License for more details. You should have received a copy of the GNU
 * General Public License along with pUPnP. If not, see <http://www.gnu.org/licenses/>.
 */
use at\mkweb\upnp\Config;
use at\mkweb\upnp\frontend\AuthManager;

require_once('src/at/mkweb/upnp/init.php');

if(AuthManager::authEnabled()) {

    AuthManager::authenticate();
}

$javascript = array(
    '3rdparty/phpjs.js',
    'pupnp-helpers.js',
    'pupnp-backend.js',
    'pupnp-gui.js',
    'pupnp-device.js',
    'pupnp-playlist.js',
    'pupnp-favorites.js',
    'pupnp-file.js',
//    'pupnp-filemanager.js',	
    'pupnp-videomanager.js',
    'pupnp.js',
    'bootstrap.min.js'
);

$css = array(
    'bootstrap.min.css',
    'style.css',
    'lightbox.css',
    'dropdown.css'
);
?>
<html>
<head>
	<title>UPnP Browser</title>

	<link href="res/jqueryui/css/custom-theme/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css"/>
    <?php if(Config::read('minify_css')): ?>

        <link rel="stylesheet" type="text/css" href="resources.php?css=<?php echo join('|', $css) ?>" />
		
    <?php else: ?>

        <?php foreach($css as $cssfile): ?>

            <link rel="stylesheet" type="text/css" href="res/css/<?php echo $cssfile ?>" />
        <?php endforeach ?>
    <?php endif ?>

	<script src="res/js/jquery.min.js" type="text/javascript"></script>
	<script src="res/jqueryui/js/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>

    <?php if(Config::read('minify_js')): ?>

        <script type="text/javascript" src="resources.php?js=<?php echo join('|', $javascript) ?>"></script>
    <?php else: ?>

        <?php foreach($javascript as $jsfile): ?>

            <script type="text/javascript" src="res/js/<?php echo $jsfile ?>"></script>
        <?php endforeach ?>
    <?php endif ?>
</head>
<body>

<?php require_once(dirname(__FILE__) . '/navigation.php') ?>

<div id="error" class="hidden"></div>

<div id="wrapper-all" class="container">
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span6" id="left">
                <h2><?php echo _('Source') ?></h2>

                <div class="deviceSelection" id="ds-src">
                    <img src="res/images/icons/ajax-loader-small.gif" /> <?php echo _('Loading devices') ?>
                </div>

                <div class="favorites" id="favorites"></div>

                <div class="desc" id="desc-src"></div>

                <div class="properties" id="p-src"></div>
            </div>
            <div class="span6" id="right">
                <h2><?php echo _('Destination') ?></h2>

                <div class="deviceSelection" id="ds-dst">
                    <img src="res/images/icons/ajax-loader-small.gif" /> <?php echo _('Loading devices') ?>
                </div>

                <div class="desc" id="desc-dst"></div>

                <div class="properties" id="p-dst"></div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
