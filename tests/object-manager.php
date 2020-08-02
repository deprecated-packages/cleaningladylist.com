<?php

use App\Kernel;
use Symfony\Component\Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

(new Dotenv())->bootEnv(dirname(__DIR__).'/.env');


$kernel = new Kernel($_SERVER['APP_ENV'] ?? 'dev', (bool) $_SERVER['APP_DEBUG'] ?? true);
$kernel->boot();

return $kernel->getContainer()->get('doctrine')->getManager();
