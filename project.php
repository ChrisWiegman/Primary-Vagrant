#!/usr/bin/env php
<?php
/**
 * Generate site configurations easily from the command line.
 *
 * @version 0.0.1
 * @author  Chris Wiegman <info@chriswiegman.com>
 */

$operations = array(
	// command operations.
	'site-list::', // List existing sites.
	'create-site::', // Use to create a site.
	'delete-site::', // Use to delete a site.
	'create-plugin::', // Create a plugin project
	'create-theme::', // Create a theme project
	'delete-plugin::', // Delete a plugin project
	'delete-theme::', // Delete a theme project.
);

$args = array(
	// Project to work on.
	'name::', // Primary project name for sites.

	// Options for all projects.
	'root::', // The root directory to map.
	'deletefiles::', // Set to perform deletion of all files when removing a project.

	// Virtualhost options.
	'domain::', // The primary domain name for the site.
	'database::', // Override database name.
	'alias::', // Server alias(es).
	'apacheroot::', // The apache docroot.
	'nodatabase::', // Set to prevent creation of a database.

	// Vagrant options.
	'noprovision::', // Set the flag to prevent a reload/provision.
);

$options = getopt( '', array_merge( $args, $operations ) );

// Make sure the user provided a valid operation.
$valid_operation = false;

foreach ( $operations as $operation ) {

	if ( array_key_exists( str_replace( '::', '', $operation ), $options ) ) {
		$valid_operation = true;
	}
}

if ( false === $valid_operation ) {

	fwrite( STDERR, 'You must specify a valid operation. View README.md for more information on using the project generator.' . PHP_EOL );
	exit( 1 );

}

// Execute list functions.
if ( isset( $options['list'] ) ) {

	echo 'Site list is still in progress. Please check back soon.' . PHP_EOL;
	exit();

}

// Make sure we have a project name.
while ( ! isset( $options['name'] ) || empty( trim( $options['name'] ) ) ) {

	echo 'Enter a project name for the site:';

	$handle = fopen( 'php://stdin', 'r' );

	$options['name'] = sanitize_file_name( trim( fgets( $handle ) ) );

	fclose( $handle );

}

$options['name'] = sanitize_file_name( $options['name'] ); // Make sure the name is sanitized even if we didn't override.

// Setup the site folder information.
$options['site_folder'] = dirname( __FILE__ ) . '/user-data/sites/' . $options['name'];

// A flag to prevent wasting time provisioning if it isn't needed.
$needs_provision = false;

// Setup variables common to both site creation and site deletion.
if ( isset( $options['create-site'] ) || isset( $options['delete-site'] ) ) {

	// Make sure we have a domain name.
	if ( ! isset( $options['domain'] ) ) {
		$options['domain'] = $options['name'];
	}

	// Get the vhost file and make sure it hasn't already been created.
	$vhost_file = dirname( __FILE__ ) . '/user-data/vhosts/' . $options['name'] . '.pp';

}

