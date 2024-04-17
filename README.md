# Dog Catalog

Welcome to the Dog Catalog! This web application allows users to explore different dog breeds, choose their favorites, and connect with other users who share their passion for dogs.

## Features

- **User Authentication and Sign Up:** Users can sign up for an account or log in to an existing account to access the app's features.

- **Browse Dog Breeds:** Once logged in, users can browse through a list of available dog breeds fetched from the [Dog API](https://dog.ceo/dog-api/documentation/). Each breed is accompanied by a random image to showcase its appearance.

- **Select Favorite Dogs:** Users can select up to three dogs as their favorites from the list of available breeds.

- **View Other Users:** Users can see a list of other users who are also using the app and explore the dogs they have chosen as their favorites.

## Tech Stack

This web app is built using the following technologies:

- **Framework:** Laravel
- **Frontend:** Vue.js
- **Styling:** Tailwind CSS

## Getting Started

To get started with the Dog Catalog, follow these steps:

1. Clone this repository to your local machine.
2. Install dependencies by running `composer install` and `npm install` in the project directory.
3. Set up your environment variables by copying the `.env.example` file to `.env` and configuring it with your database credentials and API keys.
4. Generate the application key by running `php artisan key:generate`.
5. Migrate the database by running `php artisan migrate`.
6. Start the development server with `php artisan serve`.
7. Visit `http://localhost:8000` in your web browser to access the application.

## API Usage

This application utilizes the Dog API to fetch information about different dog breeds. You can find the documentation for the Dog API [here](https://dog.ceo/dog-api/documentation/).

## Contributing

Contributions to the Dog Catalog are welcome! If you have any ideas for improvements or would like to report a bug, please open an issue or submit a pull request on GitHub.

## License

This project is licensed under the [MIT License](LICENSE). Feel free to use, modify, and distribute this code for your own purposes.
