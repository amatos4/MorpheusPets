/**
 * Created by Anthony on 12/1/2015.
 */
(function ( $ )
{
    $(document).ready(function() {
        $(".small-btn").click(function(e){
            e.preventDefault();
            var content = document.getElementById("user-description").innerText;
            $('#user-description').replaceWith('<form class="description-edit" enctype="multipart/form-data" action="#" method="POST">' +
                '<input id="description-text" type="text" value=""/>' +
                '<input type="submit" name="Submit"/>' +
                '</form>');
            document.getElementById("description-text").value = content;
        });

    });
})( $ );