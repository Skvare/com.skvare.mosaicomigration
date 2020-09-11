# com.skvare.mosaicomigration

![Screenshot](/images/screenshot.png)

This Extension is usefull when you have mosaico extensino installed and you either migrated site to new domain name or extension directory path is changed.

CiviCRM `civicrm_mailing` and `civicrm_mosaico_template` table hold old domain name and extension directory path.

If you migrated to new domain name without changing domain name and path then mosaico template won't load.

To avoid such issue, you can replace new domain and path as per your requirement.

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
