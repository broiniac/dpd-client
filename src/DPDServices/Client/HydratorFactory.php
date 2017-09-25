<?php

namespace Webit\DPDClient\DPDServices\Client;

use JMS\Serializer\Serializer;
use Webit\SoapApi\Hydrator\ArrayHydrator;
use Webit\SoapApi\Hydrator\ChainHydrator;
use Webit\SoapApi\Hydrator\HydratorSerializerBased;
use Webit\SoapApi\Hydrator\KeyExtractingHydrator;
use Webit\SoapApi\Hydrator\ResultDumpingHydrator;
use Webit\SoapApi\Hydrator\Serializer\ResultTypeMap;
use Webit\SoapApi\Util\Dumper\Dumper;
use Webit\SoapApi\Util\StdClassToArray;

class HydratorFactory
{
    /**
     * @var Dumper
     */
    private $dumper;

    /**
     * HydratorFactory constructor.
     * @param Dumper $dumper
     */
    public function __construct(Dumper $dumper)
    {
        $this->dumper = $dumper;
    }

    /**
     * @param Serializer $serializer
     * @return ChainHydrator
     */
    public function create(Serializer $serializer)
    {
        return new ChainHydrator(
            array(
                new ResultDumpingHydrator($this->dumper),
                new KeyExtractingHydrator('return'),
                new ArrayHydrator(new StdClassToArray()),
                new HydratorSerializerBased(
                    $serializer,
                    new ResultTypeMap(
                        array(
                            SoapFunctions::FIND_POSTAL_CODE_V1 => 'Webit\DPDClient\DPDServices\PostalCode\FindPostalCodeResponseV1',
                            SoapFunctions::GET_COURIER_ORDER_AVAILABILITY_V1 => 'Webit\DPDClient\DPDServices\PostalCode\GetCourierOrderAvailabilityResponseV1',
                            SoapFunctions::PACKAGES_PICKUP_CALL_V1 => 'Webit\DPDClient\DPDServices\PackagesPickupCall\PackagesPickupCallResponseV1',
                            SoapFunctions::PACKAGES_PICKUP_CALL_V2 => 'Webit\DPDClient\DPDServices\PackagesPickupCall\PackagesPickupCallResponseV2',
                            SoapFunctions::PACKAGES_PICKUP_CALL_V3 => 'Webit\DPDClient\DPDServices\PackagesPickupCall\PackagesPickupCallResponseV3',
                            SoapFunctions::GENERATE_PACKAGES_NUMBERS_V1 => 'Webit\DPDClient\DPDServices\PackagesGeneration\PackagesGenerationResponseV1',
                            SoapFunctions::GENERATE_PACKAGES_NUMBERS_V2 => 'Webit\DPDClient\DPDServices\PackagesGeneration\PackagesGenerationResponseV2',
                            SoapFunctions::GENERATE_PACKAGES_NUMBERS_V3 => 'Webit\DPDClient\DPDServices\PackagesGeneration\PackagesGenerationResponseV3',
                            SoapFunctions::GENERATE_SPED_LABELS_V1 => 'Webit\DPDClient\DPDServices\DocumentGeneration\DocumentGenerationResponseV1',
                            SoapFunctions::GENERATE_SPED_LABELS_V2 => 'Webit\DPDClient\DPDServices\DocumentGeneration\DocumentGenerationResponseV2',
                            SoapFunctions::GENERATE_PROTOCOL_V1 => 'Webit\DPDClient\DPDServices\DocumentGeneration\DocumentGenerationResponseV1',
                            SoapFunctions::IMPORT_DELIVERY_BUSINESS_EVENT_V1 => 'Webit\DPDClient\DPDServices\ImportDeliveryBusinessEvent\ImportDeliveryBusinessEventResponseV1'
                        )
                    )
                )
            )
        );
    }
}