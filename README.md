# Installation

Run the Composer install command from the Terminal:

    docker-compose up -d
    
    cd ./html

    composer install

# Usage

After finish in the methods run the next command:

    php vendor/bin/phinx migrate -c config-phinx.php