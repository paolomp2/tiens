
time_pc = new Date().getTime();
time_dif=0;

$.ajax({
	url: 'http://52.200.53.247/not_dif_betwen_timezone/'+time_pc,
	type: 'GET'
})
.done(function(succes) {
	time_dif=succes["dif_min"];
})
.fail(function() {
   
});

setInterval(function(){
	$.ajax({
		url: 'http://52.200.53.247/notification_popup/'+time_dif,
		type: 'GET'
	})
	.done(function(succes) {
		succes["not"].forEach(function(entry) {
			alertify.success(entry['message']);
		    console.log(entry['id']);
		});
    })
    .fail(function() {
        
    });

},5000);