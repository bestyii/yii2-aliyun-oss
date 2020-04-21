<?php
/**
 * @link https://github.com/bestyii/yii2-aliyun-oss
 * @copyright Copyright (c) 2020 BestYii.com
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace bestyii\aliyunoss;

use creocoder\flysystem\Filesystem as BaseFileSystem;
use Xxtime\Flysystem\Aliyun\OssAdapter;
use yii\base\InvalidConfigException;

/**
 * Filesystem
 *
 * @author ez <ez@bestyii.com>
 */
class Filesystem extends BaseFileSystem
{
    /**
     * @var string
     */
    public $accessId;
    /**
     * @var string
     */
    public $accessSecret;
    /**
     * @var string
     */
    public $region;
    /**
     * @var string
     */
    public $bucket;

    /**
     * @var string
     */
    public $endpoint;


    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->accessId === null) {
            throw new InvalidConfigException('The "accessId" property must be set.');
        }

        if ($this->accessSecret === null) {
            throw new InvalidConfigException('The "accessSecret" property must be set.');
        }

        if ($this->bucket === null) {
            throw new InvalidConfigException('The "bucket" property must be set.');
        }

        if ($this->region === null) {
            throw new InvalidConfigException('The "region" property must be set.');
        }

        parent::init();
    }

    /**
     * @return OssAdapter
     * @throws \Exception
     */
    protected function prepareAdapter()
    {
        $config = [];


        if ($this->accessId !== null) {
            $config['accessId'] = $this->accessId;
        }
        if ($this->accessSecret !== null) {
            $config['accessSecret'] = $this->accessSecret;
        }

        if ($this->region !== null) {
            $config['region'] = $this->region;
        }

        if ($this->bucket !== null) {
            $config['bucket'] = $this->bucket;
        }
        if ($this->endpoint !== null) {
            $config['endpoint'] = $this->endpoint;
        }


        return new OssAdapter($config);
    }
}
