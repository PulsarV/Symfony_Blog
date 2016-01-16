function changeRatingValue(){
    for (var i = 1; i <= 5; i++) {
        if (i <= $('input[name=rating]:checked').val()) {
            $("label[for='r" + i + "']").addClass('star-is-checked');
        } else {
            $("label[for='r" + i + "']").removeClass('star-is-checked');
        }

    }
}