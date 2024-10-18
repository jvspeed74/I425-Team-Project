# Developer Guide

## Table of Contents

1. [Composer](#composer)
2. [Coding Standards](#coding-standards)
3. [GitHub Actions](#github-actions)
4. [Environment Variables](#environment-variables)

## Composer

- The project includes a preconfigured `composer.json` file.
- The repository includes `composer.phar`, allowing Composer to be run without a global installation.
- The PhpStorm IDE has a startup task to run `composer.phar install` to get the `vendor` directory.

## Coding Standards

- The project `.idea` file has been configured to adhere to PERCS-2.0 PHP standards.
- The `phpstan` and `php-cs-fixer` packages are required in the `dev` section of the `composer.json` file. Once
  downloaded, PhpStorm detects them and runs them in the background, providing code inspections on the fly.
- This setup does not require manual intervention.

## GitHub Actions

- On every push and PR, a pipeline will run on GitHub to verify coding standards and ensure tests are successful.
- Nothing prevents code from being pushed to the repository; the pipeline is there to highlight key issues in our code.
- The project requires the `GitHub Action Manager` plugin, allowing you to see the results of the pipeline without
  needing to tab out from PhpStorm.
- To see the pipeline results, click on the circular icon with a play button, located in the bottom left corner of the
  IDE.

## Environment Variables

- The project requires a `.env` file, which is used to store environment variables.
- The main use of this package is to reduce the coupling between our environments (i.e. database ports)
- The PHP dotenv package is included in the `composer.json` file to allow the `.env` file to be read.
- To get started:
  1. Copy the contents of the `.env.example` file
  2. Create a new file named `.env`.
  3. Paste the contents into the `.env` file.
  4. Update the values in the `.env` file to match your local environment.


