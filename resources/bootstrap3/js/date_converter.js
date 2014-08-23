function getDateDescription(_time, _current_time){
    //var today = new Date();
    //console.log(Math.round( _time / 1000));
    //var entry_time = new Date( _time * 1000);
    
    //var seconds = Math.round((today.getTime() - entry_time.getTime()) / 1000);
    
    var seconds = _current_time - _time;
    if (seconds <= 1) {
        return seconds + " second ago";
    }
    else if (seconds > 1 && seconds < 60) {
        return seconds + " seconds ago";
    }
    else {
        var minutes = Math.round(seconds / 60);
        if (minutes <= 1) {
            return minutes + " minute ago";
        }
        else if (minutes > 1 && minutes < 60) {
            return minutes + " minutes ago";
        }
        else {
            var hours = Math.round(minutes / 60);
            if (hours <= 1) {
                return hours + " hour ago";
            }
            else if (hours > 1 && hours < 24) {
                return hours + " hours ago";
            }
            else {
                var days = Math.round(hours / 24);
                if (days <= 1) {
                    return days + " day ago";
                }
                else if (days > 1 && days < 30) {
                    return days + " days ago";
                }
                else {
                    var months = Math.round(days / 30);
                    if (months <= 1) {
                        return months + " month ago";
                    }
                    if (months > 1 && months < 12) {
                        return months + " months ago";
                    }
                    else {
                        var years = Math.round(months / 12);
                        return years + " years ago";
                    }
                }
            }
        }
    }
}
