# com.aghstrategies.throttlespam
Creates a settings page "Throttle Spam Settings" and adds it to the Menu (CiviCRM Admin Menu ->Administer ->Throttle Spam Settings).
![settings page](/images/settings.png)

Blocks access to Front End Contribution and Event Registration Pages based on the users IP address and the settings.

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Requirements

* PHP v7.0+
* CiviCRM 5.31

## Installation (Web UI)

This extension has not yet been published for installation via the web UI.

## Installation (CLI, Zip)

Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
cd <extension-dir>
cv dl com.aghstrategies.throttlespam@https://github.com/FIXME/com.aghstrategies.throttlespam/archive/master.zip
```

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/FIXME/com.aghstrategies.throttlespam.git
cv en throttlespam
```
