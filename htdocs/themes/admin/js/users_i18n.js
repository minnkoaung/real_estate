$(document).ready(function() {

    /**
     * Delete a user
     */
    $('.btn-delete-user').click(function() {
        window.location.href = "http://localhost/ci_real_estate/htdocs/admin/users/delete/" + $(this).attr('data-id');
    });

});
