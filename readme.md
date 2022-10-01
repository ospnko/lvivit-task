# LvivIT Task

It's a simple Rest API application, which allows you to manage books.

Full list of requirements [here](https://gist.github.com/gaalferov/d784f8ef262d803d430016194e79b09d)

## Book model structure

- Title (string)
- Publisher (string)
- Author (string)
- Genre (string)
- Book publication (date)
- Amount of words in the book (int)
- Book price in US Dollars

## API Docs

Visit the `http://localhost:8080`.

## Installation

1. `docker compose up` - will download and install needed docker image
2. Try to visit `http://localhost:8000` it should show you default Symfony page
3. `docker compose exec php php bin/console doctrine:migrations:migrate` - to initialize database tables
4. `docker compose exec php php bin/console doctrine:fixtures:load` - to fill database with dummy data

## Testing

Run `docker compose exec php sh bin/test.sh`. It initializes testing environment and runs the tests.
