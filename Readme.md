Indept
======

Indept est un application web qui permet de gérer ses notes de frais. Il est possible de faire interagir plusieurs utilisateurs.


## Installation
1. Téléchargez la dernière [release](https://github.com/remi100756/Indept/releases)
2. Extraire le dossier dans votre répertoire web
'tar -xvf indept-build.tar.gz'
3. Créez les répertoires `dept/fichiers` et `dept/comptes` et vérifiez que php peut les modifier
```
# pour rendre le groupe http propriétaire des dossiers
mkdir dept/fichiers dept/comptes
chown http:http dept/fichiers dept/comptes
```


## Dépendances
Nécéssite php5 (les version antérieures n'ont pas été testées)

### Outils tiers

#### Bibliotèques incluses
- [jQuery 2.1](https://duckduckgo.com/l/?kh=-1&uddg=http%3A%2F%2Fjquery.com%2F)
- [bootstrap 3](http://getbootstrap.com)
- [jQuery Ui](https://duckduckgo.com/l/?kh=-1&uddg=http%3A%2F%2Fjqueryui.com%2F) : restreint au datepicker
- [nprogress](http://ricostacruz.com/nprogress/)

#### Outils utilisés
- [Travis](https://travis-ci.org/)
- [Grunt](http://gruntjs.com/)
   - uglify
   - cssmin
   - jshint



[![Build Status](https://travis-ci.org/remi100756/Indept.svg?branch=master)](https://travis-ci.org/remi100756/Indept)

> Rémi Dupré
> 2014
