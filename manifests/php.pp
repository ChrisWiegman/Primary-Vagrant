php::augeas {
	'php-memorylimit':
		entry  => 'PHP/memory_limit',
		value  => '256M',
		require => Class['php'];
}
