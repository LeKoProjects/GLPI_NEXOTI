<?php

define('URL_SITE_COLOR', 'darkblue');
define('URL_SITE_COLOR_OPACITY', 0.6);
define('URL_SITE_FONT_SIZE', 12);

// Paleta da tela de login (GLPI 10+)
define('CUSTOMLOGIN_PRIMARY', '#5b2a86');
define('CUSTOMLOGIN_PRIMARY_DARK', '#3b1656');
define('CUSTOMLOGIN_PAGE_BG', '#1e0f29');

function plugin_customlogin_install()
{
   $imgPluginPath = (GLPI_PLUGIN_DOC_DIR . DIRECTORY_SEPARATOR . "customlogin");
   if (!is_dir($imgPluginPath) && !mkdir($imgPluginPath, 0777, true)) {
      return false;
   }

   $imgPath = $imgPluginPath .
      DIRECTORY_SEPARATOR .
      'dev_background.png';

   if (!copy(__DIR__ . DIRECTORY_SEPARATOR . 'pics' . DIRECTORY_SEPARATOR . 'dev_background.png', $imgPath)) {
      return false;
   }

   return true;
}

function cleanCustomLogin()
{
   $pluginTempFilesPath = (GLPI_PLUGIN_DOC_DIR . DIRECTORY_SEPARATOR . "customlogin");

   if (is_dir($pluginTempFilesPath)) {
      $files = glob($pluginTempFilesPath . DIRECTORY_SEPARATOR . '*'); // get all file names
      foreach ($files as $file) { // iterate files
         if (is_file($file)) {
            unlink($file); // delete file
         }
      }
   }

   Config::deleteConfigurationValues('customlogin', PluginCustomloginConfig::FILES_NAMES);

   $picsDirectory = GLPI_ROOT . '/public/pics/logos';

   // G
   $newImagePathBlack = $picsDirectory . '/logo-G-100-black.png';
   $newImagePathGrey = $picsDirectory . '/logo-G-100-grey.png';
   $newImagePathWhite = $picsDirectory . '/logo-G-100-white.png';

   if (file_exists($picsDirectory . '/old_logo-G-100-black.png')) {
      copy($picsDirectory . '/old_logo-G-100-black.png', $newImagePathBlack);
   }
   if (file_exists($picsDirectory . '/old_logo-G-100-grey.png')) {
      copy($picsDirectory . '/old_logo-G-100-grey.png', $newImagePathGrey);
   }
   if (file_exists($picsDirectory . '/old_logo-G-100-white.png')) {
      copy($picsDirectory . '/old_logo-G-100-white.png', $newImagePathWhite);
   }

   // LOGOS
   $newImagePathBlack = $picsDirectory . '/logo-GLPI-100-black.png';
   $newImagePathGrey = $picsDirectory . '/logo-GLPI-100-grey.png';
   $newImagePathWhite = $picsDirectory . '/logo-GLPI-100-white.png';

   if (file_exists($picsDirectory . '/old_logo-GLPI-100-black.png')) {
      copy($picsDirectory . '/old_logo-GLPI-100-black.png', $newImagePathBlack);
   }
   if (file_exists($picsDirectory . '/old_logo-GLPI-100-grey.png')) {
      copy($picsDirectory . '/old_logo-GLPI-100-grey.png', $newImagePathGrey);
   }
   if (file_exists($picsDirectory . '/old_logo-GLPI-100-white.png')) {
      copy($picsDirectory . '/old_logo-GLPI-100-white.png', $newImagePathWhite);
   }

   $newImagePathBlack = $picsDirectory . '/logo-GLPI-250-black.png';
   $newImagePathGrey = $picsDirectory . '/logo-GLPI-250-grey.png';
   $newImagePathWhite = $picsDirectory . '/logo-GLPI-250-white.png';

   if (file_exists($picsDirectory . '/old_logo-GLPI-250-black.png')) {
      copy($picsDirectory . '/old_logo-GLPI-250-black.png', $newImagePathBlack);
   }
   if (file_exists($picsDirectory . '/old_logo-GLPI-250-grey.png')) {
      copy($picsDirectory . '/old_logo-GLPI-250-grey.png', $newImagePathGrey);
   }
   if (file_exists($picsDirectory . '/old_logo-GLPI-250-white.png')) {
      copy($picsDirectory . '/old_logo-GLPI-250-white.png', $newImagePathWhite);
   }
}

