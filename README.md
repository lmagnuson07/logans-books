# Logan's Books
Logan's Books is a **PHP/MySql** database driven application meant to provide a user-friendly interface for book data. 
The book data for the application is acquired from the [**Google Books**](https://developers.google.com/books/docs/v1/reference/) and [**OpenLibrary**](https://openlibrary.org/developers/api) APIs and loaded into a **MySQL** database. 
Presentation and business logic is separated via **Twig Templates** templating engine along with **OOP** principles and **MVC** paradigm, with classes autoloaded via **PSR-4**. 
SCSS is compiled using **PostCSS**. CSS is also minified and transformed for maximum browser support using **PostCSS**. 
JavaScript is minified using **UglifyJS**. Plugins and extensions are installed via **Composer** and **NPM**.
## Features
- Admin interface to gracefully handle the API requests when uploading data.
### User Accounts
- User Account for creating and updating custom "Bookshelves"
- User Account Deletion (admin only)
### Admin Accounts
- Admin Account for CRUD (top level admin only)
---

## Country data
All country, state, and city data are acquired from [UNECE](https://unece.org/trade).
The download for the CSV files can be found [here](https://unece.org/trade/cefact/UNLOCODE-Download).
Data from [UNECE](https://unece.org/trade) is encoded in the ANSI format.
The data was converted to UTF8 with the following Windows Powershell prompt:
```text
Get-Content -Path "C:\path\to\input.csv" | Set-Content -Path "C:\path\to\output.csv" -Encoding UTF8
```
---

## PostCSS 
### Reference: [PostCss Crash Course](https://www.youtube.com/watch?v=SP8mSVSAh6s)
1) npm i -D postcss postcss-cli
2) add [ "build:css": "postcss public/styles/styles.css -o src/index.css" ] to package-json file under scripts
3) add [ "watch:css": "postcss public/styles/styles.css -o src/index.css -w" ] to package-json file under scripts
	- Change the target and source files to match your needs.
4) Install the plugins
	- npm -i -D autoprefixer
5) Create the postcss.config.js file in the root of public. Add the following code:
```js
module.exports = {
    plugins: [
        require('autoprefixer')
    ]
};
```

## PostCSS Plugins
> ### autoprefixer
> - Adds vendor prefixes for styles that don't have full browser support

> ### postcss-preset-env
> - Converts new css features to supported css, allowing you to specify the current stage

> ### precss
> - Enables SASS like markup

> ### Stylelint
> - Css linter that points out errors and enforces coding conventions

> ### PostCSS Assets
> - Asset manager for CSS that isolates  stylesheets from environmental changes, gets image sizes and inlines files 

> ### CSSNano
> - Minifies CSS and creates a min.css file for production 

> ### postcss-import
> - Allows for local css file imports using the @import rule

> ### postcss-mixins
> - Adds support for SCSS like mixins

> ### css-prefers-color-scheme
> - Adds support for light/dark modes

> ### postcss-simple-vars
> - Adds support for Sass-like variables

> ### postcss-nesting
> - Adds support for css style nesting

> ### postcss-stepped-value-functions
> - Adds more math functions for css

---
## Notes
Added the following to the vhost for this application to rewrite traffic to an index.php page in the public directory to allow for custom routing.
This can also be added in a .htaccess file, but since I have access to configuration files, I put it in the vhost config file.
```text
<IfModule mod_rewrite.c>
	RewriteEngine On

	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteCond ${REQUEST_FILENAME} !-f

	RewriteRule ^ index.php [L]
</IfModule>
```
### URLS for Site
Urls for the application are setup in the vhosts file on port 80.
The urls are added to the C:\Windows\System32\drivers\etc\hosts file to reroute localhost.
There is the main site url as well as a url for phpmyadmin as the document root is a folder inside htdocs:
- http://logans-books.local/
- http://logans-books-phpmyadmin.local/phpmyadmin/
