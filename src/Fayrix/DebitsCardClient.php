<?php

namespace Fayrix;

use GuzzleHttp;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use DateTimeInterface;
use Throwable;

/**
 * Client for DebitsCard Api.
 * Test task for Fayrix.
 * @author Vadim Shevchenko va.she25@gmail.com
 */
class DebitsCardClient implements DebitsCardClientInterface
{
    private Client $client;
    private string $baseApiUri = 'https://www.example.com/api/';

    /**
     * @param string $authorizationKey
     */
    public function __construct(string $authorizationKey)
    {
        $this->client = new Client([
            'base_uri' => $this->baseApiUri,
            GuzzleHttp\RequestOptions::HEADERS => [
                'AUTH-KEY' => $authorizationKey
            ]
        ]);
    }

    /**
     * Get the card info
     *
     * @param int $id
     * @return string
     * @throws DebitsCardClientException
     */
    public function getCardById(int $id): string
    {
        $uri = DebitsCardApiEndpoint::CARDS_BY_ID->makeUri($id);
        $request = new Request(DebitsCardApiMethod::GET->value, $uri);
        return $this->callApi($request);
    }

    /**
     * @param Request $request
     * @return string
     * @throws DebitsCardClientException
     */
    private function callApi(Request $request): string
    {
        try {
            $response = $this->client->send($request);
            return $response->getBody()->getContents();
        } catch (Throwable $exception) {
            throw new DebitsCardClientException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Gets the balance of the card
     *
     * @param int $id
     * @return string
     * @throws DebitsCardClientException
     */
    public function getCardBalance(int $id): string
    {
        $uri = DebitsCardApiEndpoint::CARDS_BALANCE->makeUri($id);
        $request = new Request(DebitsCardApiMethod::GET->value, $uri);
        return $this->callApi($request);
    }

    /**
     * Gets the pin code of the card
     *
     * @param int $id
     * @return string
     * @throws DebitsCardClientException
     */
    public function getCardPin(int $id): string
    {
        $uri = DebitsCardApiEndpoint::CARDS_PIN->makeUri($id);
        $request = new Request(DebitsCardApiMethod::GET->value, $uri);
        return $this->callApi($request);
    }

    /**
     * Get a list of transaction history
     * todo: expects a timeframe (end & start dates)
     *
     * @param int $id
     * @param ?DateTimeInterface $start
     * @param ?DateTimeInterface $end
     * @return string
     * @throws DebitsCardClientException
     */
    public function getCardHistory(
        int $id,
        ?DateTimeInterface $start = null,
        ?DateTimeInterface $end = null
    ): string {
        $uri = DebitsCardApiEndpoint::CARDS_HISTORY->makeUri($id);
        $request = new Request(DebitsCardApiMethod::GET->value, $uri);
        return $this->callApi($request);
    }

    /**
     * Creates a new debit card
     *
     * @param CardDto $cardDto
     * @return string
     * @throws DebitsCardClientException
     */
    public function createCard(CardDto $cardDto): string
    {
        $uri = DebitsCardApiEndpoint::CARDS_CREATE->makeUri();
        $request = new Request(
            DebitsCardApiMethod::POST->value,
            $uri,
            [],
            $this->cardDtoToJson($cardDto)
        );
        return $this->callApi($request);
    }

    /**
     * Converts CardDto to Json
     *
     * @param CardDto $cardDto
     * @return string
     */
    private function cardDtoToJson(CardDto $cardDto): string
    {
        return json_encode($cardDto);
    }

    /**
     * Deactivates a card
     *
     * @param int $id
     * @return string
     * @throws DebitsCardClientException
     */
    public function deactivateCard(int $id): string
    {
        $uri = DebitsCardApiEndpoint::CARDS_DEACTIVATE->makeUri($id);
        $request = new Request(DebitsCardApiMethod::POST->value, $uri);
        return $this->callApi($request);
    }

    /**
     * Activates a card
     *
     * @param int $id
     * @return string
     * @throws DebitsCardClientException
     */
    public function activateCard(int $id): string
    {
        $uri = DebitsCardApiEndpoint::CARDS_ACTIVATE->makeUri($id);
        $request = new Request(DebitsCardApiMethod::POST->value, $uri);
        return $this->callApi($request);
    }

    /**
     * Updates the pin of the card
     *
     * @param int $id
     * @param string $pin
     * @return string
     * @throws DebitsCardClientException
     */
    public function updateCardPin(int $id, string $pin): string
    {
        $uri = DebitsCardApiEndpoint::CARDS_UPDATE->makeUri($id);
        $request = new Request(
            DebitsCardApiMethod::POST->value,
            $uri,
            [],
            $pin
        );
        return $this->callApi($request);
    }

    /**
     * Loads card with a balance.
     * Expects to get the amount to load as a parameter.
     *
     * @param int $id
     * @param string $balance
     * @return string
     * @throws DebitsCardClientException
     */
    public function loadCardBalance(int $id, string $balance): string
    {
        $uri = DebitsCardApiEndpoint::CARDS_UPDATE->makeUri($id);
        $request = new Request(
            DebitsCardApiMethod::POST->value,
            $uri,
            [],
            $balance
        );
        return $this->callApi($request);
    }

    /**
     * Returns a list of the available countries.
     *
     * @return string
     * @throws DebitsCardClientException
     */
    public function getCountries(): string
    {
        $uri = DebitsCardApiEndpoint::COUNTRIES_LIST->makeUri();
        $request = new Request(DebitsCardApiMethod::GET->value, $uri);
        return $this->callApi($request);
    }

    /**
     * Get a specific country
     *
     * @param int $id
     * @return string
     * @throws DebitsCardClientException
     */
    public function getCountry(int $id): string
    {
        $uri = DebitsCardApiEndpoint::COUNTRIES_BY_ID->makeUri($id);
        $request = new Request(DebitsCardApiMethod::GET->value, $uri);
        return $this->callApi($request);
    }
}