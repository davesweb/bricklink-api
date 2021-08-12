<?php

namespace Davesweb\BrinklinkApi\Repositories;

use Davesweb\BrinklinkApi\Contracts\BricklinkGateway;
use Davesweb\BrinklinkApi\Transformers\BaseTransformer;

abstract class BaseRepository
{
    protected BricklinkGateway $gateway;

    protected BaseTransformer $transformer;

    public function __construct(BricklinkGateway $gateway, BaseTransformer $transformer)
    {
        $this->gateway     = $gateway;
        $this->transformer = $transformer;
    }
}
