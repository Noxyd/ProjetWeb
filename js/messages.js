$( document ).ready(function() {
    $("#message-content").hide();
    $("#smoke-background").hide();
    $(".btn-message-close").hide();
    $("#info-actualisation").hide();

    $("#btn-actualiser").click(function(){
        var date = new Date();
        var heure = "";
        heure+=date.getHours()+":"+date.getMinutes()+":"+date.getSeconds();
        $("#info-actualisation").text("Dernière actualisation à "+heure);
        $("#info-actualisation").fadeIn("fast").delay(2000).fadeOut("slow");
    });
});
