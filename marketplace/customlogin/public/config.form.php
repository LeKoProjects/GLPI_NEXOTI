<?php

require_once('../../../inc/includes.php');

global $CFG_GLPI;

// Check if plugin is activated...
$plugin = new Plugin();
if (!$plugin->isInstalled('customlogin') || !$plugin->isActivated('customlogin')) {
   exit;
}

if (!empty($_GET['img_path'])) {
   $pluginPath = (GLPI_PLUGIN_DOC_DIR . DIRECTORY_SEPARATOR . "customlogin");
   $name = preg_replace('/[^\w\-.]+/', '', $_GET['img_path']);

   Toolbox::sendFile($pluginPath . DIRECTORY_SEPARATOR . $_GET['img_path'], $name, null, true);

   exit;
}

if (!empty($_GET['img_dev'])) {
   $imgPath = GLPI_PLUGIN_DOC_DIR .
      DIRECTORY_SEPARATOR .
      'customlogin' .
      DIRECTORY_SEPARATOR .
      'dev_background.png';

   $name = preg_replace('/[^\w\-.]+/', '', 'dev_background.png');
   Toolbox::sendFile($imgPath, $name, null, true);

   exit;
}

Html::redirect($CFG_GLPI["root_doc"] . '/front/config.form.php?forcetab=PluginCustomloginConfig$1');

exit;
