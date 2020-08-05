// JavaScript Document
(function () {
	tinymce.PluginManager.add('scrollmagic', function (editor, url) {

		editor.addButton('scrollmagic_sequence', {
			text: '',
            id: 'bb_scrollmagic_sequence',
			tooltip: 'Image sequence',
			image: BB_SM.BB_SMIMSQ_ICON,
			onclick: function () {
				// Open window
                var body = [
						{type: 'textbox', name: 'images', label: 'Images (IDs separated by commas)'},
						{type: 'textbox', name: 'scenes', label: 'Scenes (Classes separated by spacing)', tooltip: 'Enter list Class CSS of Scenes separated by spacing'},
						{
							type: 'listbox',
							name: 'align',
							label: 'Align',
							'values': [
								{text: 'Left', value: 'left'},
								{text: 'Center', value: 'center'},
								{text: 'Right', value: 'right'},
							],
						},
					];

				body = body.concat();

				editor.windowManager.open({
					title: 'Image sequence',
					body: body,
					onsubmit: function (e) {

						var images = e.data.images;
						var align = e.data.align;
						var scenes = e.data.scenes;

						editor.insertContent('[scrollmagic_sequence scenes="'+scenes+'" align="'+align+'"  images="'+images+'"][/scrollmagic_sequence]');
					}
				});
			}
		});
		
		editor.addButton('scrollmagic_imagegroup', {
			text: '',
            id: 'bb_scrollmagic_imagegroup',
			tooltip: 'Image Group specifies the horizontal alignment of Single Image',
			image: BB_SM.BB_SM_IMAGE_GROUP,
			onclick: function () {
				// Open window
                var body = [
						{type: 'textbox', name: 'scenes', label: 'Scenes (Classes separated by spacing)', tooltip: 'Enter list Class CSS of Scenes separated by spacing'},
						{
							type: 'listbox',
							name: 'align',
							label: 'Align',
							'values': [
								{text: 'Left', value: 'left'},
								{text: 'Center', value: 'center'},
								{text: 'Right', value: 'right'},
							],
						},
					];

				body = body.concat();

				editor.windowManager.open({
					title: 'Image Group',
					body: body,
					onsubmit: function (e) {

						var align = e.data.align;
						var scenes = e.data.scenes;
						var selected_text = editor.selection.getContent();

						editor.insertContent('[scrollmagic_imagegroup scenes="'+scenes+'"  align="' + align + '"]' + selected_text + '[/scrollmagic_imagegroup]');
					}
				});
			}
		});
		
		editor.addButton('scrollmagic_image', {
			text: '',
            id: 'bb_scrollmagic_image',
			tooltip: 'Single Image & SVG file',
			image: BB_SM.BB_SM_SINGLE_IMAGE,
			onclick: function () {
				// Open window
                var body = [
						
						{type: 'textbox', name: 'scenes', label: 'Scenes (Classes separated by spacing)', tooltip: 'Enter list Class CSS of Scenes separated by spacing'},
						{type: 'textbox', name: 'image', label: 'Image ID', tooltip: 'Enter ID of Image'},

					];

				body = body.concat();

				editor.windowManager.open({
					title: 'Single Image & SVG file',
					body: body,
					onsubmit: function (e) {

						var image = e.data.image;
						var scenes = e.data.scenes;

						editor.insertContent('[scrollmagic_image scenes="'+scenes+'"  image="' + image + '"][/scrollmagic_image]');
					}
				});
			}
		});

		editor.addButton('scrollmagic', {
			text: '',
            id: 'bb_scrollmagic',
			tooltip: 'ScrollMagic',
			image: BB_SM.BB_SM_ICON,
			onclick: function () {
				// Open window
                var body = [

						{type: 'textbox', name: 'scenes', label: 'Scenes (Classes separated by spacing)', tooltip: 'Enter list Class CSS of Scenes separated by spacing'},
						
						{type: 'textbox', name: 'content', label: 'Content', multiline: true, tooltip: 'Content in ScrollMagic'},
						
						{
							type: 'listbox',
							name: 'align',
							label: 'Align',
							'values': [
								{text: 'Left', value: 'left'},
								{text: 'Center', value: 'center'},
								{text: 'Right', value: 'right'},
							],
						},
					];

				body = body.concat();

				editor.windowManager.open({
					title: 'Scroll Magic',
					body: body,
					onsubmit: function (e) {

						var scenes = e.data.scenes;
						var align = e.data.align;
						var content = e.data.content;
						var selected_text = editor.selection.getContent();

						editor.insertContent('[scrollmagic scenes="' + scenes + '" align="' + align + '"]' + selected_text + content + '[/scrollmagic]');
					}
				});
			}
		});
		
	});

})();
