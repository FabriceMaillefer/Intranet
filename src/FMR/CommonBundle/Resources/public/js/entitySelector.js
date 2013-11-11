function ImageSelector(elem, actionOnClose, nomVariable) {
	this.onClose = actionOnClose;
	this.nomVariable = nomVariable;
	this.elem = elem;
	$(this.elem).invisible();
	$(this.elem).after('<a class="btn" href="#imageSelector" id="button_select_'+this.nomVariable+'" onclick="'+this.nomVariable+'.openDialog()">Choisir une image</a>');
	
	this.openDialog = function(){
		$.ajax({
		  url: window.URLS.dialog_image,
		  type: 'POST',
		  data: 'imageselector='+this.nomVariable,
		  parent: this,
		  success: function(data) {
	
			  $(data).dialog({'width':'700px',modal: true, close:function(){$('#dialog').remove();}
			  });
			 this.parent.refreshImageList();
		  }
		 });
	}
	
	this.uploadAction = function(){
	    var formData = new FormData($('form#form_upload')[0]);
	    $.ajax({
	        url: window.URLS.upload_image,  //server script to process data
	        type: 'POST',
	        xhr: function() {  // custom xhr
	            myXhr = $.ajaxSettings.xhr();
	            if(myXhr.upload){ // check if upload property exists
	                myXhr.upload.addEventListener('progress',this.progressHandlingFunction, false); // for handling the progress of the upload
	            }
	            return myXhr;
	        },
	        beforeSend: this.beforeSendHandler,
	        success: this.completeHandler,
	        error: this.errorHandler,
	        // Form data
	        data: formData,
	        parent: this,
	        //Options to tell JQuery not to process data or worry about content-type
	        cache: false,
	        contentType: false,
	        processData: false
	    });
	}
	
	this.beforeSendHandler = function (){
			//$('#status_upload').visible();
			$('#status_upload').html("Upload en cours...");
	}
	this.completeHandler =	function (jqXHR){
			$('progress').removeAttr("value");
			if(jqXHR == "OK") {
				$('#status_upload').html("Upload terminé !");
				this.parent.refreshImageList();
				$('#status_upload').invisible();
				$('form#form_upload')[0].reset();
			} else {
				$('#status_upload').html(jqXHR);
			}
		}
	this.errorHandler = function(jqXHR, textStatus, errorThrown) {
			$('progress').removeAttr("value");
			$('#status_upload').html("Erreur!! "+jqXHR.responseText);
		}
	this.progressHandlingFunction = function (e){
		    if(e.lengthComputable){
		        $('progress').attr({value:e.loaded,max:e.total});
		    }
		}
	this.refreshImageList = function(){
		$.ajax({
		  url: window.URLS.list_image,
		  type: 'POST',
		  data: 'imageselector='+this.nomVariable,
		  success: function(data, textStatus, jqXHR) {
			  $('#container_list_image').html('');
			  $('#container_list_image').html(data);
		  }
		 });
	}
	this.searchImage = function(elem){
		$.ajax({
		  url: window.URLS.list_image,
		  type: 'POST',
		  data: 'q='+elem.value+'&imageselector='+this.nomVariable,
		  success: function(data, textStatus, jqXHR) {
		  	  $('#container_list_image').html('');
			  $('#container_list_image').html(data);
		  }
		 });
	}
	this.deleteImage  = function(id){
		$.ajax({
		  url: window.URLS.delete_image,
		  type: 'POST',
		  data: 'id='+id+'&imageselector='+this.nomVariable,
		  parent: this,
		  success: function(data, textStatus, jqXHR) {
			  $('#container_list_image').html('').html(data);
			  $('#rendu_image').html('');
			  this.parent.refreshImageList();
		  }
		 });
	}
	this.selectImage = function(url,name,id,elem){
		$(elem).emphase();
		$('#rendu_image').html('<img src="'+url+'" /><div>'+name+'</div><button onclick="'+this.nomVariable+'.deleteImage('+id+')" class="btn btn-danger">Supprimmer</button> <button onclick="'+this.nomVariable+'.choisirImage('+id+',\''+url+'\',\''+escape(name)+'\')" class="btn btn-primary">Choisir</button>')
	}
	 this.choisirImage = function(id, url, nom){
			
			$('#button_select_'+this.nomVariable).html('Image '+unescape(nom)+' choisie. Changer ?');
			
			this.onClose(id, url, unescape(nom));

			$('#dialog').dialog( "close" );	
			$('#dialog').remove();
		}
}

(function($) {
	$.fn.emphase = function() {
		$('.img_selected').removeClass("img_selected");
        return this.each(function() {
            $(this).addClass("img_selected")
        });
    };
    $.fn.invisible = function() {
        return this.each(function() {
            $(this).css("display", "none");
        });
    };
    $.fn.visible = function() {
        return this.each(function() {
            $(this).css("display", "block");
        });
    };
}(jQuery));