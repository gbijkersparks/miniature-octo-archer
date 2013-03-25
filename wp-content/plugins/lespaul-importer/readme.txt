WebMan's variation of "WordPress Importer" plugin (version 0.6) to import all images of WebMan's theme democontent.
Original plugin URL: http://wordpress.org/extend/plugins/wordpress-importer/

Changes against the original plugin:
	[lespaul-importer.php][line 887]
		Completely disable the 'Remote file is incorrect size' error HTTP request headers doesn't get the correct file size from WebMan's servers (reason unknown (possible connection issues)).