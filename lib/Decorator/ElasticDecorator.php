<?php

declare(strict_types = 1);

namespace Deetrych\Mapping\Decorator;

use Deetrych\Mapping\Mapper\WriteModel\ArrayMapper;
use Elastica\Document;
use Deetrych\Mapping\Mapper\WriteModel\AbstractMapper;

class ElasticDecorator extends AbstractMapper
{
    /**
     * @var AbstractMapper
     */
    private $mapper;

    public function __construct(ArrayMapper $mapper)
    {
        if (!class_exists(Document::class)) {
            throw new \Exception('Elastica library is required to use ElasticDecorator.');
        }
        $this->mapper = $mapper;
    }

    /**
     * {@inheritdoc}
     */
    public function map($dataToMap)
    {
        $document = new Document('', $this->mapper->map($dataToMap));

        return $document;
    }
}
