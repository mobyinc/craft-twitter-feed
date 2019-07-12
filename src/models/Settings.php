<?php

namespace mobyinc\twitterfeed\models;

use craft\base\Model;

class Settings extends Model
{
    /** @var string The Twitter account to get the feed from */
    public $twitterHandle = '';

    /** @var string OAuth Access Token */
    public $oauthAccessToken = '';

    /** @var string OAuth Access Token Secret */
    public $oauthAccessTokenSecret = '';

    /** @var string Consumer Key */
    public $consumerKey = '';

     /** @var string Consumer Secret */
     public $consumerSecret = '';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['twitterHandle', 'required'],
            ['oauthAccessToken', 'required'],
            ['oauthAccessTokenSecret', 'required'],
            ['consumerKey', 'required'],
            ['consumerSecret', 'required']
        ];
    }
}