(function() {
	tinymce.create('tinymce.plugins.amazingSystem', {
		init : function(ed, url) {
			// Register commands
			ed.addCommand('mcebutton', function() {
				ed.windowManager.open({
					file : url + '/../includes/button_popup.php', // file that contains HTML for our modal window
					width : 340 + parseInt(ed.getLang('button.delta_width', 0)), // size of our window
					height : 180 + parseInt(ed.getLang('button.delta_height', 0)), // size of our window
					inline : 1,
					title : "Amazing System"
				}, {
					plugin_url : url
				});
			});

			// Register buttons
			ed.addButton('as_shortcode_btn', {
				title : 'Amazing System',
				cmd : 'mcebutton',
				image: url + '/../includes/images/icon.png'
			});
		},

		getInfo : function() {
			return {
				longname : 'Amazing System',
				author : 'Scott Lesovic',
				authorurl : 'http://amazingsystemtraining.com',
				infourl : 'http://amazingsystem.com',
				version : tinymce.majorVersion + "." + tinymce.minorVersion
			};
		}
	});

	// Register plugin
	// first parameter is the button ID and must match ID elsewhere
	// second parameter must match the first parameter of the tinymce.create() function above
	tinymce.PluginManager.add('as_shortcode_btn', tinymce.plugins.amazingSystem);

})();
