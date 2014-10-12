#!/bin/bash

wget https://github.com/remi100756/Indept/archive/master.zip
unzip master.zip

rm -R Indept-master/comptes Indept-master/fichiers

if [ ! -d "dept/comptes" ]; then
    mkdir Indept-master/comptes
    echo "Le dossier \"comptes\" a dut etre cree, verifiez les permissions"
fi
if [ ! -d "dept/fichiers" ]; then
    mkdir Indept-master/fichiers
    echo "Le dossier \"fichier\" a dut etre cree, verifiez les permissions"
fi
cp -R dept/comptes Indept-master/comptes
cp -R dept/fichiers Indept-master/fichiers

rm master.zip
rm -R dept
mv Indept-master dept
chown -R http:http dept
mv dept/updater.sh updater.sh
