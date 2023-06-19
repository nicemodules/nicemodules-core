<?php

namespace NiceModules\Core;

use NiceModules\CoreModule\Model\Configuration;
use NiceModules\ORM\Manager;

class Config
{
    /**
     * @var Config[]
     */
    private static array $instances = [];
    private string $namespace;
    private array $config;

    protected function __construct(string $namespace)
    {
        $this->namespace = $namespace;

        $config = Manager::instance()
            ->getRepository(Configuration::class)
            ->createQueryBuilder()
            ->where('namespace', $namespace)
            ->buildQuery()
            ->getResult();

        foreach ($config as $item) {
            $this->config[$item->get('name')] = $item;
        }
    }

    public static function instance($namespace)
    {
        // Initialize the service if it's not already set.
        if (!isset(self::$instances[$namespace])) {
            $instance = new static($namespace);
            self::$instances[$namespace] = $instance;
        }

        // Return the instance of searched mapper.
        return self::$instances[$namespace];
    }

    public function get(string $name, $default = null): ?string
    {
        if (isset($this->config[$name])) {
            return $this->config[$name]->get('value');
        }

        return $default;
    }

    public function set(string $name, $value)
    {
        if (isset($this->config[$name])) {
            return $this->config[$name]->set('value', $value);
        }
    }

    public function save()
    {
        Manager::instance()->flush();
    }

}