// Execute create-site functions.
if ( isset( $options['create-site'] ) ) {

	// Create the directory and verify the vhost file doesn't already exists or die if it already exists.
	if ( ! is_dir( $options['site_folder'] ) && ! file_exists( $vhost_file ) ) {

		mkdir( $options['site_folder'] );

	} elseif ( file_exists( $vhost_file ) || file_exists( $options['site_folder'] . '/pv-hosts' ) || file_exists( $options['site_folder'] . '/pv-mappings' ) ) {

		// Throw an error if any of the Primary Vagrant site files already exist.
		fwrite( STDERR, 'A site with this domain already seems to exist. Please use a different site name or delete the existing site first.' . PHP_EOL );
		exit( 1 );

	}

	echo 'Site folder created.' . PHP_EOL;

	// Make sure we have a valid site root.
	if ( ! isset( $options['root'] ) ) {

		$options['root'] = $options['site_folder'];

	} elseif ( ! is_dir( $options['root'] ) ) { // Throw an error if the root directory isn't already a valid directory.

		fwrite( STDERR, 'The project root directory specified is not valid. Please specify a valid directory as "root"' . PHP_EOL );
		exit( 1 );

	}

	// Make sure we have a valid apache doc root.
	if ( ! isset( $options['apacheroot'] ) ) {

		$options['apacheroot'] = '';

	}

	$options['apacheroot'] = sanitize_file_name( $options['apacheroot'] );

	$apache_path = $options['site_folder'] . '/' . $options['apacheroot'];

	// Create the apache root directory if it is different than the site root.
	if ( ! is_dir( $apache_path ) ) {

		mkdir( $apache_path );
		echo 'Apache docroot folder created.' . PHP_EOL;

	}

	// Create a list of the domain and any aliases.
	$domains = $options['domain'] . PHP_EOL;
	$aliases = ''; // A space delimited string of aliases only for use in the VHost configuration.

	if ( isset( $options['alias'] ) ) {

		if ( is_array( $options['alias'] ) ) {

			foreach ( $options['alias'] as $alias ) {

				$domains .= sanitize_file_name( $alias ) . PHP_EOL;
				$aliases .= sanitize_file_name( $alias ) . ' ';

			}

			$aliases = substr( $aliases, 0, strlen( $aliases ) - 1 ); // Remove the last space.

		} else {

			$domains .= sanitize_file_name( $options['alias'] ) . PHP_EOL;
			$aliases = sanitize_file_name( $options['alias'] );

		}
	}

	$domains = substr( $domains, 0, strlen( $domains ) - 1 ); // Remove the last newline.

	// Create and write the pv-hosts file.
	$handle = fopen( $options['site_folder'] . '/pv-hosts', 'x+' );
	fwrite( $handle, $domains );
	fclose( $handle );

	echo 'Hosts file created.' . PHP_EOL;

	// Write the mapping file.
	$mapping = 'config.vm.synced_folder "' . $options['root'] . '", "/var/www/' . $options['name'] . '", :owner => "www-data", :mount_options => [ "dmode=775", "fmode=774"]';

	$handle = fopen( $options['site_folder'] . '/pv-mappings', 'x+' );
	fwrite( $handle, $mapping );
	fclose( $handle );

	echo 'Mappings file created.' . PHP_EOL;

	// Create the vhost config.
	$vhost_config = '# Site Created with Primary Vagrant Site Generator.' . PHP_EOL . PHP_EOL; // Header for easier usage later.

	$vhost_config .= "apache::vhost { '" . $options['domain'] . "':" . PHP_EOL;

	if ( ! empty( $aliases ) ) {
		$vhost_config .= "  serveraliases                   => '" . $aliases . "'," . PHP_EOL;
	}

	// @todo set more of these items as options.
	$vhost_config .= "  docroot                         => '/var/www/" . $options['name'] . "/" . $options['apacheroot'] . "'," . PHP_EOL;
	$vhost_config .= "  directory                       => '/var/www/" . $options['name'] . "/" . $options['apacheroot'] . "'," . PHP_EOL;
	$vhost_config .= "  directory_allow_override        => 'All'," . PHP_EOL;
	$vhost_config .= "  ssl                             => true," . PHP_EOL;
	$vhost_config .= "}" . PHP_EOL;

	// Only add database information if we need to.
	if ( ! isset( $options['nodatabase'] ) ) {

		$database_name = $options['name'];

		// Respect and override set for the database name.
		if ( isset( $options['database'] ) ) {
			$database_name = sanitize_file_name( $options['database'] );
		}

		// @todo set more of these items as options.
		$vhost_config .= PHP_EOL;
		$vhost_config .= "mysql_database { '" . $database_name . "':" . PHP_EOL;
		$vhost_config .= "  ensure  => 'present'," . PHP_EOL;
		$vhost_config .= "  charset => 'utf8mb4'," . PHP_EOL;
		$vhost_config .= "  collate => 'utf8mb4_general_ci'," . PHP_EOL;
		$vhost_config .= "  require => Class['mysql::server']," . PHP_EOL;
		$vhost_config .= "}" . PHP_EOL;
	}

	// Write the virtualhost file.
	$handle = fopen( $vhost_file, 'x+' );
	fwrite( $handle, $vhost_config );
	fclose( $handle );

	echo 'Virtualhost configuration created.' . PHP_EOL;

	$needs_provision = true;

}

// Execute delete-site functions.
if ( isset( $options['delete-site'] ) ) {

	// Delete the site configuration.
	if ( file_exists( $vhost_file ) ) {

		unlink( $vhost_file );
		$needs_provision = true;
		echo 'Deleted ' . $vhost_file . PHP_EOL;

	} else {

		echo 'The virtualhost configuration has already been deleted. No action taken.' . PHP_EOL;

	}

	if ( isset( $options['deletefiles'] ) ) { // Remove entire site folder.

		if ( is_dir( $options['site_folder'] ) ) {

			delete_directory( $options['site_folder'] );
			$needs_provision = true;
			echo 'Deleted site folder.' . PHP_EOL;

		} else {

			echo 'The site folder has already been deleted. No action taken.' . PHP_EOL;

		}

	} else { // Only remove Primary Vagrant files.

		// Delete pv-hosts if it exists.
		if ( file_exists( $options['site_folder'] . '/pv-hosts' ) ) {

			unlink( $options['site_folder'] . '/pv-hosts' );
			$needs_provision = true;
			echo 'Deleted ' . $options['site_folder'] . '/pv-hosts' . PHP_EOL;

		} else {

			echo 'The pv-hosts file has already been deleted. No action taken.' . PHP_EOL;

		}

		// Delete pv-mappings if it exists.
		if ( file_exists( $options['site_folder'] . '/pv-mappings' ) ) {

			unlink( $options['site_folder'] . '/pv-mappings' );
			$needs_provision = true;
			echo 'Deleted ' . $options['site_folder'] . '/pv-mappings' . PHP_EOL;

		} else {

			echo 'The pv-mappings file has already been deleted. No action taken.' . PHP_EOL;

		}
	}
}

