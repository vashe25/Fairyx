<?php
require_once __DIR__ . '/vendor/autoload.php';

use Fayrix\CardDto;
use Fayrix\DebitsCardClient;

// Create client
$authorizationKey = md5('AUTH-KEY');
$debitsCardClient = new DebitsCardClient($authorizationKey);

// Cards
$cardId = 1;

echo $debitsCardClient->getCardById($cardId);
echo $debitsCardClient->getCardBalance($cardId);
echo $debitsCardClient->getCardPin($cardId);
echo $debitsCardClient->getCardHistory($cardId, new DateTime('-1 week'), new DateTime());

$cardDto = new CardDto('Vadim', 'Shevchenko', 'EUR', '1234');
$debitsCardClient->createCard($cardDto);

$debitsCardClient->activateCard($cardId);
$debitsCardClient->deactivateCard($cardId);
$debitsCardClient->loadCardBalance($cardId, $balance = '1000');
$debitsCardClient->updateCardPin($cardId, '4321');

// Countries
echo $debitsCardClient->getCountries();
echo $debitsCardClient->getCountry(1);
