if( typeof tinymce != 'undefined' ) {
	tinymce.init({
		selector: 'textarea',
		height: 400,
		theme: 'modern',
		plugins: [
			'advlist autolink lists link charmap print preview hr anchor pagebreak',
			'searchreplace wordcount visualblocks visualchars code fullscreen',
			'insertdatetime media nonbreaking save table contextmenu directionality',
			'emoticons template paste textcolor colorpicker textpattern imagetools image'
		],
		toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor emoticons | fontsizeselect | template | pagebreak',
		fontsize_formats: "8px 10px 12px 14px 18px 24px 36px",
		toolbar2: '',
		templates: [
		    {title: 'Some title 1', description: 'Some desc 1', content: '<link href="http://localhost/bluenet_nap/assets/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/> <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> <link href="http://localhost/bluenet_nap/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" /> <link href="http://localhost/bluenet_nap/assets/plugins/material/material.min.css" rel="stylesheet" > <link href="http://localhost/bluenet_nap/assets/css/material_style.css" rel="stylesheet"> <link href="http://localhost/bluenet_nap/assets/css/style.css" rel="stylesheet" type="text/css" /> <link href="http://localhost/bluenet_nap/assets/css/plugins.min.css" rel="stylesheet" type="text/css" /> <link href="http://localhost/bluenet_nap/assets/css/responsive.css" rel="stylesheet" type="text/css" /> <link href="http://localhost/bluenet_nap/assets/css/page.css" rel="stylesheet" type="text/css" /> <link href="http://localhost/bluenet_nap/assets/css/jquery.growl.css" rel="stylesheet" type="text/css" /> <link href="http://localhost/bluenet_nap/assets/css/select2.css" rel="stylesheet" type="text/css" /> <link href="http://localhost/bluenet_nap/assets/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" /> <link href="http://localhost/bluenet_nap/assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" /> <link rel="stylesheet" href="http://localhost/bluenet_nap/assets/css/bootstrap-datetimepicker.min.css"> <div class="alert alert-danger">Yahoo!!</div>'},
		    
		],
		relative_urls : false,
		remove_script_host : false,
		convert_urls : true,
		pagebreak_split_block: true,
		pagebreak_separator: "<br pagebreak=\"true\"/>",
		image_list: [
						{title: 'leica logo', value: 'http://nap.bluenettech.com/assets/img/leica.png'},
						{title: 'danaher logo', value: 'http://nap.bluenettech.com/assets/img/danaher.png'},
						{title: 'danaher logo 2', value: 'http://nap.bluenettech.com/assets/img/danaher2.png'},
						{title: 'Signature Logo', value: 'http://nap.bluenettech.com/assets/img/signature.jpg'},
					  ],
		
  		images_upload_base_path: 'http://nap.bluenettech.com/assets/img/',
		images_upload_url: 'tiny_img_upload',
  		automatic_uploads: false,
		
		images_upload_handler: function (blobInfo, success, failure) {
			var xhr, formData;

			xhr = new XMLHttpRequest();
			xhr.withCredentials = false;
			xhr.open('POST', 'tiny_img_upload');

			xhr.onload = function() {
			  var json;

			  if (xhr.status != 200) {
				failure('HTTP Error: ' + xhr.status);
				return;
			  }

			  json = JSON.parse(xhr.responseText);

			  if (!json || typeof json.location != 'string') {
				failure('Invalid JSON: ' + xhr.responseText);
				return;
			  }
				console.log(json.location);
			  success('http://nap.bluenettech.com/assets/img/' + json.location);
			};

			formData = new FormData();
			formData.append('file', blobInfo.blob(), blobInfo.filename());

			xhr.send(formData);
		  }
	});
}