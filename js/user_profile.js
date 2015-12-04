/**
 * Created by Anthony on 12/1/2015.
 */
(function ( $ )
{
    $(document).ready(function() {
        $("#description-btn").click(function(e){
            e.preventDefault();
            document.getElementById("description-edit").style.display = "block";
        });
    });
    $(document).ready(function() {
        $("#active_pet_btn").click(function(e1){
            e1.preventDefault();
            document.getElementById("pet-collection").style.display = "none";
            document.getElementById("select-active").style.display = "block";
        });
    });
    $(document).ready(function () {
        $("input[type='checkbox']").change(function () {
            var maxAllowed = 3;
            var cnt = $("input[type='checkbox']:checked").length;
            if (cnt > maxAllowed) {
                $(this).prop("checked", "");
                alert('Select maximum ' + maxAllowed + ' Active Pets!');
            }
        });
    });
})( $ );