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
### Mockaroo Links
