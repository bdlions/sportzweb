function print_common_message(message) {
    $("#message_content").html(message);
    $('#common_message_modal').modal('show');
}

/*
 * this method will convert date from dd-mm-yyyy format to yyyy-mm-dd format
 * @param date, date to be converted
 * @returns converted date
 * @author nazmul hasan
 * @created on 26 September 2015
 */
function convert_date_from_user_to_db(date)
{
    var result = date.split("-");
    if(result.length !== 3)
    {
        return date;
    }
    else
    {
        return result[2]+"-"+result[1]+"-"+result[0];
    }
}

/*
 * This method will decode html text. As an example after using this method &#039; becomes ' (single quote)
 * @param html, html to be decoded
 * @returns deocded html
 * @author nazmul hasan
 * @created on 1 October 2015
 */
function decode_html(html) {
    var txt = document.createElement("textarea");
    txt.innerHTML = html;
    return txt.value;
}