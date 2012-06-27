__STATME__


Rappatrier le projet

`git clone git@github.com:statme-fr/statme.git`

`git status`

Remplir le fichier de configuration "config/db.yml"

Tester la connection 
`php bin/doctrine dbal:run-sql SHOW DATABASES;`
 
Puis éxécuter la commande
`php bin/doctrine orm:schema-tool:create`

test