function plugin_customlogin_uninstall()
{
   cleanCustomLogin();

   return true;
}

function plugin_glpi9()
{
   $url_site_color = URL_SITE_COLOR;
   $url_site_color_opacity = URL_SITE_COLOR_OPACITY;
   $url_site_font_size = URL_SITE_FONT_SIZE - 2;

   $imgLogo = PluginCustomloginConfig::getConfig('logo');
   $imgBackground = PluginCustomloginConfig::getConfig('background');
   $imgMainBackground = PluginCustomloginConfig::getConfig('main_background');

   $jsScript = "";

   if (!empty($imgLogo)) {
      $imgLogo = PluginCustomloginConfig::getImageUrl($imgLogo);
      $jsScript .= "
         var img = document.getElementById('logo_login').children[0];
         img.src = `{$imgLogo}`;
      ";
   } else $imgLogo = '';

   if (!empty($imgBackground)) {
      $imgBackground = PluginCustomloginConfig::getImageUrl($imgBackground);
      $imgBackground = "
         background-image: url(\"{$imgBackground}\");
         background-position: left;
         background-size: 70vw 102%;
         background-repeat: no-repeat;
      ";
   } else $imgBackground = '';

   if (!empty($imgMainBackground)) {
      $imgMainBackground = PluginCustomloginConfig::getImageUrl($imgMainBackground);
   } else $imgMainBackground = Html::getPrefixedUrl('/plugins/customlogin/front/config.php?img_dev=dev_background.png');

   $jsScript .= "
      var textLogin = document.getElementById('text-login');

      if (!textLogin.innerHTML.trim()) {
         textLogin.innerHTML = '<h2>Faça login para sua conta</h2>';
      }

      var loginInput = document.getElementsByClassName('submit')[0];
      loginInput.value = 'Entrar';

      var divEl = document.createElement('div');
      divEl.id = 'root-div';

      var bodyEl = document.getElementsByTagName('body')[0];

      divEl.innerHTML = bodyEl.innerHTML;
      bodyEl.innerHTML = '';

      bodyEl.appendChild(divEl);

      var divElDev = document.createElement('div');
      divElDev.id = 'root-div-dev';
      divElDev.innerHTML = `
         <a href=\"https://servicetic.com.br/\" title=\"Desenvolvido por Service TIC\" class=\"dev\" target=\"_blank\">
            Desenvolvido por Service TIC
         </a>
      `;

      bodyEl.appendChild(divElDev);
   ";

   echo "
      <style>
      :root {
         --login-font: Inter, system-ui, -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, \"Helvetica Neue\", sans-serif;
         --dev-font: Verdana, Arial, Helvetica, sans-serif;
         --card-bg: #fff;
         --text: #111;
         --border: rgb(98 105 118 / .16);
         --shadow: 0 10px 40px rgb(0 0 0 / .18), 0 2px 6px rgb(0 0 0 / .08);
         --radius: 16px;
         --logo-size: clamp(120px, 18vh, 195px);
         --gap-y: clamp(40px, 8vh, 75px);
         --gap-x: clamp(16px, 4vw, 40px);
         --dev-size: {$url_site_font_size}px;
         --dev-color: {$url_site_color};
         --dev-opacity: {$url_site_color_opacity};
      }

      *, *::before, *::after { box-sizing: border-box; }

      body {
         position: relative;
         margin: 0;
         width: 100dvw;
         height: 100dvh;
         overflow: hidden;
         font-family: var(--login-font);
         background: url(\"{$imgMainBackground}\") left / cover no-repeat;
         -webkit-font-smoothing: antialiased;
      }

      :is(div, label, a) { color: var(--text) !important; }

      /* ===== Card ===== */
      #root-div {
         position: absolute;
         inset: var(--gap-y) var(--gap-x);
         overflow: hidden;
         background-color: var(--card-bg) !important;
         border-radius: var(--radius);
         box-shadow: var(--shadow);
         font-family: var(--login-font);
      }

      #firstboxlogin {
         position: absolute;
         inset: 0;
         display: flex;
         flex-direction: column;
         align-items: center;
         justify-content: center;
         gap: 1rem;
         min-height: unset !important;
         background: var(--card-bg) !important;
      }

      #logo_login, #text-login { background: transparent !important; }
      #logo_login { padding: 0 !important; }

      #logo_login > img {
         width: var(--logo-size) !important;
         height: var(--logo-size) !important;
         object-fit: contain;
         transition: width .2s, height .2s;
      }

      #text-login {
         border-bottom: 1px solid var(--border);
         overflow: visible !important;
      }

      #display-login, #text-login {
         width: 100%;
         padding: 20px clamp(16px, 20%, 120px) !important;
      }

      h2 {
         margin: 0;
         font-size: clamp(1.1rem, 1.2vw + .5rem, 1.35rem) !important;
         font-weight: 600;
         line-height: 1.4;
         text-align: center;
         text-wrap: balance;
      }

      /* ===== Dev / footer ===== */
      #root-div-dev, .dev {
         font-size: var(--dev-size) !important;
         color: var(--dev-color) !important;
         opacity: var(--dev-opacity) !important;
      }

      #root-div-dev {
         position: absolute;
         bottom: 15px !important;
         inset-inline: 0;
         text-align: center;
         font-family: var(--dev-font);
         font-weight: 700;
      }

      #footer-login { display: block !important; }

      #footer-login.home {
         position: absolute;
         bottom: 55px !important;
         inset-inline: 0;
         text-align: center;
      }

      /* ===== Desktop ===== */
      @media (min-width: 1024px) {
         #root-div {
            inset: 45px 40px;
            {$imgBackground}
            background-color: var(--card-bg) !important;
         }

         #firstboxlogin {
            inset: 0 0 0 auto;
            width: min(30vw, 480px) !important;
            padding-bottom: 50px;
            box-shadow: -8px 0 24px rgb(0 0 0 / .08);
         }

         #display-login, #text-login { padding: 20px 2rem !important; }

         #root-div-dev {
            inset-inline: auto 50px;
            text-align: right;
         }

         #footer-login.home {
            inset-inline: auto 50px;
            text-align: right;
         }

         .copyright { font-size: 9px !important; }
      }

      /* ===== Telas baixas ===== */
      @media (max-height: 720px) {
         #logo_login > img { display: none; }
      }

      @media (prefers-reduced-motion: reduce) {
         * { transition: none !important; }
      }
      </style>
   ";

   echo Html::scriptBlock($jsScript);
}

