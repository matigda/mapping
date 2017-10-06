<?php

declare(strict_types = 1);

namespace Deetrych\Mapping\Mapper\ReadModel;

use Deetrych\Mapping\PropertyAccessProvider;
use Doctrine\Instantiator\Instantiator;

class Factory
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var array
     */
    private $typeMapperMap;

    public function __construct(array $config, array $typeMapperMap)
    {
        foreach ($config as $configData) {
            if (!isset($configData['model']) || !isset($configData['type']) || !isset($configData['fields'])) {
                throw new \InvalidArgumentException(
                    'You need to provide type, fields and model to factory to allow it to create mappers.'
                );
            }
        }

        array_walk($typeMapperMap, function ($class) {
            if (!is_subclass_of($class, AbstractMapper::class)) {
                throw new \InvalidArgumentException('All types passed to factory have to extend ReadModel\AbstractMapper');
            }
        });

        $this->config = $config;
        $this->typeMapperMap = $typeMapperMap;
    }

    public function createFromType(string $type): AbstractMapper
    {
        foreach ($this->config as $config) {

            if ($config['type'] == $type) {
                if (!isset($this->typeMapperMap[$type])) {
                    throw new \InvalidArgumentException(sprintf('There is no mapper for "%s" type.', $type));
                }

                // if type == 'object' setModel
                $instantiator = new Instantiator();

                return new $this->typeMapperMap[$type](
                    new PropertyAccessProvider(),
                    $config['fields'],
                    $instantiator->instantiate($config['model'])
                );
            }
        }

        throw new \InvalidArgumentException(
            sprintf('There is no config for "%s" type.', $type)
        );
    }
}
