jQuery(document).ready(function($){
	$("#search-panel, #internal-toggle, #link-options div:eq(0) span, #link-options div:eq(1), #link-options div:eq(2)").css("display", "none");
	$("#amu_content_ifr").ready(function () {
        setInterval(function(){
			var tinymceval = $('#amu_content_ifr').contents().find('body').text();
			var newlines = 0;
			$('#amu_content_ifr').contents().find('body').find("p").each(function(){
				if($(this).text()!="")
					newlines++;
			});
			if(newlines>0)
				newlines--;
            var wordscount = tinymceval.split(" ");
			var count = 0;
			if(wordscount[0]!="")
				count = wordscount.length
            $("#editorcounter").text(count+newlines);
			if(count+newlines>150)
				$("#editorcounter").addClass("limitexceeded");
			else
				$("#editorcounter").removeClass("limitexceeded");
        }, 100)
    });
	function roundNumber(num, dec)
	{
		var result = Math.round( Math.round( num * Math.pow( 10, dec + 1 ) ) / Math.pow( 10, 1 ) ) / Math.pow(10,dec);
		return result;
	}
	function updateUploadifySettings(uploader)
	{
		if(typeof(uploader.attr("data"))!="undefined")
		{
			var uploadifySettings = uploader.uploadifySettings("scriptData");
			var customData = eval('({' + uploader.attr("data") + '})');
			var data="";
			for(var name in customData)
			{
				data += "'" + name + "':";
				if(customData[name].substr(0,9)=="selector:")
					data += "'" + $(customData[name].substr(9).toString()).val() + "',";
				else
					data += "'" + customData[name] + "',";
			}
			data = data.substr(0, data.length-1);
			data = eval('({' + data + '})');
			uploader.uploadifySettings("scriptData", $.extend(uploadifySettings, data));
		}
	}
	function preventSubmit(event)
	{
		event.preventDefault();
	}
	function submitForm(event)
	{
		event.preventDefault();
		var self = event.data.uploader;
		updateUploadifySettings(self);
		var queue;
		if(typeof(self.attr("queueId"))!="undefined")
			queue = $("#"+self.attr("queueId"));
		else
			queue = $("#" + self.attr("id") + "Queue");
		if(parseInt($("#editorcounter").text())>150)
		{
			alert("Max number of words in content are is 150. Please remove exceeded.");
			$(this).one("submit", {'uploader':self}, submitForm);
		}
		else
		{
			$("#link-target-checkbox").attr("checked", "checked");
			if(queue.children().length>0 && queue.find("[name='attach_id[]']").length!=queue.children().length)
			{
				if(typeof(self.attr("filesLimit"))!="undefined" && queue.children().length>parseInt(self.attr("filesLimit")))
				{
					alert("The queue is full. The max size is " + parseInt(self.attr("filesLimit")) + ". Please remove exceeded.");
					$(this).one("submit", {'uploader':self}, submitForm);
				}
				else
				{
					var uploadifySettings = self.uploadifySettings("scriptData");
					var formData = $(this).serializeArray();
					var formDataJSON = {};
					for(var i=0; i<formData.length; i++)
						formDataJSON[formData[i].name] = formData[i].value;
					self.uploadifySettings("scriptData", $.extend(uploadifySettings, formDataJSON));
					if(typeof(self.attr("ajaxLoaderId"))!="undefined")
						$("#"+self.attr("ajaxLoaderId")).css("display", "inline");
					$(this).bind("submit", preventSubmit);
					$("html, body").animate({scrollTop: queue.offset().top-100}, 400);
					self.uploadifyUpload();
				}
			}
			else
			{
				if(typeof(self.attr("filesMin"))=="undefined" || queue.find("[name='attach_id[]']").length>=parseInt(self.attr("filesMin")))
				{
					$(this).append("<input type='hidden' name='savedata' value='" + self.attr("savedata") + "' /><input type='hidden' name='posttype' value='" + self.attr("posttype") + "' /><input type='hidden' name='attachimages' value='" + self.attr("attachimages") + "' /><input type='hidden' name='requiredfields' value='" + self.attr("requiredfields") + "' /><input type='hidden' name='sendemail' value='" + self.attr("sendemail") + "' />");
					if(typeof(self.attr("ajax"))!="undefined" && self.attr("ajax")=="true")
					{
						var data = $(this).serializeArray();
						data.savedata = self.attr("savedata");
						data.attachimages = self.attr("attachimages");
						var method = $(this).attr("method");
						var form = $(this);
						var url = (form.attr("action")=="" ? config.ajaxurl : form.attr("action"));
						if(typeof(self.attr("ajaxLoaderId"))!="undefined")
							$("#"+self.attr("ajaxLoaderId")).css("display", "inline");
						if(typeof(data.action)=="undefined")
							data.push({name: "action", value: "amu_submit"});
						data.push({name: "ajax", value: 1});
						$.ajax({
							url: url,
							data: data,
							dataType: 'html',
							type: method,
							async: false,
							success: function(json){
								json = $.trim(json);
								var indexStart = json.indexOf("amu_start")+9;
								var indexEnd = json.indexOf("amu_end")-indexStart;
								json = $.parseJSON(json.substr(indexStart, indexEnd));
								if(typeof(self.attr("ajaxInfoId"))!="undefined")
								{
									$("#"+self.attr("ajaxInfoId")).html("");
									$("#"+self.attr("ajaxInfoId")).removeClass("amu_message").removeClass("amu_error");
									if(typeof(json.error)=="undefined" || json.error=="" || json.error==null)
										$("#"+self.attr("ajaxInfoId")).addClass("amu_message");
									else
										$("#"+self.attr("ajaxInfoId")).addClass("amu_error");
									$("#"+self.attr("ajaxInfoId")).html((typeof(json.error)=="undefined" || json.error=="" || json.error==null ? json.message : json.error)).css("display", "block");
									//alert((typeof(json.error)=="undefined" || json.error=="" || json.error==null ? json.message : json.error));
									$("html, body").animate({scrollTop: $("#"+self.attr("ajaxInfoId")).offset().top}, 400);
								}
								if(typeof(json.error)=="undefined" || json.error=="" || json.error==null)
								{
									form[0].reset();
									$("[name='AMUFiles[]']").remove();
									if(typeof(self.attr("queueId"))!="undefined")
										$("#"+self.attr("queueId")).html("");
									else
										$("#" + self.attr("id") + "Queue").html("");
								}
								if(typeof(self.attr("ajaxLoaderId"))!="undefined")
									$("#"+self.attr("ajaxLoaderId")).css("display", "none");
								form.one("submit", {'uploader':self}, submitForm);
							}
						});
					}
					else
						$(this).submit();
				}
				else
				{
					alert("Select at least " + parseInt(self.attr("filesMin")) + " file(s) for upload.");
					$(this).one("submit", {'uploader':self}, submitForm);
				}
			}
		}
	}
	$(".AMU").each(function(index){
		var self = $(this);
		self.attr("id", "AMU"+index);
		if(typeof(self.attr("startOn"))!="undefined")
		{
			if(self.attr("startOn")=="manually")
			{
				self.after("<input type='button' value='" + (typeof(self.attr("buttonCaption"))=="undefined" ? '':self.attr("buttonCaption")) + "' id='AMU"+index+"start' class='uploadButton' />");
				$("#AMU"+index+"start").click(function(){
					updateUploadifySettings(self);
					self.uploadifyUpload();					
				});
			}
			else if(self.attr("startOn").substr(0, 8)=="onSubmit")
				$("#"+self.attr("startOn").substr(9)).one("submit", {'uploader':self}, submitForm);
		}
		var fileExt = "";
		if(typeof(self.attr("fileExt"))!="undefined")
		{
			var fileExtSplit = self.attr("fileExt").split(",");
			for(var i=0; i<fileExtSplit.length; i++)
			{
				fileExt += "*."+fileExtSplit[i];
				if(i+1<fileExtSplit.length)
					fileExt += ";";
			}
		}
		var fileDesc = "";
		if(typeof(self.attr("fileDesc"))!="undefined")
			fileDesc = self.attr("fileDesc");
		var buttonImg = "";
		if(typeof(self.attr("button"))!="undefined")
			buttonImg = self.attr("button");
		var bwidth = 120;
		if(typeof(self.attr("bwidth"))!="undefined")
			bwidth = self.attr("bwidth");
		var bheight = 30;
		if(typeof(self.attr("bheight"))!="undefined")
			bheight = self.attr("bheight");
		var buttonText = "SELECT FILES";
		if(typeof(self.attr("buttonText"))!="undefined")
			buttonText = self.attr("buttonText");
		var customQueueId = "";
		if(typeof(self.attr("queueId"))!="undefined")
			customQueueId = self.attr("queueId");
		var maxSize = "";
		if(typeof(self.attr("maxSize"))!="undefined")
			maxSize = self.attr("maxSize");
		var uploadScript = "upload.php";
		if(typeof(self.attr("uploadScript"))!="undefined")
			uploadScript = self.attr("uploadScript");
		var wmode = "transparent";
		if(typeof(self.attr("wmode"))!="undefined")
			wmode = self.attr("wmode");
		var filesLimit = 999;
		if(typeof(self.attr("filesLimit"))!="undefined")
			filesLimit = self.attr("filesLimit");
		var sessionId = "";
		if(typeof(self.attr("sessionId"))!="undefined")
			sessionId = self.attr("sessionId");
		var ajax = "false";
		if(typeof(self.attr("ajax"))!="undefined")
			ajax = self.attr("ajax");
		var method= "post";
		if(typeof(self.attr("method"))!="undefined")
			method = self.attr("method");
			
		var scriptData = "'action':'upload', 'path':'"+self.attr('path')+"', 'PHPSESSID':'"+sessionId+"'";
		if(typeof(self.attr("thumbnails"))!="undefined")
			scriptData += ", 'thumbnails':'" + self.attr("thumbnails") + "'";
		if(typeof(self.attr("thumbnailsCrop"))!="undefined")
			scriptData += ", 'thumbnailsCrop':'" + self.attr("thumbnailsCrop") + "'";
		self.uploadify({
			'uploader'  : amuurl+'/js/upload.swf',
			'script'    : uploadScript,
			'scriptData': eval('({' + scriptData + '})'),
			'queueID'	: customQueueId,
			'cancelImg' : amuurl+'/close.png',
			'displayData' : (self.attr("onprogress")=="speed" ? "speed":"percentage"),
			'fileExt'	: fileExt,
			'fileDesc'	: fileDesc,
			'method'	: method,
			'buttonImg'	: buttonImg,
			'buttonText': buttonText,
			'wmode'		: wmode,
			'width'		: bwidth,
			'height'	: bheight,
			'sizeLimit'	: maxSize,
			'hideButton': (self.attr("hideButton")=="true" ? true:false),
			'auto'      : (self.attr("startOn")=="auto" ? true:false),
			'multi'		: (self.attr("multi")=="true" ? true:false), 
			'queueSizeLimit' : filesLimit,
			'onSelect' : function(event, queueId, fileObj){
				if(self.attr("multi")!="true")
					if($("#"+queueId).html()!="")
						if(customQueueId!="")
							$("#"+customQueueId).html("");
						else
							$("#" + self.attr("id") + "Queue").html("");
			},
			'onSelectOnce' : function(event, data){
				if(self.attr("startOn")=="auto")
					updateUploadifySettings(self);
			},
			'onComplete' : function(event, queueId, fileObj, response, data){
				var responseJSON = $.parseJSON(response);
				if(typeof(responseJSON.error)!="undefined")
				{
					$("#" + self.attr("id") + queueId).html(responseJSON.error);
					return false;
				}
				else
				{
					if(self.attr("startOn").substr(0, 8)=="onSubmit")
						$("#"+self.attr("startOn").substr(9)).append("<input type='hidden' name='AMUFiles[]' value='"+responseJSON.filename.replace("'", "%27")+"' />");
					if(self.attr("afterUpload")=="link" || self.attr("afterUpload")=="filename" || self.attr("afterUpload")=="image")
					{
						$("#" + self.attr("id") + queueId + " .uploadifyProgress").animate({opacity: 0}, 500, function(){$(this).remove();});
						$("#" + self.attr("id") + queueId).html((self.attr("allowRemove")=="true" ? "<div class='cancel'><input class='button_cancel' name='removeFile' filename='"+responseJSON.filename.replace("'", "%27")+"' type='button'></div>":"") + (self.attr("afterUpload")=="link" || self.attr("afterUpload")=="image" ? "<a href='" + responseJSON.path + responseJSON.filename.replace("'", "%27") + "' target='_blank'>":"") + (self.attr("afterUpload")=="image" && (responseJSON.extension.toLowerCase()=="jpg" || responseJSON.extension.toLowerCase()=="jpeg" || responseJSON.extension.toLowerCase()=="bmp" || responseJSON.extension.toLowerCase()=="png" || responseJSON.extension.toLowerCase()=="tiff" || responseJSON.extension.toLowerCase()=="gif")  ? "<img class='uploadedImage' src='" + responseJSON.path + responseJSON.filename.replace("'", "%27") +"' />":"<span class='fileName'>"+fileObj.name+"</span>") + (self.attr("afterUpload")=="link" || self.attr("afterUpload")=="image" ? "</a>":""));
						if(typeof(responseJSON.attach_id)!="undefined")
							$("#" + self.attr("id") + queueId).append("<input type='hidden' name='attach_id[]' value='"+responseJSON.attach_id+"' />");
						if(typeof(self.attr("thumbnailsAfterUpload"))!="undefined")
						{
							var thumbnailsAfterUploadSplit = self.attr("thumbnailsAfterUpload").split(",");
							for(var i=0; i<thumbnailsAfterUploadSplit.length; i++)
							{
								display = $.trim(thumbnailsAfterUploadSplit[i]);
								folder = responseJSON.path;
								if(display!="filename" && display!="image" && display!="link")
									$("#" + self.attr("id") + queueId).append("<span class='afterUploadThumbnail'>" + display + "</span>");
								else
									$("#" + self.attr("id") + queueId).append("<span class='afterUploadThumbnail'>" + (display=="link" || display=="image" ? "<a href='" + folder + responseJSON.thumbnails[i].replace("'", "%27") + "' target='_blank'>":"") + (display=="image" && (responseJSON.extension.toLowerCase()=="jpg" || responseJSON.extension.toLowerCase()=="jpeg" || responseJSON.extension.toLowerCase()=="bmp" || responseJSON.extension.toLowerCase()=="png" || responseJSON.extension.toLowerCase()=="tiff" || responseJSON.extension.toLowerCase()=="gif")  ? "<img class='uploadedThumbnail' src='" + folder + responseJSON.thumbnails[i].replace("'", "%27") + "' />":"<span class='fileName'>" + "thumb" + i + "_" + fileObj.name + "</span>") + (display=="link" || display=="image" ? "</a>":"") + "</span>");
							}
						}
						return false;
					}
				}
			},
			'onAllComplete' : function(event, data){
				if(typeof(self.attr("afterUpload"))!="undefined" && self.attr("afterUpload")!="link" && self.attr("afterUpload")!="filename"&& self.attr("afterUpload")!="image")
				{
					var message = self.attr("afterUpload");
					message = message.replace("AMUfilesUploaded", data.filesUploaded);
					message = message.replace("AMUerrors", data.errors);
					message = message.replace("AMUtotalSizeB", data.allBytesLoaded);
					message = message.replace("AMUtotalSizeKB", roundNumber(data.allBytesLoaded/1024, 2));
					message = message.replace("AMUtotalSizeMB", roundNumber(data.allBytesLoaded/1024/1024, 2));
					message = message.replace("AMUtotalSizeGB", roundNumber(data.allBytesLoaded/1024/1024/1024, 2));
					message = message.replace("AMUspeedB", roundNumber(Math.round(data.speed*1024), 2));
					message = message.replace("AMUspeedKB", roundNumber(Math.round(data.speed), 2));
					message = message.replace("AMUspeedMB", roundNumber(Math.round(data.speed/1024), 2));
					message = message.replace("AMUspeedGB", roundNumber(Math.round(data.speed/1024/1024), 2));
						$("#" + self.attr("id") + "Queue").html(message);
				}
				if(self.attr("startOn").substr(0, 8)=="onSubmit")
				{
					var form = $("#"+self.attr("startOn").substr(9));
					form.unbind("submit", preventSubmit);
					form.append("<input type='hidden' name='savedata' value='" + self.attr("savedata") + "' /><input type='hidden' name='posttype' value='" + self.attr("posttype") + "' /><input type='hidden' name='attachimages' value='" + self.attr("attachimages") + "' /><input type='hidden' name='requiredfields' value='" + self.attr("requiredfields") + "' /><input type='hidden' name='sendemail' value='" + self.attr("sendemail") + "' />");
					if(ajax=="true")
					{
						var data = form.serializeArray();
						var url = (form.attr("action")=="" ? config.ajaxurl : form.attr("action"));
						var method = form.attr("method");
						if(typeof(self.attr("ajaxLoaderId"))!="undefined")
							$("#"+self.attr("ajaxLoaderId")).css("display", "inline");
						if(typeof(data.action)=="undefined")
							data.push({name: "action", value: "amu_submit"});
						data.push({name: "ajax", value: 1});
						$.ajax({
							url: url,
							data: data,
							dataType: 'html',
							type: method,
							async: false,
							success: function(json){
								json = $.trim(json);
								var indexStart = json.indexOf("amu_start")+9;
								var indexEnd = json.indexOf("amu_end")-indexStart;
								json = $.parseJSON(json.substr(indexStart, indexEnd));
								if(typeof(self.attr("ajaxInfoId"))!="undefined")
								{
									$("#"+self.attr("ajaxInfoId")).html("");
									$("#"+self.attr("ajaxInfoId")).removeClass("amu_message").removeClass("amu_error");
									if(typeof(json.error)=="undefined" || json.error=="" || json.error==null)
										$("#"+self.attr("ajaxInfoId")).addClass("amu_message");
									else
										$("#"+self.attr("ajaxInfoId")).addClass("amu_error");
									$("#"+self.attr("ajaxInfoId")).html((typeof(json.error)=="undefined" || json.error=="" || json.error==null ? json.message : json.error)).css("display", "block");
									//alert((typeof(json.error)=="undefined" || json.error=="" || json.error==null ? json.message : json.error));
									$("html, body").animate({scrollTop: $("#"+self.attr("ajaxInfoId")).offset().top}, 400);
								}
								if(typeof(json.error)=="undefined" || json.error=="" || json.error==null)
								{
									form[0].reset();
									$("[name='AMUFiles[]']").remove();
									if(typeof(self.attr("queueId"))!="undefined")
										$("#"+self.attr("queueId")).html("");
									else
										$("#" + self.attr("id") + "Queue").html("");
								}
								if(typeof(self.attr("ajaxLoaderId"))!="undefined")
									$("#"+self.attr("ajaxLoaderId")).css("display", "none");
								form.one("submit", {'uploader':self}, submitForm);
							}
						});
					}
					else
						form.submit();
				}
			},
			'onError': function (event, queueID ,fileObj, errorObj) {
				/* if you got some problems just uncomment this code for debugging */
				/*var msg;
				if (errorObj.info == 404)
				   msg = 'Could not find upload script.';
				else if(errorObj.type === "HTTP")
				   msg = errorObj.type+ ": " +errorObj.info;
				else if(errorObj.type ==="File Size")
				   msg = fileObj.name+ ": " +errorObj.type;
				else
				   msg = errorObj.type+ ": " +errorObj.info;
				alert(msg);
				return false;*/
            }
		});
		if(self.attr("allowRemove")=="true")
		{
			$("#"+(customQueueId!="" ? customQueueId:self.attr("id")+"Queue")+" [name=removeFile]").live("click", function(){
				var selfRemove = $(this);
				if(typeof(self.attr("removeData"))!="undefined")
				{
					var customRemoveData = eval('({' + self.attr("removeData") + '})');
					var data="";
					for(var name in customRemoveData)
					{
						data += "'" + name + "':";
						if(customRemoveData[name].substr(0,9)=="selector:")
							data += "'" + $(customRemoveData[name].substr(9).toString()).val() + "',";
						else
							data += "'" + customRemoveData[name] + "',";
					}
					data = data.substr(0, data.length-1);
					data = eval('({' + data + '})');
				}
				if(selfRemove.parent().parent().find("[name='attach_id[]']"))
					var attach_id = selfRemove.parent().parent().find("[name='attach_id[]']").val();
				$.ajax({
							url: uploadScript,
							data: "action=remove&filename="+selfRemove.attr("fileName")+(typeof(attach_id)!="undefined" ? "&attach_id="+attach_id : "")+(typeof(data)!="undefined" ? "&"+$.param(data) : ""),
							type: "POST",
							async: false,
							success: function(data){
									if(data!="")
										alert(data);
									else
										selfRemove.parent().parent().animate({opacity: 0}, 500, function(){$(this).remove();});
							}
					});
			});
		}
	});
});

