# Logan's Books
Logan's Books is a **PHP/MySql** database driven application for a fictious bookstore. Data is uploaded to the database via PDO **Prepared Statements** and **Transactions**. Presentation and business logic is separated via **Twig Templates** templating engine along with **OOP** principles and **MVC** paradigm. SCSS is compiled using **PostCSS**. CSS is also minified and translated for maximum browser support using **PostCSS**. Plugins and extensions are installed via **Composer**. **jQuery** is used to handle DOM tree traversal and manipulation for dynamic content. All book covers are acquired from [Open Library Covers API](https://openlibrary.org/dev/docs/api/covers "Open Library Covers API"). Most of the mock data is generated from [Mockaroo](https://www.mockaroo.com/ "Generate Test Data Fast"). **See the links to the public schemas and datasets used for this project below*. 
## Modules 
- Forward Facing
  - Customer Sales (storefront and e-commerce)
  - Rentals (storefront only)
  - Refunds/Returns (storefront and e-commerce)
- Admin/Employees
  - Purchase Orders (storefront and warehouse for e-commerce inventory) 
  - Receiving (storefront and warehouse for e-commerce inventory)
## Features
### Books 
- Book CRUD (storefront and e-commerce)
- Genre CRUD (storefront and e-commerce)
- Category CRUD (storefront and e-commerce)
- Edition CRUD (storefront and e-commerce) 
- Publisher CRUD (storefront and e-commerce)
### Customer Accounts
- Customer Account CRU (storefront and e-commerce)
- Customer Account Deletion (admin only)
### Employee Accounts
- Employee Account CRUD (storefront and warehouse only) (admin only)
### Store/Warehouse Locations
- Store/Warehouse CRUD (only top level admin - Company CEO)
---

## PostCSS Install
### Reference: [PostCss Crash Course](https://www.youtube.com/watch?v=SP8mSVSAh6s)
1) npm i -D postcss postcss-cli
2) add ["build:css": "postcss public/styles/styles.css -o src/index.css"] to package-json file under scripts
3) add ["watch:css": "postcss public/styles/styles.css -o src/index.css -w"] to package-json file under scripts
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
- ### Autoprefixer
> - Adds vendor prefixes for styles that don't have full browser support
- ### postcss-preset-env
> - Converts new css features to supported css, allowing you to specify the current stage
- precss
> - Enables SASS like markup
- Stylelint
- PostCSS Assets
- CSSNano