# Game simulator

## Requirements:
   - [docker compose](https://docs.docker.com/compose/install/)
   
## Installation:
   - To clone the project
   ```
   git@github.com:Fighter77777/rock-paper-scissors.git
   ```
   - Go to the folder
   ```
   cd rock-paper-scissors'
   ```
   - Copy file .env.[same_env].dist to .env. The example for dev enviroment:
   ```
   cp .env.dev.dist .env'
   ```
   - Build docker services 
   ```
   docker-compose build
   ```
   - Run project 
   ```
   docker-compose up
   ```
   - Install vendors 
   ```
   docker-compose exec php-fpm composer install
   ```
   
## Game play:
### rock, paper, scissors:
   To simulate game "Rock, paper, scissors" is needed to run the command:
   ```
   docker-compose exec php-fpm php bin/console play
   ```
   or
   ```
   docker-compose exec php-fpm php bin/console app:play:rock-paper-scissors
   ```

   You can specify the number of rounds using the parameter -r.
   The example for 5 rounds:
   ```
   docker-compose exec php-fpm php bin/console play -r5
   ```

## Run console in the application
   If you need the entrance to the console in docker-container:
   ```
   docker-compose exec php-fpm /bin/bash
   ```

## Run tests:
   - Project should be run. Execute next command if docker-compose is stopped.
   ```
   docker-compose up
   ```
   - To run all phpunit test use this command:
   ```
   docker-compose exec php-fpm bin/phpunit
   ```
   - To run a specific test use this command:
   ```
   docker-compose exec php-fpm bin/phpunit {path to the file with the test} 
   ```
   
## Convention
   Preferred IDE [PhpStorm](https://www.jetbrains.com/ru-ru/phpstorm/)
### New games adding
   - Configuration for games should be contained in file config/games.yaml
   - Parameters must have prefix app.game.{game_name}.*
   - Models should be put in folder src/Models/{game_name}/
   - Services should be put in folder src/Utils/{game_name}/
### Extending rock, paper, scissors:
##### To add new game element
   - need to open file config/games.yaml
   - add new game element in *app.game.rock_paper_scissors.all_elements*
   - set in the element which beat another *app.game.rock_paper_scissors.beats*.
   - you can configure game elements in strategies of players  *app.game.rock_paper_scissors.strategy_elements*.
##### To add strategies
   - add service strategy in folder src/Utils/RockPaperScissors/GameStrategies
   - you can describe service in config/services.yaml if it is needed.
   - set game elements in new strategy *app.game.rock_paper_scissors.strategy_elements* in file config/games.yaml.
   - add strategy for players *app.game.rock_paper_scissors.players* in config/games.yaml
##### To add players
   - add new player config in parameter *app.game.rock_paper_scissors.players* in file config/games.yaml.
##### To change the beating element
   - edit *app.game.rock_paper_scissors.beats* in file config/games.yaml.
