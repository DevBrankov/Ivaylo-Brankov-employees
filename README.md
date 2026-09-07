#Employee Checker

Laravel application that identifies the pair of employees who have worked together on common projects for the longest period of time.

1. Install backend dependencies:
 - composer install

2. Launch the project:
 - php artisan serve

3. Navigate to:
 - https://127.0.0.1:800

4. Upload CSV file in the following format:
```csv
    EmpID	ProjectID	DateFrom	DateTo
    11	    500         2026-01-01	NULL
    22      500         2026-03-01	NULL
    11      600         2026-01-01	2026-01-10
    22      600         2026-01-05	2026-01-20
    33      700         2026-02-01	2026-02-10
    44      700         2026-02-05	2026-02-07
```
 - use the already generated CSV file from "examples" folder in the project

Project files:
 - route file      - web.php
 - controller file - EmployeeController.php
 - UI/blade file   - welcome.blade.php
 - JavaScript file - app.js

