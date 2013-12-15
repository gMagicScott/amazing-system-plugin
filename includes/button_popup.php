<?php
header("X-Robots-Tag: none");
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Insert Merge Code</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow">
	<style>
		html {
			background:#f1f1f1;
		}

		input, select {
			padding: 5px;
			width: 170px;
			font-family: Helvetica, sans-serif;
			font-size: 1.2em;
			margin: 0px 0px 10px 0px;
			border: 2px solid #ccc;
		}

		select {
			width: 180px;
		}

		.description {
			margin: -6px 0 10px 115px;
			font-size: .8em;
			display: block;
		}

		#merge-form input:focus {
			border: 2px solid #900;
		}

		#submit {
			width: 100px;
			float: right;
		}

		label {
			float: left;
			text-align: right;
			margin-right: 15px;
			width: 100px;
			padding-top: 5px;
			font-size: 1.2em;
		}
	</style>
	<script src="../../../../wp-includes/js/tinymce/tiny_mce_popup.js"></script>
</head>
<body>

	<h2>Merge Tags</h2>

	<button id="form">Add Form</button>
	<button id="merge-code">Add Merge Code</button>

	<div id="merge-form" style="display:none">
		<label for="merge-field">Field</label>
		<select id="merge-field">
			<option value="firstname">First Name</option>
			<option value="Name">Full Name</option>
			<option value="Email1">Email Address</option>
			<option value="Company">Company</option>
			<option value="Workphone">Work Phone</option>
			<option value="Homephone">Home Phone</option>
			<option value="Fax">Fax</option>
			<option value="Address1">Address Line #1</option>
			<option value="Address2">Address Line #2</option>
			<option value="City">City</option>
			<option value="State">State</option>
			<option value="Zip">Zip</option>
			<option value="Country">Country</option>
			<option value="other">Other</option>
		</select>
		<div id="merge-other-wrap" style="display:none">
			<label for="merge-other">Other</label>
			<input type="text" id="merge-other" value="field">
		</div>

		<label for="default">Default Value</label>
		<input type="text" id="default">
		<span class="description">If the merge field is empty, display this value.</span>

		<button id="submit">Add</button>
	</div>



	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="../../../../wp-includes/js/jquery/jquery.js"><\/script>')</script>
	<script type="text/javascript">
		jQuery("#form").click(function () {
			tinyMCEPopup.execCommand('mceReplaceContent', false, '[show_as_form]');
			tinyMCEPopup.close();
		});
		jQuery("#merge-code").click(function () {
			jQuery("#merge-form").show();
			jQuery("#merge-code").hide();
			jQuery("#form").hide();
		});
		jQuery("#merge-field").change(function () {
			if ( jQuery("#merge-field").val() == 'other' ) {
				jQuery("#merge-other-wrap").show();
			} else {
				jQuery("#merge-other-wrap").hide();
			};
		});
		jQuery("#submit").click(function () {
			var output, field, def, jfield, jdef, jother;

			output = '[as what="';
			jdef = jQuery("#default");
			jfield = jQuery("#merge-field");
			jother = jQuery("#merge-other");

			if ( 'other' != jfield.val() ) {
				output = output + jfield.val() + '"';
			} else {
				output = output + jother.val().trim() + '"';
			};

			if ( '' == jdef.val().trim() ) {
				output = output + ']';
			} else{
				output = output + ' default="' + jdef.val().trim() + '"]'
			};
			tinyMCEPopup.execCommand('mceReplaceContent', false, output);
			tinyMCEPopup.close();
		});
		tinyMCEPopup.resizeToInnerSize();
	</script>
</body>
</html>
