function Editar()
{
    num = document.getElementById("cardnumber").value

    if(num != null)
    { 
      document.getElementById("TDM").value = num;  
    }

    document.getElementById("TDM").style.display="inline"; 
    document.getElementById("save").style.display="inline";
    document.getElementById("delete").style.display="inline";  
}

function Save(id)
{
    console.log(id);

    var numtar = document.getElementById("cardnumber").value;

    $.ajax({
        url: "Obj/Buscar.php",
        data: "Num="+ numtar,
        type:"POST",

        success: function(data)
        {
            console.log(data);
        }
    });
}

function H()
{
    num = document.getElementById("cardnumber").value
    console.log(num);
    /*
    if()
    document.getElementById("TDM").style.display="inline";
    document.getElementById("Send").style.display="inline";
    console.log("si la llamo");

    numTar = document.getElementById("TDM");

    
*/
}



