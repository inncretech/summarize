/* Author: Alicia Liu */

(function ($) {
	
	$.widget("ui.tagify", {
		options: {
			delimiters: [9,13, 188, 44],          // what user can type to complete a tag in char codes: [enter], [comma]
			outputDelimiter: ',',           // delimiter for tags in original input field
			cssClass: 'tagify-container',   // CSS class to style the tagify div and tags, see stylesheet
			addTagPrompt: 'add tags',       // placeholder text
			addTagOnBlur: false				// Add a tag on blur when not empty
		},
		
		_create: function() {
			var self = this,
				el = self.element,
				opts = self.options;

			this.tags = [];
			
			// hide text field and replace with a div that contains it's own input field for entering tags
			this.tagInput = $("<input type='text'>")
				.attr( 'placeholder', opts.addTagPrompt )
				.keydown( function(e) {
					var $this = $(this),
					    pressed = e.which || e.keyCode;
						
					for ( i in opts.delimiters ) {
						
						if (pressed == opts.delimiters[i]) {
							
							if (typeof product_id != 'undefined'){
								if ((member_login)||($("#advancedSearchModal").css('display')=="block")){
									$this.val($this.val().replace(",",""));
									if (($("#addManualProduct").css('display')!="block")&&($("#advancedSearchModal").css('display')!="block")) tag.save($this.val(),product_id); // add tag to db
									self.add( $this.val() );
								}else{
									$('#signInModal').modal('show')
								}
							}else{
								self.add( $this.val() );
							}
							e.preventDefault(); 
							return false;
						}
					}
				})
				// we record the value of the textfield before the key is pressed
				// so that we get rid of the backspace issue
				.keydown(function(e){
					self.keyDownValue = $(this).val();
				})
				// for some reason, in Safari, backspace is only recognized on keyup
				.keyup( function(e) {
					var $this = $(this),
					    pressed = e.which;

					// if backspace is hit with no input, remove the last tag
					if (pressed == 8) { // backspace
						if ( self.keyDownValue == '' ) {
							self.remove();
							return false;
						}
						return;
					}
				});
			
			// Add tags blur event when required	
			if (opts.addTagOnBlur) {
				// When needed, add tags on blur
				this.tagInput.blur( function(e) {
					var $this = $(this);
					
					// if lose focus on input field, check if length is empty
					if ('' !== $this.val()) {
						self.add( $this.val() );
						e.preventDefault(); 
						return false;
					}
				})
			}	
				
			this.tagDiv = $("<div></div>")
			    .addClass( opts.cssClass )
			    .click( function() {
			        $(this).children('input').focus();
			    })
			    .append( this.tagInput )
				.insertAfter( el.hide() );
				
			// if the field isn't empty, parse the field for tags, and prepopulate existing tags
			var initVal = $.trim( el.val() );

			if ( initVal ) {
				var initTags = initVal.split( opts.outputDelimiter );
				$.each( initTags, function(i, tag) {
				    self.add( tag );
				});
			}
		},
		
		_setOption: function( key, value ) {
			options.key = value;
		},
		
		// add a tag, public function		
		add: function(text) {
    		var self = this;
			text = text || self.tagInput.val();
			if (text) {
				var tagIndex = self.tags.length;
				
				var removeButton = $("<a href='#'>x</a>")
					.click( function() {
						self.remove( tagIndex );
						return false;
					});
				var newTag = $("<span style=\"cursor:pointer;\" onclick=\"render.search('"+text+"');return false;\" id='tag-name'></span>")
					.text( text )
					.append( removeButton );
				
				self.tagInput.before( newTag );
				self.tags.push( text );
				self.tagInput.val('');
			}
		},
		
		// remove a tag by index, public function
		// if index is blank, remove the last tag
		remove: function( tagIndex ) {
			
			var self = this;
			var ok = true;
			
			if ( tagIndex == null  || tagIndex === (self.tags.length - 1) ) {
				
				if (typeof product_id != 'undefined'){
					
					if ((member_login)||($("#advancedSearchModal").css('display')=="block")){
						if (($("#addManualProduct").css('display')!="block")&&($("#advancedSearchModal").css('display')!="block")) tag.remove((this.tagDiv.children("span").last().find('a').remove().end().text()),product_id); //tag remove
						this.tagDiv.children("span").last().remove();
						self.tags.pop();
					}else{
						$('#signInModal').modal('show')
					}
				}else{
					this.tagDiv.children("span").last().remove();
					self.tags.pop();
				}
				ok=false;
			}
			
			if (( typeof(tagIndex) == 'number' )&&(ok)) {
				
				if (typeof product_id != 'undefined'){
					if (member_login){
						// otherwise just hide this tag, and we don't mess up the index
						this.tagDiv.children( "span:eq(" + tagIndex + ")" ).hide();
						tag.remove((this.tagDiv.children( "span:eq(" + tagIndex + ")" ).find('a').remove().end().text()),product_id); //tag remove
						// we rely on the serialize function to remove null values
						delete( self.tags[tagIndex] );
					}else{
						$('#signInModal').modal('show')
					}
				}else{
					// otherwise just hide this tag, and we don't mess up the index
					this.tagDiv.children( "span:eq(" + tagIndex + ")" ).hide();
					// we rely on the serialize function to remove null values
					delete( self.tags[tagIndex] );
				}
				 
				
			}
		},
		
		// serialize the tags with the given delimiter, and write it back into the tagified field
		serialize: function() {
			var self = this;
			var delim = self.options.outputDelimiter;
			var tagsStr = self.tags.join( delim );
			
			// our tags might have deleted entries, remove them here
			var dupes = new RegExp(delim + delim + '+', 'g'); // regex: /,,+/g
			var ends = new RegExp('^' + delim + '|' + delim + '$', 'g');  // regex: /^,|,$/g
			var outputStr = tagsStr.replace( dupes, delim ).replace(ends, '');
			
			self.element.val(outputStr);
			return outputStr;
		},
		
		inputField: function() {
		    return this.tagInput;
		},
		
		containerDiv: function() {
		    return this.tagDiv;
		},
		
		// remove the div, and show original input
		destroy: function() {
		    $.Widget.prototype.destroy.apply(this);
			this.tagDiv.remove();
			this.element.show();
		}
	});
	


/*tag_area.tagify('inputField').autocomplete({
	source: ["c++", "java", "php", "coldfusion", "javascript", "asp", "ruby"],
	position: { of: tag_area.tagify('containerDiv') },
	close: function(event, ui) { tag_area.tagify('add'); },
});	*/

})(jQuery);
var tag_area = $('.tagArea').tagify();
var add_product_tag_area = $('.addProductTagArea').tagify();


tag_area.tagify('inputField').autocomplete({
	source: function(request, response) {
				
                $.ajax({
                    type: "GET",
                    url: site_root+"/backend/ajax.get/search_tags.php",
					data: {query: request.term },
                    dataType: "json",
                    contentType: "application/json",
                    success: function(data) {
						
                        response($.map(data, function(item) {
                            return {
                                label: item,
                                value: item,
                            }
                        }));
                    }
                });},
	position: { of: tag_area.tagify('inputField') },
	select: function(event, ui) {tag.save(ui.item.value,product_id);},
	close: function(event, ui) {tag_area.tagify('add'); }
});


add_product_tag_area.tagify('inputField').autocomplete({
	source: function(request, response) {
				
                $.ajax({
                    type: "GET",
                    url: site_root+"/backend/ajax.get/search_tags.php",
					data: {query: request.term },
                    dataType: "json",
                    contentType: "application/json",
                    success: function(data) {
						
                        response($.map(data, function(item) {
                            return {
                                label: item,
                                value: item,
                            }
                        }));
                    }
                });},
	position: { of: add_product_tag_area.tagify('inputField') },
	select: function(event, ui) {},
	close: function(event, ui) {add_product_tag_area.tagify('add'); }
});
