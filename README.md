# lsx-customizer
The LSX Customizer gives you additional layout options on your LSX powered web site.

LSX is a theme we’ve built to be versatile, so it’s only fair we put the power in the users’ hands to make it look and work exactly how they want. The importance of an active blog with a large readership is an invaluable asset, so to encourage that on your site, use the blog customizer to select just the right layout, colour, metadata and more.

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
`gulp compile-css`
`gulp compile-js`
`gulp wordpress-lang`
