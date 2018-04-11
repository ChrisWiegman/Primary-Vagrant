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

package { 'python':
	ensure => 'installed'
}

package { 'graphviz':
	ensure => 'installed'
}

class { 'ohmyzsh': }

ohmyzsh::install { 'vagrant': }

file { '.zshrc':
	path   => '/home/vagrant/.zshrc',
	ensure => file,
	mode   => '0644',
	owner  => 'vagrant',
	group  => 'vagrant',
	source => '/vagrant/provision/lib/conf/.zshrc',
}
