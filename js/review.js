function showReview(id) {

    //receive transmission value
    var accommodation_ID = id;


    $('#comment').modal('toggle');
    $('#modal_comment_content').html('');

    const review_rate = '★★★★★';


    //AJAX function, transfer data to php for database access and receive data return
    $.ajax({
        url: './general/review_list_index.php',  //target page url
        type: 'POST',  //upload method
        dataType: 'JSON',  //type of data uploaded

        //uploaded data
        data: {
            accommodation_ID: accommodation_ID,
        },
        success: function (res) {  //receive data after successful data return
            res.res.forEach(item => {  //read every piece of data
                //print review information
                $('#modal_comment_content').append(`<div class="modal-review-group">
                <span class="modal-review-user" id="userfullname"><b>${item.Email}</b></span>
                <br>
                <span class="modal-review-content" id="reviewcontent">${item.ReviewComment}</span>
                <br>
                <span>Rate:&nbsp</span>
                <span id="reviewrate"><b>${review_rate.substring(0, item.ReviewRate)}</b></span>
                <br><br>
            </div>`)
            });
            return false;
        },
        error: function () {  //data return failed
            //alert(111);
            $('#modal_comment_content').append(`<div class="modal-review-group"><b>There is no review at the moment!<b></div>`)
            return false;
        }
    });

}