 //  function doAddItem()
 //  {
 //     
 //  }
   
//   function doCancelAdd(url)
//   {
//      
//   }

  function doEdit(n,p)
	{
		var tr = document.getElementById("row_" + n);
		var cn = tr.childNodes.length;

		for (var i = 1; i < cn - 1; i++)
		{
			//var curNode = tr.firstChild;
			var curNode = tr.childNodes[i];
			var w = curNode.offsetWidth;
			
			var initialVal = curNode.innerHTML;
			var count = 1;
			curNode.innerHTML = "<input type='text' style='width: " + w + "px;' id='newVal" + count + "' value='" + initialVal + "'>";
		}
		tr.lastChild.innerHTML = "<td><input type='button' value='Save' onClick=doSave(" + n + "," + p + ")></td>";
		
		setEditEnabled(false);
		
	}	
	
	
	function doSave (n,p) 
	{
		var tr = document.getElementById("row_" + n);
		var cn = tr.childNodes.length;

		for (var i = 1; i < cn - 1; i++)
		{
			var curNode = tr.childNodes[i];
			var initialVal = curNode.firstChild.value;
			
			curNode.innerHTML = initialVal;
	  }
	  
	  tr.lastChild.innerHTML = "<td><input type='button' value='Edit' onClick=doEdit(" + n + "," + p + ")><input type='button' value ='Delete' onClick=doDelete(" + n + ")></td>";
	  setEditEnabled (true);
	  //SAVE NEW DATA TO DB!
	  doUpdateTable(n,p);

	}
	
		function setEditEnabled (b)
	{
		var inputs = document.getElementsByTagName("input");
		for (var i = 0; i < inputs.length; i++) {
		    if (inputs[i].value == 'Edit' || inputs[i].value == 'Delete') 
		    {
		        inputs[i].disabled = !b;
		    }
		}
	}
	
	function doDelete (n,p)
	{
		var result = confirm("Warning! Operation cannot be undone! Are you sure you want to delete this item?");
		if (result)
		{
   		var ajax = getRequest();
     		ajax.onreadystatechange = function()
     		{
         	if(ajax.readyState == 4)
         	{
              window.location.href=window.location.href;
           }
         }

			//REMOVE ITEM FROM DB
			   var delID = encodeURIComponent(document.getElementById('id_' + n).innerHTML);
			   var params = "pg=" + p + "&idx=" + delID;
			   //alert("sending: method=remove&" + params);
			  	ajax.open("GET", "php/updateDB.php?method=remove&" + params, true);
           	ajax.send(null);

		}
		
		reloadPage();
	}
	
	function reloadPage()
	{
	   //'http://djakata.com/jargon2/editJargon.php?page=$pg'  
	   //location.reload(true); 
	}
	
	function doUpdateTable(n,p)
	{
		var ajax = getRequest();
  		ajax.onreadystatechange = function()
  		{
      	if(ajax.readyState == 4)
      	{
          document.getElementById('dataTable').innerHTML = ajax.responseText;
        }
      }
      
     	var newID = encodeURIComponent(document.getElementById('id_' + n).innerHTML);
     	var newJI = encodeURIComponent(document.getElementById('ji_' + n).innerHTML);
     	var newDF = encodeURIComponent(document.getElementById('df_' + n).innerHTML);
     	var newDS = encodeURIComponent(document.getElementById('ds_' + n).innerHTML);
     	var newCT = encodeURIComponent(document.getElementById('ct_' + n).innerHTML);
     	var newSM = encodeURIComponent(document.getElementById('sm_' + n).innerHTML);
     	var newCO = encodeURIComponent(document.getElementById('co_' + n).innerHTML);
     	var newTY = encodeURIComponent(document.getElementById('ty_' + n).innerHTML);
     
     	//alert("newDF = " + newDF);
     
     	var params = "pg=" + p + "&idx=" + newID + "&ji=" + newJI + "&df=" + newDF + "&ds=" + newDS + "&ct=" + newCT + "&sm=" + newSM + "&co=" + newCO + "&ty=" + newTY;
      //alert("url = " + params);
     	ajax.open("GET", "php/updateDB.php?method=update&" + params, true);
     	ajax.send(null);
   
	}
	
function getRequest() 
{
    var req = false;
    try{
        // most browsers
        req = new XMLHttpRequest();
    } catch (e){
        // IE
        try{
            req = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            // try an older version
            try{
                req = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e){
                return false;
            }
        }
    }
    return req;
}
