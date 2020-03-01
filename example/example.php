<?php

require_once __DIR__ . '/../vendor/autoload.php';

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
require_once __DIR__ . '/../src/Mapper/MapperInterface.php';
require_once __DIR__ . '/../src/Mapper/Quote/QuoteMapper.php';
require_once __DIR__ . '/../src/Entity/MappedQuote.php';
require_once __DIR__ . '/../src/Deliver/DelivererInterface.php';
require_once __DIR__ . '/../src/Deliver/MappedQuote/MappedQuoteDeliverer.php';
require_once __DIR__ . '/../src/ViewModel/Quote/QuoteViewModel.php';

$faker = \Faker\Factory::create();

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

$quote = new Quote($faker->randomNumber(), $faker->randomNumber(), $faker->randomNumber(), $faker->date());
try {
    $mappedQuote = QuoteMapper::getInstance()->map($quote);
    $quoteVM = MappedQuoteDeliverer::getInstance()->deliver($mappedQuote);
} catch (Exception $e) {
    //todo log
    echo 'Error: ' . $e->getMessage();
}

$templateManager = new TemplateManager();

$message = $templateManager->getTemplateComputed(
    $template,
    [
        'quote' => $quoteVM
    ]
);

echo $message->getSubject() . "\n" . $message->getContent();
