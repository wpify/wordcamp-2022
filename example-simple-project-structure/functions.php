<?php

use Wordcamp\Prague\Wpify\CustomLogger;
use Wordcamp\Prague\Wpify\DB;
use Wordcamp\Prague\Wpify\Plugin;
use WordcampDeps\DI\ContainerBuilder;
use WordcampDeps\Psr\Log\LoggerInterface;

use function WordcampDeps\DI\create;

// Required scoped dependencies
require_once __DIR__ . '/deps/scoper-autoload.php';

// Require non-scoped dependencies
require_once __DIR__ . '/vendor/autoload.php';

// Create the DI container
$container_builder = new ContainerBuilder();

// Add DI definitions
$container_builder->addDefinitions( [
	// The Logger interface is mapped to CustomLogger implementation
	LoggerInterface::class => create( CustomLogger::class ),
	// Passing some params to the constructor
	DB::class              => create()->constructor( 'localhost', 'root', 'root' ),
] );

// Build the container
$container = $container_builder->build();

// Init the plugin
$container->get( Plugin::class );
