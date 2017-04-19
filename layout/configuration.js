$(document).ready(function () {
    
    alert("hello");
    
    $("#changernom").submit(function (e) {
        e.preventDefault();
       
        if ($("#nom").val() == '')
        {
            alert("Veuillez entrer un nom");
        }        
       /* else{
            $.ajax({
                data: 'nom=' +  $("#nom").val(),
                url: 'configuration.php',
                method: 'POST',
                success: function(msg) {
                    alert(msg);   
                }
            });
        }*/
    });
};