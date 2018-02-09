class { '::php':
  ensure       => latest,
  manage_repos => true,
  phpunit      => true,
  extensions   => {
    mysql        => { },
    imagick      => { },
    gd           => { },
    curl         => { },
    memcache     => { },
    mbstring     => { },
    redis        => { },
    xdebug       => {
      zend            => true,
      settings        => {
        'XDEBUG/xdebug.trace_enable_trigger'      => '1',
        'XDEBUG/xdebug.trace_output_dir'          => '/vagrant/user-data/debug',
        'XDEBUG/xdebug.collect_includes'          => '1',
        'XDEBUG/xdebug.collect_params'            => '1',
        'XDEBUG/xdebug.collect_vars'              => '1',
        'XDEBUG/xdebug.collect_return'            => '1',
        'XDEBUG/xdebug.dump_globals'              => '1',
        'XDEBUG/xdebug.idekey'                    => 'VAGRANT_DEBUG',
        'XDEBUG/xdebug.profiler_enable_trigger'   => '1',
        'XDEBUG/xdebug.profiler_output_name'      => 'cachegrind.out.%t-%s',
        'XDEBUG/xdebug.profiler_output_dir'       => '/vagrant/user-data/debug',
        'XDEBUG/xdebug.remote_enable'             => '1',
        'XDEBUG/xdebug.remote_mode'               => 'req',
        'XDEBUG/xdebug.remote_host'               => '192.168.13.1',
        'XDEBUG/xdebug.remote_log'                => '/vagrant/user-data/debug/xdebug-remote.log',
        'XDEBUG/xdebug.remote_port'               => '9000',
        'XDEBUG/xdebug.var_display_max_children'  => '-1',
        'XDEBUG/xdebug.var_display_max_data'      => '-1',
        'XDEBUG/xdebug.var_display_max_depth'     => '-1',
        'XDEBUG/xdebug.max_nesting_level'         => '256',
      },
    },
  },
  settings     => {
    'PHP/memory_limit'        => '256M',
    'PHP/post_max_size'       => '100M',
    'PHP/upload_max_filesize' => '100M',
    'PHP/max_execution_time'  => '90',
  },
} ->
exec { 'disable_php_mysql':
  command => 'phpdismod mysql',
  require => Class['php'],
} ->
exec { 'php_codesniffer':
  command =>
    'git clone https://github.com/squizlabs/PHP_CodeSniffer.git /var/phpcs && sudo ln -s /var/phpcs/bin/phpcs /usr/bin/phpcs && sudo ln -s /var/phpcs/bin/phpcbf /usr/bin/phpcbf'
  ,
  require => Class['php'],
  creates => '/usr/bin/phpcs',
} ->
exec { 'wp_code_standards':
  command =>
    'git clone https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards.git /var/wpcs && phpcs --config-set installed_paths /var/wpcs'
  ,
  require => Class['php'],
  creates => '/var/wpcs/README.md',
}