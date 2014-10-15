# Genere une archive contenant le fichiers minifiés uniquement

grunt

mv web indept
rm -r indept/css/src indept/js/src

zip -9r indept-build indept/
tar -vczf indept-build.tar.gz indept/