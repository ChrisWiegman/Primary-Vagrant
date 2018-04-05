class { 'apache':
  require => Apt::Ppa['ppa:ondrej/php'],
}

class { 'apache::mod::rewrite': }
class { 'apache::mod::cache': }
class { 'apache::mod::expires': }
class { 'apache::mod::headers': }
class { 'apache::mod::suexec': }
class { 'apache::mod::proxy': }
class { 'apache::mod::proxy_fcgi': }
class { 'apache::mod::ssl': }

apache::vhost { 'dashboard.pv':
  serveraliases => 'pv.io pv',
  docroot       => '/var/www/default-sites/dashboard',
}

apache::vhost { 'phpmyadmin.pv':
  docroot                  => '/var/www/default-sites/phpmyadmin/phpmyadmin',
  directory                => '/var/www/default-sites/phpmyadmin/phpmyadmin',
  directory_allow_override => 'All',
  ssl                      => true,
}

apache::vhost { 'replacedb.pv':
  docroot                  => '/var/www/internal-sites/replacedb',
  directory                => '/var/www/internal-sites/replacedb',
  directory_allow_override => 'All',
  ssl                      => true,
}

apache::vhost { 'core.wordpress.pv':
  docroot                  => '/var/www/default-sites/wordpress/core/wordpress/src',
  directory                => '/var/www/default-sites/wordpress/core/wordpress/src',
  directory_allow_override => 'All',
  ssl                      => true,
}

apache::vhost { 'legacy.wordpress.pv':
  docroot                  => '/var/www/default-sites/wordpress/legacy/htdocs',
  directory                => '/var/www/default-sites/wordpress/legacy/htdocs',
  aliases                  => '/content /var/www/default-sites/wordpress/content',
  directory_allow_override => 'All',
  ssl                      => true,
}

apache::vhost { 'stable.wordpress.pv':
  docroot                  => '/var/www/default-sites/wordpress/stable/htdocs',
  directory                => '/var/www/default-sites/wordpress/stable/htdocs',
  aliases                  => '/content /var/www/default-sites/wordpress/content',
  directory_allow_override => 'All',
  ssl                      => true,
}

apache::vhost { 'trunk.wordpress.pv':
  docroot                  => '/var/www/default-sites/wordpress/trunk/htdocs',
  directory                => '/var/www/default-sites/wordpress/trunk/htdocs',
  aliases                  => '/content /var/www/default-sites/wordpress/content',
  directory_allow_override => 'All',
  ssl                      => true,
}

apache::vhost { 'webgrind.pv':
  docroot                  => '/var/www/internal-sites/webgrind',
  directory                => '/var/www/internal-sites/webgrind',
  directory_allow_override => 'All',
  ssl                      => true,
}