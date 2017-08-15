/*
 *  Author: paothegreat
 *	Date: 21/04/2017
 */
 
 //Hide/Show Div tags
function showDiv(x,y) {
	hideAll(y);
    var x = document.getElementById('myDIV'+x);
	x.style.display = 'block';
}
function hideAll(x){
	for(var z=1;z<=x;z++){
		var name = document.getElementById('myDIV'+z);
		name.style.display = 'none';
	}
}

//Data in HTML table filtering
//filter for non-datatable
function myFunction(x) {
  // Declare variables 
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput"+x);
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[x];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}


var keyID;
function setModalKey(x){
	this.keyID = x;
}

function getModalKey(){
	return keyID;
}