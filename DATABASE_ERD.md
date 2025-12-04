# NexStack Inventory Management System - Database ERD Documentation

## Database Name: `nexstock_db`

This document provides a comprehensive list of all database tables, their columns, data types, relationships, and constraints for the NexStack Inventory Management System.

---

## Core Business Tables

### 1. `users`
**Description:** Stores user account information and authentication details.

| Column Name | Data Type | Constraints | Default | Description |
|------------|-----------|-------------|---------|-------------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | - | User unique identifier |
| name | VARCHAR(255) | NOT NULL | - | User's full name |
| email | VARCHAR(255) | NOT NULL, UNIQUE | - | User's email address |
| email_verified_at | TIMESTAMP | NULLABLE | NULL | Email verification timestamp |
| password | VARCHAR(255) | NOT NULL | - | Hashed password |
| role | ENUM/VARCHAR | NOT NULL | 'staff' | User role: 'admin' or 'staff' |
| remember_token | VARCHAR(100) | NULLABLE | NULL | Remember me token |
| created_at | TIMESTAMP | NULLABLE | NULL | Record creation timestamp |
| updated_at | TIMESTAMP | NULLABLE | NULL | Record update timestamp |

**Relationships:**
- One-to-Many with `sessions` (user_id)
- One-to-Many with `defects` (reported_by, reviewed_by)

---

### 2. `categories`
**Description:** Product categories for organizing products.

| Column Name | Data Type | Constraints | Default | Description |
|------------|-----------|-------------|---------|-------------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | - | Category unique identifier |
| name | VARCHAR(255) | NOT NULL | - | Category name |
| description | TEXT | NULLABLE | NULL | Category description |
| created_at | TIMESTAMP | NULLABLE | NULL | Record creation timestamp |
| updated_at | TIMESTAMP | NULLABLE | NULL | Record update timestamp |

**Relationships:**
- One-to-Many with `products` (category_id → categories.id) - CASCADE DELETE

---

### 3. `suppliers`
**Description:** Supplier/vendor information.

| Column Name | Data Type | Constraints | Default | Description |
|------------|-----------|-------------|---------|-------------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | - | Supplier unique identifier |
| company_name | VARCHAR(255) | NOT NULL | - | Supplier company name |
| contact_person | VARCHAR(255) | NOT NULL | - | Contact person name |
| email | VARCHAR(255) | NOT NULL | - | Supplier email |
| phone | VARCHAR(255) | NOT NULL | - | Supplier phone number |
| address | TEXT | NULLABLE | NULL | Supplier address |
| created_at | TIMESTAMP | NULLABLE | NULL | Record creation timestamp |
| updated_at | TIMESTAMP | NULLABLE | NULL | Record update timestamp |

**Relationships:**
- None (standalone table)

---

### 4. `products`
**Description:** Product master data.

| Column Name | Data Type | Constraints | Default | Description |
|------------|-----------|-------------|---------|-------------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | - | Product unique identifier |
| name | VARCHAR(255) | NOT NULL | - | Product name |
| sku | VARCHAR(50) | NOT NULL, UNIQUE | - | Stock Keeping Unit (unique) |
| category_id | BIGINT UNSIGNED | NOT NULL, FOREIGN KEY | - | Reference to categories.id |
| description | TEXT | NULLABLE | NULL | Product description |
| price | DECIMAL(10,2) | NOT NULL | - | Product price |
| quantity | INTEGER | NOT NULL | 0 | Product quantity in stock |
| status | VARCHAR(255) | NOT NULL | 'active' | Product status (active/discontinued) |
| created_at | TIMESTAMP | NULLABLE | NULL | Record creation timestamp |
| updated_at | TIMESTAMP | NULLABLE | NULL | Record update timestamp |

**Foreign Keys:**
- `category_id` → `categories.id` (ON DELETE CASCADE)

**Relationships:**
- Many-to-One with `categories` (category_id)
- One-to-Many with `transactions` (product_id)
- One-to-Many with `inventory` (product_id)
- One-to-Many with `defects` (product_id)

---

### 5. `warehouses`
**Description:** Warehouse locations for inventory management.

| Column Name | Data Type | Constraints | Default | Description |
|------------|-----------|-------------|---------|-------------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | - | Warehouse unique identifier |
| name | VARCHAR(255) | NOT NULL | - | Warehouse name |
| location | VARCHAR(255) | NOT NULL | - | Warehouse location |
| status | VARCHAR(255) | NOT NULL | 'active' | Warehouse status (active/inactive) |
| created_at | TIMESTAMP | NULLABLE | NULL | Record creation timestamp |
| updated_at | TIMESTAMP | NULLABLE | NULL | Record update timestamp |

**Relationships:**
- One-to-Many with `inventory` (warehouse_id)

---

### 6. `inventory`
**Description:** Inventory tracking per product and warehouse.

