(function() {
    tinymce.create('tinymce.plugins.Revive', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init : function(ed, url) {
            ed.addCommand('bluebutton', function() {
                var selected_text = ed.selection.getContent();
                var return_text = '';
				if(selected_text === 'schedule'){
	                return_text = '<a class="button small register-button" target="_blank" href="https://thefamilygreenhouse.acuityscheduling.com/schedule.php">Schedule Now <i class="fa fa-angle-double-right"></i></a>';
				} else {
	                return_text = '<a class="button small register-button" target="_blank" href="https://app.acuityscheduling.com/catalog.php?owner=11380870&action=addCart&id='+ selected_text +'">Register <i class="fa fa-angle-double-right"></i></a>';
				}

                ed.execCommand('mceInsertContent', 0, return_text);
            });
            ed.addCommand('greenbutton', function() {
                var selected_text = ed.selection.getContent();
                var return_text = '';
				if(selected_text === 'schedule'){
	                return_text = '<a class="button small success register-button" target="_blank" href="https://thefamilygreenhouse.acuityscheduling.com/schedule.php">Schedule Now <i class="fa fa-angle-double-right"></i></a>';
				} else {
	                return_text = '<a class="button small success register-button" target="_blank" href="https://app.acuityscheduling.com/catalog.php?owner=11380870&action=addCart&id='+ selected_text +'">Register <i class="fa fa-angle-double-right"></i></a>';
				}

                ed.execCommand('mceInsertContent', 0, return_text);
            });
            ed.addCommand('orangebutton', function() {
                var selected_text = ed.selection.getContent();
                var return_text = '';
				if(selected_text === 'schedule'){
	                return_text = '<a class="button small orange register-button" target="_blank" href="https://thefamilygreenhouse.acuityscheduling.com/schedule.php">Schedule Now <i class="fa fa-angle-double-right"></i></a>';
				} else {
	                return_text = '<a class="button small orange register-button" target="_blank" href="https://app.acuityscheduling.com/catalog.php?owner=11380870&action=addCart&id='+ selected_text +'">Register <i class="fa fa-angle-double-right"></i></a>';
				}

                ed.execCommand('mceInsertContent', 0, return_text);
            });
            
            ed.addButton('bluebutton', {
                title : 'Blue Button',
                cmd : 'bluebutton',
                image : url + '/bluebutton.png'
            });
            ed.addButton('greenbutton', {
                title : 'Green Button',
                cmd : 'greenbutton',
                image : url + '/greenbutton.png'
            });
            ed.addButton('orangebutton', {
                title : 'Orange Button',
                cmd : 'orangebutton',
                image : url + '/orangebutton.png'
            });

        },

        /**
         * Creates control instances based in the incomming name. This method is normally not
         * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
         * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
         * method can be used to create those.
         *
         * @param {String} n Name of the control to create.
         * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
         * @return {tinymce.ui.Control} New control instance or null if no control was created.
         */
        createControl : function(n, cm) {
            return null;
        },

        /**
         * Returns information about the plugin as a name/value array.
         * The current keys are longname, author, authorurl, infourl and version.
         *
         * @return {Object} Name/value array containing information about the plugin.
         */
        getInfo : function() {
            return {
                    longname : 'Custom Regsiter Button',
                    author : 'Jesse Matlock',
                    authorurl : 'http://jessematlock.com',
                    infourl : 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/example',
                    version : "0.1"
            };
        }
    });

    // Register plugin
    tinymce.PluginManager.add('revive', tinymce.plugins.Revive);
})();