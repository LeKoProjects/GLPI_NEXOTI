<?php

class PluginCustomloginConfig extends CommonDBTM
{
    private static $CACHE = null;

    const FILES_PLUGIN_DIR = (GLPI_PLUGIN_DOC_DIR . DIRECTORY_SEPARATOR . "customlogin");

    const FILES_NAMES = [
        'logo',
        'logo_menu',
        'logo_menu_rec',
        'background',
        'main_background'
    ];

    function getTabNameForItem(CommonGLPI $item, $withtemplate = 0)
    {
        switch ($item::getType()) {
            case 'Config':
                return '<span class="d-flex align-items-center"><i class="ti ti-user-shield me-2"></i>' . __('ST-Custom Login', 'customlogin') . '</span>';
                break;
        }
        return '';
    }

    static function displayTabContentForItem(CommonGLPI $item, $tabnum = 1, $withtemplate = 0)
    {
        switch ($item::getType()) {
            case 'Config':
                $config = new self();
                $config->show();
                break;
        }
    }

    static function getConfig($name, $defaultValue = null)
    {
        if (self::$CACHE === null) {
            $config = new self();

            $config->fields = array_merge($config->fields, Config::getConfigurationValues('customlogin'));

            self::$CACHE = $config->fields;
        }

        if (isset(self::$CACHE[$name]) && self::$CACHE[$name] !== '') {
            return self::$CACHE[$name];
        }

        return $defaultValue;
    }

    static function checkAllValuesExcept(string $keyExcept, array $fields)
    {
        foreach (self::FILES_NAMES as $key => $value) {
            if ($value != $keyExcept && !empty($fields[$value])) return true;
        }

        return false;
    }

    public function show()
    {
        if (!Config::canView()) {
            return false;
        }

        $fields = [
            "logo" => "",
            "logo_menu" => "",
            "logo_menu_rec" => "",
            "background" => "",
            "main_background" => "",
        ];

        $fields = array_merge($fields, Config::getConfigurationValues('customlogin'));

        echo "
            <style>
                #customlogin_tbody td {
                    padding-top: 10px;
                }
            </style>
        ";

        echo "<form name='form' action=\"" . Toolbox::getItemTypeFormURL('Config') . "\" method='post'>";
        echo Html::hidden('config_context', ['value' => 'customlogin']);
        echo Html::hidden('config_class', ['value' => __CLASS__]);

        echo "<div class=\"center\">";
        echo "<table class=\"tab_cadre_fixe\">";
        echo "<tbody id=\"customlogin_tbody\">";
        echo "<tr><th colspan=\"4\" >Personalização</th></tr>";

        echo "<tr><td></td></tr>";

