# Examples

```batch
php ./commands.php controller=Ma\Worker\Test\Controllers\TestController action=getParam param='Este es un parametro'
```

```batch
php ./commands.php controller=Ma\Worker\Test\Controllers\TestController action=setParam method='Este es un parametro en el metodo'
```

```batch
php ./commands.php controller=Ma\Worker\Test\Controllers\TestController action=db
```

## Database Class Example

Here are some examples of how to use the `Database` class for common database operations. First you need configure database credentials in **.env** .

### 1. Database Connection

```php
use Ma\Worker\Shared\Database;

// Create a database connection
$database = new Database('localhost', 'username', 'password', 'database_name');
```

### 2. Custom Query Execution

```php
// Execute a custom SQL query
$query = "SELECT * FROM users WHERE id = :id";
$params = [':id' => 1];
$result = $database->query($query, $params);
```

### 3. Retrieve First Row

```php
// Retrieve and return the first row as an associative array
$query = "SELECT * FROM users WHERE id = :id";
$params = [':id' => 1];
$row = $database->get($query, $params);
```

### 4. Retrieve All Rows

```php
// Retrieve and return all rows as an array of associative arrays
$query = "SELECT * FROM products";
$rows = $database->getAll($query);
```

### 5. Insert Data

```php
// Insert data into a table
$data = ['name' => 'John', 'email' => 'john@example.com'];
$table = 'users';
$database->insert($table, $data);
```

### 6. Update data

```php
// Insert data into a table
$data = ['name' => 'John', 'email' => 'john@example.com'];
$table = 'users';
$database->insert($table, $data);
```

### 7. Delete data

```php
// Delete rows from a table based on a condition
$table = 'users';
$condition = 'id = :id';
$params = [':id' => 1];
$database->delete($table, $condition, $params);
```

### 8. Search

```php
// Search for rows in a table based on a column value using a LIKE condition
$table = 'products';
$column = 'product_name';
$value = 'apple';
$matchingProducts = $database->search($table, $column, $value);
```

### 9. Single Row

```php
// Retrieve and return a single row from a table based on a condition
$table = 'users';
$condition = 'id = :id';
$params = [':id' => 1];
$row = $database->find($table, $condition, $params);
```

### 10. Bulk insert

```php
// Perform a bulk insert of data into a table
$data = [
    ['name' => 'John', 'email' => 'john@example.com'],
    ['name' => 'Jane', 'email' => 'jane@example.com'],
    // Add more data rows as needed
];
$table = 'users';
$database->insertBulk($table, $data);
```
