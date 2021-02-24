<?php
require_once dirname(__FILE__)."/Config.php";
require_once dirname(__FILE__)."/AffiliateNetwork.php";

class Service
{
    /**
     * @var Config
     */
    private $_config;

    public function __construct($path)
    {
        $this->_config = new Config($path);
    }

    public function doConvert($str)
    {   $result = $str;
        foreach ($this->_config->getNetworks() as $network) {
            $pattern = $network->getPattern();
            list($subPattern1, $subPattern2) = explode('{code}', $pattern.'{code}');
            $subPattern1 =preg_quote($subPattern1, '/');
            $subPattern2 =preg_quote($subPattern2, '/');
            if (empty($subPattern2)){
                $subPattern2 = '(?=$|\s|\'|\")';
            }
            $pattern = '/'.$subPattern1.'(\S+)'.$subPattern2.'/';

            if (preg_match($pattern, $result)){
                $html = strtr($network->getHtml(), ['{code}' => '$1']);
                $result = preg_replace($pattern, $html, $result);
            }
        }

        $result = str_replace(array("\n", "\r"), '', nl2br($result));
        return json_encode(['html'=>$result]);
    }

    public function removeNetwork($key)
    {
        return empty($key) ?: $this->_config->removeNetwork($key);
    }

    public function updateNetwork($originKey, $key, $pattern, $html)
    {
        $network = new AffiliateNetwork($originKey, $pattern, $html);
        $network->setName($key);
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