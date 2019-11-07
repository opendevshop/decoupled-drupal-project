# Composer template for Decoupled Drupal projects

This project template extends the Drupal Composer Project Template to include a 
tools for working with a decoupled front-end.

Please read that project's documentation for background information: https://github.com/drupal-composer/drupal-project for 

## Usage

First you need to [install composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx).

After that you can create a new Drupal project with the `composer create-project` command:

```
composer create-project devshop/decoupled-template:8.x-dev --no-interaction my-new-site
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



## Decoupled Drupal Models

There are many ways to connect a separate front-end project to your Drupal codebase.

### Method #1: Shared Repository

This is the simplest method. Create a composer-based Drupal codebase and add a 
folder for your second app to live.

Then you an hook `composer install` to run `npm install` or your desired command by adding a `post-install-hook`.

If you put your second codebase in the `app` folder. Add the following
to your `composer.json` file:

```json
{
  "scripts": {
        "post-install-cmd": [
            "cd app && npm install"
        ]
  }
}
```

This way, all of the source code is populated with one command: `composer install`.
 
### Method #2: Separate Repositories installed with Scripts

There's nothing wrong with just cloning the repo into the desired location after `composer install`...

```json
{
    "scripts": {
        "post-install-cmd": [
            "git clone git@github.com:my-organization/web-front-end.git app",
            "cd app && git checkout v1.0.0 && npm install"
        ]
    }
}
```

However, you should be sure to checkout a specific version (tag) so that 
changes to the branch won't affect this build.

### Method #3: Separate Repositories installed with Composer

With composer, you can require a separate git repository even if it is not on 
Packagist by creating a pseudo-package right in your `composer.json` file:

```json
{
    "require": {
        "our-website/front-end":  "dev-master"
     },
    "repositories": [
        {
            "type": "package",
            "package": {
                "name": "mywebsite-com/web",
                "version": "dev-master",
                "source": {
                    "url": "https://github.com/department-of-veterans-affairs/vets-website",
                    "type": "git",
                    "reference": "35deea6e8afaf58b9b4e3ee23fe2e0134c18d2e2"
                }
            }
        }
    ]
}
```

Then, your `web` project will installed into your `vendor` directory just like
any other composer package. It will be set to use the exact version mentioned 
in the "reference" field.

To make it easier to find, a symlink can be added to your `web` project in the 
vendor directory. The symlink can be added to the git repo.

```shell script
ln -s vendor/mywebsite-com/web app
git commit app -m 'Adding symlink to web front-end.'
```
### Method #4: Separate Repositories with Packagist

If your project is public, or you are willing to pay for a private packagist,
you can leverage the power of composer dependency management to link your 
projects.

#### Create a composer.json file in the Front-end project and Submit to Packagist or NPM.

Composer and NPM are dependency management tools. They allow you to specify 
exactly what version of different components to use so that you can be sure
they work together.

By submitting your project to Packagist or NPM (and using `composer require npm-asset/project-name`)
you free yourself from having to manually update the git reference.

Add a basic `composer.json` file to your front-end codebase and visit https://packagist.org
to sign up and Submit a Package. New git pushes to the web front-end will automatically update packagist.org, 
which provides the information to composer.

#### Front-end Project
From: https://github.com/department-of-veterans-affairs/vets-website/blob/master/composer.json:

```json
{
    "name": "mywebsite-com/web",
    "description": "Front-end for mywebsite.com. This repo contains the code to statically generate mywebsite.com.",
    "type": "node-project",
    "require": {
    },
    "license": "CC0-1.0",
    "minimum-stability": "dev",
    "extra": {
        "installer-types": ["node-project"],
        "installer-paths": {
            "web/": [
                "type:node-project"
            ]
        }
    }
}

```

#### Drupal Project
Once packagist or NPM has the new package, you can add it to your Drupal
codebase with: 

```shell script
composer require mywebsite-com/web
```

Packagist will sort out the latest version for you.
## Serving Decoupled Drupal

### NodeJS 

If your application requires a node server, you can simply configure it to
load it's content from the folder that the project was installed to. 
(`app` in our examples.)

Point your Drupal server to your Drupal codebase and your node server to the app. 

### Static Site Generators

Most NodeJS projects don't need to run a node server at all because they are
static site generators. They create `index.html` files and images and CSS from 
different sources, including Drupal.

#### Use the Drupal Server
Since any Drupal server can also serve static HTML and image assets, you can
tell your app to generate those assets into a folder in the "document root" 
of the Drupal site.

For example, if your static site generator output it's files to the `/web/static` 
folder in a Drupal Composer codebase, and you accessed your Drupal site at 
http://localhost, you would be able to access https://localhost/static to view 
the generated site.    

#### Absolute link references?

Most static site generators do not handle sub-folder paths. All links to 
external assets like images, CSS and other pages are typically generated with 
"absolute" paths. 

This means, if you load a page from https://localhost/static/about, the links 
might point to `/css/style.css`, which would result in 404 not found.

To work around this, you can use a trick with Drupal's `.htaccess` file:

From  