| Column Name | Data Type | Constraints | Default | Description |
|------------|-----------|-------------|---------|-------------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | - | Inventory unique identifier |
| product_id | BIGINT UNSIGNED | NOT NULL, FOREIGN KEY | - | Reference to products.id |
| warehouse_id | BIGINT UNSIGNED | NULLABLE, FOREIGN KEY | NULL | Reference to warehouses.id |
| quantity | INTEGER | NOT NULL | - | Quantity in inventory |
| status | VARCHAR(255) | NOT NULL | 'in_stock' | Inventory status |
| created_at | TIMESTAMP | NULLABLE | NULL | Record creation timestamp |
| updated_at | TIMESTAMP | NULLABLE | NULL | Record update timestamp |

**Foreign Keys:**
- `product_id` → `products.id` (ON DELETE CASCADE)
- `warehouse_id` → `warehouses.id` (ON DELETE CASCADE)

**Relationships:**
- Many-to-One with `products` (product_id)
- Many-to-One with `warehouses` (warehouse_id)

---

### 7. `transactions`
**Description:** Transaction records for stock in/out movements.

| Column Name | Data Type | Constraints | Default | Description |
|------------|-----------|-------------|---------|-------------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | - | Transaction unique identifier |
| product_id | BIGINT UNSIGNED | NOT NULL, FOREIGN KEY | - | Reference to products.id |
| quantity | INTEGER | NOT NULL | - | Transaction quantity |
| type | VARCHAR(255) | NOT NULL | - | Transaction type: 'in' or 'out' |
| date | DATE | NOT NULL | - | Transaction date |
| status | VARCHAR(255) | NOT NULL | 'completed' | Transaction status |
| created_at | TIMESTAMP | NULLABLE | NULL | Record creation timestamp |
| updated_at | TIMESTAMP | NULLABLE | NULL | Record update timestamp |

**Foreign Keys:**
- `product_id` → `products.id` (ON DELETE CASCADE)

**Relationships:**
- Many-to-One with `products` (product_id)

---

### 8. `defects`
**Description:** Quality control defect reports.

| Column Name | Data Type | Constraints | Default | Description |
|------------|-----------|-------------|---------|-------------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | - | Defect unique identifier |
| product_id | BIGINT UNSIGNED | NOT NULL, FOREIGN KEY | - | Reference to products.id |
| description | TEXT | NOT NULL | - | Defect description |
| proof_image | VARCHAR(500) | NULLABLE | NULL | Path to proof image (max 500 chars) |
| quantity_affected | INTEGER | NOT NULL | - | Number of items affected |
| reported_by | BIGINT UNSIGNED | NOT NULL, FOREIGN KEY | - | Reference to users.id (reporter) |
| status | VARCHAR(255) | NOT NULL | - | Defect status |
| action_taken | TEXT | NULLABLE | NULL | Action taken description |
| reviewed_by | BIGINT UNSIGNED | NULLABLE, FOREIGN KEY | NULL | Reference to users.id (reviewer) |
| created_at | TIMESTAMP | NULLABLE | NULL | Record creation timestamp |
| updated_at | TIMESTAMP | NULLABLE | NULL | Record update timestamp |

**Foreign Keys:**
- `product_id` → `products.id`
- `reported_by` → `users.id`
- `reviewed_by` → `users.id` (ON DELETE SET NULL)

**Relationships:**
- Many-to-One with `products` (product_id)
- Many-to-One with `users` (reported_by)
- Many-to-One with `users` (reviewed_by)

---

## Laravel Framework Tables

### 9. `sessions`
**Description:** Laravel session storage.

| Column Name | Data Type | Constraints | Default | Description |
|------------|-----------|-------------|---------|-------------|
| id | VARCHAR(255) | PRIMARY KEY | - | Session identifier |
| user_id | BIGINT UNSIGNED | NULLABLE, FOREIGN KEY, INDEX | NULL | Reference to users.id |
| ip_address | VARCHAR(45) | NULLABLE | NULL | User IP address |
| user_agent | TEXT | NULLABLE | NULL | User agent string |
| payload | LONGTEXT | NOT NULL | - | Session payload data |
| last_activity | INTEGER | NOT NULL, INDEX | - | Last activity timestamp |

**Foreign Keys:**
- `user_id` → `users.id`

---

### 10. `password_reset_tokens`
**Description:** Password reset tokens for email verification.

| Column Name | Data Type | Constraints | Default | Description |
|------------|-----------|-------------|---------|-------------|
| email | VARCHAR(255) | PRIMARY KEY | - | User email address |
| token | VARCHAR(255) | NOT NULL | - | Password reset token |
| created_at | TIMESTAMP | NULLABLE | NULL | Token creation timestamp |

---

### 11. `cache`
**Description:** Laravel cache storage.

| Column Name | Data Type | Constraints | Default | Description |
|------------|-----------|-------------|---------|-------------|
| key | VARCHAR(255) | PRIMARY KEY | - | Cache key |
| value | MEDIUMTEXT | NOT NULL | - | Cached value |
| expiration | INTEGER | NOT NULL | - | Expiration timestamp |

