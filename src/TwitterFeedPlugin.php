<?php

namespace mobyinc\twitterfeed;

use yii\base\Event;

use Craft;
use craft\base\Plugin;
use craft\helpers\UrlHelper;
use craft\web\twig\variables\CraftVariable;

use mobyinc\twitterfeed\models\Settings;
use mobyinc\twitterfeed\services\TwitterService;
use mobyinc\twitterfeed\variables\TwitterFeedVariable;

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

        $this->setComponents([
            'twitterService' => TwitterService::class,
        ]);

        Event::on(CraftVariable::class, CraftVariable::EVENT_INIT, function(Event $event) {
            $variable = $event->sender;
            $variable->set('twitter', TwitterFeedVariable::class);
        });
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