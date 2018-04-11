group { 'puppet': ensure => present }

Exec { path => [ '/bin/', '/sbin/', '/usr/bin/', '/usr/sbin/', '/vagrant/provision/bin/' ] }
File { owner => 0, group => 0, mode => 0644 }