---

### 12. `cache_locks`
**Description:** Laravel cache locks for distributed locking.

| Column Name | Data Type | Constraints | Default | Description |
|------------|-----------|-------------|---------|-------------|
| key | VARCHAR(255) | PRIMARY KEY | - | Lock key |
| owner | VARCHAR(255) | NOT NULL | - | Lock owner identifier |
| expiration | INTEGER | NOT NULL | - | Lock expiration timestamp |

---

### 13. `jobs`
**Description:** Laravel queue jobs.

| Column Name | Data Type | Constraints | Default | Description |
|------------|-----------|-------------|---------|-------------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | - | Job unique identifier |
| queue | VARCHAR(255) | NOT NULL, INDEX | - | Queue name |
| payload | LONGTEXT | NOT NULL | - | Job payload |
| attempts | TINYINT UNSIGNED | NOT NULL | - | Number of attempts |
| reserved_at | INTEGER UNSIGNED | NULLABLE | NULL | Reservation timestamp |
| available_at | INTEGER UNSIGNED | NOT NULL | - | Available timestamp |
| created_at | INTEGER UNSIGNED | NOT NULL | - | Creation timestamp |

---

### 14. `job_batches`
**Description:** Laravel job batches for batch processing.

| Column Name | Data Type | Constraints | Default | Description |
|------------|-----------|-------------|---------|-------------|
| id | VARCHAR(255) | PRIMARY KEY | - | Batch unique identifier |
| name | VARCHAR(255) | NOT NULL | - | Batch name |
| total_jobs | INTEGER | NOT NULL | - | Total jobs in batch |
| pending_jobs | INTEGER | NOT NULL | - | Pending jobs count |
| failed_jobs | INTEGER | NOT NULL | - | Failed jobs count |
| failed_job_ids | LONGTEXT | NOT NULL | - | Failed job IDs (JSON) |
| options | MEDIUMTEXT | NULLABLE | NULL | Batch options |
| cancelled_at | INTEGER | NULLABLE | NULL | Cancellation timestamp |
| created_at | INTEGER | NOT NULL | - | Creation timestamp |
| finished_at | INTEGER | NULLABLE | NULL | Completion timestamp |

---

### 15. `failed_jobs`
**Description:** Failed queue jobs storage.

| Column Name | Data Type | Constraints | Default | Description |
|------------|-----------|-------------|---------|-------------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | - | Failed job unique identifier |
| uuid | VARCHAR(255) | NOT NULL, UNIQUE | - | Job UUID |
| connection | TEXT | NOT NULL | - | Queue connection name |
| queue | TEXT | NOT NULL | - | Queue name |
| payload | LONGTEXT | NOT NULL | - | Job payload |
| exception | LONGTEXT | NOT NULL | - | Exception details |
| failed_at | TIMESTAMP | NOT NULL | CURRENT_TIMESTAMP | Failure timestamp |

---

## Entity Relationship Diagram (ERD) Summary

### Primary Relationships

```
users
  ├── has many → sessions (user_id)
  ├── has many → defects (reported_by)
  └── has many → defects (reviewed_by)

categories
  └── has many → products (category_id)

products
  ├── belongs to → categories (category_id)
  ├── has many → transactions (product_id)
  ├── has many → inventory (product_id)
  └── has many → defects (product_id)

warehouses
  └── has many → inventory (warehouse_id)

inventory
  ├── belongs to → products (product_id)
  └── belongs to → warehouses (warehouse_id)

transactions
  └── belongs to → products (product_id)

defects
  ├── belongs to → products (product_id)
  ├── belongs to → users (reported_by)
  └── belongs to → users (reviewed_by)

suppliers
  └── (standalone - no relationships defined)
```

---

## Notes

1. **Role Column:** The `users.role` column should be an ENUM type with values 'admin' and 'staff', with no NULL values allowed. Default value is 'staff'.

2. **SKU Column:** The `products.sku` column must be unique and is required for all products.

3. **Quantity Fields:** 
   - `products.quantity` has a default value of 0
   - `inventory.quantity` and `transactions.quantity` are required fields

4. **Warehouse Relationship:** The `inventory.warehouse_id` is nullable, allowing inventory to exist without a specific warehouse assignment.

5. **Defect Reporting:** The `defects.reviewed_by` field is nullable, allowing defects to be reported before review.

6. **Cascade Deletes:** 
   - Products are deleted when their category is deleted
   - Transactions, inventory, and defects are deleted when their associated product is deleted
   - Inventory items are deleted when their warehouse is deleted

---

## Indexes

- `users.email` - UNIQUE index
- `products.sku` - UNIQUE index
- `sessions.user_id` - INDEX
- `sessions.last_activity` - INDEX
- `jobs.queue` - INDEX
- `failed_jobs.uuid` - UNIQUE index

---

**Last Updated:** December 2025  
**Database System:** MySQL  
**Laravel Version:** 12.41.1

