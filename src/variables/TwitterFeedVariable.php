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

        $tweet = $this->cache->get(`latest_tweet_from_${handle}`);

        if(!$tweet || $tweet === null)
        {
            Craft::info('Starting Twitter API query.', __METHOD__); 
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
                Craft::warning('Twitter API query failed.', __METHOD__); 
                return $e->getMessage();
            }

            if ($tweet) {
                Craft::info("Storing Twitter result in cache for {$handle}", __METHOD__); 
                $this->cache->set(`latest_tweet_from_{$handle}`, $tweet);
            }
        }
        Craft::info('Returning Twitter results.', __METHOD__); 
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