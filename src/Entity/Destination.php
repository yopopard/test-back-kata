<?php

class Destination
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $countryName;

    /**
     * @var string
     */
    protected $conjunction;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $computerName;

    /**
     * Destination constructor.
     *
     * @param int $id
     * @param string $countryName
     * @param string $conjunction
     * @param string $computerName
     */
    public function __construct($id, $countryName, $conjunction, $computerName)
    {
        $this->id = $id;
        $this->countryName = $countryName;
        $this->conjunction = $conjunction;
        $this->computerName = $computerName;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCountryName()
    {
        return $this->countryName;
    }

    /**
     * @return string
     */
    public function getConjunction()
    {
        return $this->conjunction;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getComputerName()
    {
        return $this->computerName;
    }
}
