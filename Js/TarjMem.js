function Editar()
{
    document.getElementById("TDM").style.display="inline"; 
    document.getElementById("save").style.display="inline"; 
}

function Save(id)
{
    var numTar = document.getElementById("TDM").value;

    $.ajax({
        url: "Obj/Buscar.php",
        data: {fun: "a", name: id, tar: numTar},
        type:"POST",

        success: function(data)
        {
            window.alert("Succesfully saved card");
            location.reload();
        }
    });
}

function Delete(id)
{
    $.ajax({
        url: "Obj/Buscar.php",
        data: {fun: "b", name: id},
        type:"POST",

        success: function(data)
        {
            window.alert("Deleted card succesfully");
            location.reload();
        }
    })

}



