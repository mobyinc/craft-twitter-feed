<?php

namespace mobyinc\twitterfeed\services;

use craft\base\Component;
use mobyinc\twitterfeed\TwitterFeedPlugin;

class TwitterService extends Component
{

    /** @var string $handle  */
    protected $handle;

    public function __construct()
    {
        $this->twitterHandle = TwitterFeedPlugin::getInstance()->getSettings()->twitterHandle;
    }

    /**
     * Returns the current Twitter feed of the configured account.
     * Checks local cache store prior to sending requests to Twitter.
     *
     * @param string $twitterHandle Optional account name to fetch. If not presented, the account from the settings will be used.
     * @return array data payload
     */
    public function getFeed($twitterHandle = null): array
    {
        if ($twitterHandle !== null && empty($this->handle))
        {
            return [];
        }

        $this->handle = $twitterHandle ?: $this->handle;

        $cache = $this->checkCache();

        
        return !empty($cache) ? $cache : $this->getData();
    }

    /**
     * Fetches feed from Twitter
     *
     * @return array
     */
    private function getData(): array
    {
        return [];
    }

    /**
     * Review local cache for data saved about account
     *
     * @param string $account Optional account name to fetch.
     * @return mixed
     */
    private function checkCache()
    {

    }
}
