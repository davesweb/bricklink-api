<?php

namespace Davesweb\BrinklinkApi\Repositories;

use function Davesweb\uri;
use function Davesweb\toString;
use Davesweb\BrinklinkApi\ValueObjects\PriceGuide;
use Davesweb\BrinklinkApi\ParameterObjects\ItemType;
use Davesweb\BrinklinkApi\Contracts\BricklinkGateway;
use Davesweb\BrinklinkApi\ParameterObjects\GuideType;
use Davesweb\BrinklinkApi\ParameterObjects\NewOrUsed;
use Davesweb\BrinklinkApi\Exceptions\NotFoundException;
use Davesweb\BrinklinkApi\Transformers\PriceGuideTransformer;

class PriceGuideRepository extends BaseRepository
{
    public function __construct(BricklinkGateway $gateway, PriceGuideTransformer $transformer)
    {
        parent::__construct($gateway, $transformer);
    }

    public function find(
        string $number,
        ?ItemType $type = null,
        ?int $colorId = null,
        ?GuideType $guideType = null,
        ?NewOrUsed $newOrUsed = null,
        ?string $countryCode = null,
        ?string $region = null,
        ?string $currencyCode = null,
        string $vat = 'N',
    ): ?PriceGuide {
        $uri = uri('/items/{type}/{number}/price', [
            'type'   => $type ? (string) $type : ItemType::default(),
            'number' => $number,
        ], [
            'color_id'      => $colorId,
            'guide_type'    => toString($guideType, GuideType::default()),
            'new_or_used'   => toString($newOrUsed, NewOrUsed::default()),
            'country_code'  => $countryCode,
            'region'        => $region,
            'currency_code' => $currencyCode,
            'vat'           => $vat,
        ]);

        $response = $this->gateway->get($uri);

        if (!$response->hasData()) {
            return null;
        }

        /** @var PriceGuide $priceGuide */
        $priceGuide = $this->transformer->toObject($response->getData());

        return $priceGuide;
    }

    public function findOrFail(
        string $number,
        ?ItemType $type = null,
        ?int $colorId = null,
        ?GuideType $guideType = null,
        ?NewOrUsed $newOrUsed = null,
        ?string $countryCode = null,
        ?string $region = null,
        ?string $currencyCode = null,
        string $vat = 'N',
    ): PriceGuide {
        $priceGuide = $this->find($number, $type, $colorId, $guideType, $newOrUsed, $countryCode, $region, $currencyCode, $vat);

        if (null === $priceGuide) {
            throw NotFoundException::forId($number);
        }

        return $priceGuide;
    }
}
