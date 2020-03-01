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
     * @param Quote $quote
     *
     * @return string
     */
    public static function renderHtml(Quote $quote)
    {
        return '<p>' . $quote->getId() . '</p>';
    }

    /**
     * @param Quote $quote
     *
     * @return string
     */
    public static function renderText(Quote $quote)
    {
        return (string) $quote->getId();
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
