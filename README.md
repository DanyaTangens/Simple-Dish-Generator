# Dish Generator

Simple Dish Builder

## Clone the project

CLone this project

```sh
git clone https://github.com/DanyaTangens/simple-dish-generator.git
```

Go to the project directory :

```sh
cd simple-dish-generator
```

## Run the application

1. Copying the composer configuration file :

    ```sh
    cp .env.local.example .env
	cp web/.env.local.example web/.env
    ```

2. Start the application :

    ```sh
    make start
    ```

   **Please wait this might take a several minutes...**

    ```sh
    make logs 
    ```

3. Open your favorite browser :

   * [http://localhost:8000](http://localhost:8000/)
   * [http://localhost:8080](http://localhost:8080/) PHPMyAdmin (see .env)

4. Stop  services

    ```sh
    make stop
    ```

___

## Use Makefile

When developing, you can use [Makefile](https://en.wikipedia.org/wiki/Make_(software)) for doing the following operations :

| Name          | Description                                  |
|---------------|----------------------------------------------|
| composer-up   | Update PHP dependencies with composer        |
| start  | Create and start containers                  |
| stop   | Stop all services                  |
| restart | Restart all services                  |
| logs          | Follow log output                            |

### Examples

Start the application :

```sh
make start
```

Show help :

```sh
make help
```
### API
```
api/ping?name=world - Check working status
api/get-all-dishes-by-recipe?recipe=dcciii - Get All Dishes Combinations
``` 
