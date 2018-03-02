Primary Vagrant
=========

Primary Vagrant is intended for WordPress plugin, theme, and core development, as well as general PHP development in the UF Health environment and can be used as a replacement for local development stacks such as MAMP, XAMPP, and others.

*For more information and full documentation please visit* ***[this project's wiki](https://github.com/ChrisWiegman/Primary-Vagrant/wiki).***

Important
---------

This server configuration is designed for development use only. Please don't put it on a production server as some of these settings would cause serious security issues.

Quickstart
----------

1. Install [VirtualBox](http://virtualbox.org), and the [Oracle VM VirtualBox Extension Pack](https://www.virtualbox.org/wiki/Downloads) for your environment.

2. Install [Vagrant](http://vagrantup.com).

3. Once Vagrant is installed you can install the three optional plugins as discussed on the [Requirements](https://github.com/ChrisWiegman/Primary-Vagrant/wiki/Requirements) page.

    ```vagrant plugin install vagrant-vbguest```

    ```vagrant plugin install vagrant-triggers```

    ```vagrant plugin install landrush```

4. Clone Primary Vagrant (and it's submodules) onto your local machine:

    ```$ git clone --recursive git@github.com:ChrisWiegman/Primary-Vagrant.git Primary\ Vagrant```

5. Change into the new directory with `cd Primary\ Vagrant`

6. Start the Vagrant environment with `vagrant up`
	- Be patient as the magic happens. This could take a while on the first run as your host machine downloads the base box and Primary Vagrant downloads and installs all the software you'll need.
	- Pay attention during execution as an administrator or `su` ***password may be required*** to properly modify the hosts file on your local machine.

7. Navigate to [http://dashboard.pv](http://dashboard.pv) to get started.

Changelog
---------

#### 4.5.3 (2 March 2018)
* Update upstream Puppet Modules
* Upgrade default NodeJS version (9.7.1)

#### 4.5.2 (1 March 2018)
* Update PhpMyAdmin (4.7.8)
* Update upstream Puppet Modules
* Upgrade default NodeJS version (9.7.0)

#### 4.5.1 (26 February 2018)
* Update upstream Puppet Modules
* Upgrade default NodeJS version (9.6.1)

#### 4.5 (9 February 2018)
* Updated PHP to 7.2
* Removed default "destroy" script preventing database updates on destroy

#### 4.4.10 (6 February 2018)
* Update default WordPress version (4.9.4)

#### 4.4.9 (6 February 2018)
* Update default WordPress version (4.9.3)

#### 4.4.8 (1 February 2018)
* Update upstream Puppet Modules
* Upgrade default NodeJS version (9.5.0)

#### 4.4.7 (17 January 2018)
* Update default WordPress versions (4.9.2 and 4.8.5)

#### 4.4.6 (11 January 2018)
* Update upstream Puppet Modules
* Upgrade default NodeJS version (9.4.0)

#### 4.4.5 (8 January 2018)
* Update upstream Puppet Modules

#### 4.4.4 (3 January 2018)
* Update upstream Puppet Modules
* Update default PhpMyAdmin to 4.7.7

#### 4.4.3 (13 December 17)
* Upgrade default NodeJS version (9.3.0)
* Update upstream Puppet Modules

#### 4.4.2 (8 December 17)
* Update default PhpMyAdmin to 4.7.6
* Update upstream Puppet modules

#### 4.4.1 (30 November 17)
* Update default WordPress versions to 4.9.1 and 4.8.4
* Update upstream Puppet modules

#### 4.4 (16 November 17)
* Upgrade default NodeJS version (9.2.0)
* Update upstream Puppet Modules
* Update default WordPress version for 4.9

#### 4.3.12 (1 November 17)
* Upgrade default NodeJS version (9.0.0)
* Update PhpMyAdmin (4.7.5)

#### 4.3.11 (31 October 17)
* Upgrade default NodeJS version (8.8.1)
* Update upstream Puppet Modules
* Updated default WordPress versions (4.7.7 and 4.8.3)

#### 4.3.10 (25 October 17)
* Update upstream Puppet Modules
* Upgrade default NodeJS version (8.8.0)

#### 4.3.9 (28 September 17)
* Update upstream Puppet Modules
* Upgrade default NodeJS version (8.6.0)

#### 4.3.8 (20 September 17)
* Updated default WordPress versions (4.7.6 and 4.8.2)

#### 4.3.7 (18 September 17)
* Update default database charsets to utf8mb4

#### 4.3.6 (17 September 17)
* Upgrade default NodeJS version (8.5.0)
* Update upstream Puppet modules
* Update PhpMyAdmin (4.7.4) 

#### 4.3.5 (18 August 17)
* Upgrade default NodeJS version (8.4.0)
* Update upstream Puppet modules

#### 4.3.4 (11 August 17)
* Upgrade default NodeJS version (8.3.0)
* Update upstream Puppet modules
* Upgrade WordPress Coding Standards and PHP_CodeSniffer to current versions

#### 4.3.3 (04 August 17)
* Switch to https for WordPress.org plugin repositories

#### 4.3.2 (04 August 17)
* Update upstream Puppet modules
* Update WordPress Stable (4.8.1)

#### 4.3.1  (22 July 17)
* Upgrade default NodeJS version (8.2.1)
* Update upstream Puppet modules
* Update PhpMyAdmin (4.7.3)

#### 4.3 (5 July 17)
* Update upstream Puppet modules
* Update PhpMyAdmin
* Switch WordPress repos to git://core.git.wordpress.org/
* Added .sh extension to shell scripts where appropriate
* Renamed "init" folder to the more appropriate "manifests"

#### 4.2.2 (2 July 17)
* Update default NodeJS version (8.1.3)
* Update upstream Puppet modules

#### 4.2.1 (16 June 17)
* Update default NodeJS version (8.1.2)
* Update upstream Puppet modules

#### 4.2 (8 June 17)
* Define JETPACK_DEV_DEBUG for default sites to make it easier to keep plugins and themes under development compatible with Jetpack.
* Update WordPress versions to 4.8 for stable and 4.7.5 for legacy.
* Update PhpMyAdmin to 4.7.1

#### 4.1.3 (31 May 17)
* Updated default NodeJS version (8.0.0)
* Fixed URL for wp-cli download to avoid extra 301 redirects
* Update upstream Puppet modules

#### 4.1.2 (24 May 17)
* Fixed an update caused by a bad quote

#### 4.1.1 (24 May 17)
* Update upstream Puppet modules

#### 4.1 (22 May 17)
* Add WP Inspect plugin to aid in theme and plugin development
* Switch Debug Bar plugin to SVN repo to ensure timely updates
* Fixed bug in site generator due to obsolete file list (credit @Alex-Keyes)
* Fixed bug in Readme for proper link to Wiki (credit @chuckreynolds)

#### 4.0.4 (17 May 17)
* Update WordPress versions to 4.6.6 for Legacy and 4.7.5 for Stable

#### 4.0.3 (14 May 17)
* Update upstream Puppet modules

#### 4.0.2 (10 May 17)
* Downgrade PHPCS to 2.9 for compatibility with WordPress Coding Standards.
* Add Quickstart information
* Upgrade upstream Puppet modules

#### 4.0.1 (8 May 17)
* Fix PHPCS paths
* Fixed issue with mysql module (Credit @crazyjaco)
* Upgrade upstream Puppet modules

#### 4.0 (6 May 17)
* A complete overhaul with new features, better documentation and more. *This WILL require a destroy of an existing environment before upgrading*
