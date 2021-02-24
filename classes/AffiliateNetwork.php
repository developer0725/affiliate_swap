<?php


class AffiliateNetwork
{
    const USER_KEY = '{user}';

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