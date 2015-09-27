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