
## Api de commentaires
L’API permet d’obtenir, de rédiger et de supprimer des commentaires. Elle permet également de répondre à un commentaire et d’en signaler en cas de contenu jugé inapproprié.

## Installation
1. Cloner le projet
2. Installer les dépendances : composer install
3. Créer la base de données : php bin/console doctrine:database:create (modifier si besoin le chemin vers la base de données dans le fichier .env)
4. Jouer les migrations : php bin/console doctrine:migrations:migrate
5. Installer le système d'authentification :
$ mkdir -p config/jwt  
$ openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096  
$ openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout  
Attention : la pass phrase entrée doit être identique à celle présente dans le fichier .env  
6. Lancer le serveur : symfony server:start
