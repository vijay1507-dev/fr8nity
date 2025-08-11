## Importing ports from public/ports.xlsx into the ports table

This guide explains how to import the `Country_id` and `Port` columns from `public/ports.xlsx` into the `ports` table via a one-time static route.

### What this does
- Reads `public/ports.xlsx` (first sheet)
- Skips the header row
- Inserts unique pairs of `(country_id, name)` into `ports`
- Ignores the `COUNTRY` column in the spreadsheet

### Prerequisites
- PHP 8.2 and Composer
- Database migrated so the `ports` table exists with columns:
  - `country_id` (unsigned big integer)
  - `name` (string)

Run migrations if needed:

```bash
php artisan migrate
```

### Dependency used to read XLSX
We use Spout to read `.xlsx` files.

```bash
composer require box/spout
```

If Composer fails due to a missing GD extension (pulled in by another package), either enable GD in your `php.ini`, or install Spout while ignoring the GD platform requirement:

```bash
composer require box/spout --ignore-platform-req=ext-gd
```

On XAMPP (Windows) to enable GD:
- Open `C:\xampp\php\php.ini`
- Ensure the line `extension=gd` is enabled (remove leading `;` if present)
- Restart Apache (and PHP-FPM if applicable)

### File format required
Place your Excel file at `public/ports.xlsx` with these columns in the first sheet:

- Column A: `Country_id` (numeric; this will be inserted into `ports.country_id`)
- Column B: `COUNTRY` (text; ignored by the importer)
- Column C: `Port` (text; inserted into `ports.name`)

Example row (after the header):

```
| Country_id | COUNTRY              | Port                 |
| 229        | UNITED ARAB EMIRATE  | ABU DHABI            |
```

### Route to run the import
The project defines a static route that performs the import:

- Method: `GET`
- Path: `/admin/import-ports`
- Middleware: `auth`, `admin` (must be logged-in admin)

How to call it locally (examples):

```text
http://localhost/admin/import-ports
```

or if your public path is under a subfolder:

```text
http://localhost/fr8nity/public/admin/import-ports
```

Successful response:

```json
{ "inserted": 1234 }
```

### Behavior and safeguards
- Header row is skipped automatically.
- Empty or invalid rows (missing country_id or name) are skipped.
- Duplicate check: a row is inserted only if no existing `ports` row matches the same `country_id` and `name`.
- Only the first sheet is processed.

### Relevant code locations
- Route: `routes/web.php` — look for `GET /admin/import-ports`.
- Model: `app/Models/Port.php` — `country_id` was added to `$fillable` to allow mass assignment.
- Migration: `database/migrations/2025_08_07_094106_create_ports_table.php`.

### Code added/changed

#### 1) Model edit (`app/Models/Port.php`)

```php
protected $fillable = [
    'country_id',
    'name',
];
```

#### 2) Route added (`routes/web.php`)

```php
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use App\Models\Port;

// Static route to import ports from public/ports.xlsx
Route::get('/admin/import-ports', function () {
    $filePath = public_path('ports.xlsx');
    if (!file_exists($filePath)) {
        abort(404, 'ports.xlsx not found in public folder');
    }

    $reader = ReaderEntityFactory::createXLSXReader();
    $reader->open($filePath);

    $insertCount = 0;
    foreach ($reader->getSheetIterator() as $sheet) {
        foreach ($sheet->getRowIterator() as $rowIndex => $row) {
            $cells = $row->toArray();
            if ($rowIndex === 1) {
                // Skip header
                continue;
            }
            // Expecting columns: [A:country_id, B:COUNTRY, C:Port]
            $countryId = isset($cells[0]) ? (int) $cells[0] : null;
            $portName = isset($cells[2]) ? trim((string) $cells[2]) : null;
            if (!$countryId || !$portName) {
                continue;
            }

            // Upsert to avoid duplicates per country/name
            $exists = Port::where('country_id', $countryId)
                ->where('name', $portName)
                ->exists();
            if (!$exists) {
                Port::create([
                    'country_id' => $countryId,
                    'name' => $portName,
                ]);
                $insertCount++;
            }
        }
        // Only first sheet is needed
        break;
    }

    $reader->close();

    return response()->json(['inserted' => $insertCount]);
})->middleware(['auth', 'admin']);
```

### Verifying the import
Use any of the following:

```bash
php artisan tinker
>>> App\Models\Port::count();
>>> App\Models\Port::where('country_id', 229)->take(5)->get();
```

Or query directly:

```sql
SELECT country_id, name FROM ports ORDER BY country_id, name LIMIT 50;
```

