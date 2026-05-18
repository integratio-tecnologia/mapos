# Tech Stack: Map-OS

## Core Language & Framework
- **PHP ^8.4:** Leveraging modern PHP features and performance improvements.
- **CodeIgniter ^3.1.13:** The base MVC framework, chosen for its small footprint and reliability in shared hosting environments.

## Database & Storage
- **MySQL / MariaDB:** Relational database for all system data.
- **SQL Source:** `banco.sql` serves as the base schema, with incremental updates in the `updates/` directory.

## Backend Dependencies
- **vlucas/phpdotenv:** For environment variable management (`.env`).
- **NFePHP:** For electronic invoice (NF-e, NFC-e) emission and communication with SEFAZ.
- **mercadopago/dx-php, efipay/sdk-php-apis-efi, codephix/asaas-sdk:** Payment gateway integrations.
- **mpdf/mpdf & phpoffice/phpword:** For generating PDF reports and Word documents.
- **filp/whoops:** For detailed error handling during development.

## Frontend Technologies
- **HTML5 & CSS3:** Responsive layout using the Matrix-Admin theme.
- **Bootstrap v2.3.2:** The primary CSS framework (legacy dependency).
- **jQuery:** The main JavaScript library for DOM manipulation and AJAX.
- **DataTables:** For advanced, searchable, and paginated tables.
- **SweetAlert2 & Gritter:** For user notifications and alerts.

## Infrastructure & Dev Tools
- **Docker:** Containerized development environment using `docker-compose`.
- **Composer:** For PHP dependency management.
- **PHP-CS-Fixer:** To ensure coding standards are maintained across the project.
