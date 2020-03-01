<?php


class MappedQuote extends Quote
{
    /**
     * @var Destination
     */
    protected $destination;

    /**
     * @var Site
     */
    protected $site;

    /**
     * MappedQuote constructor.
     *
     * @param Quote $quote
     * @param Destination $destination
     * @param Site $site
     */
    public function __construct($quote, $destination, $site)
    {
        parent::__construct($quote->getId(), $quote->getSiteId(), $quote->getDestinationId(), $quote->getDateQuoted());
        $this->destination = $destination;
        $this->site = $site;
    }

    /**
     * @return Destination
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @return Site
     */
    public function getSite()
    {
        return $this->site;
    }
}