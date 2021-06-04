changeIt.innerHTML = "";
$.ajax({    
    type: "GET",
    url: "ajax/getUpdate.php",             
    dataType: "JSON"                 
    
}).done(function(res){
    changeIt.innerHTML += res[i].firstName
});
document.querySelector("#dbData").setInterval(,1000)