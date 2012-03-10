<?php

require 'autoload.php';

$cli          = eZCLI::instance();

$script = eZScript::instance(array(
    'description' => 'Export configured db to a snapshot',
    'use-session' => false,
    'use-modules' => false,
    'use-extensions' => true
));

$options = $script->getOptions('[snapshot:]', array(
    'snapshot' => 'The name of the snapshot',
));

$snapshotName = $options['snapshot'];

if($snapshotName == '')
{
    $snapshotName = 'default';
}

$cli->output('Creating snapshot ' . $snapshotName . ' ...');

$imExPorter = new ImExPorter();

try
{
    $imExPorter->export($snapshotName);
}
catch(Exception $exception)
{
    $cli->output($exception->getMessage());
}

//-- final shutdown
$cli->output('Done.');
$script->shutdown();