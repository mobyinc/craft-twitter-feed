<?php

namespace mobyinc\twitterfeed;

use craft\base\Plugin;

class TwitterFeedPlugin extends Plugin
{
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
        //
    }
}