function plugin_glpi10()
{
   global $CFG_GLPI;

   $primary = CUSTOMLOGIN_PRIMARY;
   $primaryDark = CUSTOMLOGIN_PRIMARY_DARK;
   $pageBg = CUSTOMLOGIN_PAGE_BG;

   $imgLogo = PluginCustomloginConfig::getConfig('logo');
   $imgBackground = PluginCustomloginConfig::getConfig('background');
   $imgMainBackground = PluginCustomloginConfig::getConfig('main_background');

   $jsScript = "";

   if (!empty($imgLogo)) {
      $imgLogo = PluginCustomloginConfig::getImageUrl($imgLogo);
      $imgLogo = "content: url(\"{$imgLogo}\") !important;";
   } else $imgLogo = '';

   // Imagem lateral: camada nítida (contain) sobre uma cópia desfocada (cover),
   // para nunca distorcer nem cortar a arte, independente da proporção da tela.
   if (!empty($imgBackground)) {
      $imgBackground = PluginCustomloginConfig::getImageUrl($imgBackground);
      $imgBackgroundBlur = "background-image: url(\"{$imgBackground}\");";
      $imgBackground = "background-image: url(\"{$imgBackground}\");";
   } else {
      $imgBackgroundBlur = '';
      $imgBackground = '';
   }

   if (!empty($imgMainBackground)) {
      $imgMainBackground = PluginCustomloginConfig::getImageUrl($imgMainBackground);
   } else $imgMainBackground = Html::getPrefixedUrl('/plugins/customlogin/front/config.php?img_dev=dev_background.png');

   $jsScript .= "
      var divElDev = document.createElement('div');
      divElDev.id = 'root-div-dev';
      divElDev.innerHTML = `
         <a href=\"https://servicetic.com.br/\" title=\"Desenvolvido por Service TIC\" class=\"dev\" target=\"_blank\">
            Desenvolvido por Service TIC
         </a>
      `;

      var imgEl = document.querySelector('.container-tight > .text-center');
      var cardEl = document.querySelector('.main-content-card form > .row');
      if (imgEl && cardEl) {
         imgEl.remove();
         cardEl.children[0].className = 'col-md-12';
         cardEl.children[0].insertBefore(imgEl, cardEl.children[0].firstChild);
      }

      var divElImg = document.createElement('div');
      divElImg.id = 'card-div-img';
      var elCardBody = document.querySelector('.main-content-card > .card-body');
      if (elCardBody) {
         elCardBody.insertBefore(divElImg, elCardBody.firstChild);
      }

      var footerEl = document.querySelector('.container-tight > .text-muted');
      (footerEl || document.body).appendChild(divElDev);

      function aguardarElementoExistir(selector, callback) {
         const interval = 100; // Intervalo de verificação em milissegundos
         let tempoMaximo = 5000; // Tempo máximo para aguardar (5 segundos)

         const verificarExistencia = () => {
           const elSelected = document.querySelector(selector);
           if (elSelected) {
             callback(elSelected);
           } else if (tempoMaximo > 0) {
             setTimeout(verificarExistencia, interval);
             tempoMaximo -= interval;
           }
         };

         verificarExistencia();
       }

       // NEWS
       aguardarElementoExistir('.plugin_news_alert-container', function(elemento) {
         if (elemento.hasChildNodes()) {
            document.body.classList.add('customlogin-has-news');
         }
       });
   ";

   if (!empty($CFG_GLPI['text_login']) && strlen(strval($CFG_GLPI['text_login'])) > 0) {
      $loginText = html_entity_decode(strval($CFG_GLPI['text_login']));
      $jsScript .= "
         var textLogin = document.querySelector('.main-content-card .card-header.mb-4 > h2');
         var oldTextLogin = document.querySelector('.main-content-card form > .rich_text_container');

         if (oldTextLogin) oldTextLogin.style.display = 'none';
         if (textLogin) textLogin.innerHTML = `{$loginText}`;
      ";
   }

   echo "
      <style>
      :root {
         --cl-primary: {$primary};
         --cl-primary-dark: {$primaryDark};
         --cl-page-bg: {$pageBg};
         --cl-text: #1f1530;
         --cl-muted: #6b6478;
         --cl-border: #e3dde9;
         --cl-input-bg: #f8f6fb;
         --cl-radius: 18px;
      }

      @keyframes customlogin-fade-up {
         from { opacity: 0; transform: translateY(14px); }
         to   { opacity: 1; transform: translateY(0); }
      }

      body.welcome-anonymous {
         min-height: 100vh;
         margin: 0;
         background-color: var(--cl-page-bg) !important;
         background-image:
            radial-gradient(ellipse at 15% 10%, rgba(139, 92, 246, .22), transparent 55%),
            radial-gradient(ellipse at 90% 95%, rgba(91, 42, 134, .35), transparent 55%),
            linear-gradient(rgba(20, 8, 28, .55), rgba(20, 8, 28, .55)),
            url(\"{$imgMainBackground}\");
         background-size: cover;
         background-position: center;
         background-attachment: fixed;
         font-family: Inter, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
      }

      .page-anonymous,
      .page-anonymous > div {
         min-height: 100vh;
         padding: 0 !important;
         margin: 0 !important;
      }
      .page-anonymous > div {
         justify-content: center;
         align-items: center;
      }

      /* ----- Cartão principal ----- */
      .page-anonymous .container-tight {
         max-width: unset !important;
         width: min(1360px, 92vw) !important;
         padding: 32px 0 !important;
      }
      .main-content-card {
         height: min(820px, calc(100vh - 140px));
         min-height: 560px;
         border: 0 !important;
         border-radius: var(--cl-radius) !important;
         overflow: hidden;
         background: #fff !important;
         box-shadow: 0 30px 80px -20px rgba(0, 0, 0, .55), 0 0 0 1px rgba(255, 255, 255, .06);
         animation: customlogin-fade-up .5s ease-out both;
      }
      .main-content-card > .card-header:empty {
         display: none;
      }
      .main-content-card > .card-body {
         padding: 0 !important;
         display: flex;
         flex-direction: row;
         height: 100%;
         overflow: hidden;
      }

      /* ----- Painel da imagem ----- */
      #card-div-img {
         flex: 1 1 auto;
         position: relative;
         overflow: hidden;
         background: linear-gradient(135deg, var(--cl-primary-dark), var(--cl-primary));
      }
      #card-div-img::before,
      #card-div-img::after {
         content: '';
         position: absolute;
         inset: 0;
         background-repeat: no-repeat;
         background-position: center;
      }
      #card-div-img::before {
         {$imgBackgroundBlur}
         background-size: cover;
         filter: blur(28px) saturate(1.1);
         transform: scale(1.15);
      }
      #card-div-img::after {
         {$imgBackground}
         background-size: contain;
      }

      /* ----- Painel do formulário ----- */
      .main-content-card form {
         flex: 0 0 460px;
         height: 100%;
         overflow-y: auto;
         padding: 48px 56px !important;
         display: flex;
         flex-direction: column;
         justify-content: center;
         background: #fff;
         color: var(--cl-text);
         box-shadow: -12px 0 32px -16px rgba(30, 15, 41, .35);
         position: relative;
         z-index: 1;
      }
      .main-content-card form > .row {
         margin: 0;
      }
      .main-content-card form > .row > .col-md-12 {
         padding: 0 !important;
      }
      .main-content-card form .col-auto.px-2.text-center {
         display: none;
      }

      .glpi-logo {
         display: block;
         width: 190px !important;
         height: 96px !important;
         margin: 0 auto 8px !important;
         object-fit: contain;
         background-size: contain !important;
         background-position: center !important;
         {$imgLogo}
      }

      .main-content-card .card-header.mb-4 {
         border: 0 !important;
         padding: 0 0 4px !important;
         margin-bottom: 28px !important;
         background: transparent !important;
         flex-direction: column;
      }
      .main-content-card .card-header.mb-4 > h2 {
         font-size: 1.35rem !important;
         font-weight: 700;
         color: var(--cl-text) !important;
         letter-spacing: -.01em;
         margin: 0 auto;
         text-align: center;
      }
      .main-content-card .card-header.mb-4::after {
         content: '';
         display: block;
         width: 44px;
         height: 3px;
         margin: 14px auto 0;
         border-radius: 3px;
         background: linear-gradient(90deg, var(--cl-primary), #8b5cf6);
      }

      .main-content-card .form-label {
         font-size: .8rem;
         font-weight: 600;
         color: var(--cl-muted) !important;
         text-transform: uppercase;
         letter-spacing: .04em;
         margin-bottom: 6px;
      }
      .main-content-card .form-control,
      .main-content-card .select2-container--default .select2-selection--single,
      .main-content-card select.form-select {
         height: 46px !important;
         padding: 0 14px;
         border: 1px solid var(--cl-border) !important;
         border-radius: 10px !important;
         background-color: var(--cl-input-bg) !important;
         color: var(--cl-text) !important;
         font-size: .95rem;
         transition: border-color .15s ease, box-shadow .15s ease, background-color .15s ease;
      }
      .main-content-card .select2-container--default .select2-selection--single {
         display: flex;
         align-items: center;
      }
      .main-content-card .select2-container--default .select2-selection--single .select2-selection__rendered {
         padding-left: 0;
         color: var(--cl-text) !important;
         line-height: 44px;
      }
      .main-content-card .select2-container--default .select2-selection--single .select2-selection__arrow {
         height: 44px;
         right: 8px;
      }
      .main-content-card .form-control:hover,
      .main-content-card .select2-selection--single:hover {
         border-color: #cfc5da !important;
      }
      .main-content-card .form-control:focus,
      .main-content-card .select2-container--focus .select2-selection--single,
      .main-content-card .select2-container--open .select2-selection--single {
         border-color: var(--cl-primary) !important;
         background-color: #fff !important;
         box-shadow: 0 0 0 4px rgba(91, 42, 134, .14) !important;
         outline: none;
      }

      .main-content-card .form-check-label {
         color: var(--cl-muted) !important;
         font-size: .9rem;
      }
      .main-content-card .form-check-input:checked {
         background-color: var(--cl-primary) !important;
         border-color: var(--cl-primary) !important;
      }
      .main-content-card .form-check-input:focus {
         box-shadow: 0 0 0 4px rgba(91, 42, 134, .14);
      }

      .main-content-card .form-footer {
         margin-top: 24px;
      }
      .main-content-card .form-footer .btn-primary {
         height: 48px;
         border: 0 !important;
         border-radius: 10px !important;
         background: linear-gradient(135deg, var(--cl-primary), var(--cl-primary-dark)) !important;
         color: #fff !important;
         font-size: 1rem;
         font-weight: 600;
         letter-spacing: .02em;
         box-shadow: 0 10px 24px -10px rgba(91, 42, 134, .8);
         transition: transform .15s ease, box-shadow .15s ease, filter .15s ease;
      }
      .main-content-card .form-footer .btn-primary:hover {
         transform: translateY(-1px);
         filter: brightness(1.08);
         box-shadow: 0 14px 28px -10px rgba(91, 42, 134, .9);
      }
      .main-content-card .form-footer .btn-primary:active {
         transform: translateY(0);
      }
      .main-content-card .forgot_password a {
         color: var(--cl-primary) !important;
         font-size: .875rem;
         font-weight: 500;
      }

      /* ----- Rodapé ----- */
      .container-tight > .text-muted {
         margin-top: 20px !important;
         color: rgba(255, 255, 255, .45) !important;
         font-size: .75rem;
      }
      .container-tight > .text-muted a {
         color: rgba(255, 255, 255, .6) !important;
      }
      #root-div-dev {
         margin-top: 6px;
         font-size: .75rem;
         font-weight: 600;
      }
      #root-div-dev .dev {
         color: rgba(255, 255, 255, .5) !important;
         text-decoration: none;
         transition: color .15s ease;
      }
      #root-div-dev .dev:hover {
         color: #fff !important;
      }

      /* Plugin News: libera altura quando houver alertas */
      body.customlogin-has-news .main-content-card {
         height: auto;
      }

      /* ----- Tablet / mobile: só o formulário ----- */
      @media only screen and (max-width: 1024px) {
         .page-anonymous .container-tight {
            width: min(460px, 92vw) !important;
         }
         .main-content-card {
            height: auto;
            min-height: unset;
         }
         #card-div-img {
            display: none;
         }
         .main-content-card form {
            flex: 1 1 auto;
            padding: 40px 32px !important;
            box-shadow: none;
         }
      }

      @media only screen and (max-height: 720px) {
         .glpi-logo {
            height: 64px !important;
         }
         .main-content-card .card-header.mb-4 {
            margin-bottom: 18px !important;
         }
      }
      </style>
   ";

   echo Html::scriptBlock($jsScript);
}

function plugin_customlogin_display_login()
{
   if (version_compare(GLPI_VERSION, '9.0', 'ge') && version_compare(GLPI_VERSION, '10.0', 'lt')) {
      plugin_glpi9();
   } else if (version_compare(GLPI_VERSION, '10.0', 'ge')) {
      plugin_glpi10();
   };
}

function plugin_customlogin_redefine_menus($menu)
{
   if (empty($menu)) {
      return $menu;
   }

   if (empty($menu['servicetic'])) {
      $menu['servicetic'] = [
         'title' => __('ST-Módulos'),
         'icon'  => __('fa-solid fa-list'),
         'types'  => [],
         'content' => [],
      ];
   }

   $menu['servicetic']['content']['customlogin'] = [
      'title' => __('ST-Custom Login'),
      'page'  => '/plugins/customlogin/front/config.php',
      'icon'  => 'fas fa-user-shield',
   ];


   // Sort menu by title
   usort($menu['servicetic']['content'], function ($a, $b) {
      return strcmp($a['title'], $b['title']);
   });

   return $menu;
}
