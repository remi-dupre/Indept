wget https://github.com/remi100756/Indept/archive/master.zip
unzip master.zip

rm -R Indept-master/comptes Indept-master/fichiers

if [ ! -d "dept/comptes" ]; then
    mkdir dept/comptes
    chown http:http dept/comptes
    echo "Le dossier \"comptes\" a dut etre cree, verifiez les permissions"
fi
if [ ! -d "dept/fichiers" ]; then
    mkdir dept/fichiers
    chown http:http dept/fichiers
    echo "Le dossier \"fichier\" a dut etre cree, verifiez les permissions"
fi
cp -R dept/comptes Indept-master/comptes
cp -R dept/fichiers Indept-master/fichiers

rm master.zip
rm -R dept
mv Indept-master dept
mv dept/updater.sh updater.sh
