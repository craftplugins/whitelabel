<?php

namespace craftplugins\whitelabel;

use craft\web\AssetBundle;

/**
 * Class UserAssetBundle
 *
 * @package craftplugins\whitelabel
 */
class UserAssetBundle extends AssetBundle
{
    public function init()
    {
        $this->sourcePath = '@craftplugins/whitelabel/resources';

        $this->css = [
            'user.css',
        ];

        parent::init();
    }
}
