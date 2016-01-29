<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap
require_once 'tests/bootstrap.php';

// replace with mechanism to retrieve EntityManager in your app
$entityManager = \AudioCoreEntity\Tests\Bootstrap::GetEntityManager();

return ConsoleRunner::createHelperSet($entityManager);