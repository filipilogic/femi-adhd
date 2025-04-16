<?php
// This is just repurposed Hello Dolly plugin
function ilogic_facts() {

	$facts = "Developer of this awesome theme is <a href='https://zeljkoskipic.dev/'>Zeljko Skipic</a>
WordPress was downloaded more than <strong>100 Milion Times</strong>
Google-hosted Fonts violates the GDPR <a href='https://make.wordpress.org/themes/2022/06/18/complying-with-gdpr-when-using-google-fonts/'>Read More</a>
Develop future-proof websites and shorten the QA time with <a href='https://defensivecss.dev/tips'>Defensive CSS</a>
WordPress is used by 43.2% of all websites on the internet";

	// Here we split it into lines.
	$facts = explode( "\n", $facts );

	// And then randomly choose a line.
	return wptexturize( $facts[ mt_rand( 0, count( $facts ) - 1 ) ] );
}

// This just echoes the chosen line, we'll position it later.
function facts_generator() {
	$chosen = ilogic_facts();
	$lang   = '';
	if ( 'en_' !== substr( get_user_locale(), 0, 3 ) ) {
		$lang = ' lang="en"';
	}
	printf(
		'<p id="facts"><span class="screen-reader-text">%s </span><span dir="ltr"%s>%s</span></p>',
		__( 'Fun fact generator', 'ilogic' ),
		$lang,
		$chosen
	);
}

// Now we set that function up to execute when the admin_notices action is called.
add_action( 'admin_notices', 'facts_generator' );
