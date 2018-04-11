class { 'mysql::server':
  root_password           => 'password',
  remove_default_accounts => true,
  override_options        => {
    mysqld => {
      'sql_mode' => 'NO_ENGINE_SUBSTITUTION',
    }
  }
}

mysql_database { 'stable.wordpress.pv':
  ensure  => 'present',
  charset => 'utf8mb4',
  collate => 'utf8mb4_general_ci',
  require => Class['mysql::server'],
}

mysql_database { 'legacy.wordpress.pv':
  ensure  => 'present',
  charset => 'utf8mb4',
  collate => 'utf8mb4_general_ci',
  require => Class['mysql::server'],
}

mysql_database { 'trunk.wordpress.pv':
  ensure  => 'present',
  charset => 'utf8mb4',
  collate => 'utf8mb4_general_ci',
  require => Class['mysql::server'],
}

mysql_database { 'core.wordpress.pv':
  ensure  => 'present',
  charset => 'utf8mb4',
  collate => 'utf8mb4_general_ci',
  require => Class['mysql::server'],
}

mysql_database { 'tests.core.wordpress.pv':
  ensure  => 'present',
  charset => 'utf8mb4',
  collate => 'utf8mb4_general_ci',
  require => Class['mysql::server'],
}

mysql_user { 'username@localhost':
  ensure        => 'present',
  require       => Class['mysql::server'],
  password_hash => mysql_password(password),
}

mysql_grant { 'username@localhost/*.*':
  ensure     => 'present',
  options    => ['GRANT'],
  privileges => ['ALL'],
  table      => '*.*',
  user       => 'username@localhost',
  require    => Class['mysql::server'],
}

mysql_user { 'backup@localhost':
  ensure        => 'present',
  require       => Class['mysql::server']
}

mysql_grant { 'backup@localhost/*.*':
  ensure     => 'present',
  options    => ['GRANT'],
  privileges => ['SELECT, LOCK TABLES, SHOW VIEW, EVENT, TRIGGER'],
  table      => '*.*',
  user       => 'backup@localhost',
  require    => Class['mysql::server'],
}
