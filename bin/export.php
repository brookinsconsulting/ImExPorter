<?php

set_time_limit( 0 );

define('__FOLDER__', './var/export/');

require 'autoload.php';

$cli          = eZCLI::instance();

$script = eZScript::instance(array(
    'use-session'    => false,
    'use-modules'    => true,
    'use-extensions' => true
));

$cli->output('Exporting db ...');

$imExPorter = new ImExPorter();

try
{
    $imExPorter->export();
}
catch(Exception $exception)
{
    $cli->output($exception->getMessage());
}

//-- final shutdown
$cli->output('Done.');
$script->shutdown();