ImExPorter - Handle your eZ Publish database easier! (for mysql and innodb)

# What is it all about?
> Handling content on different environments for eZ Publish is a pain. Right, you have the package-manager, but do you really want
> to manually mark and unmark changed objects before you can start exporting? Is it really the answer for the problem you are facing?
>
> True, there is also a way in doing a mysql-dump, but this also is a manual process...
>
> What the ImExPorter extension does, is reading the whole database-structure and fetching each tables content to finally create
> snapshots for each table. These snapshots can be imported into your database again by just running one command on cli.
>
> You dont need to type in your database login all the time. ImExPorter reads your database-settings directly from your eZ Publish instance.
> The snapshots are a lot smaller than a mysl-dump would be and they are split, so transfering them via scp/rsync/ftp isnt a big deal.
>
> In first place you will need a structure inside of your database, so ImExPorter can apply the data on tables. Fortunately ImExPorter is also
> capable of executing sql-dumps on your database, so you can create a working environment (database wise) by just running two cli commands.

# Features
>+ Create compressed snapshots of your db!
>
>+ Create the basic table-structure using a mysql-dump via cli!
>
>+ Use multiple snapshots and switch between them!
>
>+ Take only the tables you need to export!
>
>+ Dont waste time, just use a one-liner!
>
>+ Switch your environments (dev / live) easily!

# Installation
>+ Simply clone into extensions directory or add as submodule (git submodule add https://benboi@github.com/benboi/ImExPorter.git extension/imexporter)
>
>+ Add "imexporter" to your extensions-list.
>
>+ Run php bin/php/ezpgenerateautoloads.php -e
>
>+ Copy settings from imexport extension (if you like to modify them) and add them to the siteacces or (better) settings override
>
>+ Create a directory named "snapshots" in your projects var directory (or change it in your config file, see step before)

# Import / Export
>+ Go to your projets root path via cli
>
>+ Run: php extension/imexporter/bin/export.php --snapshot=name (if you skip the last parameter, default will be used)
>
>+ The snapshot will now be written to your configured "SnapshotDir"
>
> With importing it is the other way around. Running the import.php a snapshot from your "SnapshotDir" will be read and imported to your db. The tables will
> be truncated before.
>
>+ If you import the first time on a freshly created database, you need to have a table-structure inside your db. Luckily you can do this with ImExPorter to, by just running php extension/imexporter/bin/loadstructure.php --structure=dump.sql.
> The dumps are living in var/structure by default (you can change this using your config file). A current ezpublish community-edition dump is included. You simply have to copy it, to the given var-folder.

# Available commands
>+ php extension/imexporter/bin/export.php --snapshot=name (default snapshot is "default" if none given)
>+ php extension/imexporter/bin/import.php --snapshot=name (default snapshot is "default" if none given) [WARNING: data is dropped!!!]
>+ php extension/imexporter/bin/loadstructure.php --structure=name (default structure is "dump.sql" if none given) [WARNING: everything is dropped!!!]

# Troubleshooting
>+ ImExPorter is not finding my database-settings
>  Where do your database-settings live?
>* site-access
>* settings/override
>* extension
>
> The first two wont be your problem, if you configured the database in these places. If you outsourced your database-settings to
> an extension (for staging/environment separation for instance) then normally Ez Publish doesn't know these in cli-environment. With
> ImExPorter there is a way to get it work. Copy the configuration lines to your site-access or better settings-override
> and configure your extension plus settings-file in the so called "ExtensionSettingsMap". You can define as many extensions as you want,
> but ImExPorter just cares for active extensions (more precise one). If there is a match with your configuration und currently active
> extensions, ImExPorter will try to read the database-settings from there and use them.