        // LOGO
        echo "<tr class=\"tab_bg_1\"><td>Logo Login (Tamanho: <b>250 x 138</b>)</td>";
        if (!empty($fields['logo'])) {
            echo '<td style="text-align: center;">';
            echo Html::image(self::getImageUrl($fields['logo']), [
                'style' => '
                    max-width: 100px;
                    max-height: 100px;
                    background-image: linear-gradient(45deg, #b0b0b0 25%, transparent 25%), linear-gradient(-45deg, #b0b0b0 25%, transparent 25%), linear-gradient(45deg, transparent 75%, #b0b0b0 75%), linear-gradient(-45deg, transparent 75%, #b0b0b0 75%);
                    background-size: 10px 10px;
                    background-position: 0 0, 0 5px, 5px -5px, -5px 0px;',
                'class' => 'picture_square'
            ]);
            echo '</td>';
        } else if (self::checkAllValuesExcept('logo', $fields)) {
            echo '<td></td>';
        }

        echo "<td>";

        Html::file([
            'name'       => "logo",
            'onlyimages' => true,
            'multiple'   => false,
            'max_files'  => 1
        ]);
        echo "</td></tr>";

        // LOGO MENU
        echo "<tr class=\"tab_bg_1\"><td>Logo Menu (Tamanho: <b>100 x 55</b>)</td>";
        if (!empty($fields['logo_menu'])) {
            echo '<td style="text-align: center;">';
            echo Html::image(self::getImageUrl($fields['logo_menu']), [
                'style' => '
                    max-width: 100px;
                    max-height: 100px;
                    background-image: linear-gradient(45deg, #b0b0b0 25%, transparent 25%), linear-gradient(-45deg, #b0b0b0 25%, transparent 25%), linear-gradient(45deg, transparent 75%, #b0b0b0 75%), linear-gradient(-45deg, transparent 75%, #b0b0b0 75%);
                    background-size: 10px 10px;
                    background-position: 0 0, 0 5px, 5px -5px, -5px 0px;',
                'class' => 'picture_square'
            ]);
            echo '</td>';
        } else if (self::checkAllValuesExcept('logo_menu', $fields)) {
            echo '<td></td>';
        }

        echo "<td>";

        Html::file([
            'name'       => "logo_menu",
            'onlyimages' => true,
            'multiple'   => false,
            'max_files'  => 1
        ]);
        echo "</td></tr>";

        // LOGO MENU SMALL
        echo "<tr class=\"tab_bg_1\"><td>Logo Menu Recolhido (Tamanho: <b>53 x 53</b>)</td>";
        if (!empty($fields['logo_menu_rec'])) {
            echo '<td style="text-align: center;">';
            echo Html::image(self::getImageUrl($fields['logo_menu_rec']), [
                'style' => '
                    max-width: 100px;
                    max-height: 100px;
                    background-image: linear-gradient(45deg, #b0b0b0 25%, transparent 25%), linear-gradient(-45deg, #b0b0b0 25%, transparent 25%), linear-gradient(45deg, transparent 75%, #b0b0b0 75%), linear-gradient(-45deg, transparent 75%, #b0b0b0 75%);
                    background-size: 10px 10px;
                    background-position: 0 0, 0 5px, 5px -5px, -5px 0px;',
                'class' => 'picture_square'
            ]);
            echo '</td>';
        } else if (self::checkAllValuesExcept('logo_menu_rec', $fields)) {
            echo '<td></td>';
        }

        echo "<td>";

        Html::file([
            'name'       => "logo_menu_rec",
            'onlyimages' => true,
            'multiple'   => false,
            'max_files'  => 1
        ]);
        echo "</td></tr>";

        // BACKGROUND
        echo "<tr class=\"tab_bg_1\"><td>Imagem Lateral (Tamanho: <b>1250 x 770</b>)</td>";
        if (!empty($fields['background'])) {
            echo '<td style="text-align: center;">';
            echo Html::image(self::getImageUrl($fields['background']), [
                'style' => '
                    max-width: 100px;
                    max-height: 100px;
                    background-image: linear-gradient(45deg, #b0b0b0 25%, transparent 25%), linear-gradient(-45deg, #b0b0b0 25%, transparent 25%), linear-gradient(45deg, transparent 75%, #b0b0b0 75%), linear-gradient(-45deg, transparent 75%, #b0b0b0 75%);
                    background-size: 10px 10px;
                    background-position: 0 0, 0 5px, 5px -5px, -5px 0px;',
                'class' => 'picture_square'
            ]);
            echo '</td>';
        } else if (self::checkAllValuesExcept('background', $fields)) {
            echo '<td></td>';
        }

        echo "<td>";

        Html::file([
            'name'       => "background",
            'onlyimages' => true,
            'multiple'   => false,
            'max_files'  => 1
        ]);
        echo "</td></tr>";

        // MAIN BACKGROUND
        echo "<tr class=\"tab_bg_1\"><td>Imagem de Fundo (Tamanho: <b>1920 x 1080</b>)</td>";
        if (!empty($fields['main_background'])) {
            echo '<td style="text-align: center;">';
            echo Html::image(self::getImageUrl($fields['main_background']), [
                'style' => '
                    max-width: 100px;
                    max-height: 100px;
                    background-image: linear-gradient(45deg, #b0b0b0 25%, transparent 25%), linear-gradient(-45deg, #b0b0b0 25%, transparent 25%), linear-gradient(45deg, transparent 75%, #b0b0b0 75%), linear-gradient(-45deg, transparent 75%, #b0b0b0 75%);
                    background-size: 10px 10px;
                    background-position: 0 0, 0 5px, 5px -5px, -5px 0px;',
                'class' => 'picture_square'
            ]);
            echo '</td>';
        } else if (self::checkAllValuesExcept('main_background', $fields)) {
            echo '<td></td>';
        }

        echo "<td>";

        Html::file([
            'name'       => "main_background",
            'onlyimages' => true,
            'multiple'   => false,
            'max_files'  => 1
        ]);
        echo "</td></tr>";

        echo "<tr><td></td></tr>";

        echo "<tr class='tab_bg_1'><td class='center' style=\"text-align: center;\" colspan='4'>";
        echo "<input type='submit' name='update' class='submit' value=\"" . __s('Salvar') . "\" >";
        echo "</td></tr>\n";

        echo "</tbody>";
        echo "</table>";
        echo "</div>";

        Html::closeForm();
    }

    static function configUpdate($input)
    {
        $old = Config::getConfigurationValues('customlogin');

        $input['logo'] = empty($input['_logo']) ? null : $input['_logo'][array_key_last($input['_logo'])];
        $input['logo_menu'] = empty($input['_logo_menu']) ? null : $input['_logo_menu'][array_key_last($input['_logo_menu'])];
        $input['logo_menu_rec'] = empty($input['_logo_menu_rec']) ? null : $input['_logo_menu_rec'][array_key_last($input['_logo_menu_rec'])];
        $input['background'] = empty($input['_background']) ? null : $input['_background'][array_key_last($input['_background'])];
        $input['main_background'] = empty($input['_main_background']) ? null : $input['_main_background'][array_key_last($input['_main_background'])];

        $input = self::checkPicture('logo', 'logo', $input, $old, 250, 138, 250);
        $input = self::checkPicture('logo_menu', 'logo_menu', $input, $old, 100, 55, 100);
        $input = self::checkPicture('logo_menu_rec', 'logo_menu_rec', $input, $old, 53, 53, 53);
        $input = self::checkPicture('background', 'background', $input, $old);
        $input = self::checkPicture('main_background', 'main_background', $input, $old);

        unset($input['_logo']);
        unset($input['_prefix_logo']);
        unset($input['_tag_logo']);
        unset($input['_uploader_logo']);

        unset($input['_logo_menu']);
        unset($input['_prefix_logo_menu']);
        unset($input['_tag_logo_menu']);
        unset($input['_uploader_logo_menu']);

        unset($input['_logo_menu_rec']);
        unset($input['_prefix_logo_menu_rec']);
        unset($input['_tag_logo_menu_rec']);
        unset($input['_uploader_logo_menu_rec']);

        unset($input['_background']);
        unset($input['_prefix_background']);
        unset($input['_tag_background']);
        unset($input['_uploader_background']);

        unset($input['_main_background']);
        unset($input['_prefix_main_background']);
        unset($input['_tag_main_background']);
        unset($input['_uploader_main_background']);

        $input['logo'] = $input['logo'] ?? $old['logo'];
        $input['logo_menu'] = $input['logo_menu'] ?? $old['logo_menu'];
        $input['logo_menu_rec'] = $input['logo_menu_rec'] ?? $old['logo_menu_rec'];
        $input['background'] = $input['background'] ?? $old['background'];
        $input['main_background'] = $input['main_background'] ?? $old['main_background'];

        return $input;
    }

    static function checkPicture($name, $filename, $input, $old, $width = 0, $height = 0, $max_size = 500)
    {
        if (empty($input[$name])) return $input;

        $tempImg = $input[$name];
        $imgPath = GLPI_TMP_DIR . '/' . $tempImg;
        $imgPathDefault = $imgPath;
        $imgResizedPath = GLPI_TMP_DIR . '/resized_' . $tempImg;

        if ($width || $height) {
            if (Toolbox::resizePicture($imgPath, $imgResizedPath, $width, $height, 0, 0, 0, 0, $max_size)) {
                $imgPath = $imgResizedPath;
            }
        }

        if ($dest = self::savePicture($imgPath, $filename, $old, $name)) {
            $input[$name] = $dest;

            if ($name === "logo") {
                $picsDirectory = GLPI_ROOT . '/public/pics/logos';

                // LOGO 250
                $newImagePathBlack = $picsDirectory . '/logo-GLPI-250-black.png';
                $newImagePathGrey = $picsDirectory . '/logo-GLPI-250-grey.png';
                $newImagePathWhite = $picsDirectory . '/logo-GLPI-250-white.png';

                if (!file_exists($picsDirectory . '/old_logo-GLPI-250-black.png')) {
                    rename($newImagePathBlack, $picsDirectory . '/old_logo-GLPI-250-black.png');
                }
                if (!file_exists($picsDirectory . '/old_logo-GLPI-250-grey.png')) {
                    rename($newImagePathGrey, $picsDirectory . '/old_logo-GLPI-250-grey.png');
                }
                if (!file_exists($picsDirectory . '/old_logo-GLPI-250-white.png')) {
                    rename($newImagePathWhite, $picsDirectory . '/old_logo-GLPI-250-white.png');
                }

                Toolbox::resizePicture($imgPathDefault, $newImagePathBlack, 250, 138, 0, 0, 0, 0, 250);
                Toolbox::resizePicture($imgPathDefault, $newImagePathGrey, 250, 138, 0, 0, 0, 0, 250);
                Toolbox::resizePicture($imgPathDefault, $newImagePathWhite, 250, 138, 0, 0, 0, 0, 250);
            } else if ($name === "logo_menu") {
                $picsDirectory = GLPI_ROOT . '/public/pics/logos';

                // LOGO 100
                $newImagePathBlack = $picsDirectory . '/logo-GLPI-100-black.png';
                $newImagePathGrey = $picsDirectory . '/logo-GLPI-100-grey.png';
                $newImagePathWhite = $picsDirectory . '/logo-GLPI-100-white.png';

                if (!file_exists($picsDirectory . '/old_logo-GLPI-100-black.png')) {
                    rename($newImagePathBlack, $picsDirectory . '/old_logo-GLPI-100-black.png');
                }
                if (!file_exists($picsDirectory . '/old_logo-GLPI-100-grey.png')) {
                    rename($newImagePathGrey, $picsDirectory . '/old_logo-GLPI-100-grey.png');
                }
                if (!file_exists($picsDirectory . '/old_logo-GLPI-100-white.png')) {
                    rename($newImagePathWhite, $picsDirectory . '/old_logo-GLPI-100-white.png');
                }

                Toolbox::resizePicture($imgPathDefault, $newImagePathBlack, 100, 55, 0, 0, 0, 0, 100);
                Toolbox::resizePicture($imgPathDefault, $newImagePathGrey, 100, 55, 0, 0, 0, 0, 100);
                Toolbox::resizePicture($imgPathDefault, $newImagePathWhite, 100, 55, 0, 0, 0, 0, 100);
            } else if ($name === "logo_menu_rec") {
                $picsDirectory = GLPI_ROOT . '/public/pics/logos';

                // LOGO G 100
                $newImagePathBlack = $picsDirectory . '/logo-G-100-black.png';
                $newImagePathGrey = $picsDirectory . '/logo-G-100-grey.png';
                $newImagePathWhite = $picsDirectory . '/logo-G-100-white.png';

                if (!file_exists($picsDirectory . '/old_logo-G-100-black.png')) {
                    rename($newImagePathBlack, $picsDirectory . '/old_logo-G-100-black.png');
                }
                if (!file_exists($picsDirectory . '/old_logo-G-100-grey.png')) {
                    rename($newImagePathGrey, $picsDirectory . '/old_logo-G-100-grey.png');
                }
                if (!file_exists($picsDirectory . '/old_logo-G-100-white.png')) {
                    rename($newImagePathWhite, $picsDirectory . '/old_logo-G-100-white.png');
                }

                Toolbox::resizePicture($imgPathDefault, $newImagePathBlack, 53, 53, 0, 0, 0, 0, 53);
                Toolbox::resizePicture($imgPathDefault, $newImagePathGrey, 53, 53, 0, 0, 0, 0, 53);
                Toolbox::resizePicture($imgPathDefault, $newImagePathWhite, 53, 53, 0, 0, 0, 0, 53);
            }
        } else {
            Session::addMessageAfterRedirect(__('Não foi possível salvar a imagem.'), true, ERROR);
        }

        return $input;
    }

    static public function savePicture($src, $filename, $old, $name)
    {
        $imgPluginPath = self::FILES_PLUGIN_DIR;

        if (function_exists('Document::isImage') && !Document::isImage($src)) {
            return false;
        } else if (function_exists('Document::isPicture') && !Document::isPicture($src)) {
            return false;
        }

        if (!empty($old[$name])) {
            $destOld = $imgPluginPath . DIRECTORY_SEPARATOR . $old[$name];
            if (file_exists($destOld)) {
                if (!@unlink($destOld)) return false;
            }
        }

        $ext = pathinfo($src, PATHINFO_EXTENSION);
        $dest = $imgPluginPath . DIRECTORY_SEPARATOR . $filename . uniqid() . '.' . $ext;

        if (!is_dir($imgPluginPath) && !mkdir($imgPluginPath, 0777, true)) {
            return false;
        }

        if (!rename($src, $dest)) {
            return false;
        }

        return substr($dest, strlen($imgPluginPath . '/')); // Return dest relative to GLPI_PICTURE_DIR
    }

    static public function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    static function getImageUrl($imgPath)
    {
        $imgPath = Html::cleanInputText($imgPath); // prevent xss

        if (empty($imgPath)) {
            return null;
        }

        return Html::getPrefixedUrl('/plugins/customlogin/front/config.php?img_path=' . $imgPath);
    }
}
