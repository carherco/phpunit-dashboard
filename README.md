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

## Usage

### Generating reports

Generate reports of your project in JUnit XML output

For example, with PHPUnit:

> phpunit tests --log-junit=report.xml

### Loading reports

To load a report to the dashboard, launch this command in the console

> php bin/console app:upload-report path/to/report.xml --tag myProject

### Visualizing reports

In your browser, go to the project url /dashboard/report/list to see a list of all reports loaded and click in a report
to see the detail of that report and the messages of its failed tests.

In development mode, you can run a development server with this command:

> php -S localhost:8000 -t public/

And then go to http://localhost:8000/dashboard/report/list

## Online demo

[online demo](https://carherco.es/phpunit-dashboard/public/index.php/dashboard/report/list)
