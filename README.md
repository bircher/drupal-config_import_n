# Config Import N

## Introduction

Drupal core has a `hook_update_N()` mechanism with which developers can fix the
database. But often we also want to abuse it to deploy other changes.
This can lead to the situation that we would like to import the configuration
before running the update hooks. But this is a very bad idea and will not be
possible in the future.

This module introduces two new hooks which should be intuitive to use: 
`hook_pre_config_import_NAME` and `hook_pre_config_import_NAME`.

The functions are defined in a file called `<module>.pre_config_import.php` and
`<module>.post_config_import.php` respectively, analogous to `post_update`
hooks. In fact this module uses cores classes to detect and load the functions.

Each function will be run once before or after the configuration import.
A 

