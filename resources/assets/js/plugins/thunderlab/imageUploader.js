/*
	=====================================================================
	imageUploader
	=====================================================================
	Version		: 0.1
	Author 		: Budi
	Requirement : jQuery, bootstrap 3 or 4 alpha 6, font awesome, 
					Thunder Cloner (load cloner first),
					Thunder imagePreviewer

	Notes:
	1. MAKE SURE TO REGISTER THIS PLUGINS BEFORE REQUIRED PLUGINS : CLONER & IMAGEPREVIEWER
	2. wrap your input file with div wrapper, with class selector 
		matching variable target_input_file_wrapper_class
	3. Notice: if you're using bs 4, please change "btn-default" class, to desired bs 4 btn class 
*/

var imageUploader = function(){

	/* --------------------------
	Setting & Parameter 
	-------------------------- */

	/* behavior */
	/*
		1. Upload Async Using Ajax
		Description 	: use ajax to upload or manually uploaded on form submit.
	*/	
	const upload_async_using_ajax = true;

	/*
		2. Validate On Remove
		Description 	: validate on remove image.
	*/	
	const validate_on_remove = true;	

	/*
		3. Validate On Upload Image
		Description 	: validate on image upload.
	*/	
	const validate_on_upload_image = true;	


	/* overrides core settings */
	/*
		1. Target Input File Wrapper Class
		Description 	: form html class selector that will be set up with imageUploader.
	*/	
	const target_input_file_wrapper_class = 'thunder-imgUploader';

	/*
		2. Target Title Attribute
		Description 	: Html class selector that will be used as Title.
	*/
	const target_title_attribute = 'thunder-imgUploader-title';	

	/*
		3. Target Subtitle Attribute
		Description 	: Html class selector that will be used as Sub-Title.
	*/
	const target_subtitle_attribute = 'thunder-imgUploader-subtitle';	

	/*
		4. Target Button Upload Attribute
		Description 	: Html class selector that trigger upload image.
	*/
	const target_btn_upload_attribute = 'thunder-imgUploader-btn-upload';

	/*
		5. Target Button Remove Uploaded Attribute
		Description 	: Html class selector that trigger remove uploaded image.
	*/
	const target_btn_remove_attribute = 'thunder-imgUploader-btn-remove';

	/*
		6. Target Input File
		Description 	: Target input file class name
	*/
	const target_input_file ='thunder-imageUploader-input';

	/*
		7. Target Modal Id 
		Description 	: Target id of confirmation modal
	*/
	const target_modal_id ='thunder-imageUploader-confirmation-modal';

	/*
		8. Target Ajax Store Url 
		Description 	: Target attribute: ajax upload image url
	*/
	const target_ajax_store_url ='thunder-imageUploader-store-url';	

	/*
		8. Target Ajax Remove Url 
		Description 	: Target attribute: ajax remove image url
	*/
	const target_ajax_remove_url ='thunder-imageUploader-remove-url';	

	/* Cloner Setup */
	/*
		1. Append section
	*/
	const cloner_parent = 'thunder-cloner-data';

	/*
		2. Appended section
	*/
	const cloner_data = 'thunder-cloner-data';



	/* Defaults */
	/*
		1. Default Title
	*/	
	const default_title = 'Unggah Foto';

	/*
		2. Default Sub Title
	*/	
	const default_subtitle = 'Pilih & Unggah Foto Anda Dengan Klik Tombol Unggah';

	/*
		3. Default Button Upload
	*/	
	const default_btn_upload = 'Unggah';


	/* --------------------------
	Html Template
	-------------------------- */
	/*
		Template file
		this is the default template, you can create your own template by editing template file.
		path : assets/imageUploader/template.html
	*/ 

	const html_template =  require('./assets/imageUploader/template.html');

	/*
		Modale Template
		this is the default template, you can create your own validation modal by editing file.
		path : assets/imageUploader/modal.html
	*/ 

	const html_modal =  require('./assets/imageUploader/modal.html');	

	/*
		Template Status Uploading
		this is the default template, you can create your own by editing file.
		path : assets/imageUploader/statusUploading.html
	*/ 

	const html_tmplate_status_uploading = require('./assets/imageUploader/statusUploading.html');	

	/*
		Template Status Fail
		this is the default template, you can create your own by editing file.
		path : assets/imageUploader/statusFail.html
	*/ 

	const html_tmplate_status_fail = require('./assets/imageUploader/statusFail.html');

	/*
		Template Status Uploaded
		this is the default template, you can create your own by editing file.
		path : assets/imageUploader/statusUploaded.html
	*/ 

	const html_tmplate_status_uploaded = require('./assets/imageUploader/statusUploaded.html');

	/*
		Template Status no Upload
		this is the default template, you can create your own by editing file.
		path : assets/imageUploader/noUpload.html
	*/ 

	const html_tmplate_status_no_upload = require('./assets/imageUploader/statusNoUpload.html');		

	/* --------------------------
	Core Engine
	-------------------------- */

	var el_pointer_helper = null;

	/* Interface Functions */
	this.init = function() {
		var el = $( document.getElementsByClassName(target_input_file_wrapper_class) );

		// init
		el.each(function() {
			// ui init
			uiInit($(this));
		});

		// event bindings
		// btn upload click
		$(document).on('click', '.' + target_btn_upload_attribute, function(e){
			$(e.target).closest('.' + target_input_file_wrapper_class).find('input:file').click();
		});

		// file changes
		$(document).on('change', '.' + target_input_file, function(e){
			addSelectedImage($(e.target));
		});

		// set modals
		$('body').append($(html_modal));

		// re-init plugins
		// no need, unless you're not using autoload then turn on following code
		// window.thunder.cloner.init();
		// window.thunder.imagePreviewer.init();
	}

	this.removeImage = function(el){
		// fuse: can't click on disabled
		if($(el).attr('disabled') == 'disabled'){
			return false;
		}

		// remove this
		if(validate_on_remove == true){
			// trigger validation
			$('#' + target_modal_id).modal('show');

			// set helpers
			el_pointer_helper = $(el);
		}else{		
			removeSelectedImage($(el));
		}
	}

	this.retryUpload = function(el){
		// get image fo re upload? for img maybe?
		ajaxStartUpload([], $(el).closest('.' + target_input_file_wrapper_class).attr(target_ajax_store_url), $(el).closest('.' + cloner_data));
	}

	this.removeValidated = function(){
		// this only happened if validation turned on
		if(el_pointer_helper != null){
			// do deletion
			if(upload_async_using_ajax == true){
				// ajaxRemoveImage(null,null);
				// uiRemoveImage(el_pointer_helper);
				removeSelectedImage(el_pointer_helper);
			}else{
				// ui remove
				removeSelectedImage(el_pointer_helper);
			}
		}else{
			console.log("%cError: imageUploader" + "\n" + "on: removeValidated" + "\n" + "detail: can't get value from el_pointer_helper"  , 'color: red;');
		}
	}


	/* --------------------------
	UI
	-------------------------- */
	var uiInit = function(el){
		// validate requirement
		var inp = el.find('input:file');
		if(inp.length > 0){
			// hide default input file
			var target = el.find('input:file'); 
			target.css('display', 'none');
			target.addClass(target_input_file);	
		}else{
			console.log("%cError: imageUploader" + "\n" + "on: Init" + "\n" + "detail: input file : image not found"  , 'color: red;');
			return false;
		}

		// get input information
		var inp_name = inp.attr('name');
		if(!inp_name || inp_name == ''){
			// validate input
			console.log("%cError: imageUploader" + "\n" + "on: Init" + "\n" + "detail: input file name not set" + "\n" +  "element id: " +  inp.attr('id') , 'color: red;');
			return false;
		}

		// append template to DOM
		el.append(html_template);

		// set template value to the real deal data		
		// set titles
		var header_el = el.find('#header');
		header_el.find('#title').text(el.attr(target_title_attribute) ? el.attr(target_title_attribute) : default_title);
		header_el.find('#subtitle').text(el.attr(target_subtitle_attribute) ? el.attr(target_subtitle_attribute) : default_subtitle);
		header_el.find('#btn-upload').text(el.attr(target_btn_upload_attribute) ? ' ' + el.attr(target_btn_upload_attribute) : ' ' + default_btn_upload);
		
		// deal with ajax
		if(upload_async_using_ajax){ 
			// set buttons     
			el.find('#content').find('#content-template').find('.' + target_btn_remove_attribute).attr('disabled', '');
			// set helpers
			el.find('#input-helper').attr('name', inp_name);
			inp.removeAttr('name');
		}
	}

	var addSelectedImage = function(el){
		// get all files
		$.map(el.prop('files'), function(_file) { 
			// validate image
			if(validate_on_upload_image == true){
				// if calidation fail
				if(1 == 0){
					return  false;
				}
			}

			// clone template
			var latest_append = drawUi();

			// set UI
			latest_append.find('#fileName').text(_file.name);
			var drawer =  window.thunder.imagePreviewer.preview(_file,latest_append.find('#canvas'));
			drawer.onloadend = function(){
				latest_append.find('#loader').remove();
			}

			// ajax upload?
			if(upload_async_using_ajax == true){
				// call upload function
				ajaxStartUpload(_file, el.closest('.' + target_input_file_wrapper_class).attr(target_ajax_store_url), latest_append);
			}else{
				var status = latest_append.find('#status');
				status.find('#uploading').css('display', 'none');
				status.find('#noUpload').css('display', 'block');
			}
		});

		// ui manage
		uiManagement(el.closest("." + target_input_file_wrapper_class).find("#content"));

		// modules
		function drawUi(){
			var content = el.closest('.' + target_input_file_wrapper_class).find('#content');
			return window.thunder.cloner.clone(content, content.find('#content-template'));
		}
	}

	var removeSelectedImage = function(el){
		// if ajax, remove data from server
		if(upload_async_using_ajax == true){
			// if ajax has error recently
			if(el.closest('.' + cloner_data).find('#failed').css('display') == 'none'){
				ajaxRemoveImage(null, null);
				return true;
			}
		}

		uiRemoveImage(el);
		return true;
	}

	var uiManagement = function(el){
		// get cloned number
		var ctr = el.find('.' + cloner_parent).length;

		if(ctr == 0){
			// display no data
			el.find('#default').css('display', 'block');
		}else{
			// hide display no data
			el.find('#default').css('display', 'none');
		}
	}

	function uiRemoveImage(el){
		// ui
		var parent_of_the_removed = el.closest('#content');
		window.thunder.cloner.remove(el.closest('.' + cloner_parent));

		// Ui management
		uiManagement(parent_of_the_removed);
	}

	function disableSubmitButton(el){

	}

	function enableSubmitButton(el){

	}

	/* --------------------------
	AJAX
	-------------------------- */
	var ajaxStartUpload = function(img, url, el){
	    var formData = new FormData();

	    // sets ui
	    var status = el.find('#status');
	    status.empty();
	    status.append($(html_tmplate_status_uploading).html());
		el.find('.' + target_btn_remove_attribute).attr('disabled', true);


	    // add assoc key values, this will be posts values
	    formData.append("file", img, img.filename);
	    formData.append("upload_file", true);

	    var _token = $(el).closest('form').find('#_token').val();

	    $.ajax({
	        type: "POST",
	        url: url,
	        headers: {
		        'X-CSRF-TOKEN': _token
		    },
	        xhr: function () {
	            var myXhr = $.ajaxSettings.xhr();
	            if (myXhr.upload) {
	                myXhr.upload.addEventListener('progress', progressHandling, false);
	            }
	            return myXhr;
	        },			
	        success: function (response) {
	            onSuccess(response);
	        },
	        error: function (error) {
	            onFail(error);
	        },
	        async: true,
	        data: formData,
	        cache: false,
	        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
	        processData: false,
	        timeout: 60000
		});

	    function uint8ToString(buf) {
		    var i, length, out = '';
		    for (i = 0, length = buf.length; i < length; i += 1) {
		        out += String.fromCharCode(buf[i]);
		    }
		    return out;
		}

		var onSuccess = function(response){
			status.empty();
		    status.append($(html_tmplate_status_uploaded).html());
			el.find('.' + target_btn_remove_attribute).attr('disabled', false);

			//set filesname
			console.log(response);
		}

		var onFail = function(response){
			status.empty();
		    status.append($(html_tmplate_status_fail).html());
			el.find('.' + target_btn_remove_attribute).attr('disabled', false);
		}
		var progressHandling = function (event) {
		    var percent = 0;
		    var position = event.loaded || event.position;
		    var total = event.total;
		    var progress_bar_id = "#progress-wrp";
		    if (event.lengthComputable) {
		        percent = Math.ceil(position / total * 100);
		    }
			el.find('#uploading').find('#progress').text(percent + '%');
		}		
	}

	var ajaxRemoveImage = function(filename, url){

	}
}

// This the interface
window.thunder.imageUploader = new imageUploader();