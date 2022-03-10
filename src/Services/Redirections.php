<?php

namespace YsGroups\Services;

class Redirections
{
    /**
     * @var string|mixed Uri courant
     */
    public string $requestUri;

    /**
     * @var array|string[] elements de la requete segmentés dans un tableau
     */
    public array $explodedRequestUri;
}
