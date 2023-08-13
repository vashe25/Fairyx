<?php

namespace Fayrix;

interface DebitsCardClientInterface
{
    public function __construct(string $authorizationKey);
}