# com.skvare.mosaicomigration

![Screenshot](/images/screenshot.png)

## Overview

The Mosaico Migration extension is a specialized utility designed to resolve domain and path-related issues that occur when migrating CiviCRM sites that use the Mosaico email template extension. When organizations change domains, move to new hosting environments, or restructure their CiviCRM installation directories, Mosaico templates often break due to hardcoded domain names and file paths stored in the database. This extension provides a safe, automated solution to update these references and restore Mosaico functionality after site migrations.

**Key Features:**
- Domain name replacement in Mosaico templates and mailings
- Extension path updates for relocated CiviCRM installations
- Bulk processing of existing templates and mailings
- Cross-domain AJAX request issue resolution
- Subdomain handling

## The Problem

### What is Mosaico?

Mosaico is a popular CiviCRM extension that provides drag-and-drop email template creation capabilities. It stores email templates with embedded images, styles, and assets that reference specific domain names and file paths. When these references become invalid due to site migration, the templates break and cannot load properly.

### Migration Issues

When you migrate a CiviCRM site with Mosaico installed, several database tables retain references to the old domain and paths:

**Affected Database Tables:**
- **`civicrm_mailing`:** Contains mailing content with embedded domain references
- **`civicrm_mosaico_template`:** Stores template definitions with asset URLs and paths

**Common Migration Scenarios:**
1. **Domain Changes:** Moving from `oldsite.com` to `newsite.com`
2. **Protocol Changes:** Switching from `http://` to `https://`
3. **Subdomain Changes:** Moving from `www.example.com` to `mail.example.com`
4. **Path Changes:** Relocating CiviCRM or extensions to different directories
5. **Development to Production:** Moving from staging to live environments

### Symptoms of Migration Issues

**Template Loading Problems:**
- Mosaico templates fail to load in the editor
- Images and assets appear broken or missing
- AJAX requests fail due to cross-domain restrictions
- Template preview shows broken layouts

**Error Messages:**
- "Cross-Origin Request Blocked" errors in browser console
- "Template not found" errors when editing templates
- Asset loading failures (404 errors for images, CSS files)
- Template corruption or incomplete rendering

## Benefits

- **Quick Migration Recovery:** Rapidly restore Mosaico functionality after site moves
- **Automated Processing:** Bulk update thousands of templates and mailings efficiently
- **Flexible Options:** Handle various migration scenarios (domain, path, protocol changes)
- **Minimal Downtime:** Fast processing minimizes service interruption

## Use Cases

### Domain Migration Scenarios

#### Complete Domain Change
```
Scenario: Company rebrand requiring domain change
Before: https://oldcompany.com/civicrm/
After: https://newcompany.com/civicrm/
Challenge: All Mosaico templates reference oldcompany.com assets
Solution: Use domain replacement feature to update all references
```

#### Protocol Upgrade
```
Scenario: Security upgrade from HTTP to HTTPS
Before: http://example.com/sites/default/files/civicrm/
After: https://example.com/sites/default/files/civicrm/
Challenge: Mixed content warnings and broken secure connections
Solution: Update protocol references in all templates
```

#### Subdomain Restructuring
```
Scenario: Moving CiviCRM to dedicated subdomain
Before: https://www.organization.org/crm/
After: https://crm.organization.org/
Challenge: Cross-subdomain resource loading issues
Solution: Comprehensive domain replacement including subdomain changes
```

### Path Migration Scenarios

#### Extension Directory Relocation
```
Scenario: CiviCRM upgrade changes extension directory structure
Before: sites/default/files/civicrm/ext/uk.co.vedaconsulting.mosaico
After: sites/default/civicrm/extensions/uk.co.vedaconsulting.mosaico
Challenge: Template assets point to old directory structure
Solution: Extension path replacement updates all file references
```

#### Server Infrastructure Changes
```
Scenario: Moving to new hosting provider with different directory structure
Before: /var/www/html/sites/default/files/civicrm/
After: /home/username/public_html/wp-content/civicrm/
Challenge: Absolute paths in templates no longer valid
Solution: Path replacement handles complex directory restructuring
```

### Development and Staging Workflows

#### Staging to Production Migration
```
Scenario: Regular deployment from staging to production environment
Before: https://staging.example.com/civicrm/
After: https://www.example.com/civicrm/
Challenge: Templates developed on staging contain staging URLs
Solution: Automated domain replacement as part of deployment process
```

## Requirements

- **CiviCRM:** 5.0 or higher
- **PHP:** 7.0 or higher (recommended 7.4+)
- **Mosaico Extension:** Must be installed (any version)
- **Administrative Access:** CiviCRM system administrator permissions

## Installation (Web UI)

This extension has not yet been published for installation via the web UI.

## Installation (CLI, Zip)

Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
cd <extension-dir>
cv dl com.skvare.mosaicomigration@https://github.com/Skvare/com.skvare.mosaicomigration/archive/master.zip
```

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/Skvare/com.skvare.mosaicomigration.git
cv en mosaicomigration
```

## Configuration and Usage

### Accessing the Migration Tool

After installation, access the migration interface:

