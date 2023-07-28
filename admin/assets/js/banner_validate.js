
function emptyVal()
{
    $("#locationError").html("");
    $("#typeError").html("");
    $("#imgVidLinkError").html("");
    $("#linkError").html("");
    $("#errorMsg").html("");
    $("#success").html("");
}

$("#addBanner").click(function(){

 //var location=$.trim($("#location").val());
 //var type=$.trim($("#type").val());
 var imgVidLink=$.trim($("#imgVidLink").val());
 var link=$.trim($("#link").val());
 emptyVal();

   /* if(location.length==0)
    {
        $("#locationError").html("<span style=\"color:red !important;font-family:verdana;font-weight:400;font-size:13px\">Please provide location.</span>");
         return false;	
    }
    if(type.length==0)
    {
        $("#typeError").html("<span style=\"color:red !important;font-family:verdana;font-weight:400;font-size:13px\">Please provide type.</span>");
         return false;	
    }*/
    if(imgVidLink.length==0)
    {
            
        $("#imgVidLinkError").html("<span style=\"color:red !important;font-family:verdana;font-weight:400;font-size:13px\">Please provide path.</span>");
         return false;	
    }
   /* if(link.length==0)
    {
        $("#linkError").html("<span style=\"color:red !important;font-family:verdana;font-weight:400;font-size:13px\">Please provide link.</span>");
         return false;	
    }*/

});