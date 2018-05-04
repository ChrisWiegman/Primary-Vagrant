vcsrepo { '/var/www/default-sites/wordpress/legacy/htdocs/wordpress':
  ensure   => present,
  revision => '4.8.6',
  provider => git,
  source   => 'git://core.git.wordpress.org/',
}

vcsrepo { '/var/www/default-sites/wordpress/stable/htdocs/wordpress':
  ensure   => present,
  revision => '4.9.5',
  provider => git,
  source   => 'git://core.git.wordpress.org/',
}

vcsrepo { '/var/www/default-sites/wordpress/trunk/htdocs/wordpress':
  ensure   => latest,
  provider => git,
  source   => 'git://core.git.wordpress.org/',
}

vcsrepo { '/var/www/default-sites/wordpress/core/wordpress':
  ensure   => latest,
  provider => git,
  source   => 'git://develop.git.wordpress.org/',
}

vcsrepo { '/var/www/default-sites/phpmyadmin/phpmyadmin':
  ensure   => present,
  revision => 'RELEASE_4_8_0_1',
  provider => git,
  source   => 'https://github.com/phpmyadmin/phpmyadmin.git',
} ->
file { '/var/www/default-sites/phpmyadmin/phpmyadmin/config.inc.php':
  ensure => 'link',
  owner  => 'www-data',
  group  => 'vagrant',
  target => '/var/www/default-sites/phpmyadmin/config.inc.php',
} -> exec { 'install_phpmyadmin':
  command     => '/usr/local/bin/composer update',
  environment => ["COMPOSER_HOME=/home/vagrant"],
  cwd         => '/var/www/default-sites/phpmyadmin/phpmyadmin/',
  user        => vagrant,
  group       => vagrant,
  require     => Class['php'],
}

vcsrepo { '/var/www/default-sites/wordpress/content/plugins/any-ipsum':
  ensure   => latest,
  provider => git,
  source   => 'https://github.com/petenelson/wp-any-ipsum.git',
}

vcsrepo { '/var/www/default-sites/wordpress/content/plugins/debug-bar':
  ensure   => latest,
  provider => svn,
  source   => 'https://plugins.svn.wordpress.org/debug-bar/trunk',
}

vcsrepo { '/var/www/default-sites/wordpress/content/plugins/wp-inspect':
  ensure   => latest,
  provider => svn,
  source   => 'https://plugins.svn.wordpress.org/wp-inspect/trunk',
}

vcsrepo { '/var/www/default-sites/wordpress/content/plugins/heartbeat-control':
  ensure   => latest,
  provider => git,
  source   => 'https://github.com/JeffMatson/heartbeat-control.git',
}

vcsrepo { '/var/www/default-sites/wordpress/content/plugins/query-monitor':
  ensure   => latest,
  provider => git,
  source   => 'https://github.com/johnbillion/query-monitor.git',
}

vcsrepo { '/var/www/default-sites/wordpress/content/plugins/whats-running':
  ensure   => latest,
  provider => git,
  source   => 'https://github.com/szepeviktor/whats-running.git',
}

vcsrepo { '/var/www/default-sites/wordpress/content/plugins/debug-bar-remote-requests':
  ensure   => latest,
  provider => git,
  source   => 'https://github.com/alleyinteractive/debug-bar-remote-requests.git',
}

vcsrepo { '/var/www/internal-sites/webgrind':
  ensure   => latest,
  provider => git,
  source   => 'https://github.com/jokkedk/webgrind.git',
}

vcsrepo { '/var/www/internal-sites/replacedb':
  ensure   => latest,
  provider => git,
  source   => 'https://github.com/interconnectit/Search-Replace-DB.git',
}

vcsrepo { '/var/www/default-sites/wordpress/content/wp-test':
  ensure   => latest,
  provider => git,
  source   => 'https://github.com/manovotny/wptest.git',
}
