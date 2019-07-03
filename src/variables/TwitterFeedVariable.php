<?php

namespace mobyinc\twitterfeed\variables;

use mobyinc\twitterfeed\TwitterFeedPlugin;

class TwitterFeedVariable
{
    public function getFeed($account = null)
    {
        return TwitterFeedPlugin::getInstance()->twitterService->getFeed($account);
    }
}