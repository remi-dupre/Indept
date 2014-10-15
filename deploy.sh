# Genere une archive contenant le fichiers minifiés uniquement

grunt

mv web indept
rm -r indept/css/src indept/js/src

echo "Création fichier .zip"
zip -9r indept-build indept/
echo "Création fichier .tar.gz"
tar -vczf indept-build.tar.gz indept/

ls