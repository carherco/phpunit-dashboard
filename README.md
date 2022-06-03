# A dashboard for phpunit reports

A dashboard panel for visualizing phpunit reports.

It's made with Symfony framework v6 and PHP v8.

The visualizer reads JUnit XML reports, so it's also valid for other testing libraries as long as they admit JUnit XML output format.

## Installation

> git clone https://github.com/carherco/phpunit-dashboard.git
> cd phpunit-dashboard
> composer install

## Configuration

Create a file named .env.local

Copy .env file content to .env.local file

Edit .env.local file to configure DATABASE_URL variable.

In the console run:

> php bin/console doctrine:database:create
> php bin/console doctrine:migrations:migrate

### Create users

The app is preconfigured to be private. So you will need to create users to be able to login into. 

> **_NOTE:_**  If you don't want the app to be private skip this step and go to next step: _Deactivate security_.

Users can be created manually in the database, in the _user_ table:

````sql
INSERT INTO `user` (`id`, `email`, `roles`, `password`) VALUES
(1, 'carherco@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$DcaLIyNfA5UQLm5KVvQBpOU4ria6AqkMwYON8weJNRhvLiWW5B5pu');
````

User passwords can be generated with this command:

> php bin/console security:hash-password a_plain_password


### Deactivate security

Instead of creating users, the app can be configured to be completely public.

To do so, go to _config/packages/security.yaml_ and comment all the access control section:

With security (users need to log in):

````yaml
access_control:
        - { path: '^/dashboard', roles: ROLE_USER }
        - { path: '^/upload', roles: ROLE_USER }
        - { path: '^/login', roles: PUBLIC_ACCESS }
````

Without security (without users):

````yaml
    access_control:
#        - { path: '^/dashboard', roles: ROLE_USER }
#        - { path: '^/upload', roles: ROLE_USER }
#        - { path: '^/login', roles: PUBLIC_ACCESS }
````


## Usage

### Generating reports

Generate reports of your project in JUnit XML output

For example, with PHPUnit:

> phpunit tests --log-junit=report.xml

### Loading reports via command

To load a report to the dashboard, launch this command in the console

> php bin/console app:upload-report path/to/report.xml --tag myProject

### Loading reports via web

In your browser, go to the project url _/upload/report_

### Visualizing reports

In your browser, go to the project url _/dashboard/report/list_ to see a list of all reports loaded.

Click in a report to see the detail of that report and the messages of its failed tests.

## Web development server

In development mode, you can run a development server with this command:

> php -S localhost:8000 -t public/

And then go to http://localhost:8000

## Online demo

[online demo](https://carherco.es/phpunit-dashboard/public/index.php/dashboard/report/list)

- email: carherco@gmail.com
- password: carlos
