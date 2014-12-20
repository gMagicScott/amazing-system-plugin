<?php
/**
* Updgrade Routine
*/
// delete_option( 'amsys_settings' );
if ( ! get_option( 'amsys_settings', false ) ) {
	add_option( 'amsys_settings', array(
		'_version' => '0.5.0-rc.1',
		'basic_merge_shortcode' => get_option( 'amazing_system_shortcode', 'as' ),
		'1shop_fields' => array(
			'default-1' => array(
				'shortname' => 'Name',
				'mergetag' => '%$Name$%',
				'description' => __('Client&apos;s full name')
				),
			'default-2' => array(
				'shortname' => 'Email1',
				'mergetag' => '%$Email1$%',
				'description' => __('Client&apos;s email address')
				),
			'default-3' => array(
				'shortname' => 'Company',
				'mergetag' => '%$Company$%',
				'description' => __('Company the client works for')
				),
			'default-4' => array(
				'shortname' => 'Workphone',
				'mergetag' => '%$Workphone$%',
				'description' => __('Client&apos;s phone number at work')
				),
			'default-5' => array(
				'shortname' => 'Homephone',
				'mergetag' => '%$Homephone$%',
				'description' => __('Client&apos;s phone number at home')
				),
			'default-6' => array(
				'shortname' => 'Fax',
				'mergetag' => '%$Fax$%',
				'description' => __('Client&apos;s fax number')
				),
			'default-7' => array(
				'shortname' => 'Address1',
				'mergetag' => '%$Address1$%',
				'description' => __('Client&apos;s 1st line mailing address')
				),
			'default-8' => array(
				'shortname' => 'Address2',
				'mergetag' => '%$Address2$%',
				'description' => __('Client&apos;s 2nd line mailing address')
				),
			'default-9' => array(
				'shortname' => 'City',
				'mergetag' => '%$City$%',
				'description' => __('Client&apos;s city of residence')
				),
			'default-10' => array(
				'shortname' => 'State',
				'mergetag' => '%$State$%',
				'description' => __('Client&apos;s state/province of residence')
				),
			'default-11' => array(
				'shortname' => 'Zip',
				'mergetag' => '%$Zip$%',
				'description' => __('Client&apos;s ZIP/Postal Code')
				),
			'default-12' => array(
				'shortname' => 'Country',
				'mergetag' => '%$Country$%',
				'description' => __('Client&apos;s country of residence')
				),
			'custom-1' => array(
				'shortname' => 'field1',
				'mergetag' => '%$custom:field1$%',
				'description' => __('Event Type')
				),
			'custom-2' => array(
				'shortname' => 'field2',
				'mergetag' => '%$custom:field2$%',
				'description' => __('Event Date')
				),
			'custom-3' => array(
				'shortname' => 'field3',
				'mergetag' => '%$custom:field3$%',
				'description' => __('Event Time')
				),
			'custom-4' => array(
				'shortname' => 'field4',
				'mergetag' => '%$custom:field4$%',
				'description' => __('Event Site')
				),
			'custom-5' => array(
				'shortname' => 'field5',
				'mergetag' => '%$custom:field5$%',
				'description' => __('Number of Guests')
				),
			'custom-6' => array(
				'shortname' => 'field6',
				'mergetag' => '%$custom:field6$%',
				'description' => __('Lead Source')
				),
			'custom-7' => array(
				'shortname' => 'field7 ',
				'mergetag' => '%$custom:field7 $%',
				'description' => __('Custom field #7 ')
				),
			'custom-8' => array(
				'shortname' => 'field8',
				'mergetag' => '%$custom:field8$%',
				'description' => __('Total Fee')
				),
			'custom-9' => array(
				'shortname' => 'field9',
				'mergetag' => '%$custom:field9$%',
				'description' => __('Deposit')
				),
			'custom-10' => array(
				'shortname' => 'field10',
				'mergetag' => '%$custom:field10$%',
				'description' => __('Payment Made')
				),
			'custom-11' => array(
				'shortname' => 'field11',
				'mergetag' => '%$custom:field11$%',
				'description' => __('Balance Due')
				),
			'custom-12' => array(
				'shortname' => 'field12',
				'mergetag' => '%$custom:field12$%',
				'description' => __('Custom field #12')
				),
			'custom-13' => array(
				'shortname' => 'field13',
				'mergetag' => '%$custom:field13$%',
				'description' => __('Custom field #13')
				),
			'custom-14' => array(
				'shortname' => 'field14',
				'mergetag' => '%$custom:field14$%',
				'description' => __('Custom field #14')
				),
			'custom-15' => array(
				'shortname' => 'field15',
				'mergetag' => '%$custom:field15$%',
				'description' => __('Custom field #15')
				),
			'custom-16' => array(
				'shortname' => 'field16',
				'mergetag' => '%$custom:field16$%',
				'description' => __('Custom field #16')
				),
			'custom-17' => array(
				'shortname' => 'field17',
				'mergetag' => '%$custom:field17$%',
				'description' => __('Custom field #17')
				),
			'custom-18' => array(
				'shortname' => 'field18',
				'mergetag' => '%$custom:field18$%',
				'description' => __('Travel Fee')
				),
			'custom-19' => array(
				'shortname' => 'field19',
				'mergetag' => '%$custom:field19$%',
				'description' => __('Custom field #19')
				),
			'custom-20' => array(
				'shortname' => 'field20',
				'mergetag' => '%$custom:field20$%',
				'description' => __('Custom field #20')
				),
			'custom-21' => array(
				'shortname' => 'field21',
				'mergetag' => '%$custom:field21$%',
				'description' => __('Custom field #21')
				),
			'custom-22' => array(
				'shortname' => 'field22',
				'mergetag' => '%$custom:field22$%',
				'description' => __('Custom field #22')
				),
			'custom-23' => array(
				'shortname' => 'field23',
				'mergetag' => '%$custom:field23$%',
				'description' => __('Custom field #23')
				),
			'custom-24' => array(
				'shortname' => 'field24',
				'mergetag' => '%$custom:field24$%',
				'description' => __('Custom field #24')
				),
			'custom-25' => array(
				'shortname' => 'field25',
				'mergetag' => '%$custom:field25$%',
				'description' => __('Custom field #25')
				),
			'custom-26' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-27' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-28' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-29' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-30' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-31' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-32' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-33' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-34' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-35' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-36' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-37' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-38' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-39' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-40' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-41' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-42' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-43' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-44' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-45' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-46' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-47' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-48' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-49' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-50' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-51' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-52' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-53' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-54' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-55' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-56' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-57' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-58' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-59' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-60' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-61' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-62' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-63' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-64' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-65' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-66' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-67' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-68' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-69' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-70' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-71' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-72' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-73' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-74' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-75' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-76' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-77' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-78' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-79' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-80' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-81' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-82' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-83' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-84' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-85' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-86' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-87' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-88' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-89' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-90' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-91' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-92' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-93' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-94' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-95' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-96' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-97' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-98' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-99' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				),
			'custom-100' => array(
				'shortname' => '',
				'mergetag' => '',
				'description' => ''
				)

			),
	));

	delete_option( 'amazing_system_shortcode' );
	wp_clear_scheduled_hook('gill_check_event');
}
