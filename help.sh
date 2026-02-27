#!/bin/bash

case "$1" in

  resetar-banco)
    echo "🧹 Zerando banco wegia..."

    docker exec -i db mysql -uroot -psecret -e "DROP DATABASE IF EXISTS wegia; CREATE DATABASE wegia;"

    echo "🚀 Rodando migrations e seed..."

    docker exec -it api php artisan migrate --seed
    docker exec -it api php artisan module:seed --class=DatabaseSeeder --all

    echo "✅ Processo finalizado."
    ;;

  *)
    echo ""
    echo "Uso:"
    echo "  ./help.sh resetar-banco"
    echo ""
    ;;
esac