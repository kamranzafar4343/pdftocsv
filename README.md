````md
# PDF to CSV Converter — Technical Steps

These are the exact steps to rebuild this project later without rethinking the design.

---

## 1. Create Laravel Project
```bash
laravel new pdftocsv
````

---

## 2. Install Java (JDK)

Verify installation:

```bash
where java
```

Use the full path of `java.exe` in the code.

---

## 3. Download Tabula

* Download `tabula-jar-with-dependencies.jar`
* Rename to:

```
tabula.jar
```

* Place it in:

```
storage/app/tabula.jar
```

---

## 4. Create Controller

```bash
php artisan make:controller PdfController
```

---

## 5. Controller Logic (Core)

* Get the uploaded file real path
* Execute Tabula via `exec()`
* Capture CSV output
* Return CSV as download

```php
$pdfPath = $request->file('pdf')->getRealPath();

$javaPath = "C:\\Program Files\\Eclipse Adoptium\\jdk-xx\\bin\\java.exe";
$tabulaJar = storage_path("app/tabula.jar");

$command = "\"$javaPath\" -jar \"$tabulaJar\" -p all -f CSV \"$pdfPath\"";

exec($command . " 2>&1", $output);

file_put_contents($outputCsv, implode("\n", $output));

return response()->download($outputCsv);
```

---

## 6. Routes

```php
Route::get('/pdf', fn() => view('pdf'));
Route::post('/convert', [PdfController::class, 'convert']);
```

---

## 7. Frontend (Single Page, No Reload)

* File input
* JavaScript Fetch API
* Download CSV blob

```js
const formData = new FormData();
formData.append('pdf', file);

fetch('/convert', { method: 'POST', body: formData })
  .then(res => res.blob())
  .then(blob => {
    const url = URL.createObjectURL(blob);
    window.location = url;
  });
```

---

## 8. PHP Settings

In `php.ini`:

```
disable_functions =
```

Make sure `exec` is enabled.

---

## 9. Requirements

* PHP 8+
* Java JDK
* Tabula.jar
* Works only for text-based PDFs (not scanned images)

---

## 10. Run Project

```bash
php artisan serve
```

Open in browser:

```
http://127.0.0.1:8000/pdf
```

---

```
```
