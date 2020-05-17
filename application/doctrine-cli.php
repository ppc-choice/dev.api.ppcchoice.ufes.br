<?php

    // trailing slash is important!
    define('APPPATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
    define('BASEPATH', APPPATH);
    define('ENVIRONMENT', 'development');

    // Load Dotenv
    define('PATHSYS', str_replace('application','', dirname(__FILE__)));
    require PATHSYS . 'system/dotenv/autoloader.php';

    if ( file_exists(PATHSYS . '/.env.' . ENVIRONMENT)){
        $dotenv = new Dotenv\Dotenv(PATHSYS);
        $dotenv->load();
    }


    require APPPATH.'libraries/Doctrine.php';

    $doctrine = new Doctrine();
    
    $helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
        'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($doctrine->getEntityManager()->getConnection()),
        'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($doctrine->getEntityManager())
    ));

    $cli = new \Symfony\Component\Console\Application('Doctrine Command Line Interface (CodeIgniter integration by Joel Verhagen)', Doctrine\ORM\Version::VERSION);
    $cli->setCatchExceptions(true);
    $cli->setHelperSet($helperSet);
    $cli->addCommands(array(
        // DBAL Commands
        new \Doctrine\DBAL\Tools\Console\Command\RunSqlCommand(),
        new \Doctrine\DBAL\Tools\Console\Command\ImportCommand(),
    
        // ORM Commands
        new \Doctrine\ORM\Tools\Console\Command\ClearCache\MetadataCommand(),
        new \Doctrine\ORM\Tools\Console\Command\ClearCache\ResultCommand(),
        new \Doctrine\ORM\Tools\Console\Command\ClearCache\QueryCommand(),
        new \Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand(),
        new \Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand(),
        new \Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand(),
        new \Doctrine\ORM\Tools\Console\Command\EnsureProductionSettingsCommand(),
        new \Doctrine\ORM\Tools\Console\Command\ConvertDoctrine1SchemaCommand(),
        new \Doctrine\ORM\Tools\Console\Command\GenerateRepositoriesCommand(),
        new \Doctrine\ORM\Tools\Console\Command\GenerateEntitiesCommand(),
        new \Doctrine\ORM\Tools\Console\Command\GenerateProxiesCommand(),
        new \Doctrine\ORM\Tools\Console\Command\ConvertMappingCommand(),
        new \Doctrine\ORM\Tools\Console\Command\RunDqlCommand(),
        new \Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand(),
    
    ));
    $cli->run();