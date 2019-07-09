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

        if (!$handle)
        {
            Craft::warning('No handle provided for getLatestTweet.', __METHOD__); 
            return;
        }

        $tweet = $this->cache->get(`latest_tweet_from_${handle}`);

        if(!$tweet)
        {
            try {
                $tweet = $this->instance->twitterService
                ->buildOauth('https://api.twitter.com/1.1/statuses/user_timeline.jsoon', 'POST')
                ->setPostfields([
                    'screen_name' => $handle,
                    'exclude_replies' => true,
                    'count' => 1,
                ])
                ->performRequest();
            } catch (Exception $e) {
                Craft::warning('Accessing Twitter OAuth failed.', __METHOD__); 
                return $e->getMessage();
            }

            if ($tweet) {
                $this->cache->set(`latest_tweet_from_{$handle}`, $tweet);
            }
        }

        return json_decode($tweet);
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