// Create a plugin or theme project
if ( isset( $options['create-plugin'] ) || isset( $options['create-theme'] ) ) {

	$needs_provision = true;

	// Create the directory or die if it already exists.
	if ( ! is_dir( $options['site_folder'] ) ) {

		mkdir( $options['site_folder'] );

	} elseif ( file_exists( $options['site_folder'] . '/pv-mappings' ) ) {

		// Throw an error if any of the Primary Vagrant site files already exist.
		fwrite( STDERR, 'A project with this name already seems to exist. Please use a different project name or delete the existing project first.' . PHP_EOL );
		exit( 1 );

	}

	echo 'Project folder created.' . PHP_EOL;

	// Make sure we have a valid plugin root.
	if ( ! isset( $options['root'] ) ) {

		$options['root'] = $options['site_folder'];

	} elseif ( ! is_dir( $options['root'] ) ) { // Throw an error if the root directory isn't already a valid directory.

		fwrite( STDERR, 'The project root directory specified is not valid. Please specify a valid directory as "root"' . PHP_EOL );
		exit( 1 );

	}

	// Set the appropriate destination directory for a plugin or theme.
	$type_dir = 'plugins';

	if ( isset( $options['create-theme'] ) ) {
		$type_dir = 'themes';
	}

	// Write the mapping file.
	$mapping = 'config.vm.synced_folder "' . $options['root'] . '", "/var/www/default-sites/wordpress/content/' . $type_dir . '/' . $options['name'] . '", :owner => "www-data", :mount_options => [ "dmode=775", "fmode=774"]';

	$handle = fopen( $options['site_folder'] . '/pv-mappings', 'x+' );
	fwrite( $handle, $mapping );
	fclose( $handle );

	echo 'Mappings file created.' . PHP_EOL;

}

// Delete a plugin or theme project
if ( isset( $options['delete-plugin'] ) || isset( $options['delete-theme'] ) ) {

	if ( isset( $options['deletefiles'] ) ) { // Remove entire site folder.

		if ( is_dir( $options['site_folder'] ) ) {

			delete_directory( $options['site_folder'] );
			$needs_provision = true;
			echo 'Deleted project folder.' . PHP_EOL;

		} else {

			echo 'The project folder has already been deleted. No action taken.' . PHP_EOL;

		}

	} else { // Only remove Primary Vagrant files.

		// Delete pv-mappings if it exists.
		if ( file_exists( $options['site_folder'] . '/pv-mappings' ) ) {

			unlink( $options['site_folder'] . '/pv-mappings' );
			$needs_provision = true;
			echo 'Deleted ' . $options['site_folder'] . '/pv-mappings' . PHP_EOL;

		} else {

			echo 'The pv-mappings file has already been deleted. No action taken.' . PHP_EOL;

		}
	}
}

// Reload and provision vagrant if needed.
if ( ! isset( $options['noprovision'] ) && true === $needs_provision ) {

	echo 'Reloading Vagrant for changes to take effect.' . PHP_EOL;
	passthru( 'vagrant reload --provision' );

} elseif ( ! isset( $options['noprovision'] ) ) {

	echo 'Provisioning of Vagrant is not required.' . PHP_EOL;

}

exit();

/**
 * Removes a directory recursively.
 *
 * @since 0.0.1
 *
 * @param string $directory The name of the directory to remove.
 *
 * @return bool True on success or false.
 */
function delete_directory( $directory ) {

	$files = array_diff( scandir( $directory ), array( '.', '..' ) );

	foreach ( $files as $file ) {
		( is_dir( $directory . '/' . $file ) ) ? delete_directory( $directory . '/' . $file ) : unlink( $directory . '/' . $file );
	}

	return rmdir( $directory );

}

/**
 * Sanitize the file and folder names submitted.
 *
 * @since 0.0.1
 *
 * @param string $file_name The file/folder name to sanitize.
 *
 * @return string A sanitized file/folder name.
 */
function sanitize_file_name( $file_name ) {

	// Replace all weird characters with dashes
	$file_name = preg_replace( '/[^\w\-\.]+/u', '-', $file_name );

	// Only allow one dash separator at a time (and make string lowercase)
	return mb_strtolower( preg_replace( '/--+/u', '-', $file_name ), 'UTF-8' );

}
