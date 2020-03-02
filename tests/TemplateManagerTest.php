<?php

require_once __DIR__ . '/../src/Entity/Destination.php';
require_once __DIR__ . '/../src/Entity/Quote.php';
require_once __DIR__ . '/../src/Entity/Site.php';
require_once __DIR__ . '/../src/Entity/Template.php';
require_once __DIR__ . '/../src/Entity/User.php';
require_once __DIR__ . '/../src/Helper/SingletonTrait.php';
require_once __DIR__ . '/../src/Context/ApplicationContext.php';
require_once __DIR__ . '/../src/Repository/Repository.php';
require_once __DIR__ . '/../src/Repository/DestinationRepository.php';
require_once __DIR__ . '/../src/Repository/QuoteRepository.php';
require_once __DIR__ . '/../src/Repository/SiteRepository.php';
require_once __DIR__ . '/../src/TemplateManager.php';
require_once __DIR__ . '/../src/Entity/MappedQuote.php';
require_once __DIR__ . '/../src/Mapper/MapperInterface.php';
require_once __DIR__ . '/../src/Mapper/Quote/QuoteMapper.php';
require_once __DIR__ . '/../src/Deliver/DelivererInterface.php';
require_once __DIR__ . '/../src/Deliver/MappedQuote/MappedQuoteDeliverer.php';
require_once __DIR__ . '/../src/ViewModel/Quote/QuoteViewModel.php';

class TemplateManagerTest extends PHPUnit_Framework_TestCase
{
    /**
     * Init the mocks
     */
    public function setUp()
    {
    }

    /**
     * Closes the mocks
     */
    public function tearDown()
    {
    }

    /**
     * @test
     */
    public function test()
    {
        $faker = \Faker\Factory::create();

        $expectedUser = ApplicationContext::getInstance()->getCurrentUser();

        $quote = new Quote($faker->randomNumber(), $faker->randomNumber(), $faker->randomNumber(), $faker->date());
        $mappedQuote = QuoteMapper::getInstance()->map($quote);
        $quoteVM = MappedQuoteDeliverer::getInstance()->deliver($mappedQuote);

        $template = new Template(
            1,
            'Votre voyage avec une agence locale [quote:destination_name]',
            "
Bonjour [user:first_name],

Merci d'avoir contacté un agent local pour votre voyage [quote:destination_name].

Vous pouvez accéder à votre espace en accédant au lien suivant: [quote:destination_link]

Bien cordialement,

L'équipe Evaneos.com
www.evaneos.com
");
        $templateManager = new TemplateManager();

        $message = $templateManager->getTemplateComputed(
            $template,
            [
                'quote' => $quoteVM,
                'user' => ApplicationContext::getInstance()->getCurrentUser()
            ]
        );

        $this->assertEquals('Votre voyage avec une agence locale ' .
            $mappedQuote->getDestination()->getCountryName(), $message->getSubject());
        $this->assertEquals("
Bonjour " . $expectedUser->getFirstname() . ",

Merci d'avoir contacté un agent local pour votre voyage " . $mappedQuote->getDestination()->getCountryName() . ".

Vous pouvez accéder à votre espace en accédant au lien suivant: ". $mappedQuote->getSite()->getUrl() . '/' .
            $mappedQuote->getDestination()->getCountryName() . '/quote/' . $mappedQuote->getId() ."

Bien cordialement,

L'équipe Evaneos.com
www.evaneos.com
", $message->getContent());
    }
}
