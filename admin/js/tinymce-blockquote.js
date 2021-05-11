(function() {
    tinymce.PluginManager.add( 'mlmi_blockquote', function( editor, url ) {
      editor.on('click', function(e) {
        if(jQuery(e.target).closest('.mlmi-blockquote').length > 0){
          blockquote_object = jQuery(e.target).closest('.mlmi-blockquote');
          editor.buttons.mlmi_blockquote.onclick();
        }else{
          blockquote_object = null;
        }
      });
  		editor.addButton( 'mlmi_blockquote', {
        title: mlmi_blockquote.add_blockquote,
        type: 'button',
        icon: 'blockquote',
        onclick: function() {
          var editing = false;
          var selection = '';
          var selection_author = '';
          var selection_source = '';
          var selection_source_url = '';
          var selection_style = '';
          if ( editor.selection.getContent() ) {
            selection = editor.selection.getContent();
          }else if(blockquote_object != null){
            selection = blockquote_object.find('.mlmi-blockquote__quote p').html();
            selection_author = blockquote_object.find('.mlmi-blockquote__author').html();
            selection_source = blockquote_object.find('.mlmi-blockquote__source').html();
            selection_source_url = blockquote_object.find('blockquote').attr('cite');
            styles = blockquote_object.attr("class").split(/\s+/);
            for (index = 0; index < styles.length; ++index) {
              if(styles[index].includes('mlmi-blockquote--')){
                selection_style = styles[index].replace("mlmi-blockquote--", "");
              }
            }
            editing = true;
          }

          var body = [
    		    {
              type: 'textbox',
    		      name: 'quote',
    		      label: mlmi_blockquote.quote,
    		      multiline: true,
    		      minWidth: 300,
    				  minHeight: 100,
              value: selection
    		    },
            {
    	        type: 'textbox',
    	        name: 'author',
    	        label: mlmi_blockquote.author,
              value: selection_author,
    		    },
    		    {
    	        type: 'textbox',
    	        name: 'cite',
    	        label: mlmi_blockquote.source,
              value: selection_source,
    	      },
    		    {
    	        type: 'textbox',
    	        name: 'link',
    	        label: mlmi_blockquote.source_link,
              value: selection_source_url,
    	      },
    	    ];

    			// Display classes dropdown in pop-up if defined
    			if ( mlmi_blockquote.class_options ) {
    				var class_options = [];
    				for ( var key in mlmi_blockquote.class_options ) {
    					class_options.push({ 'value': key, 'text' : mlmi_blockquote.class_options[key] });
    				}
    				body.push({
    	        type: 'listbox',
    	        name: 'style',
    	        label: mlmi_blockquote.class,
    	        values : class_options,
              value: selection_style
    			  });
    			}

          if(editing) {
            body.push({
              type: 'button', // component type
              text: mlmi_blockquote.remove_formating,
              onclick: function () {
                text_format = blockquote_object.text();
                blockquote_object.remove();
                editor.insertContent(text_format);
                editor.windowManager.close();
              }
            });
          }

    			editor.windowManager.open({
    		    title: mlmi_blockquote.blockquote,
    		    body: body,
    		    onsubmit: function( e ) {
              var link = '';
              var cite = '';
              var author = '';
              var caption = '';
              var style = '';
              var quote = e.data.quote;
              var blockquote = '';
              if(e.data.cite){
                cite = '<cite class="mlmi-blockquote__source">' + e.data.cite + '</cite>';
              }
              if(e.data.author && e.data.cite){
                cite = ', ' + cite;
              }
              if(e.data.link){
                link = ' cite="' + e.data.link + '"';
              }
              if(e.data.author){
                author = '<span class="mlmi-blockquote__author">' + e.data.author + '</span>';
              }
              if(e.data.author || e.data.cite){
                caption = '<figcaption>' + author + cite + '</figcaption>';
              }
              if(e.data.style){
                style = ' mlmi-blockquote--' + e.data.style;
              }

              var blockquote = '<figure class="mlmi-blockquote' + style + '"><blockquote class="mlmi-blockquote__quote"' + link + '><p>' + quote + '</p></blockquote>' + caption + '</figure>';
              if(editing) {
                blockquote_object.remove();
              }
              editor.insertContent(blockquote);
            }
    			});
  			}
      });
    });
})();
