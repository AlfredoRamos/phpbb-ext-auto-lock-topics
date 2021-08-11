### About

Auto-lock Topics extension for phpBB

[![Build Status](https://img.shields.io/github/workflow/status/AlfredoRamos/phpbb-ext-auto-lock-topics/GitHub%20Actions%20CI?style=flat-square)](https://github.com/AlfredoRamos/phpbb-ext-auto-lock-topics/actions)
[![Latest Stable Version](https://img.shields.io/github/tag/AlfredoRamos/phpbb-ext-auto-lock-topics.svg?label=stable&style=flat-square)](https://github.com/AlfredoRamos/phpbb-ext-auto-lock-topics/releases)
[![Code Quality](https://img.shields.io/codacy/grade/1b2cb6aeb1214d80afbc800e31de36a0.svg?style=flat-square)](https://app.codacy.com/manual/AlfredoRamos/phpbb-ext-auto-lock-topics/dashboard)
[![Translation Progress](https://badges.crowdin.net/phpbb-ext-auto-lock-topics/localized.svg)](https://crowdin.com/project/phpbb-ext-auto-lock-topics)
[![License](https://img.shields.io/github/license/AlfredoRamos/phpbb-ext-auto-lock-topics.svg?style=flat-square)](https://raw.githubusercontent.com/AlfredoRamos/phpbb-ext-auto-lock-topics/master/license.txt)

It will automatically lock old topics using phpBB’s cron functionality.

### Features

- Run the auto-lock cron task only in the selected forums
- Enable/disable announcements auto-lock
- Enable/disable polls auto-lock
- Enable/disable stickies auto-lock
- Set the number of days of post inactivity to trigger the auto-lock
- Set the frequency between auto-lock events
- Support for [Move Topics When Locked](https://www.phpbb.com/customise/db/extension/move_topics_when_locked/) extension

### Requirements

- PHP 7.1.3 or greater
- phpBB 3.3 or greater

### Support

- [**Download page**](https://www.phpbb.com/customise/db/extension/auto_lock_topics/)
- [Support area](https://www.phpbb.com/customise/db/extension/auto_lock_topics/support)
- [GitHub issues](https://github.com/AlfredoRamos/phpbb-ext-auto-lock-topics/issues)
- [Crowdin translations](https://crowdin.com/project/phpbb-ext-auto-lock-topics)

### Donate

If you like or found my work useful and want to show some appreciation, you can consider supporting its development by giving a donation.

[![Donate with PayPal](https://alfredoramos.mx/images/paypal.svg)](https://alfredoramos.mx/donate/) | [![Donate with Stripe](https://alfredoramos.mx/images/stripe.svg)](https://alfredoramos.mx/donate/)
:-:|:-:
[![Donate with PayPal](https://alfredoramos.mx/images/donate_paypal.svg)](https://alfredoramos.mx/donate/) | [![Donate with Stripe](https://alfredoramos.mx/images/donate_stripe.svg)](https://alfredoramos.mx/donate/)

### Installation

- Download the [latest release](https://github.com/AlfredoRamos/phpbb-ext-auto-lock-topics/releases)
- Decompress the `*.zip` or `*.tar.gz` file
- Copy the files and directories inside `{PHPBB_ROOT}/ext/alfredoramos/autolocktopics/`
- Go to your `Administration Control Panel` > `Customize` > `Manage extensions`
- Click on `Enable` and confirm

### Preview

[![Forums](https://i.imgur.com/aBjwVBpt.png)](https://i.imgur.com/aBjwVBp.png)
[![Forum settings](https://i.imgur.com/mBCEbSft.png)](https://i.imgur.com/mBCEbSf.png)
[![Topics loked](https://i.imgur.com/uM7dkoGt.png)](https://i.imgur.com/uM7dkoG.png)
[![Admin log](https://i.imgur.com/PIOhYf7t.png)](https://i.imgur.com/PIOhYf7.png)

*(Click to view in full size)*

### Configuration

- Go to your `Administration Control Panel` > `Forums` > `Manage Forums`
- Select a category and then a forum
- Click on the `Edit` button (green gear)
- Scroll down to `Auto-lock settings`
- Edit the settings as you like
- Click on `Submit`

### Uninstallation

- Go to your `Administration Control Panel` > `Customize` > `Manage extensions`
- Click on `Disable` and confirm
- Go back to `Manage extensions` > `Auto-lock Topics` > `Delete data` and confirm

### Upgrade

- Go to your `Administration Control Panel` > `Customize` > `Manage extensions`
- Click on `Disable` and confirm
- Delete all the files inside `{PHPBB_ROOT}/ext/alfredoramos/autolocktopics/`
- Download the new version
- Upload the new files inside `{PHPBB_ROOT}/ext/alfredoramos/autolocktopics/`
- Enable the extension again
