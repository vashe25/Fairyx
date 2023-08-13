<?php

namespace Fayrix;

enum DebitsCardApiEndpoint: string
{
    // Cards
    case CARDS_BY_ID = 'cards/%d';
    case CARDS_BALANCE = 'cards/%d/balance';
    case CARDS_PIN = 'cards/%d/pin';
    case CARDS_HISTORY = 'cards/%d/history';
    case CARDS_CREATE = 'cards/create';
    case CARDS_DEACTIVATE = 'cards/%d/deactivate';
    case CARDS_ACTIVATE = 'cards/%d/activate';
    case CARDS_UPDATE = 'cards/%d/update';
    case CARDS_LOAD = 'cards/%d/load';
    // Countries
    case COUNTRIES_LIST = 'countries';
    case COUNTRIES_BY_ID = 'countries/%d';

    public function makeUri(...$parameters): string
    {
        return sprintf($this->value, ...$parameters);
    }
}
