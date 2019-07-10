<?php

namespace mobyinc\twitterfeed\variables;

use Craft; 
use mobyinc\twitterfeed\TwitterFeedPlugin;
use yii\caching\FileCache as Cache;

class TwitterFeedVariable
{
    /** @var object Instance of TwitterFeedPlugin class */
    protected $instance;

    /**
     * Construct instance of plugin class
     */
    public function __construct()
    {
        $this->instance = TwitterFeedPlugin::getInstance();
        $this->cache = new Cache;
    }

    /**
     * Retrieve tweet from cache or do API request
     *
     * @param string|null $handle 
     * @return object|null
     */
    public function getLatestTweet($handle = null)
    {
        $handle = $handle ?: $this->instance->getSettings()->twitterHandle;
        Craft::warning('getLatestTweet requested.', __METHOD__); 

        if (!$handle)
        {
            Craft::warning('No handle provided for getLatestTweet.', __METHOD__); 
            return;
        }

        $tweets = $this->cache->getOrSet(`latest_tweets_from_${handle}`, function () use ($handle) {
            try {
                return $this->instance->twitterService
                    ->setGetfield("?screen_name={$handle}&count=10")
                    ->buildOauth('https://api.twitter.com/1.1/statuses/user_timeline.jsoon', 'GET')
                    ->performRequest();
            } catch (Exception $e) {
                return false;
            }
        });

        Craft::info('Returning Twitter results.', __METHOD__); 
        return json_decode($tweets);
    }

    /**
     * Alias for getLatestTweet
     *
     * @param string|null $handle 
     * @return object
     */
    public function getLatestTweetFrom($handle = null)
    {
        return $this->getLatestTweet($handle);
    }
}