<?php

namespace craftplugins\whitelabel;

use Craft;
use craft\events\TemplateEvent;
use craft\web\View;
use yii\base\Event;

/**
 * Class Plugin
 *
 * @package craftplugins\whitelabel
 */
class Plugin extends \craft\base\Plugin
{
    public function init()
    {
        parent::init();

        if (Craft::$app->request->isCpRequest) {
            Event::on(
                View::class,
                View::EVENT_BEFORE_RENDER_TEMPLATE,
                function () {
                    $view = Craft::$app->getView();

                    // Clean up the admin
                    $view->registerAssetBundle(CpAssetBundle::class);

                    $isAdmin = Craft::$app->user->getIsAdmin();
                    $isSolo = Craft::$app->edition === Craft::Solo;

                    if ($isAdmin === false || $isSolo === false) {
                        // For non-admins hide the edition notice when using the Pro edition
                        $view->registerAssetBundle(UserAssetBundle::class);
                    }
                }
            );

            Event::on(
                View::class,
                View::EVENT_AFTER_RENDER_TEMPLATE,
                function (TemplateEvent $templateEvent) {
                    if (preg_match('#id="app-info"#', $templateEvent->output)) {
                        // Remove “Craft” prefix but retain version
                        $templateEvent->output = preg_replace(
                            '#<div id="version">Craft CMS (.+)</div>#',
                            '<div id="version">CMS $1</div>',
                            $templateEvent->output
                        );
                    }
                }
            );
        }

        if (Craft::$app->request->isSiteRequest) {
            Event::on(
                View::class,
                View::EVENT_AFTER_RENDER_PAGE_TEMPLATE,
                function () {
                    $headers = Craft::$app->response->headers;

                    // Remove Craft’s stock powered by
                    $headers->remove('X-Powered-By');

                    // Put something back so hosting providers can track traffic
                    $headers->add('X-Powered-By', 'CMS');
                }
            );
        }
    }
}
