#!/bin/bash

set -euo pipefail

run_composer() {
    printf "Running composer commands...\n"
    composer --version
    composer install --no-interaction
    composer update --no-interaction
}

main() {
    local web_root="/var/www/html"
    cd "$web_root"
    run_composer
}

main "$@"
