# com.skvare.mosaicomigration

![Screenshot](/images/screenshot.png)

This Extension is usefull when your site have mosaico extensino installed and you have either migrated your site to new domain name or extension directory path is changed.

CiviCRM `civicrm_mailing` and `civicrm_mosaico_template` table hold old domain name and extension directory path.

If you migrated to new domain name without changing domain name and path in above 2 tables then mosaico template won't load due to AJAX request on old domain (Cross Domain request).

To avoid such issue, you can replace domain and path as per your requirement.

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Requirements

* PHP v7.0+
* CiviCRM 5.0

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

## Usage
Install Extension and visit the url `civicrm/mosaicomigration`, you can access this url  under `Administer >> System Settings`.

Example for Domain Replacement:

* Choose 'Replace Domain Name' Radio button Option
* Current Value : Put your old domain name, (enter domain name with http,www; how your domain were loaded previously in browser, e.g. : `https://old.example.com` or `https:://www.oldexample.com`)
* New Value : Put your New domain name (e.g. `https://new.example.com` or `https:://www.newexample.com`)
* Click on Submit Button

Example for Extension Path Replacement:

In case you have changed Extension directory path, we need to update path in above 2 tables.
* Choose 'Replace Extension Path' Radio button Option
* Current Value : Put your old extension path from webroot, (e.g `sites/default/files/civicrm/ext/uk.co.vedaconsulting.mosaico`)
* New Value : Put your New extension path from webroot, (e.g. `sites/default/civicrm/extension/uk.co.vedaconsulting.mosaico`)
* Click on Submit Button
