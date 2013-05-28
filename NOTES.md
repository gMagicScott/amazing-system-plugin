##############
# Shortcodes #
##############

[merge]|[as]
  field|what
	default
	before
	after
	escape

[if_(not_)set]
	field
	comparison
	value

[date]
	format
	offset {min hour day month year}
	eodt

[show_form]|[show_as_form]
	id

[gender]|[switch]
	boy*
	girl*
	multi*
	default
	field
	only_if

[if_not_*] (boy|girl|multi)
	field

[goto_form]
	nofollow

[click_track_submit]



#############
# Post Meta #
#############

Include jQuery
Include DatePicker
	theme
	format
	months
	buttonpanel
	mindate
	selector
Include Auto-Cap
	selector
Include B/G/M switcher
	selector
	target
Include Validation
Include Show/Hide Field
Include Use Above Address
	target
Include Highlighter

Custom CSS
Custom Form HTML
Custom JavaScript

###########
# Options #
###########
System
	version

User
	shortcode prefix
	Merchant ID


#####################
# Click Custom Post #
#####################
Meta
	Merchant ID
	Tracking Field
	.amaz-sys_$email = $count
	Autoresponder ID
	Thank-you page
	System Notification [Y/n]
	Page Title
	Use Cookies instead [Y/n]
	Link Text
		If you are not automatically forwarded, please [click_track_submit]CLICK HERE[/click_track_submit].

Function
	delete all saved data

Notes
	if is_admin() - display example URL for including in link

