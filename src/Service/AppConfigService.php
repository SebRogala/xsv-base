<?php
/**
 * Author: Sebastian Rogala
 * Mail: sebrogala@gmail.com
 * Created: 29.01.18
 */

namespace Xsv\Base\Service;

class AppConfigService
{
    /** @var array */
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getConfig($key = "")
    {
        if(empty($key)) {
            return $this->config;
        }

        if(!empty($this->config[$key])) {
            return $this->config[$key];
        }

        return [];
    }
}
