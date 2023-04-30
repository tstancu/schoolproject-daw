function validateForm() {
    let content = $('#content').val();
    let file = $('#pdf-file').val();

    if (content.trim() === '' && file.trim() === '') {

        $("#message").removeClass("alert-success").addClass("alert-danger").html('Please input content or upload a pdf file');
        $("#message").css("display", "block");

        return false;
    }

    return true;
}