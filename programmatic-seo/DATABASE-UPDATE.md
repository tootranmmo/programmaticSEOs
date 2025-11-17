# 🔧 Database Schema Update Required

## ⚠️ If you see error: "Unknown column 'description'"

This means your database was created with an older version. Follow these steps:

### Option 1: Deactivate & Reactivate (Recommended - Safe)

1. Go to **Plugins** in WordPress Admin
2. Find **Programmatic SEO**
3. Click **Deactivate**
4. Click **Activate** again
5. ✅ Database will be automatically updated

**Note:** This is SAFE - your data will NOT be deleted!

---

### Option 2: Manual Database Update (Advanced)

If you prefer SQL, run this in phpMyAdmin or wp-cli:

```sql
-- Check your table prefix (default is wp_)
-- Replace wp_ with your actual prefix

-- Add missing columns
ALTER TABLE wp_pseo_templates
ADD COLUMN IF NOT EXISTS description text AFTER name;

ALTER TABLE wp_pseo_templates
ADD COLUMN IF NOT EXISTS updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER created_at;

ALTER TABLE wp_pseo_templates
ADD COLUMN IF NOT EXISTS slug_pattern varchar(255) AFTER meta_description_template;

ALTER TABLE wp_pseo_templates
ADD COLUMN IF NOT EXISTS variables text AFTER status;

-- Add indexes
ALTER TABLE wp_pseo_templates ADD INDEX IF NOT EXISTS name (name);
ALTER TABLE wp_pseo_templates ADD INDEX IF NOT EXISTS status (status);
```

---

### Option 3: Fresh Install (Nuclear Option)

**⚠️ WARNING: This will DELETE all templates and data!**

Only use if:
- You have no important data
- Other methods failed
- You want a clean slate

Steps:
1. Go to **Plugins** → **Deactivate** Programmatic SEO
2. Click **Delete**
3. Reinstall the plugin
4. Activate

---

## What Changed?

### New Database Schema (v1.0.1+)

**Added columns:**
- `description` - Template description text
- `updated_at` - Timestamp for last update
- `slug_pattern` - URL slug pattern with variables
- `variables` - Comma-separated list of variables

**Added indexes:**
- Index on `name` for faster searches
- Index on `status` for filtering

### Why This Matters

The new columns enable:
- ✨ Template descriptions for better organization
- ✨ Slug patterns like `{{city}}-{{service}}`
- ✨ Auto-variable extraction
- ✨ Better performance with indexes

---

## Verify It Worked

After reactivating, check debug.log:

```
tail -f /path/to/wp-content/debug.log
```

You should see:
```
PSEO: Added description column to templates table
PSEO: Added updated_at column to templates table
PSEO: Added slug_pattern column to templates table
PSEO: Added variables column to templates table
```

---

## Still Having Issues?

1. **Check PHP error log** - May show SQL errors
2. **Check database permissions** - User needs ALTER TABLE permission
3. **Contact support** - Create issue on GitHub with error details

---

## Technical Details

The migration runs automatically in `class-pseo-activator.php`:

```php
private static function migrate_database() {
    // Checks existing columns
    // Adds missing ones with ALTER TABLE
    // Logs all changes
}
```

It's safe to run multiple times - it only adds missing columns.

---

Made with ❤️ in Vietnam 🇻🇳
