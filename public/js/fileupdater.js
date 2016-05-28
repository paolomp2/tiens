//	uploadButton.innerHTML = 'Uploading...';


try{
	//document.getElementById("btn_submit").disabled = true;
}catch(err) {}

//var form_type = document.getElementById("form_type").value;

/*if(form_type=="create")
	document.getElementById("btn_submit").disabled = true;*/

$("#file_document").change(function(e){
	e.preventDefault();

	var token = $("#csrf-token").val();

	var fileSelect = document.getElementById('file_document');
	var files = fileSelect.files;
	var sessionMath = $("#sessionMath").val();
	var id_file = document.getElementById('numFiles').value;
	//var edit_flag = document.getElementById('edit_flag').value;
	var model = $("#model").val();//Modelo desde donde se llama a la funci'on
	var i = 0;
	var file_size=0;
	for (; i < files.length; i++) {
		
		var formData = new FormData();
		var file = files[i];
		var id_file = document.getElementById('numFiles').value;
		// Check the file type.
		/*if (!file.type.match('image.*')){
			console.log("its not image type");
			continue;
		}*/
		// Add the file to the request.
		
		var total_string ="";
		var index = (id_file*1 + i*1);

		console.log(file_size);

		if(file_size>10*1024*1024)
		{
			console.log("sleeping");
			setTimeout(2000);
		}

		switch(model)
		{
			
			case "1":
				if (!file.type.match('image.*')){
					alert("El archivo que trata de subir no es una imagen.");
					continue;
				}
				console.log("iniciando inserción");						
				var row = 	"<tr id=file_line_"+index+">"+
								"<td><img id='img"+index+"' src='#' alt='Loading...' height='150px'/>"+
								"</td>"+
								"<td>"+
									"<span id='status"+index+"' class='label label-warning'>Cargando...</span>"+
								"</td>"+
								"<td id=file_line_adv_"+index+">"+
									"<a id='"+index+"' class='btn btn-danger quickMenu'>"+
										"<i class='halflings-icon white trash'></i>"+
									"</a>"+
								"</td>"+
						   	"</tr>";

				total_string = row;
				file_size = file_size+file.size;
				$("#file_list").append(total_string);
				console.log("terminando inserción");						
				/*var reader = new FileReader();
				var index = (id_file*1 + i*1);
				console.log("id_file: "+id_file);
				console.log("i: "+i);
				console.log("index: "+index);

				reader.onload = function (e) {
					console.log("name: #img"+index);
					console.log(e.target.result));
	                $("#img"+index).attr('src', e.target.result);
	                $("#img"+index).attr('width','100px');
	            }
	            reader.readAsDataURL(document.getElementById("file_document").files[i]);*/
				break;
			case "2":
				var prt1 = "<li id= file_line_"+id_file+"><span class='label label-important'>"
				//zip
				var prt11 = "</span> <b>";
				//bootstrap.zip
				var prt2 = "</b> <i>(";
				var file_size = Math.round((100*file.size / 1048576))/100 ;
				var prt3 = "MB)</i><span class='quickMenu'><a id= file_line_a_"+id_file+" href=";
				//#
				var prt4 = " class='halflings-icon remove'><i></i></a></span><span id= file_line_adv_"+id_file+" class='label label-warning'>Cargando...</span></li>";

				var total_string = prt1.concat(file.name.split(".")[1],prt11,file.name,prt2,file_size,prt3,"link",prt4);
				$("#file_list").append(total_string);
		}

		
		//Carga de data a subir
		formData.append('document', file, file.name);
		formData.append('file_name', file.name);
		formData.append('sessionMath', sessionMath);
		formData.append('size', file.size);
		formData.append('model', model);
		formData.append('index', index);

		$.ajax({
			url: '/document/store',
			type: 'POST',
			headers: {'X-CSRF-TOKEN': token},
			dataType: 'json',
			data:formData,
			contentType: false,
	        processData: false
		})
		.done(function(succes) {
			
			switch(model)
			{
				case "1":
					console.log(succes['index']);
					//update file_size
					file_size = file_size - succes['size'];
					console.log("updating size:"+file_size);
					
					//if(edit_flag==1)						
					$("#img"+succes['index']).attr('src', "../../documentos/150x150_"+succes['id']+"."+succes['extension']);
					

					$("#img"+succes['index']).attr('width','150px');
					$("#status"+succes['index']).attr('class','label label-success');
					document.getElementById("status"+succes['index']).innerHTML = "Cargado";
					$("#status"+succes['index']).attr('content','label label-success');
					$("#"+succes['index']).attr('id',succes['id']);

					
					break;
				case "2":
					$("#file_line_a_"+id_file).remove();
					$("#file_line_adv_"+id_file).remove();
					$("#file_line_"+id_file).append("<a href='#' id="+succes["id"]+" class='quickMenu halflings-icon remove'><i></i></a>");
			        $("#file_line_"+id_file).append("<span class='label label-success'>Subido</span>");
					break;
			
			document.getElementById('numFiles').value = parseInt(document.getElementById('numFiles').value) +1
			}		
	        
	    })
	    .fail(function(succes) {
	    	console.log(formData);
	       document.getElementById('numFiles').value = parseInt(document.getElementById('numFiles').value) -1 
	    });
	}

	document.getElementById('numFiles').value=i;
	try{
		document.getElementById("btn_submit").disabled = false;
	}catch(err) {}
	//Vaciar el input
	document.getElementById("file_document").value = "";

	
});



