<script type="text/javascript">

	function updateTime(name,timezone){

		var date = new Date();
		var offset = date.getTimezoneOffset();
		var UTCTime = new Date(new Date().getTime() + offset*60*1000 + timezone*60*60*1000);

		var hours = UTCTime.getHours();
	    var minutes=UTCTime.getMinutes();
	    var seconds= UTCTime.getSeconds();
		
	    if(minutes < 10)
	        minutes = '0'+minutes;
	    if(seconds<10)   
	       seconds = '0'+seconds;
	    if(hours<10) 
	    	hours = '0'+hours;

	    var displayTime = hours+":"+minutes+":"+seconds;
		
		document.getElementById(name).innerHTML = displayTime;
		}

	function startClock(name, timezone){
		document.write("<div id="+name+"></div>");
		clockID = setInterval(function(){updateTime(name,timezone);}, 1000);
	}

	startClock('Canberra',10);
</script>
