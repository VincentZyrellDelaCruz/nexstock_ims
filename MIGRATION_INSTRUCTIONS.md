# Migration Instructions

## Issue
The error occurs because the new database tables haven't been created yet. The migrations exist but need to be run.

## Solution: Run Migrations

### Step 1: Check Migration Status
First, check which migrations have been run:
```bash
php artisan migrate:status
```

### Step 2: Run All Pending Migrations
Run all pending migrations to create the new tables:
```bash
php artisan migrate
```

This will create the following tables:
- `restock_confirmations`
- `pendings`
- `warehouses` (if not exists)
- `defects` (if not exists)
- `alerts`

### Step 3: Verify Tables Created
You can verify the tables were created by checking your database or running:
```bash
php artisan db:show
```

## New Migrations Created

1. **2025_12_04_000001_create_restock_confirmations_table.php**
   - Creates restock_confirmations table

2. **2025_12_04_000002_create_pendings_table.php**
   - Creates pendings table (this is the one causing the error)

3. **2025_12_04_000003_create_warehouses_table.php**
   - Creates warehouses table

4. **2025_12_04_000004_create_defects_table.php**
   - Creates defects table (if not already exists)

5. **2025_12_04_000005_create_alerts_table.php**
   - Creates alerts table

## Temporary Fix Applied

I've updated `DashboardController.php` to check if the `pendings` table exists before querying it. This prevents the error even if migrations haven't been run yet.

However, **you still need to run the migrations** to use all the new features.

## After Running Migrations

Once migrations are complete, the dashboard will show:
- Pending messages count
- All new features will be functional

## If You Encounter Issues

If you get foreign key constraint errors, you may need to:
1. Check if `warehouses` table exists first
2. Check if `users` table exists
3. Run migrations in order

You can also run migrations with force if needed:
```bash
php artisan migrate --force
```

