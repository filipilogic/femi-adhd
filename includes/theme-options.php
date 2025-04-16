<?php

if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
		'position' => '2.69',
		'icon_url' => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyNi41LjEsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHZpZXdCb3g9IjAgMCA0OC4yIDQzLjciIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQ4LjIgNDMuNzsiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPHN0eWxlIHR5cGU9InRleHQvY3NzIj4NCgkuc3Qwe2ZpbGw6I0VGOUQ5Qzt9DQoJLnN0MXtmaWxsOiM1ODU5NUI7fQ0KCS5zdDJ7ZmlsbDojOTlEN0Q2O30NCgkuc3Qze2ZpbGw6I0UxRTQzQzt9DQo8L3N0eWxlPg0KPGc+DQoJPGc+DQoJCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0wLDF2MC4yaDBDMCwxLjEsMCwxLDAsMXogTTIuMSwxLjFMMi4xLDEuMUwyLjEsMS4xQzIuMSwxLjEsMi4xLDEuMSwyLjEsMS4xeiIvPg0KCTwvZz4NCgk8cG9seWdvbiBjbGFzcz0ic3QzIiBwb2ludHM9IjQ4LjIsNDQuMSA0My45LDQ0LjEgNDMuOSwyMC43IDI0LjMsMzIuNSAxMS4zLDI1IDExLjIsMTkuOCAyNC4zLDI3LjUgNDguMiwxMyAJIi8+DQoJPHBvbHlnb24gY2xhc3M9InN0MSIgcG9pbnRzPSIwLDQzLjcgNC4zLDQzLjcgNC4zLDcuNiAyMy45LDE5LjUgNDguMSw1LjIgNDguMiwwIDIzLjksMTQuNSAwLDAgCSIvPg0KPC9nPg0KPC9zdmc+DQo='
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Header Settings',
		'menu_title'	=> 'Header',
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Footer Settings',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'theme-general-settings',
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> 'External Scripts',
		'menu_title'	=> 'External Scripts',
		'parent_slug'	=> 'theme-general-settings',
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Miscellaneous Options',
		'menu_title'	=> 'Misc',
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Blog Options',
		'menu_title'	=> 'Blog Options',
		'parent_slug'	=> 'theme-general-settings',
	));
}
