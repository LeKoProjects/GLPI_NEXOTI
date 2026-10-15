<?php

use Glpi\Http\Firewall;

define('PLUGIN_CUSTOM_LOGIN_VERSION', '2.0.0');

$folder = basename(dirname(__FILE__));

if ($folder !== "customlogin") {
   $msg = sprintf("Por favor, renomeie a pasta dso plugin de \"%s\" para \"customlogin\"", $folder);
   Session::addMessageAfterRedirect($msg, true, ERROR);
}

function plugin_init_customlogin()
{
   Firewall::addPluginStrategyForLegacyScripts(
      'customlogin',
      '#/front/config.php#',
      Firewall::STRATEGY_NO_CHECK
   );

   global $PLUGIN_HOOKS;

   $PLUGIN_HOOKS['csrf_compliant']['customlogin'] = true;

   $plugin = new Plugin();

   if ($plugin->isActivated("customlogin")) {
      $PLUGIN_HOOKS['display_login']['customlogin'] = "plugin_customlogin_display_login";
      $PLUGIN_HOOKS['config_page']['customlogin'] = 'front/config.php';

      if (isset($_SESSION['glpiactiveprofile']['id']) && $_SESSION['glpiactiveprofile']['id'] == 4) {
         $PLUGIN_HOOKS['redefine_menus']['customlogin'] = 'plugin_customlogin_redefine_menus';

         Plugin::registerClass(
            'PluginCustomloginConfig',
            [
               'addtabon' => [
                  'Config'
               ]
            ]
         );
      }
   }
}

function plugin_version_customlogin()
{
   return [
      'name'           => 'ST-Custom Login',
      'version'        =>  PLUGIN_CUSTOM_LOGIN_VERSION,
      'author'         => '<a href="https://www.servicetic.com.br" target="_blank">Stevenes Donato/Service TIC</a>',
      'license'        => 'GLPv3',
      'homepage'       => 'https://github.com/serviceticst/glpi-plugin-custom_login/releases',
      'requirements'   => [
         'glpi'   => [
            'min' => '11',
         ],
         'php'    => [
            'min' => '7.0'
         ]
      ]
   ];
}


function plugin_customlogin_check_prerequisites()
{
   return true;
}

function plugin_customlogin_check_config($verbose = false)
{
   return true;
}

function plugin_customlogin_options()
{
   return [
      Plugin::OPTION_AUTOINSTALL_DISABLED => true,
   ];
}
