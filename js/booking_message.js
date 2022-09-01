function refresh_denie_message(textarea, bookingID)
{
    document.getElementById("denie_message" + bookingID).value = textarea.value;
}

function refresh_review_comment(textarea, bookingID)
{
    document.getElementById("review_comment" + bookingID).value = textarea.value;
}

function refresh_review_rate(select, bookingID)
{
    document.getElementById("review_rate" + bookingID).value = select.value;
}

function refresh_host_rate(select, bookingID)
{
    document.getElementById("host_rate" + bookingID).value = select.value;
}