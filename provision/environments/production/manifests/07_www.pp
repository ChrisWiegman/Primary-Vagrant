package{ 'postfix':
  ensure => 'installed',
  name   => 'postfix',
  before => [
    File['postfix_config']
  ],
}

file{ 'postfix_config':
  ensure  => 'file',
  path    => '/etc/postfix/main.cf',
  content => template('/vagrant/provision/lib/conf/main.cf.erb'),
}

service{ 'postfix':
  ensure     => 'running',
  enable     => true,
  hasstatus  => true,
  hasrestart => true,
  subscribe  => [
    File['postfix_config']
  ]
}

class { 'mailhog':
  smtp_bind_addr_port => '1025'
}