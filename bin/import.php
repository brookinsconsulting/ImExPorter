<?php

require 'autoload.php';

$cli = eZCLI::instance();

$script = eZScript::instance(array(
    'description' => 'Import a snapshot to configured db',
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

$cli->output('Importing snapshot ' . $snapshotName . ' ...');

$imExPorter = new ImExPorter();

try
{
    $imExPorter->import($snapshotName);
}
catch(Exception $exception)
{
    $cli->output($exception->getMessage());
}

//-- final shutdown
$cli->output('Done.');
$script->shutdown();