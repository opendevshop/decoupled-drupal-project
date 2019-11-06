# Composer template for Decoupled Drupal projects

This project template extends the Drupal Composer Project Template to include a 
tools for working with a decoupled front-end.

Please read that project's documentation for background information: https://github.com/drupal-composer/drupal-project for 

## Usage

First you need to [install composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx).

After that you can create a new Drupal project with the `composer create-project` command:

```
composer create-project opendevshop/decoupled-drupal-project:8.x-dev --no-interaction my-new-site
```

Then, put the resulting files into a git repository.

```
cd my-new-site
git init
git add * .*
git commit -m'New project files.'
```

Follow instructions on your favorite git repo provider for creating the remote 
repository.

## What does this template do?

In addition to the [features of the Drupal Composer Project Template](https://github.com/drupal-composer/drupal-project#what-does-the-template-do), 
when installing the given `composer.json` some tasks are taken care of:

* Node & NPM are installed into the project's `bin-dir` thanks to the 
[mouf/nodejs-installer](https://packagist.org/packages/mouf/nodejs-installer) project.
* Node & NPM commands to output the version are run in `composer install` and `composer update` 
to ensure they are installed properly and to show the user which node and npm
are being used.
* Since `node` and `npm` are added to the composer `bin-dir`, they are 
automatically added to the PATH in composer scripts and plugins. Easily add calls
to `npm` to the `post-install-cmd` section of composer.json.
* Asset-packagist is added, allowing composer to require `npm-asset` and 
`bower-asset` packages. This means that [any NPM or Bower package](https://asset-packagist.org/)
 can be installed with composer instead of NPM.
* Provides branches with example structure for your projects.
