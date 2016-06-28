<!-- @file Instructions for subtheming using the Bootstrap Sass Starterkit. -->
<!-- @defgroup subtheme_sass -->
<!-- @ingroup subtheme -->

# Bootstrap SASS

Below are instructions on how to create a Bootstrap sub-theme using a SASS
preprocessor.

- [Requirements](#requirements)
- [Installation](#install)
- [Initial setup](#setup)
- [Theme Development](#theming)
- [Compiling via Gulp](#compiling)
- [Adding Browsersync](#browsersync)

## Requirements {#requirements}

This starter theme assumes that you have:

- Drupal Bootstrap Theme
- NodeJS (Version v4.2.x or newer recommended with NPM 3.x)
- Gulp installed globally with the -g option
- For Drupal 7 - jQuery 1.9.1 or higher (Use jQuery_Update module for Drupal)

## Installation {#install}

Download this project into your sites/all/themes folder of your Drupal
installation.

## Initial setup {#setup}

1. Enable this theme and set it as the default theme in Drupal.

2. Run these commands from the root directory of this theme to install the required npm modules:

`npm install`

`npm install -g gulp`

## Theme Development {#theming}

- Start by reviewing the variables file in sass/base/_variable-overrides.scss file.
 
- You can customize most variables here to match your website design.

- Add SASS files to the subfolders in the sass folder, following the existing patterns.

## Compiling via Gulp {#compiling}

- Run the following commands in the root of your subtheme to compile the Bootstrap SASS code to CSS:

`gulp init` - creates the initial css files

`gulp watch` - watches the sass folder for changes

## Adding Browsersync {#browsersync}

- Install the Drupal browsersync module from https://www.drupal.org/project/browsersync
- In "Themes" -> "Appearance" -> "Settings" scroll down and enable browsersync.
- Edit the proxy address in the gulpfile.js file to match the IP or hostname of your Drupal website.
- Run `gulp browsersync` - sets up a browsersync session and watches the sass and js folders.


----

[Bootstrap Framework](http://getbootstrap.com)

[Bootstrap Framework Source Files](https://github.com/twbs/bootstrap/releases)

[SASS Reference](http://sass-lang.com)
