ImExPorter - Handle your eZ Publish database easier! (for mysql and innodb)

# What is it all about?
> Handling content on different environments for eZ Publish is a pain. Right, you habe the package-manager, but do you really want
> to manually mark and unmark changed objects before you can start exporting? Is it really the answer for the problem you are facing?
>
> True, there is also a way in doing a mysql-dump, but this also is a manual process...
>
> What the ImExPorter extension does, is reading the whole database-structure and fetching each tables content to finally create
> packed packages for each table. These packages can be imported into your database again by just running one command on cli.
>
> You dont need to type in your database login all the time. ImExPorter reads your database-settings directly from your eZ Publish instance.
> The packages are a lot smaller than a mysl-dump would be and they are split, so transfering them via scp/rsync/ftp isnt a big deal.
>
> At the moment only the content is exported. ImExPorter requires you, to have the same table structure on each databases you import or export
> from/to. This will be history, when a new feature dealing with this issue arrives.

# Installation
>+ Simply clone into extensions directory or add as submodule (git submodule add https://benboi@github.com/benboi/ImExPorter.git extension/imexporter)
>
>+ Add "imexporter" to your extensions-list.
>
>+ Run php bin/php/ezpgenerateautoloads.php -e
>
>+ Copy settings from imexport extension (if you like to modify them) and add them to the siteacces or (better) settings override
>
>+ Create a directory named "export" in your projects var directory (or change it in your config file, see step before)

# Import / Export
>+ Go to your projets root path via cli
>
>+ Run: php extension/imexporter/bin/export.php
>
>+ The export will now be written to your configured "BckDir"
>
> With importing it is the other way around. Running the import.php packages from your "BckDir" will be read and imported to your db. The tables will
> be truncated before.

# Troubleshooting
>+ ImExPorter is not finding my database-settings
> Where do your database-settings live?
> site-access
> settings/override
> extension
>
> The first two wont be your problem, if you configured the database in these places. If you resourced your database-settings to
> extension (for staging/environment separation for instance) then normally Ez Publish doesn't know these in cli-environment. With
> ImExPorter extension there is a way to get it work. Copy the configuration lines to your site-access or better settings-override
> and configure your extension plus settings-file in the so called "ExtensionSettingsMap". You can define as many extensions as you want,
> but ImExPorter just cares for active extensions (more precise one). If there is a match with your configuration und currently active
> extensions, ImExPorter will try to read the database-settings from there.

# TODO
>+ support for creating / changing the root structure (tables etc.) using a sql file
