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

$config = Config::getAll();

$errors = array();
if(isset($_POST['save'])) {

    $new = $_POST['config'];

    $errors = Config::validate($new);

    print_r($errors);
    print_r($_POST);

    if(count($errors) == 0) {

        Config::change($new);

        $_SESSION['flash'] = _('Sucessfully saved.');

        header('Location: ?page=config');
        exit;
    }
}
?>
<html>
<head>
    <title>pUPnP Device Tester</title>

    <link rel="stylesheet" type="text/css" href="res/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="resources.php?css=style.css" />
            
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="res/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="res/js/pupnp.js"></script>
    <script type="text/javascript">
    $(document).ready(function () {

        $("[rel=tooltip]").tooltip({
            placement : 'right'
        });
    });
    </script>
</head>
<body>

<?php require_once(dirname(__FILE__) . '/navigation.php') ?>

<div id="wrapper-all">

    <?php if(isset($error)) echo '<div id="error">' . $error . '</div>'; ?>

    <div class="span12">
        <h2><?php echo _('Configuration') ?></h2>

        <?php echo $flash ?>

        <form action="" method="post">
            <table class="table table-striped table-config">
            <?php foreach($config as $key => $data): ?>

                <?php if(isset($data->hidden)): continue; endif ?>

                <tr valign="top">
                    <td><label for="<?php echo $key ?>"<?php echo (!isset($data->null) ? ' class="bold"' : '') ?>><?php echo $data->name ?></label></td>
                    <td>
                        <?php switch($data->type): 

                            case 'string': ?>

                                <input type="text" name="config[<?php echo $key ?>]" id="<?php echo $key ?>"<?php echo (isset($errors[$key]) ? ' class="error"' : '') ?> value="<?php echo (isset($_POST['config'][$key]) ? $_POST['config'][$key] : $data->current) ?>" />
                                <?php echo (isset($errors[$key]) ? '<div class="error small">' . $errors[$key] . '</div>' : '') ?>
                                <?php break ?>

                            <?php case 'enum': ?>

                                <ul class="optgroup">
                                    <?php foreach($data->values as $k => $v): ?>
                                    <li>
                                        <?php $current = (isset($_POST['config'][$key]) ? $_POST['config'][$key] : $data->current); ?>
                                        <input type="radio" name="config[<?php echo $key ?>]" id="<?php echo $key ?>_<?php echo $k ?>" value="<?php echo $k ?>"<?php echo ($current == $k ? ' checked="checked"' : '') ?><?php echo (isset($errors[$key]) ? ' class="error"' : '') ?>  /> 
                                        <label for="<?php echo $key ?>_<?php echo $k ?>"><?php echo $v ?></label>
                                    </li>
                                    <?php endforeach ?>
                                </ul>
                                <?php echo (isset($errors[$key]) ? '<div class="error small clear">' . $errors[$key] . '</div>' : '') ?>
                                <?php break ?>

                            <?php case 'bool': ?>

                                <?php $current = (isset($_POST['config'][$key]) ? $_POST['config'][$key] : $data->current); ?>
                                <input type="hidden" name="config[<?php echo $key ?>]" value="off" />
                                <input type="checkbox" name="config[<?php echo $key ?>]" id="<?php echo $key ?>"<?php echo ($current == 1 ? ' checked="checked"' : '') ?><?php echo (isset($errors[$key]) ? ' class="error"' : '') ?> />
                                <?php echo (isset($errors[$key]) ? '<div class="error small clear">' . $errors[$key] . '</div>' : '') ?>
                                <?php break ?>

                        <?php endswitch ?>
                    </td>
                    <td>
                        <?php if(isset($data->desc)): ?>
                            <a href="javascript://" rel="tooltip" title="<?php echo htmlspecialchars($data->desc) ?>"><img src="res/images/icons/info.png" /></a>
                        <?php endif ?>
                    </td>
                </tr>

            <?php endforeach ?>

            <tr>
                <td colspan="3" align="right">
                    <input type="submit" name="save" class="btn btn-inverse" value="<?php echo _('Save') ?>" style="float: right;" />
                </td>
            </tr>
            </table>
        </form>
    </div>
</div>
</body>
</html>
