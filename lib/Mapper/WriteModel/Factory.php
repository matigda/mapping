<?php

declare(strict_types = 1);

namespace Deetrych\Mapping\Mapper\WriteModel;

use Deetrych\Mapping\PropertyAccessProviderInterface;
use InvalidArgumentException;

class Factory
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var array
     */
    protected $typeMapperMap;

    /**
     * @var PropertyAccessProviderInterface
     */
    protected $propertyAccessProvider;

    public function __construct(PropertyAccessProviderInterface $propertyAccessProvider, array $config, array $typeMapperMap)
    {
        foreach ($config as $configData) {
            if (!isset($configData['type']) || !isset($configData['fields'])) {
                throw new InvalidArgumentException(
                    'You need to provide type and fields to factory to allow it to create mappers.'
                );
            }
        }
        array_walk($typeMapperMap, function ($class) {
            if (!is_subclass_of($class, AbstractMapper::class)) {
                throw new InvalidArgumentException('All types passed to factory have to extend WriteModel\AbstractMapper');
            }
        });

        $this->config = $config;
        $this->typeMapperMap = $typeMapperMap;
        $this->propertyAccessProvider = $propertyAccessProvider;
    }

    public function createFromType(string $type): AbstractMapper
    {
        foreach ($this->config as $config) {
            if ($config['type'] == $type) {
                if (!isset($this->typeMapperMap[$type])) {
                    throw new InvalidArgumentException(sprintf('There is no mapper for "%s" type.', $type));
                }

                // if type == 'object' setModel
                return new $this->typeMapperMap[$type]($this->propertyAccessProvider, $config['fields']);
            }
        }

        throw new InvalidArgumentException(
            sprintf('There is no config for "%s" type.', $type)
        );
    }
}
