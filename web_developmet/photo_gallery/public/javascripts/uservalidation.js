$("#submit").click( function() {
    var data = ;
    
    
    if ($("#username").val() == "" || $("#pass").val() == "")
        $("#ack").html("Username and Password are mandatory fields -- Re-Enter Your Information");
    else {
    $.post( $("#createaccount").attr("action"),
           $("#createaccount :input").serializeArray(),
          function (info) {
            $("#ack").empty();
              $("#ack").html(info);
              clear();
              
                } );
    }
    $("#createaccount").submit ( function () {
        return false;
    })
});

function clear () {
    $("#createaccount :input").each ( function (){
        $(this).val("");
    });
}
