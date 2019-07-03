<?php

namespace mobyinc\twitterfeed\models;

use craft\base\Model;

class Settings extends Model
{
    /** @var string The Twitter account to get the feed from */
    public $twitterHandle = '';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['twitterHandle', 'required'],
        ];
    }
}