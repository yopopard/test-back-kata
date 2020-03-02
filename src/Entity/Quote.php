<?php

class Quote
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $siteId;

    /**
     * @var int
     */
    protected $destinationId;

    /**
     * @var string
     */
    protected $dateQuoted;

    /**
     * MappedQuote constructor.
     *
     * @param int $id
     * @param int $siteId
     * @param int $destinationId
     * @param string $dateQuoted
     */
    public function __construct($id, $siteId, $destinationId, $dateQuoted)
    {
        $this->id = $id;
        $this->siteId = $siteId;
        $this->destinationId = $destinationId;
        $this->dateQuoted = $dateQuoted;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getSiteId()
    {
        return $this->siteId;
    }

    /**
     * @return int
     */
    public function getDestinationId()
    {
        return $this->destinationId;
    }

    /**
     * @return string
     */
    public function getDateQuoted()
    {
        return $this->dateQuoted;
    }
}
