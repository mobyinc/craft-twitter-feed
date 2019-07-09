<?php

namespace mobyinc\twitterfeed;

use Craft;
use craft\base\Plugin;
use craft\helpers\UrlHelper;

use mobyinc\twitterfeed\models\Settings;

class TwitterFeedPlugin extends Plugin
{

    /** @var */
    public $hasCpSettings = true;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @inheritDoc
     */
    public function afterInstall()
    {
        parent::afterInstall();

        if (Craft::$app->getRequest()->getIsConsoleRequest()) {
            return;
        }

        Craft::$app->getResponse()->redirect(
            UrlHelper::cpUrl('settings/plugins/twitterfeed')
        )->send();
    }

    /**
     * @inheritDoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritDoc
     */
    protected function settingsHtml()
    {
        return Craft::$app->getView()->renderTemplate('twitterfeed/settings', [
            'settings' => $this->getSettings()
        ]);
    }
}