# Remove old files
rm -f ./build/*.zip

# Zip Plugin
composer install
npm install
npm run production
zip -qr ./build/plg_system_yooalgolia.zip ./plugin/* -x ./plugin/assets/src/\*
