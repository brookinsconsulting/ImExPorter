<?php

set_time_limit( 0 );

require 'autoload.php';

$cli          = eZCLI::instance();

$script = eZScript::instance(array(
    'use-session'    => false,
    'use-modules'    => false,
    'use-extensions' => true
));

$cli->output('Importing export ...');

$imExPorter = new ImExPorter();

try
{
    $imExPorter->import();
}
catch(Exception $exception)
{
    $cli->output($exception->getMessage());
}

//-- final shutdown
$cli->output('Done.');
$script->shutdown();