<?php

namespace craftplugins\whitelabel;

use craft\web\AssetBundle;

/**
 * Class CpAssetBundle
 *
 * @package craftplugins\whitelabel
 */
class CpAssetBundle extends AssetBundle
{
    public function init()
    {
        $this->sourcePath = '@craftplugins/whitelabel/resources';

        $this->css = [
            'cp.css',
        ];

        parent::init();
    }
}
