<?php


namespace App;

use Dotenv\Dotenv;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

/**
 * Class Config
 * @package App
 */
class Config
{

    /**
     * @var array
     */
    private $settings;

    /**
     *
     */
    public function run()
    {
        $dotenv = Dotenv::createUnsafeImmutable(__DIR__.'/..');
        $this->settings = $dotenv->load();
        $dotenv->required([
            'DATABASE_NAME', 'DATABASE_HOST', 'DATABASE_LOGIN', 'DATABASE_PASSWORD',
        ]);
    }

    /**
     * @param  string $key
     * @param null $default
     * @return mixed|null
     */
    public function get($key, $default = null) {
        return $this->settings[$key] ?? $default;
    }

    /**
     * @return EntityManager
     * @throws \Doctrine\ORM\ORMException
     */
    public function createEntityManager() {
        $isDevMode = true;
        $proxyDir = null;
        $cache = null;
        $useSimpleAnnotationReader = false;
        $config = Setup::createAnnotationMetadataConfiguration([
            __DIR__
        ], $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);

        $conn = [
            'driver' => 'pdo_mysql',
            'dbname' => $this->get('DATABASE_NAME', 'test'),
            'user' =>  $this->get('DATABASE_LOGIN', 'root'),
            'password' =>  $this->get('DATABASE_PASSWORD', ''),
            'host' =>  $this->get('DATABASE_HOST', 'localhost'),
        ];
        $entityManager = EntityManager::create($conn, $config);
        return $entityManager;
    }
}