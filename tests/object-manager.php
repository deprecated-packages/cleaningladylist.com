<?php

use App\HttpKernel\CleaningladylistKernel;
use Symfony\Component\Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

(new Dotenv())->bootEnv(dirname(__DIR__).'/.env');


$kernel = new CleaningladylistKernel($_SERVER['APP_ENV'] ?? 'dev', (bool) $_SERVER['APP_DEBUG'] ?? true);
$kernel->boot();

return $kernel->getContainer()->get('doctrine')->getManager();
