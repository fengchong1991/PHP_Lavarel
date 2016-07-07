	// Update clock periodically
	function updateTime(name,timezone){
		var date = new Date();
		var offset = date.getTimezoneOffset();
		var timezoneTime = new Date(new Date().getTime() + offset*60*1000 + timezone*60*60*1000);

		var hours = timezoneTime.getHours();
	    var minutes=timezoneTime.getMinutes();
	    var seconds= timezoneTime.getSeconds();
		
	    if(minutes < 10)
	        minutes = '0'+minutes;
	    if(seconds<10)   
	       seconds = '0'+seconds;
	    if(hours<10) 
	    	hours = '0'+hours;

	    var displayTime = hours+":"+minutes+":"+seconds;


	    var displayDate =timezoneTime.getDate()+"/"+(timezoneTime.getMonth()+1)+"/"+timezoneTime.getFullYear();
		
		document.getElementById(name).innerHTML = '<h4>'+displayDate+'</h4>'+'<h4>'+displayTime+'</h4>';
		}

	// Create a clock by calling startClock function
	function startClock(name, timezone){
		var name = name.replace(/\s/, '');
		document.write("<div id="+name+"></div>");
		updateTime(name,timezone);
		setInterval(function(){updateTime(name,timezone);}, 1000);
	}

