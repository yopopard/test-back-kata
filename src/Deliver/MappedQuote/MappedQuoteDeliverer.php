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
        $quote->summary = self::renderText($object);
        $quote->summaryHtml = self::renderHtml($object);

        return $quote;
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
}