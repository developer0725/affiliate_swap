<?php


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