/**
 * Controls the behaviours of custom metabox fields.
 *
 * @author RSTHEME team
 * @see    https://github.com/RSTHEME/RSTHEME
 */

/**
 * Custom jQuery for Custom Metaboxes and Fields
 */
window.RSTHEME = window.RSTHEME || {};
(function(window, document, $, rstheme, undefined){
	'use strict';

	// localization strings
	var l10n = window.rstheme_l10;
	var setTimeout = window.setTimeout;
	var $document;
	var $id = function( selector ) {
		return $( document.getElementById( selector ) );
	};
	var defaults = {
		idNumber        : false,
		repeatEls       : 'input:not([type="button"],[id^=filelist]),select,textarea,.rstheme-media-status',
		noEmpty         : 'input:not([type="button"]):not([type="radio"]):not([type="checkbox"]),textarea',
		repeatUpdate    : 'input:not([type="button"]),select,textarea,label',
		styleBreakPoint : 450,
		mediaHandlers   : {},
		defaults : {
			time_picker  : l10n.defaults.time_picker,
			date_picker  : l10n.defaults.date_picker,
			color_picker : l10n.defaults.color_picker || {},
			code_editor  : l10n.defaults.code_editor,
		},
		media : {
			frames : {},
		},
	};

	rstheme.metabox = function() {
		if ( rstheme.$metabox ) {
			return rstheme.$metabox;
		}
		rstheme.$metabox = $('.rstheme-wrap > .rstheme-metabox');
		return rstheme.$metabox;
	};

	rstheme.init = function() {
		$document = $( document );

		// Setup the RSTHEME object defaults.
		$.extend( rstheme, defaults );

		rstheme.trigger( 'rstheme_pre_init' );

		var $metabox     = rstheme.metabox();
		var $repeatGroup = $metabox.find('.rstheme-repeatable-group');

		 // Init time/date/color pickers
		rstheme.initPickers( $metabox.find('input[type="text"].rstheme-timepicker'), $metabox.find('input[type="text"].rstheme-datepicker'), $metabox.find('input[type="text"].rstheme-colorpicker') );

		// Init code editorstheme.
		rstheme.initCodeEditors( $metabox.find( '.rstheme-textarea-code:not(.disable-codemirror)' ) );

		// Insert toggle button into DOM wherever there is multicheck. credit: Genesis Framework
		$( '<p><span class="button-secondary rstheme-multicheck-toggle">' + l10n.strings.check_toggle + '</span></p>' ).insertBefore( '.rstheme-checkbox-list:not(.no-select-all)' );

		// Make File List drag/drop sortable:
		rstheme.makeListSortable();

		$metabox
			.on( 'change', '.rstheme_upload_file', function() {
				rstheme.media.field = $( this ).attr( 'id' );
				$id( rstheme.media.field + '_id' ).val('');
			})
			// Media/file management
			.on( 'click', '.rstheme-multicheck-toggle', rstheme.toggleCheckBoxes )
			.on( 'click', '.rstheme-upload-button', rstheme.handleMedia )
			.on( 'click', '.rstheme-attach-list li, .rstheme-media-status .img-status img, .rstheme-media-status .file-status > span', rstheme.handleFileClick )
			.on( 'click', '.rstheme-remove-file-button', rstheme.handleRemoveMedia )
			// Repeatable content
			.on( 'click', '.rstheme-add-group-row', rstheme.addGroupRow )
			.on( 'click', '.rstheme-add-row-button', rstheme.addAjaxRow )
			.on( 'click', '.rstheme-remove-group-row', rstheme.removeGroupRow )
			.on( 'click', '.rstheme-remove-row-button', rstheme.removeAjaxRow )
			// Ajax oEmbed display
			.on( 'keyup paste focusout', '.rstheme-oembed', rstheme.maybeOembed )
			// Reset titles when removing a row
			.on( 'rstheme_remove_row', '.rstheme-repeatable-group', rstheme.resetTitlesAndIterator )
			.on( 'click', '.rsthemehandle, .rsthemehandle + .rsthemehandle-title', rstheme.toggleHandle );

		if ( $repeatGroup.length ) {
			$repeatGroup
				.on( 'rstheme_add_row', rstheme.emptyValue )
				.on( 'rstheme_add_row', rstheme.setDefaults )
				.filter('.sortable').each( function() {
					// Add sorting arrows
					$( this ).find( '.rstheme-remove-group-row-button' ).before( '<a class="button-secondary rstheme-shift-rows move-up alignleft" href="#"><span class="'+ l10n.up_arrow_class +'"></span></a> <a class="button-secondary rstheme-shift-rows move-down alignleft" href="#"><span class="'+ l10n.down_arrow_class +'"></span></a>' );
				})
				.on( 'click', '.rstheme-shift-rows', rstheme.shiftRows );
		}

		// on pageload
		setTimeout( rstheme.resizeoEmbeds, 500);
		// and on window resize
		$( window ).on( 'resize', rstheme.resizeoEmbeds );

		if ( $id( 'addtag' ).length ) {
			rstheme.listenTagAdd();
		}

		rstheme.trigger( 'rstheme_init' );
	};

	rstheme.listenTagAdd = function() {
		$document.ajaxSuccess( function( evt, xhr, settings ) {
			if ( settings.data && settings.data.length && -1 !== settings.data.indexOf( 'action=add-tag' ) ) {
				rstheme.resetBoxes( $id( 'addtag' ).find( '.rstheme-wrap > .rstheme-metabox' ) );
			}
		});
	};

	rstheme.resetBoxes = function( $boxes ) {
		$.each( $boxes, function() {
			rstheme.resetBox( $( this ) );
		});
	};

	rstheme.resetBox = function( $box ) {
		$box.find( '.wp-picker-clear' ).trigger( 'click' );
		$box.find( '.rstheme-remove-file-button' ).trigger( 'click' );
		$box.find( '.rstheme-row.rstheme-repeatable-grouping:not(:first-of-type) .rstheme-remove-group-row' ).click();
		$box.find( '.rstheme-repeat-row:not(:first-child)' ).remove();

		$box.find( 'input:not([type="button"]),select,textarea' ).each( function() {
			var $element = $( this );
			var tagName = $element.prop('tagName');

			if ( 'INPUT' === tagName ) {
				var elType = $element.attr( 'type' );
				if ( 'checkbox' === elType || 'radio' === elType ) {
					$element.prop( 'checked', false );
				} else {
					$element.val( '' );
				}
			}
			if ( 'SELECT' === tagName ) {
				$( 'option:selected', this ).prop( 'selected', false );
			}
			if ( 'TEXTAREA' === tagName ) {
				$element.html( '' );
			}
		});
	};

	rstheme.resetTitlesAndIterator = function( evt ) {
		if ( ! evt.group ) {
			return;
		}

		// Loop repeatable group tables
		$( '.rstheme-repeatable-group.repeatable' ).each( function() {
			var $table = $( this );
			var groupTitle = $table.find( '.rstheme-add-group-row' ).data( 'grouptitle' );

			// Loop repeatable group table rows
			$table.find( '.rstheme-repeatable-grouping' ).each( function( rowindex ) {
				var $row = $( this );
				var $rowTitle = $row.find( 'h3.rstheme-group-title' );
				// Reset rows iterator
				$row.data( 'iterator', rowindex );
				// Reset rows title
				if ( $rowTitle.length ) {
					$rowTitle.text( groupTitle.replace( '{#}', ( rowindex + 1 ) ) );
				}
			});
		});
	};

	rstheme.toggleHandle = function( evt ) {
		evt.preventDefault();
		rstheme.trigger( 'postbox-toggled', $( this ).parent('.postbox').toggleClass('closed') );
	};

	rstheme.toggleCheckBoxes = function( evt ) {
		evt.preventDefault();
		var $this = $( this );
		var $multicheck = $this.closest( '.rstheme-td' ).find( 'input[type=checkbox]:not([disabled])' );

		// If the button has already been clicked once...
		if ( $this.data( 'checked' ) ) {
			// clear the checkboxes and remove the flag
			$multicheck.prop( 'checked', false );
			$this.data( 'checked', false );
		}
		// Otherwise mark the checkboxes and add a flag
		else {
			$multicheck.prop( 'checked', true );
			$this.data( 'checked', true );
		}
	};

	rstheme.handleMedia = function( evt ) {
		evt.preventDefault();

		var $el = $( this );
		rstheme.attach_id = ! $el.hasClass( 'rstheme-upload-list' ) ? $el.closest( '.rstheme-td' ).find( '.rstheme-upload-file-id' ).val() : false;
		// Clean up default 0 value
		rstheme.attach_id = '0' !== rstheme.attach_id ? rstheme.attach_id : false;

		rstheme._handleMedia( $el.prev('input.rstheme-upload-file').attr('id'), $el.hasClass( 'rstheme-upload-list' ) );
	};

	rstheme.handleFileClick = function( evt ) {
		if ( $( evt.target ).is( 'a' ) ) {
			return;
		}

		evt.preventDefault();

		var $el    = $( this );
		var $td    = $el.closest( '.rstheme-td' );
		var isList = $td.find( '.rstheme-upload-button' ).hasClass( 'rstheme-upload-list' );
		rstheme.attach_id = isList ? $el.find( 'input[type="hidden"]' ).data( 'id' ) : $td.find( '.rstheme-upload-file-id' ).val();

		if ( rstheme.attach_id ) {
			rstheme._handleMedia( $td.find( 'input.rstheme-upload-file' ).attr( 'id' ), isList, rstheme.attach_id );
		}
	};

	rstheme._handleMedia = function( id, isList ) {
		if ( ! wp ) {
			return;
		}

		var media, handlers;

		handlers          = rstheme.mediaHandlers;
		media             = rstheme.media;
		media.field       = id;
		media.$field      = $id( media.field );
		media.fieldData   = media.$field.data();
		media.previewSize = media.fieldData.previewsize;
		media.sizeName    = media.fieldData.sizename;
		media.fieldName   = media.$field.attr('name');
		media.isList      = isList;

		// If this field's media frame already exists, reopen it.
		if ( id in media.frames ) {
			return media.frames[ id ].open();
		}

		// Create the media frame.
		media.frames[ id ] = wp.media( {
			title: rstheme.metabox().find('label[for="' + id + '"]').text(),
			library : media.fieldData.queryargs || {},
			button: {
				text: l10n.strings[ isList ? 'upload_files' : 'upload_file' ]
			},
			multiple: isList ? 'add' : false
		} );

		// Enable the additional media filters: https://github.com/RSTHEME/RSTHEME/issues/873
		media.frames[ id ].states.first().set( 'filterable', 'all' );

		rstheme.trigger( 'rstheme_media_modal_init', media );

		handlers.list = function( selection, returnIt ) {

			// Setup our fileGroup array
			var fileGroup = [];
			var attachmentHtml;

			if ( ! handlers.list.templates ) {
				handlers.list.templates = {
					image : wp.template( 'rstheme-list-image' ),
					file  : wp.template( 'rstheme-list-file' ),
				};
			}

			// Loop through each attachment
			selection.each( function( attachment ) {

				// Image preview or standard generic output if it's not an image.
				attachmentHtml = handlers.getAttachmentHtml( attachment, 'list' );

				// Add our file to our fileGroup array
				fileGroup.push( attachmentHtml );
			});

			if ( ! returnIt ) {
				// Append each item from our fileGroup array to .rstheme-media-status
				media.$field.siblings( '.rstheme-media-status' ).append( fileGroup );
			} else {
				return fileGroup;
			}

		};

		handlers.single = function( selection ) {
			if ( ! handlers.single.templates ) {
				handlers.single.templates = {
					image : wp.template( 'rstheme-single-image' ),
					file  : wp.template( 'rstheme-single-file' ),
				};
			}

			// Only get one file from the uploader
			var attachment = selection.first();

			media.$field.val( attachment.get( 'url' ) );
			$id( media.field +'_id' ).val( attachment.get( 'id' ) );

			// Image preview or standard generic output if it's not an image.
			var attachmentHtml = handlers.getAttachmentHtml( attachment, 'single' );

			// add/display our output
			media.$field.siblings( '.rstheme-media-status' ).slideDown().html( attachmentHtml );
		};

		handlers.getAttachmentHtml = function( attachment, templatesId ) {
			var isImage = 'image' === attachment.get( 'type' );
			var data    = handlers.prepareData( attachment, isImage );

			// Image preview or standard generic output if it's not an image.
			return handlers[ templatesId ].templates[ isImage ? 'image' : 'file' ]( data );
		};

		handlers.prepareData = function( data, image ) {
			if ( image ) {
				// Set the correct image size data
				handlers.getImageData.call( data, 50 );
			}

			data                   = data.toJSON();
			data.mediaField        = media.field;
			data.mediaFieldName    = media.fieldName;
			data.stringRemoveImage = l10n.strings.remove_image;
			data.stringFile        = l10n.strings.file;
			data.stringDownload    = l10n.strings.download;
			data.stringRemoveFile  = l10n.strings.remove_file;

			return data;
		};

		handlers.getImageData = function( fallbackSize ) {

			// Preview size dimensions
			var previewW = media.previewSize[0] || fallbackSize;
			var previewH = media.previewSize[1] || fallbackSize;

			// Image dimensions and url
			var url    = this.get( 'url' );
			var width  = this.get( 'width' );
			var height = this.get( 'height' );
			var sizes  = this.get( 'sizes' );

			// Get the correct dimensions and url if a named size is set and exists
			// fallback to the 'large' size
			if ( sizes ) {
				if ( sizes[ media.sizeName ] ) {
					url    = sizes[ media.sizeName ].url;
					width  = sizes[ media.sizeName ].width;
					height = sizes[ media.sizeName ].height;
				} else if ( sizes.large ) {
					url    = sizes.large.url;
					width  = sizes.large.width;
					height = sizes.large.height;
				}
			}

			// Fit the image in to the preview size, keeping the correct aspect ratio
			if ( width > previewW ) {
				height = Math.floor( previewW * height / width );
				width = previewW;
			}

			if ( height > previewH ) {
				width = Math.floor( previewH * width / height );
				height = previewH;
			}

			if ( ! width ) {
				width = previewW;
			}

			if ( ! height ) {
				height = 'svg' === this.get( 'filename' ).split( '.' ).pop() ? '100%' : previewH;
			}

			this.set( 'sizeUrl', url );
			this.set( 'sizeWidth', width );
			this.set( 'sizeHeight', height );

			return this;
		};

		handlers.selectFile = function() {
			var selection = media.frames[ id ].state().get( 'selection' );
			var type = isList ? 'list' : 'single';

			if ( rstheme.attach_id && isList ) {
				$( '[data-id="'+ rstheme.attach_id +'"]' ).parents( 'li' ).replaceWith( handlers.list( selection, true ) );
			} else {
				handlers[type]( selection );
			}

			rstheme.trigger( 'rs_media_modal_select', selection, media );
		};

		handlers.openModal = function() {
			var selection = media.frames[ id ].state().get( 'selection' );
			var attach;

			if ( ! rstheme.attach_id ) {
				selection.reset();
			} else {
				attach = wp.media.attachment( rstheme.attach_id );
				attach.fetch();
				selection.set( attach ? [ attach ] : [] );
			}

			rstheme.trigger( 'rs_media_modal_open', selection, media );
		};

		// When a file is selected, run a callback.
		media.frames[ id ]
			.on( 'select', handlers.selectFile )
			.on( 'open', handlers.openModal );

		// Finally, open the modal
		media.frames[ id ].open();
	};

	rstheme.handleRemoveMedia = function( evt ) {
		evt.preventDefault();
		var $this = $( this );
		if ( $this.is( '.rstheme-attach-list .rstheme-remove-file-button' ) ) {
			$this.parents( '.rstheme-media-item' ).remove();
			return false;
		}

		rstheme.media.field = $this.attr('rel');

		rstheme.metabox().find( document.getElementById( rstheme.media.field ) ).val('');
		rstheme.metabox().find( document.getElementById( rstheme.media.field + '_id' ) ).val('');
		$this.parents('.rstheme-media-status').html('');

		return false;
	};

	rstheme.cleanRow = function( $row, prevNum, group ) {
		var $elements = $row.find( rstheme.repeatUpdate );
		if ( group ) {

			var $other = $row.find( '[id]' ).not( rstheme.repeatUpdate );

			// Remove extra ajaxed rows
			$row.find('.rstheme-repeat-table .rstheme-repeat-row:not(:first-child)').remove();

			// Update all elements w/ an ID
			if ( $other.length ) {
				$other.each( function() {
					var $_this = $( this );
					var oldID = $_this.attr( 'id' );
					var newID = oldID.replace( '_'+ prevNum, '_'+ rstheme.idNumber );
					var $buttons = $row.find('[data-selector="'+ oldID +'"]');
					$_this.attr( 'id', newID );

					// Replace data-selector vars
					if ( $buttons.length ) {
						$buttons.attr( 'data-selector', newID ).data( 'selector', newID );
					}
				});
			}
		}

		$elements.filter( ':checked' ).removeAttr( 'checked' );
		$elements.find( ':checked' ).removeAttr( 'checked' );
		$elements.filter( ':selected' ).removeAttr( 'selected' );
		$elements.find( ':selected' ).removeAttr( 'selected', false );

		if ( $row.find('h3.rstheme-group-title').length ) {
			$row.find( 'h3.rstheme-group-title' ).text( $row.data( 'title' ).replace( '{#}', ( rstheme.idNumber + 1 ) ) );
		}

		$elements.each( function() {
			rstheme.elReplacements( $( this ), prevNum, group );
		} );

		return rstheme;
	};

	rstheme.elReplacements = function( $newInput, prevNum, group ) {
		var oldFor    = $newInput.attr( 'for' );
		var oldVal    = $newInput.val();
		var type      = $newInput.prop( 'type' );
		var defVal    = rstheme.getFieldArg( $newInput, 'default' );
		var newVal    = 'undefined' !== typeof defVal && false !== defVal ? defVal : '';
		var tagName   = $newInput.prop('tagName');
		var checkable = 'radio' === type || 'checkbox' === type ? oldVal : false;
		var attrs     = {};
		var newID, oldID;
		if ( oldFor ) {
			attrs = { 'for' : oldFor.replace( '_'+ prevNum, '_'+ rstheme.idNumber ) };
		} else {
			var oldName = $newInput.attr( 'name' );
			var newName;
			oldID = $newInput.attr( 'id' );

			// Handle adding groups vs rows.
			if ( group ) {
				// Expect another bracket after group's index closing bracket.
				newName = oldName ? oldName.replace( '['+ prevNum +'][', '['+ rstheme.idNumber +'][' ) : '';
				// Expect another underscore after group's index trailing underscore.
				newID   = oldID ? oldID.replace( '_' + prevNum + '_', '_' + rstheme.idNumber + '_' ) : '';
			}
			else {
				// Row indexes are at the very end of the string.
				newName = oldName ? rstheme.replaceLast( oldName, '[' + prevNum + ']', '[' + rstheme.idNumber + ']' ) : '';
				newID   = oldID ? rstheme.replaceLast( oldID, '_' + prevNum, '_' + rstheme.idNumber ) : '';
			}

			attrs = {
				id: newID,
				name: newName
			};

		}

		// Clear out textarea values
		if ( 'TEXTAREA' === tagName ) {
			$newInput.html( newVal );
		}

		if ( 'SELECT' === tagName && undefined !== typeof defVal ) {
			var $toSelect = $newInput.find( '[value="'+ defVal + '"]' );
			if ( $toSelect.length ) {
				$toSelect.attr( 'selected', 'selected' ).prop( 'selected', 'selected' );
			}
		}

		if ( checkable ) {
			$newInput.removeAttr( 'checked' );
			if ( undefined !== typeof defVal && oldVal === defVal ) {
				$newInput.attr( 'checked', 'checked' ).prop( 'checked', 'checked' );
			}
		}

		if ( ! group && $newInput[0].hasAttribute( 'data-iterator' ) ) {
			attrs['data-iterator'] = rstheme.idNumber;
		}

		$newInput
			.removeClass( 'hasDatepicker' )
			.val( checkable ? checkable : newVal ).attr( attrs );

		return $newInput;
	};

	rstheme.newRowHousekeeping = function( $row ) {

		var $colorPicker = $row.find( '.wp-picker-container' );
		var $list        = $row.find( '.rstheme-media-status' );

		if ( $colorPicker.length ) {
			// Need to clean-up colorpicker before appending
			$colorPicker.each( function() {
				var $td = $( this ).parent();
				$td.html( $td.find( 'input[type="text"].rstheme-colorpicker' ).attr('style', '') );
			});
		}

		// Need to clean-up colorpicker before appending
		if ( $list.length ) {
			$list.empty();
		}

		return rstheme;
	};

	rstheme.afterRowInsert = function( $row ) {
		// Init pickers from new row
		rstheme.initPickers( $row.find('input[type="text"].rstheme-timepicker'), $row.find('input[type="text"].rstheme-datepicker'), $row.find('input[type="text"].rstheme-colorpicker') );
	};

	rstheme.updateNameAttr = function () {

		var $this = $( this );
		var name  = $this.attr( 'name' ); // get current name

		// If name is defined
		if ( typeof name !== 'undefined' ) {
			var prevNum = parseInt( $this.parents( '.rstheme-repeatable-grouping' ).data( 'iterator' ), 10 );
			var newNum  = prevNum - 1; // Subtract 1 to get new iterator number

			// Update field name attributes so data is not orphaned when a row is removed and post is saved
			var $newName = name.replace( '[' + prevNum + ']', '[' + newNum + ']' );

			// New name with replaced iterator
			$this.attr( 'name', $newName );
		}

	};

	rstheme.emptyValue = function( evt, row ) {
		$( rstheme.noEmpty, row ).val( '' );
	};

	rstheme.setDefaults = function( evt, row ) {
		$( rstheme.noEmpty, row ).each( function() {
			var $el = $(this);
			var defVal = rstheme.getFieldArg( $el, 'default' );
			if ( 'undefined' !== typeof defVal && false !== defVal ) {
				$el.val( defVal );
			}
		});
	};

	rstheme.addGroupRow = function( evt ) {
		evt.preventDefault();

		var $this = $( this );

		// before anything significant happens
		rstheme.triggerElement( $this, 'rstheme_add_group_row_start', $this );

		var $table   = $id( $this.data('selector') );
		var $oldRow  = $table.find('.rstheme-repeatable-grouping').last();
		var prevNum  = parseInt( $oldRow.data('iterator'), 10 );
		rstheme.idNumber = parseInt( prevNum, 10 ) + 1;
		var $row     = $oldRow.clone();

		// Make sure the next number doesn't exist.
		while ( $table.find( '.rstheme-repeatable-grouping[data-iterator="'+ rstheme.idNumber +'"]' ).length > 0 ) {
			rstheme.idNumber++;
		}

		rstheme.newRowHousekeeping( $row.data( 'title', $this.data( 'grouptitle' ) ) ).cleanRow( $row, prevNum, true );
		$row.find( '.rstheme-add-row-button' ).prop( 'disabled', false );

		var $newRow = $( '<div class="postbox rstheme-row rstheme-repeatable-grouping" data-iterator="'+ rstheme.idNumber +'">'+ $row.html() +'</div>' );
		$oldRow.after( $newRow );

		rstheme.afterRowInsert( $newRow );

		rstheme.triggerElement( $table, { type: 'rstheme_add_row', group: true }, $newRow );

	};

	rstheme.addAjaxRow = function( evt ) {
		evt.preventDefault();

		var $this         = $( this );
		var $table        = $id( $this.data('selector') );
		var $emptyrow     = $table.find('.empty-row');
		var prevNum       = parseInt( $emptyrow.find('[data-iterator]').data('iterator'), 10 );
		rstheme.idNumber      = parseInt( prevNum, 10 ) + 1;
		var $row          = $emptyrow.clone();

		rstheme.newRowHousekeeping( $row ).cleanRow( $row, prevNum );

		$emptyrow.removeClass('empty-row hidden').addClass('rstheme-repeat-row');
		$emptyrow.after( $row );

		rstheme.afterRowInsert( $row );

		rstheme.triggerElement( $table, { type: 'rstheme_add_row', group: false }, $row );

	};

	rstheme.removeGroupRow = function( evt ) {
		evt.preventDefault();

		var $this   = $( this );
		var $table  = $id( $this.data('selector') );
		var $parent = $this.parents('.rstheme-repeatable-grouping');
		var number  = $table.find('.rstheme-repeatable-grouping').length;

		if ( number < 2 ) {
			return rstheme.resetRow( $parent.parents('.rstheme-repeatable-group').find( '.rstheme-add-group-row' ), $this );
		}

		rstheme.triggerElement( $table, 'rstheme_remove_group_row_start', $this );

		// when a group is removed loop through all next groups and update fields names
		$parent.nextAll( '.rstheme-repeatable-grouping' ).find( rstheme.repeatEls ).each( rstheme.updateNameAttr );

		$parent.remove();

		rstheme.triggerElement( $table, { type: 'rstheme_remove_row', group: true } );

	};

	rstheme.removeAjaxRow = function( evt ) {
		evt.preventDefault();

		var $this = $( this );

		// Check if disabled
		if ( $this.hasClass( 'button-disabled' ) ) {
			return;
		}

		var $parent = $this.parents('.rstheme-row');
		var $table  = $this.parents('.rstheme-repeat-table');
		var number  = $table.find('.rstheme-row').length;

		if ( number <= 2 ) {
			return rstheme.resetRow( $parent.find( '.rstheme-add-row-button' ), $this );
		}

		if ( $parent.hasClass('empty-row') ) {
			$parent.prev().addClass( 'empty-row' ).removeClass('rstheme-repeat-row');
		}

		$this.parents('.rstheme-repeat-table .rstheme-row').remove();


		rstheme.triggerElement( $table, { type: 'rstheme_remove_row', group: false } );
	};

	rstheme.resetRow = function( $addNewBtn, $removeBtn ) {
		// Click the "add new" button followed by the "remove this" button
		// in order to reset the repeat row to empty values.
		$addNewBtn.trigger( 'click' );
		$removeBtn.trigger( 'click' );
	};

	rstheme.shiftRows = function( evt ) {

		evt.preventDefault();

		var $this = $( this );
		var $from = $this.parents( '.rstheme-repeatable-grouping' );
		var $goto = $this.hasClass( 'move-up' ) ? $from.prev( '.rstheme-repeatable-grouping' ) : $from.next( '.rstheme-repeatable-grouping' );

		// Before shift occurstheme.
		rstheme.triggerElement( $this, 'rstheme_shift_rows_enter', $this, $from, $goto );

		if ( ! $goto.length ) {
			return;
		}

		// About to shift
		rstheme.triggerElement( $this, 'rstheme_shift_rows_start', $this, $from, $goto );

		var inputVals = [];
		// Loop this item's fields
		$from.find( rstheme.repeatEls ).each( function() {
			var $element = $( this );
			var elType = $element.attr( 'type' );
			var val;

			if ( $element.hasClass('rstheme-media-status') ) {
				// special case for image previews
				val = $element.html();
			} else if ( 'checkbox' === elType || 'radio' === elType ) {
				val = $element.is(':checked');
			} else if ( 'select' === $element.prop('tagName') ) {
				val = $element.is(':selected');
			} else {
				val = $element.val();
			}

			// Get all the current values per element
			inputVals.push( { val: val, $: $element } );
		});
		// And swap them all
		$goto.find( rstheme.repeatEls ).each( function( index ) {
			var $element = $( this );
			var elType = $element.attr( 'type' );
			var val;

			if ( $element.hasClass('rstheme-media-status') ) {
				var toRowId = $element.closest('.rstheme-repeatable-grouping').attr('data-iterator');
				var fromRowId = inputVals[ index ].$.closest('.rstheme-repeatable-grouping').attr('data-iterator');

				// special case for image previews
				val = $element.html();
				$element.html( inputVals[ index ].val );
				inputVals[ index ].$.html( val );

				inputVals[ index ].$.find( 'input' ).each(function() {
					var name = $( this ).attr( 'name' );
					name = name.replace( '['+toRowId+']', '['+fromRowId+']' );
					$( this ).attr( 'name', name );
				});
				$element.find('input').each(function() {
					var name = $( this ).attr('name');
					name = name.replace('['+fromRowId+']', '['+toRowId+']');
					$( this ).attr('name', name);
				});

			}
			// handle checkbox swapping
			else if ( 'checkbox' === elType  ) {
				inputVals[ index ].$.prop( 'checked', $element.is(':checked') );
				$element.prop( 'checked', inputVals[ index ].val );
			}
			// handle radio swapping
			else if ( 'radio' === elType  ) {
				if ( $element.is( ':checked' ) ) {
					inputVals[ index ].$.attr( 'data-checked', 'true' );
				}
				if ( inputVals[ index ].$.is( ':checked' ) ) {
					$element.attr( 'data-checked', 'true' );
				}
			}
			// handle select swapping
			else if ( 'select' === $element.prop('tagName') ) {
				inputVals[ index ].$.prop( 'selected', $element.is(':selected') );
				$element.prop( 'selected', inputVals[ index ].val );
			}
			// handle normal input swapping
			else {
				inputVals[ index ].$.val( $element.val() );
				$element.val( inputVals[ index ].val );
			}
		});

		$from.find( 'input[data-checked=true]' ).prop( 'checked', true ).removeAttr( 'data-checked' );
		$goto.find( 'input[data-checked=true]' ).prop( 'checked', true ).removeAttr( 'data-checked' );

		// trigger color picker change event
		$from.find( 'input[type="text"].rstheme-colorpicker' ).trigger( 'change' );
		$goto.find( 'input[type="text"].rstheme-colorpicker' ).trigger( 'change' );

		// shift done
		rstheme.triggerElement( $this, 'rstheme_shift_rows_complete', $this, $from, $goto );
	};

	rstheme.initPickers = function( $timePickers, $datePickers, $colorPickers ) {
		// Initialize jQuery UI timepickers
		rstheme.initDateTimePickers( $timePickers, 'timepicker', 'time_picker' );
		// Initialize jQuery UI datepickers
		rstheme.initDateTimePickers( $datePickers, 'datepicker', 'date_picker' );
		// Initialize color picker
		rstheme.initColorPickers( $colorPickers );
	};

	rstheme.initDateTimePickers = function( $selector, method, defaultKey ) {
		if ( $selector.length ) {
			$selector[ method ]( 'destroy' ).each( function() {
				var $this     = $( this );
				var fieldOpts = $this.data( method ) || {};
				var options   = $.extend( {}, rstheme.defaults[ defaultKey ], fieldOpts );
				$this[ method ]( rstheme.datePickerSetupOpts( fieldOpts, options, method ) );
			} );
		}
	};

	rstheme.datePickerSetupOpts = function( fieldOpts, options, method ) {
		var existing = $.extend( {}, options );

		options.beforeShow = function( input, inst ) {
			if ( 'timepicker' === method ) {
				rstheme.addTimePickerClasses( inst.dpDiv );
			}

			// Wrap datepicker w/ class to narrow the scope of jQuery UI CSS and prevent conflicts
			$id( 'ui-datepicker-div' ).addClass( 'rstheme-element' );

			// Let's be sure to call beforeShow if it was added
			if ( 'function' === typeof existing.beforeShow ) {
				existing.beforeShow( input, inst );
			}
		};

		if ( 'timepicker' === method ) {
			options.onChangeMonthYear = function( year, month, inst, picker ) {
				rstheme.addTimePickerClasses( inst.dpDiv );

				// Let's be sure to call onChangeMonthYear if it was added
				if ( 'function' === typeof existing.onChangeMonthYear ) {
					existing.onChangeMonthYear( year, month, inst, picker );
				}
			};
		}

		options.onClose = function( dateText, inst ) {
			// Remove the class when we're done with it (and hide to remove FOUC).
			var $picker = $id( 'ui-datepicker-div' ).removeClass( 'rstheme-element' ).hide();
			if ( 'timepicker' === method && ! $( inst.input ).val() ) {
				// Set the timepicker field value if it's empty.
				inst.input.val( $picker.find( '.ui_tpicker_time' ).text() );
			}

			// Let's be sure to call onClose if it was added
			if ( 'function' === typeof existing.onClose ) {
				existing.onClose( dateText, inst );
			}
		};

		return options;
	};

	// Adds classes to timepicker buttons.
	rstheme.addTimePickerClasses = function( $picker ) {
		var func = rstheme.addTimePickerClasses;
		func.count = func.count || 0;

		// Wait a bit to let the timepicker render, since these are pre-render events.
		setTimeout( function() {
			if ( $picker.find( '.ui-priority-secondary' ).length ) {
				$picker.find( '.ui-priority-secondary' ).addClass( 'button-secondary' );
				$picker.find( '.ui-priority-primary' ).addClass( 'button-primary' );
				func.count = 0;
			} else if ( func.count < 5 ) {
				func.count++;
				func( $picker );
			}
		}, 10 );
	};

	rstheme.initColorPickers = function( $selector ) {
		if ( ! $selector.length ) {
			return;
		}
		if ( typeof jQuery.wp === 'object' && typeof jQuery.wp.wpColorPicker === 'function' ) {

			$selector.each( function() {
				var $this = $( this );
				var fieldOpts = $this.data( 'colorpicker' ) || {};
				$this.wpColorPicker( $.extend( {}, rstheme.defaults.color_picker, fieldOpts ) );
			} );

		} else {
			$selector.each( function( i ) {
				$( this ).after( '<div id="picker-' + i + '" style="z-index: 1000; background: #EEE; border: 1px solid #CCC; position: absolute; display: block;"></div>' );
				$id( 'picker-' + i ).hide().farbtastic( $( this ) );
			} )
			.focus( function() {
				$( this ).next().show();
			} )
			.blur( function() {
				$( this ).next().hide();
			} );
		}
	};

	rstheme.initCodeEditors = function( $selector ) {
		if ( ! rstheme.defaults.code_editor || ! wp || ! wp.codeEditor || ! $selector.length ) {
			return;
		}


		$selector.each( function() {
			wp.codeEditor.initialize(
				this.id,
				rstheme.codeEditorArgs( $( this ).data( 'codeeditor' ) )
			);
		} );
	};

	rstheme.codeEditorArgs = function( overrides ) {
		var props = [ 'codemirror', 'csslint', 'jshint', 'htmlhint' ];
		var args = $.extend( {}, rstheme.defaults.code_editor );
		overrides = overrides || {};

		for ( var i = props.length - 1; i >= 0; i-- ) {
			if ( overrides.hasOwnProperty( props[i] ) ) {
				args[ props[i] ] = $.extend( {}, args[ props[i] ] || {}, overrides[ props[i] ] );
			}
		}

		return args;
	};

	rstheme.makeListSortable = function() {
		var $filelist = rstheme.metabox().find( '.rstheme-media-status.rstheme-attach-list' );
		if ( $filelist.length ) {
			$filelist.sortable({ cursor: 'move' }).disableSelection();
		}
	};

	rstheme.maybeOembed = function( evt ) {
		var $this = $( this );

		var m = {
			focusout : function() {
				setTimeout( function() {
					// if it's been 2 seconds, hide our spinner
					rstheme.spinner( '.rstheme-metabox', true );
				}, 2000);
			},
			keyup : function() {
				var betw = function( min, max ) {
					return ( evt.which <= max && evt.which >= min );
				};
				// Only Ajax on normal keystrokes
				if ( betw( 48, 90 ) || betw( 96, 111 ) || betw( 8, 9 ) || evt.which === 187 || evt.which === 190 ) {
					// fire our ajax function
					rstheme.doAjax( $this, evt );
				}
			},
			paste : function() {
				// paste event is fired before the value is filled, so wait a bit
				setTimeout( function() { rstheme.doAjax( $this ); }, 100);
			}
		};

		m[ evt.type ]();
	};

	/**
	 * Resize oEmbed videos to fit in their respective metaboxes
	 */
	rstheme.resizeoEmbeds = function() {
		rstheme.metabox().each( function() {
			var $this      = $( this );
			var $tableWrap = $this.parents('.inside');
			var isSide     = $this.parents('.inner-sidebar').length || $this.parents( '#side-sortables' ).length;
			var isSmall    = isSide;
			var isSmallest = false;
			if ( ! $tableWrap.length )  {
				return true; // continue
			}

			// Calculate new width
			var tableW = $tableWrap.width();

			if ( rstheme.styleBreakPoint > tableW ) {
				isSmall    = true;
				isSmallest = ( rstheme.styleBreakPoint - 62 ) > tableW;
			}

			tableW = isSmall ? tableW : Math.round(($tableWrap.width() * 0.82)*0.97);
			var newWidth = tableW - 30;
			if ( isSmall && ! isSide && ! isSmallest ) {
				newWidth = newWidth - 75;
			}
			if ( newWidth > 639 ) {
				return true; // continue
			}

			var $embeds   = $this.find('.rstheme-type-oembed .embed-status');
			var $children = $embeds.children().not('.rstheme-remove-wrapper');
			if ( ! $children.length ) {
				return true; // continue
			}

			$children.each( function() {
				var $this     = $( this );
				var iwidth    = $this.width();
				var iheight   = $this.height();
				var _newWidth = newWidth;
				if ( $this.parents( '.rstheme-repeat-row' ).length && ! isSmall ) {
					// Make room for our repeatable "remove" button column
					_newWidth = newWidth - 91;
					_newWidth = 785 > tableW ? _newWidth - 15 : _newWidth;
				}
				// Calc new height
				var newHeight = Math.round((_newWidth * iheight)/iwidth);
				$this.width(_newWidth).height(newHeight);
			});

		});
	};

	/**
	 * Safely log things if query var is set
	 * @since  1.0.0
	 */
	rstheme.log = function() {
		if ( l10n.script_debug && console && typeof console.log === 'function' ) {
			console.log.apply(console, arguments);
		}
	};

	rstheme.spinner = function( $context, hide ) {
		var m = hide ? 'removeClass' : 'addClass';
		$('.rstheme-spinner', $context )[ m ]( 'is-active' );
	};

	// function for running our ajax
	rstheme.doAjax = function( $obj ) {
		// get typed value
		var oembed_url = $obj.val();
		// only proceed if the field contains more than 6 characters
		if ( oembed_url.length < 6 ) {
			return;
		}

		// get field id
		var field_id         = $obj.attr('id');
		var $context         = $obj.closest( '.rstheme-td' );
		var $embed_container = $context.find( '.embed-status' );
		var $embed_wrap      = $context.find( '.embed_wrap' );
		var $child_el        = $embed_container.find( ':first-child' );
		var oembed_width     = $embed_container.length && $child_el.length ? $child_el.width() : $obj.width();

		rstheme.log( 'oembed_url', oembed_url, field_id );

		// show our spinner
		rstheme.spinner( $context );
		// clear out previous results
		$embed_wrap.html('');
		// and run our ajax function
		setTimeout( function() {
			// if they haven't typed in 500 ms
			if ( $( '.rstheme-oembed:focus' ).val() !== oembed_url ) {
				return;
			}
			$.ajax({
				type : 'post',
				dataType : 'json',
				url : l10n.ajaxurl,
				data : {
					'action'          : 'rstheme_oembed_handler',
					'oembed_url'      : oembed_url,
					'oembed_width'    : oembed_width > 300 ? oembed_width : 300,
					'field_id'        : field_id,
					'object_id'       : $obj.data( 'objectid' ),
					'object_type'     : $obj.data( 'objecttype' ),
					'rstheme_ajax_nonce' : l10n.ajax_nonce
				},
				success: function(response) {
					rstheme.log( response );
					// hide our spinner
					rstheme.spinner( $context, true );
					// and populate our results from ajax response
					$embed_wrap.html( response.data );
				}
			});

		}, 500);

	};

	rstheme.trigger = function( evtName ) {
		var args = Array.prototype.slice.call( arguments, 1 );
		args.push( rstheme );
		$document.trigger( evtName, args );
	};

	rstheme.triggerElement = function( $el, evtName ) {
		var args = Array.prototype.slice.call( arguments, 2 );
		args.push( rstheme );
		$el.trigger( evtName, args );
	};

	rstheme.replaceLast = function( string, search, replace ) {
		// find the index of last time word was used
		var n = string.lastIndexOf( search );

		// slice the string in 2, one from the start to the lastIndexOf
		// and then replace the word in the rest
		return string.slice( 0, n ) + string.slice( n ).replace( search, replace );
	};

	rstheme.getFieldArg = function( hash, arg ) {
		return rstheme.getField( hash )[ arg ];
	};

	rstheme.getField = function( hash ) {
		hash = hash instanceof jQuery ? hash.data( 'hash' ) : hash;
		return hash && l10n.fields[ hash ] ? l10n.fields[ hash ] : {};
	};

	$( rstheme.init );

})(window, document, jQuery, window.RSTHEME);
