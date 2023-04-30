<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <title>Submit Article</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="js/form-validation.js"></script>

</head>

<body>
    <div class="container">
        <h1>Submit Article</h1>

        <form id="submit-article-form">
            <div class="alert" id="message" style="display:none;"></div>
            <div class="form-group">
                <label for="author">Author</label>
                <br>
                <div class="row">
                    <div class="col-9">
                        <input type="text" class="form-control" id="author" name="author" required>
                        <input type="hidden" id="author-id" name="author_id">
                    </div>
                    <div class="col-3">
                        <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal" data-bs-target="#add-author-modal">
                            <i class="bi bi-plus">+</i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="Enter article title" required>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea class="form-control" id="content" name="content" rows="10"></textarea>
            </div>

            <div class="form-group">
                <label for="pdf-file">PDF File</label>
                <input type="file" class="form-control-file" id="pdf-file" name="pdf-file">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- Add Author Modal -->
    <div class="modal fade" id="add-author-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Author</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="add-author-form">
                    <div class="alert" id="message-author" style="display:none;"></div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="author-name" class="col-form-label">Name</label>
                            <input type="text" class="form-control" id="author-name" name="author-name">
                        </div>
                        <div class="mb-3">
                            <label for="author-bio" class="col-form-label">Bio</label>
                            <textarea class="form-control" id="author-bio" name="author-bio"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="author-picture-url" class="col-form-label">Profile Image URL</label>
                            <input type="text" class="form-control" id="author-picture-url" name="author-picture-url">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Autocomplete for author field
            console.log("jQuery script block executed!");
            $('#author').autocomplete({
                source: function(request, response) {
                    $.getJSON('author-autocomplete.php', {
                        term: request.term,
                        timestamp: $.now() // add timestamp parameter to prevent caching
                    }, function(data) {
                        response(data);
                    });
                },
                minLength: 2,
                select: function(event, ui) {
                    $('#author-id').val(ui.item.id);
                },
                create: function() {
                    $(this).data('ui-autocomplete')._renderItem = function(ul, item) {
                        return $('<li>')
                            .append('<div>' + item.label + '</div>')
                            .appendTo(ul);
                    };
                }
            });

            // Submit article form handler
            $('#submit-article-form').submit(function(e) {
                
                e.preventDefault();
                var formData = new FormData(this);
                // var formData = $(this).serialize();
                // console.log(formData.get('pdf-file'));
                // console.log(this);
                if (validateForm()) {
                    console.log("jQuery #submit-article-form script block executed!");
                    $.ajax({
                        url: 'submit-article-handler.php',
                        type: 'POST',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            console.log(data);
                            console.log(data[0]);
                            var dataArray = JSON.parse(data);

                            // If submission was successful, show success message and reset form
                            $("#message").css("display", "block");
                            $("#message").removeClass("alert-danger").addClass("alert-success").html(dataArray['message']);
                            //$('#submit-article-form')[0].reset();
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            var response = JSON.parse(xhr.responseText);
                            var errorMessage = response.message;

                            // If addition was not successful, show error message
                            $("#message").css("display", "block");
                            $("#message").removeClass("alert-success").addClass("alert-danger").html(errorMessage);

                            // If submission was not successful, show error message
                            //$('#submit-error-modal').modal('show');
                        }
                    });
                }
            });

            // Add author form handler
            $('#add-author-form').submit(function(e) {

                console.log("jQuery script add-author-form block executed!");

                e.preventDefault();
                // console.dir(this);
                //var formData = new FormData(this);
                // console.log($(this).find('#author-name').val());
                // console.log($(this).find('#author-bio').val());
                var formData = $(this).serialize();

                $.ajax({
                    url: 'add-author-handler.php',
                    type: 'POST',
                    data: formData,
                    success: function(data) {
                        var dataArray = JSON.parse(data);
                        // If addition was successful, close modal and update author autocomplete
                        $("#message").css("display", "block");
                        $("#message").removeClass("alert-danger").addClass("alert-success").html(dataArray['message']);
                        $('#author').val(dataArray['author']);
                        $('#add-author-modal').modal('hide');
                        $('#add-author-form')[0].reset();
                        // $('#author').autocomplete('option', 'source', 'author-autocomplete.php');
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        //console.log("xhr.responseText" + xhr.responseText);
                        var response = JSON.parse(xhr.responseText);
                        var errorMessage = response.message;

                        // If addition was not successful, show error message
                        $("#message-author").css("display", "block");
                        $("#message-author").removeClass("alert-success").addClass("alert-danger").html(errorMessage);
                        // $('#author').val(dataArray['author']);
                        // $('#add-author-error-modal').modal('show');
                    }
                });
            });

            $('#add-author-modal').on('hidden.bs.modal', function() {
                // Reset the form fields
                $("#message-author").html('');
                $("#message-author").css("display", "none");
                $('#add-author-form')[0].reset();
            });
        });
    </script>
</body>

</html>