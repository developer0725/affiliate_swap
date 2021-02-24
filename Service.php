<?php

class AffiliateNetwork
{
    private $_originName;
    private $_name;
    private $_pattern;
    private $_html;

    /**
     * AffiliateNetwork constructor.
     * @param $name
     * @param $pattern
     * @param $html
     */
    public function __construct($name, $pattern, $html = null)
    {
        $this->_originName = $name;
        $this->_name = $name;
        $this->_pattern = $pattern;
        $this->_html = $html;
    }

    /**
     * @return mixed
     */
    public function getOriginName()
    {
        return $this->_originName;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param  mixed  $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @return mixed
     */
    public function getPattern()
    {
        return $this->_pattern;
    }

    /**
     * @param  mixed  $pattern
     */
    public function setPattern($pattern)
    {
        $this->_pattern = $pattern;
    }

    /**
     * @return mixed
     */
    public function getHtml()
    {
        return $this->_html;
    }

    /**
     * @param  mixed  $html
     */
    public function setHtml($html)
    {
        $this->_html = $html;
    }

}

class Config
{
    const CONFIG_FILE = 'config.json';

    private $_path;

    /**
     * @var AffiliateNetwork[]
     */
    private $_networks = [];

    /**
     * Config constructor.
     * @param $path
     */
    public function __construct($path)
    {
        $this->_path = $path;
        $this->_loadNetworks();
    }

    private function _getConfigFile()
    {
        return $this->_path.'/'.self::CONFIG_FILE;
    }

    private function _loadNetworks()
    {
        if (file_exists($this->_getConfigFile())) {
            $json = file_get_contents($this->_getConfigFile());
            $networks = json_decode(str_replace(array("\n", "\r"), '', $json), true);
            foreach ($networks as $network) {
                $key = $network['name'];
                $pattern = $network['pattern'];
                $html = $network['html'];
                if (!empty($key) && !empty($pattern) && !empty($html)) {
                    $this->_networks[$key] = new AffiliateNetwork($key, $pattern, $html);
                }
            }
        }
    }

    public function toJson()
    {
        $networks = [];
        if (!empty($this->_networks)) {
            foreach ($this->_networks as $key => $network) {
                $networks[$key] = [
                    'name' => $network->getName(),
                    'pattern' => $network->getPattern(),
                    'html' => $network->getHtml()
                ];
            }
        }

        return json_encode($networks);
    }

    private function _saveNetworks()
    {
        return file_put_contents($this->_getConfigFile(), $this->toJson());
    }

    public function getNetwork($key)
    {
        $network = null;
        if (array_key_exists($key, $this->_networks)) {
            $network = $this->_networks[$key];
        }
        return $network;
    }

    public function getNetworks()
    {
        return $this->_networks;
    }

    /**
     * @param  AffiliateNetwork  $network
     * @return bool
     */
    public function updateNetwork($network)
    {
        $originKey = $network->getOriginName();
        $key = $network->getName();
        $pattern = htmlentities(str_replace(array("\n", "\r"), '', $network->getPattern()), ENT_QUOTES);
        $html = htmlentities(str_replace(array("\n", "\r"), '', $network->getHtml()), ENT_QUOTES);
        if (empty($key) || empty($pattern) || empty($html)) {
            return false;
        }

        if (array_key_exists($key, $this->_networks)) {
            $this->_networks[$key]->setPattern($pattern);
            $this->_networks[$key]->setHtml($html);
        } else {
            $this->_networks[$key] = new AffiliateNetwork($key, $pattern, $html);
        }

        if ($originKey != $key && array_key_exists($originKey, $this->_networks)) {
            unset($this->_networks[$originKey]);
        }

        return $this->_saveNetworks();
    }

    public function removeNetwork($key)
    {
        if (array_key_exists($key, $this->_networks)) {
            unset($this->_networks[$key]);
        }

        return $this->_saveNetworks();
    }

}

class Service
{
    /**
     * @var Config
     */
    private $_config;

    public function __construct($path = null)
    {
        $path = empty($path) ? dirname(__FILE__) : $path;
        $this->_config = new Config($path);
    }

    public function doConvert($str)
    {
        $matchedNetworks = [];
        foreach ($this->_config->getNetworks() as $network) {
            $pattern = $network->getPattern();
            list($subPattern1, $subPattern2) = explode('{code}', $pattern.'{code}');
            $subPattern1 = preg_quote($subPattern1, '/');
            $subPattern2 = preg_quote($subPattern2, '/');
            if (empty($subPattern2)) {
                $subPattern2 = '(?=$|\s|\'|")';
            }
            $pattern = '/'.$subPattern1.'(\S+)'.$subPattern2.'/';

            if (preg_match($pattern, $str)) {
                $html = strtr($network->getHtml(), ['{code}' => '$1']);
                $html = nl2br(preg_replace($pattern, $html, $str));
                $html = str_replace(array("\n", "\r"), '', $html);
                $matchedNetworks[] = [
                    'network' => $network->getName(),
                    'html' => $html,
                ];
            }
        }

        return json_encode($matchedNetworks);
    }

    public function doConvertAll($str)
    {
        $result = $str;
        $matchedNetworks = [];
        foreach ($this->_config->getNetworks() as $network) {
            $pattern = $network->getPattern();
            list($subPattern1, $subPattern2) = explode('{code}', $pattern.'{code}');
            $subPattern1 = preg_quote($subPattern1, '/');
            $subPattern2 = preg_quote($subPattern2, '/');
            if (empty($subPattern2)) {
                $subPattern2 = '(?=$|\s|\'|")';
            }
            $pattern = '/'.$subPattern1.'(\S+)'.$subPattern2.'/';

            if (preg_match($pattern, $result)) {
                $matchedNetworks[] = $network->getName();
                $html = strtr($network->getHtml(), ['{code}' => '$1']);
                $result = preg_replace($pattern, $html, $result);
            }
        }

        $result = str_replace(array("\n", "\r"), '', nl2br($result));
        return json_encode([
            'networks' => $matchedNetworks,
            'html' => $result != $str ? $result : '',
        ]);
    }

    public function removeNetwork($key)
    {
        return empty($key) ?: $this->_config->removeNetwork($key);
    }

    public function updateNetwork($originKey, $key, $pattern, $html)
    {
        $network = new AffiliateNetwork($originKey, $pattern, $html);
        if (!empty($key)) {
            $network->setName($key);
        }
        return $this->_config->updateNetwork($network);
    }

    public function getNetworks()
    {
        $networks = $this->_config->getNetworks();
        return empty($networks) || !is_array($networks) ? [] : $networks;
    }

    public function getNetworksInJson()
    {
        return $this->_config->toJson();
    }
}