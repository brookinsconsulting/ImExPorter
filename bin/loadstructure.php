<?php

require 'autoload.php';

$cli          = eZCLI::instance();

$script = eZScript::instance(array(
    'description' => 'Load sql-structure file and apply to db',
    'use-session' => false,
    'use-modules' => false,
    'use-extensions' => true
));

$options = $script->getOptions('[structurefile:]', array(
    'structurefile' => 'The name of the structure-file',
));

$structureFileName = $options['structurefile'];

if($structureFileName == '')
{
    $structureFileName = 'dump.sql';
}

$cli->output('Loading structure ' . $structureFileName . ' ...');

$structureLoader = new ImExPorterStructureLoader();

try
{
    $structureLoader->load($structureFileName);
}
catch(Exception $exception)
{
    $cli->output($exception->getMessage());
}

//-- final shutdown
$cli->output('Done.');
$script->shutdown();