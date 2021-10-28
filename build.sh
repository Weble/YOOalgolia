# Remove old files
rm -f build/*.zip

# Zip Plugin
cd plugin/
composer install
npm install
npm run production
rm -R node_modules
zip -qr ../build/plg_system_yooalgolia.zip ./* -x node_modules

cd ../
