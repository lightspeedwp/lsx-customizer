# LSX Customizer

This extension gives you complete control over the appearance of your LSX-powered WordPress site.

## Changelog

### 1.0.3
* Moved all blog customizer options to LSX Blog Customizer plugin

### 1.0.2
* Fix - Fixed all prefixes replaces (to_ > lsx_to_, TO_ > LSX_TO_)

### 1.0.1 - 08/12/16
* Fix - Added a extra style selector for main menu CSS: item active + hover
* Fix - Avoided use a return function inside the PHP function "empty" (compatibility with PHP 5.5 and lower)
* Fix - Compatibility with WPML 3.6
* Fix - Reduced the access to server (check API key status) using transients
* Fix - Made the API URLs dev/live dynamic using a prefix "dev-" in the API KEY

### 1.0.0 - 30/11/16
* First Version

## Setup

### 1: Install NPM
https://nodejs.org/en/

### 2: Install Gulp
`npm install`

This will run the package.json file and download the list of modules to a "node_modules" folder in the plugin.

### 3: Install Composer

Run the following two commands, this will install all the Composer Modules. 

This you need to do while inside the plugin directory.
`curl -sS https://getcomposer.org/installer | php`
 
Wait for the terminal to finish and test by running
`php composer.phar install`

### 4: Gulp Commands
`gulp watch`
`gulp compile-sass`
`gulp compile-js`
`gulp wordpress-lang`