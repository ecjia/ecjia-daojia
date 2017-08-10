<?php

return [

	// The default gateway to use
	'default' => 'unionpay',

	// Add in each gateway here
	'gateways' => [
		'paypal' => [
			'driver'  => 'PayPal_Express',
			'options' => [
                'username'  => env( 'OMNIPAY_PAYPAL_EXPRESS_USERNAME', '' ),
                'password'  => env( 'OMNIPAY_PAYPAL_EXPRESS_PASSWORD', '' ),
                'signature' => env( 'OMNIPAY_PAYPAL_EXPRESS_SIGNATURE', '' ),
                'solutionType' => env( 'OMNIPAY_PAYPAL_EXPRESS_SOLUTION_TYPE', '' ),
                'landingPage'    => env( 'OMNIPAY_PAYPAL_EXPRESS_LANDING_PAGE', '' ),
                'headerImageUrl' => env( 'OMNIPAY_PAYPAL_EXPRESS_HEADER_IMAGE_URL', '' ),
                'brandName' =>  'Your app name',
                'testMode' => env( 'OMNIPAY_PAYPAL_TEST_MODE', true )
            ]
		],
	    'unionpay' => [
	        'driver'  => 'UnionPay_Express',
	        'options' => [
	            'merId'     => env( 'OMNIPAY_UNIONPAL_EXPRESS_MERID', '' ),
	            'password'  => env( 'OMNIPAY_UNIONPAL_EXPRESS_PASSWORD', '' ),
	            'certPath'  => env( 'OMNIPAY_UNIONPAL_EXPRESS_CERTPATH', '' ),
	            'certPassword'  => env( 'OMNIPAY_UNIONPAL_EXPRESS_CERTPASSWORD', '' ),
	            'returnUrl'  => env( 'OMNIPAY_UNIONPAL_EXPRESS_RETURNURL', '' ),
	            'notifyUrl'  => env( 'OMNIPAY_UNIONPAL_EXPRESS_NOTIFYURL', '' ),
	            'brandName'  =>  'Your app name',
	            'testMode'   => env( 'OMNIPAY_UNIONPAL_TEST_MODE', true )
            ]
        ]
	]

];