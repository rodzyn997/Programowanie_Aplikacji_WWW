function getDate()
{
    todays = new Date();
    theDate = "" + (todays.getDate()  ) +"."+ (todays.getMonth()+1) + "." +(todays.getYear() + 1900);
    document.getElementById("data").innerHTML = theDate;
}

var timerID = null;
var timerRunning = false;

function stopClock()
{
    if (timerRunning)
        clearTimeout(timerID);
    timerRunning = false;
}

function startClock()
{
    stopClock();
    getDate();
    showTime();
}

function showTime()
{
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var seconds = now.getSeconds();
    var timeValue = "" + ((hours > 12) ? hours -12 : hours);
    timeValue += ((minutes < 10) ? ":0" : ":") + minutes; 
    //timeValue += ((seconds < 10) ? ":0" : ":") + seconds; 
    timeValue += (hours >= 12) ? " P.M." : " A.M.";
    document.getElementById("zegarek").innerHTML = timeValue;
    timerID = setTimeout("showTime()", 1000);
    timerRunning = true;
}