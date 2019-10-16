<?php

namespace App\Infrastructure;

use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;

class SerializerFactory
{
    public static function create(): SerializerInterface
    {
        return SerializerBuilder::create()
            ->setPropertyNamingStrategy(new SerializedNameAnnotationStrategy(new IdenticalPropertyNamingStrategy()))
            ->addDefaultHandlers()
            ->setAnnotationReader(new CachedReader(new AnnotationReader(), $cache, false))
            ->setMetadataCache(new DoctrineCacheAdapter('JMS_METADATA_', $cache))
            ->build();
    }
}
