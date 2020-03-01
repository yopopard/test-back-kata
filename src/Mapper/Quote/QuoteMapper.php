<?php


class QuoteMapper implements MapperInterface
{
    use SingletonTrait;

    /**
     * @var QuoteRepository
     */
    protected $quoteRepository;

    /**
     * @var DestinationRepository
     */
    protected $destinationRepository;

    /**
     * @var SiteRepository
     */
    protected $siteRepository;

    protected function __construct()
    {
        $this->quoteRepository = QuoteRepository::getInstance();
        $this->destinationRepository = DestinationRepository::getInstance();
        $this->siteRepository = SiteRepository::getInstance();
    }

    /**
     * @param $object
     *
     * @return MappedQuote
     * @throws Exception
     */
    public function map($object)
    {
        if (!$object instanceof Quote) {
            throw new Exception('Wrong type: expected Quote');
        }

        return new MappedQuote(
            $this->quoteRepository->getById($object->getId()),
            $this->destinationRepository->getById($object->getDestinationId()),
            $this->siteRepository->getById($object->getSiteId())
        );
    }
}