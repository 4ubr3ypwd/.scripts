<?php

/**
 * Apache
 */

$eg = "sudo php {$argv[0]} add|rm example.dev [custom xampp file location; optional]"; // Example how to use.

// Vars
$action = ( ( $argv[1] != 'rm' && $argv[1] != 'add' ) || ! isset( $argv[1] ) ) ? false : $argv[1];
$domain = isset( $argv[2] ) ? $argv[2] : false;
$custom_vhost_file = isset( $argv[3] ) ? $argv[3] : false;

// Requirements
if ( ! $action ) {
	die( "You are using this wrong, first parameter should be add|rm. E.g.: $eg" );
}

if ( ! stristr( $domain, '.dev' ) ) {
	die( "Please add a .dev domain." );
}

ob_start();

?>

# <?php echo "$domain\n"; ?>
<VirtualHost *:80>
	ServerName <?php echo $domain; ?>

	ServerAlias <?php echo $domain; ?>.*.xip.io

	DocumentRoot "/Applications/XAMPP/xamppfiles/htdocs/<?php echo $domain; ?>"

	<Directory "/Applications/XAMPP/xamppfiles/htdocs/<?php echo $domain; ?>">
		Options Indexes FollowSymLinks Includes ExecCGI
		AllowOverride All
		Require all granted
	</Directory>

	ErrorLog "logs/<?php echo $domain; ?>-error_log.log"
</VirtualHost>

<?php

$vhost_text = ob_get_contents(); // vhost to add
$vhosts_file = $custom_vhost_file ? $custom_vhost_file : "/Applications/XAMPP/xamppfiles/etc/extra/httpd-vhosts.conf";  // XAMPP vhost file
$vhosts_file_contents = file_get_contents( $vhosts_file ); // get vhosts file contents

if ( 'rm' == $action ) {
	$vhosts_file_contents = str_replace( $vhost_text, '', $vhosts_file_contents );
}

if ( 'add' == $action ) {
	if ( stristr( $vhosts_file_contents, $vhost_text ) ) {
		die( "That domain is already there." );
	}

	$vhosts_file_contents .= $vhost_text;
}

file_put_contents( $vhosts_file, $vhosts_file_contents );

shell_exec( "sudo xampp restart" );

/**
 * hosts File
 */
$hosts_file = "/etc/hosts";
$hosts_file_contents = file_get_contents( $hosts_file );
$host_line = "\n127.0.0.1 $domain";

if ( 'add' == $action ) {
	$hosts_file_contents .= $host_line;
}

if ( 'rm' == $action ) {
	$hosts_file_contents = str_replace( $host_line, '', $vhosts_file_contents );
}

file_put_contents( $hosts_file, $hosts_file_contents );
