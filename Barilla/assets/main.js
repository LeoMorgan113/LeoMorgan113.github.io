var delay_popup = 0;
setTimeout("document.getElementById('openModal1').style.display='block'", delay_popup);
setTimeout("document.getElementById('openModal2').style.display='block'", delay_popup);
setTimeout("document.getElementById('openModal3').style.display='block'", delay_popup);

var x=document.forms["prize"]["firstname"].value;
var y=document.forms["prize"]["lastname"].value;
var z=document.forms["prize"]["lastname"].value;
var a=document.getElementById("dayofbirth").value;
var b=document.getElementById("monthofbirth").value;
var c=document.getElementById("yearofbirth").value;

var btn = document.getElementById("submit");

function fun1() {
    var rad=document.getElementsByName('gender');
    var gender=document.getElementsByName('gen');
    for (var i=0;i<rad.length; i++) {
        if (rad[i].checked) {
        	gender[i].style = "background-color: rgba(23,121,186,.75); color: #fff;";
        }
        else{
        	gender[i].style = "none";
        }
    }
}

function validateName(){
	if (x.length < 3) {
		document.getElementById('nm').innerHTML = 'completa correttamente il campo: nome';
		document.getElementsByClassName('validate_text')[0].style= "border-bottom: 2px solid #c71414;";
		return false;
	} else {
		document.getElementById('nm').innerHTML = '';
		return true;
	}
}
function validateLastname(){
	if (y.length<3) {
		document.getElementById('cm').innerHTML = 'completa correttamente il campo: cognome';
		document.getElementsByClassName('validate_text')[1].style= "border-bottom: 2px solid #c71414;";
		return false;
	} else {
		document.getElementById('cm').innerHTML = '';
		return true;
	}
}
function validateMail(){	
	if (z.length<3) {
		document.getElementById('em').innerHTML = 'completa correttamente il campo: email';
		document.getElementsByClassName('validate_text')[2].style= "border-bottom: 2px solid #c71414;";
		return false;
	} else {
		document.getElementById('em').innerHTML = '';
		return true;
	}
}
function validateDate(){
	if (c > 2002 ) {
		document.getElementById('dt').innerHTML = 'I minori di 18 anni non possono participare!';
		//document.getElementsByClassName('validate_text')[1].style= "border-bottom: 2px solid #c71414;";
		return false;
	}else {
		document.getElementById('dt').innerHTML = '';
		return true;
	} 
}
btn.onclick = function(){
	if(!x && !y && !z && !a && !b && !c){
		document.getElementById('gn').innerHTML = 'completa correttamente il campo: sesso';
		document.getElementById('nm').innerHTML = 'completa correttamente il campo: nome';
		document.getElementById('cm').innerHTML = 'completa correttamente il campo: cognome';
		document.getElementById('em').innerHTML = 'completa correttamente il campo: email';
		document.getElementById('dt').innerHTML = 'I minori di 18 anni non possono participare!';
		var el = document.getElementsByClassName('hollow');
		for (var i = 0; i<el.length ;i++) {
			el[i].style ="border: 2px solid #c71414;";
		}
		var elems=document.getElementsByClassName('validate_text');
		for(var i=0; i<elems.length; i++){
			elems[i].style ="border-bottom: 2px solid #c71414;";
		}
		for(var j=3; j<elems.length+3; j++){
			elems[j].style ="border-bottom: 2px solid #c71414; background: #faebeb;";
		}	
		
	}
}
