exec { "wp-cli-/usr/bin":
  command => "wget https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar -O /usr/bin/wp && chmod +x /usr/bin/wp",
  path    => ['/usr/bin' , '/bin'],
  creates => "/usr/bin/wp",
}