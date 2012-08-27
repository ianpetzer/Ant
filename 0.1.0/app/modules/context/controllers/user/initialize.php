<?php

	/*
	* 	Initialize the user
	* 	based on the session/cookie
	* 
	* 	@since 0.1.0
	*/

	namespace Ant\Controller\User;

	use \Ant\Application as App;
	use \Ant\User as User;
	use \Ant\Cookie as Cookie;
	use \Ant\Controller as Control;
	
	function initialize( $arguments ) {
		
		// Check if the user exists in browser cookie or session //
		switch ( App :: getClient() ) {
			case 'web' :
				// User is in cookie if they opted for "remember me" //
				if ( $cookie = Cookie :: get('Ant.User') ) {
					
					$user = Control :: call('User.getUserFromSecret', array(
						'secret' => $cookie['user_secret']
					));
					
					if ( $user ) {
						Control :: call( 'User.setCurrentUser', array(
							'user' => $user
						));
					} else {
						// That cookie is invalid, delete it //
						Cookie :: delete('Ant.User');
					}
				}
				break;
		}
		
		// Try get the current user or return a blank user //
		return Control :: call('User.getCurrentUser');
	}