// Remove parent of 'remove' link when link is clicked.
// id           event    class ul
$('#files').on('click', '.quickMenu', function(e) {
    
    console.log("ok");
    
    e.preventDefault();
    var model = $("#model").val();//Modelo desde donde se llama a la funci'on

    var id = $(this).attr('id');
    switch(model){
    	case "1":
    		$(this).parent().parent().remove();
    		break;
		case "2":
			$(this).parent().remove();
    		break;
    }
    

    var token = $("#csrf-token").val();
    

    console.log(id);

    $.ajax({
		url: '/document/'+id+'/delete',
		type: 'GET'
	})
	.done(function() {
    })
    .fail(function() {
        
    });
});

$("#video_file_low").change(function(e){
	e.preventDefault();
	upVideo(1);	
});

$("#video_file_hight").change(function(e){
	e.preventDefault();
	upVideo(2);	
});

function upVideo(type)
{
	
	var token = $("#csrf-token").val();

	if(type==1)
	{
		var fileSelect_name = 'video_file_low';
		var video_file_group_name = '#video_file_group_low';
		var video_updating_name = '#video_updating_low';
		var video_preview = '#video_preview_low';
		var msg_uploading = 'Visualización del Video de baja calidad';
		var name_movie = '/movie_l_';
	}

	if(type==2)
	{
		var fileSelect_name = 'video_file_hight';
		var video_file_group_name = '#video_file_group_hight';
		var video_updating_name = '#video_updating_hight';
		var video_preview = '#video_preview_hight';
		var msg_uploading = 'Visualización del Video de alta calidad';
		var name_movie = '/movie_h_';
	}

	var fileSelect = document.getElementById(fileSelect_name);
	var files = fileSelect.files;
	
	for (var i = 0; i < files.length; i++) {

		var formData = new FormData();
		var file = files[i];
		// Check the file type.
		if (!file.type.match('video.*')){
			console.log("its not video type");
			continue;
		}
		// Add the file to the request.
		
		var total_string ="";
		var file_size = Math.round((100*file.size / 1048576))/100 ;
			
		//Carga de data a subir
		formData.append('movie_file', file, file.name);
		formData.append('file_name', file.name);
		formData.append('size', file_size);
		formData.append('id', document.getElementById('id_movie').value);
		formData.append('type', type);

		console.log(video_file_group_name);
		$(video_file_group_name).remove();
		$(video_updating_name).append("<div class='controls'><span class='label label-warning'>Subiendo video, espere.</span></div>");

		try{
			document.getElementById("btn_submit").disabled = true;
		}catch(err) {}

		$.ajax({
			url: '/movie/store_movie',
			type: 'POST',
			headers: {'X-CSRF-TOKEN': token},
			dataType: 'json',
			data:formData,
			contentType: false,
	        processData: false
		})
		.done(function(succes) {

			var url = $("#url").val();
			var movie_folder = $("#movie_folder").val();

	        $(video_preview).append("<label class='control-label'>"+msg_uploading+"</label>");		

			$(video_preview).append("<div class='controls'><video id='myVideo' width='320' height='176' controls>"+
			  "<source src='/"+movie_folder+name_movie+succes['id']+"."+succes['extension']+"' type='video/"+succes['extension']+"'>"+
			  "Your browser does not support HTML5 video."+
			"</video></div>")

			$(video_updating_name).remove();
			document.getElementById('id_movie').value = succes['id'];

			document.getElementById("btn_submit").disabled = false;

	    })
	    .fail(function() {
	        
	    });
	}
}

//youtube videos

$('#youtube_verify').on('click', function(e) {
    e.preventDefault();
    var youtube_link = $("#youtube_link").val();
    var youtube_link = youtube_link.substring(32);

    if(youtube_link!=""){
    	document.getElementById('id_youtube').value = youtube_link;
    	$('#youtube_video_preview_into_div').remove();
    	$("#youtube_video_preview").append("<div id='youtube_video_preview_into_div' class='controls'><iframe width='320' height='176' src='http://www.youtube.com/embed/"+youtube_link+"?autoplay=1'> </iframe> </div>");
    	$('#youtube_video_message_into_div').remove();
    	$("#youtube_video_message").append("<div id='youtube_video_message_into_div' class='controls'><span class='external-event badge badge-info ui-draggable'>El video debe visualizarce, de lo contrario cambie el link y verifique nuevamente.</span></div>");
    	try{
			document.getElementById("btn_submit").disabled = false;
		}catch(err) {}
    }else{
    	$('#youtube_video_message_into_div').remove();
    	$("#youtube_video_message").append("<div id='youtube_video_message_into_div' class='controls'><span class='external-event badge badge-important ui-draggable'>El link no puede ser vacío</span></div>");
    }
});

function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}