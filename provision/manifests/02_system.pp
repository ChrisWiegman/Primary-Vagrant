class { 'apt': }

package { 'vim':
  ensure => 'installed'
}

package { 'subversion':
  ensure => 'installed'
}

package { 'ntp':
  ensure => 'installed'
}

package { 'memcached':
  ensure => 'installed'
}

package { 'redis-server':
  ensure => 'installed'
}

package { 'python' :
  ensure => 'installed'
}

package { 'graphviz' :
  ensure => 'installed'
}

class { 'ohmyzsh': }

ohmyzsh::install { 'vagrant': }

class { 'nvm':
  user         => 'vagrant',
  install_node => '10.0.0',
}

file { '.zshrc':
  path    => '/home/vagrant/.zshrc',
  ensure  => file,
  owner   => 'vagrant',
  group   => 'vagrant',
  source  => '/vagrant/provision/lib/conf/.zshrc',
}
