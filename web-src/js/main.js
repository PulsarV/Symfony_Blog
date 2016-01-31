function changeRatingValue(){
    for (var i = 0; i < 5; i++) {
        if (i <= $('input[name="form[rating]"]:checked').val() - 1) {
            $("label[for='form_rating_" + i + "']").addClass('star-is-checked');
        } else {
            $("label[for='form_rating_" + i + "']").removeClass('star-is-checked');
        }
    }
}