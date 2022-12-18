## 💻 API Remake

This project is a remake of CoinPaprika API (https://api.coinpaprika.com/)

# 🚀 To start the project, follow theses steps : 
- Clone this repo
- Replace your own informations in .env file if you need to
- Type the commands "composer install" & "symfony server:start"
- Create database with "php bin/console doctrine:database:create" and the tables with "php bin/console doctrine:migrations:diff" and "php bin/console doctrine:migrations:migrate"
- Fill it with the fixtures for the Users "php bin/console doctrine:fixtures:load" and the symfony command for the API data "php bin/console app:insert-data"

# 🔧 Usage of the application : 
- You can create a new user on "/sign/up"
- You can generate a JWT Token with Postman on "/api/login_check" and then enter it in the swagger window on "/api" to get access 

## 🎊 ENJOY !

ps: dsl mais Coupe du monde > Étape 4 🥲