1. **Navigate to Migration Tool:**
  - **Via Menu:** Administer > System Settings > Mosaico Migration
  - **Direct URL:** `/civicrm/mosaicomigration`

2. **Pre-Migration Checklist:**
  - ✅ Create complete database backup
  - ✅ Document current domain and path configurations
  - ✅ Plan for potential rollback if issues occur


### Domain Name Replacement

Use this option when your site's domain name has changed.

#### Configuration Steps

1. **Select Migration Type:**
  - Choose **"Replace Domain Name"** radio button option

2. **Configure Domain Settings:**
  - **Current Value:** Enter your old domain name exactly as it appears in the database
  - **New Value:** Enter your new domain name in the desired format

3. **Domain Format Guidelines:**
   ```
   Include full protocol and domain structure:
   ✅ Correct: https://old.example.com
   ✅ Correct: https://www.oldexample.com
   ✅ Correct: http://staging.company.org

   ❌ Incorrect: old.example.com (missing protocol)
   ❌ Incorrect: www.oldexample.com (missing protocol)
   ```

#### Domain Replacement Examples

**Example 1: Basic Domain Change**
```
Current Value: https://oldcompany.com
New Value: https://newcompany.com
Result: All references to oldcompany.com updated to newcompany.com
```

**Example 2: Protocol and Domain Change**
```
Current Value: http://www.example.org
New Value: https://secure.example.org
Result: Protocol upgraded and subdomain changed simultaneously
```

**Example 3: Development to Production**
```
Current Value: https://dev.myorganization.com
New Value: https://www.myorganization.com
Result: Development URLs replaced with production URLs
```

**Example 4: Port Number Changes**
```
Current Value: https://localhost:8080
New Value: https://production.example.com
Result: Local development URLs replaced with production domain
```

### Extension Path Replacement

Use this option when your CiviCRM or extension directory structure has changed.

#### Configuration Steps

1. **Select Migration Type:**
  - Choose **"Replace Extension Path"** radio button option

2. **Configure Path Settings:**
  - **Current Value:** Enter the old extension path from webroot
  - **New Value:** Enter the new extension path from webroot

3. **Path Format Guidelines:**
   ```
   Use relative paths from webroot (no leading slash):
   ✅ Correct: sites/default/files/civicrm/ext/uk.co.vedaconsulting.mosaico
   ✅ Correct: wp-content/civicrm/extensions/mosaico

   ❌ Incorrect: /sites/default/files/civicrm/ext/uk.co.vedaconsulting.mosaico
   ❌ Incorrect: /var/www/html/sites/default/files/civicrm/ext/mosaico
   ```

#### Path Replacement Examples

**Example 1: Standard Extension Directory Change**
```
Current Value: sites/default/files/civicrm/ext/uk.co.vedaconsulting.mosaico
New Value: sites/default/civicrm/extensions/uk.co.vedaconsulting.mosaico
Result: Extension paths updated to new directory structure
```

**Example 2: CMS Platform Migration**
```
Current Value: sites/default/files/civicrm/ext/mosaico
New Value: wp-content/uploads/civicrm/ext/mosaico
Result: Drupal to WordPress migration path updates
```

**Example 3: Custom Directory Structure**
```
Current Value: public_html/crm/extensions/mosaico
New Value: html/civicrm/ext/mosaico
Result: Custom hosting environment path changes
```

## Database Operations

### Understanding Database Changes

The extension modifies specific database tables to update references:

#### Tables Modified

**`civicrm_mailing` Table:**
- **Columns:** `body_html`, `body_text`, `header`, `footer`
- **Content:** HTML email content with embedded domain references
- **Changes:** URL references in email content updated to new domain/path

**`civicrm_mosaico_template` Table:**
- **Columns:** `base_url`, `html`, `metadata`
- **Content:** Template definitions with asset references
- **Changes:** Template asset URLs and metadata updated


## Support and Contributing

- **Issues:** Report bugs and feature requests on [GitHub Issues](https://github.com/Skvare/com.skvare.mosaicomigration/issues)

## Credits

Developed by [Skvare, LLC](https://skvare.com/contact) for the CiviCRM community.

## About Skvare

Skvare LLC specializes in CiviCRM development, Drupal integration, and providing technology solutions for nonprofit organizations, professional societies, membership-driven associations, and small businesses. We are committed to developing open source software that empowers our clients and the wider CiviCRM community.

**Contact Information**:
- Website: [https://skvare.com](https://skvare.com)
- Email: info@skvare.com
- GitHub: [https://github.com/Skvare](https://github.com/Skvare)

## Support

[Contact us](https://skvare.com/contact) for support or to learn more.

---

## Related Extensions

You might also be interested in other Skvare CiviCRM extensions:

- **Database Custom Field Check**: Prevents adding custom fields when table limits are reached
- **Image Resize**: Automatically resizes contact images for consistent display
- **Registration Button Label**: Customize button labels on event registration pages
- **Unlink User Account**: Safely unlink user accounts from contacts without deleting data

For a complete list of our open source contributions, visit our [GitHub organization page](https://github.com/Skvare).

