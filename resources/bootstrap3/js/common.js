var question_list = new Array();
// Written by Omar Faruk for back previous URL
function goBackByURL(url) {
    window.location.href = url;
    return;
}

function validateNumberAllowDecimal(event, isDecimal) {
    
    var keysWithDecimal;
    if (isDecimal) {
    	// keycode 190 dot (.) without number pad
    	// keycode 110 dot (.) on number pad
        keysWithDecimal = [46,8,9,27,13,190,110];
    } else {
        keysWithDecimal = [46,8,9,27,13];
    }
    
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(event.keyCode, keysWithDecimal) !== -1 ||
         // Allow: Ctrl+A
        (event.keyCode == 65 && event.ctrlKey === true) || 
         // Allow: home, end, left, right
        (event.keyCode >= 35 && event.keyCode <= 39)) {
             // let it happen, don't do anything
             return;
    } else {
        // Ensure that it is a number and stop the keypress
        if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
            event.preventDefault(); 
        }   
    }
}

function set_question_list(q_list)
{
    question_list = q_list; 
    //console.log(question_list);
}

function get_question_list()
{
    return question_list;
}