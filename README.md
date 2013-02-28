aws-sdk-wrapper
===============

Simple framework wrapper for Amazon's AWS SDK for PHP 5

Here is simple example on how to check e-mail verification status using Amazon's Simple Email Service with this wrapper:

<?php
use \Exception;
use \classes\Amazon;

$amazon = new Amazon();
$client = $amazon->get('ses');

try {
  $response = $client->getIdentityVerificationAttributes(
		array(
			'Identities' => array(
				'something@gmail.com'
			)
		)
	);
	
	print_r($response->getAll());
} catch (Exception $e) {
	print $e->getMessage();
}


Read more: http://alekseykorzun.com/post/44203912088/simple-framework-wrapper-for-amazons-aws-sdk-for-php-5

