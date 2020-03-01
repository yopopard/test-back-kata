<?php


class MappedQuoteDeliverer implements DelivererInterface
{
    use SingletonTrait;

    /**
     * @param $object
     *
     * @return QuoteViewModel
     * @throws Exception
     */
    public function deliver($object)
    {
        if (!$object instanceof MappedQuote) {
            throw new Exception('Wrong type: expected MappedQuote');
        }

        $quote = new QuoteViewModel();
        // todo fix spaces and capital into name
        $quote->destinationLink = $object->getSite()->getUrl() . '/' . $object->getDestination()->getCountryName() .
            '/quote/' . $object->getId();
        $quote->destinationName = $object->getDestination()->getCountryName();
        $quote->summary = Quote::renderText($object);
        $quote->summaryHtml = Quote::renderHtml($object);

        return $quote;
    }
}