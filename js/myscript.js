function to_join() {
	location.assign("./join.php");
}

function to_join_complete(){
	location.assign("./join_complete.php");
}

function to_create_account(){
	location.assign("./create_account.php");
}

function to_index(){
	location.assign("./index.php");
}

function to_main(){
	location.assign("./main.php");
}

function to_my_account(){
	location.assign("./my_account.php?account_no=");
}

function to_my_deal(){
	location.assign("./my_deal.php");
}

function to_stock_detail(){
	location.assign("./stock_detail.php");
}

function back(){
	history.go(-1);
}

function logout(){
	location.assign("./logout.php");
}

function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
	window.onclick = function(event) {
		if (!event.target.matches('.dropbtn')) {		
			var dropdowns = document.getElementsByClassName("dropdown-content");
			var i;
			for (i = 0; i < dropdowns.length; i++) {
				var openDropdown = dropdowns[i];
				if (openDropdown.classList.contains('show')) {
					openDropdown.classList.remove('show');
				}
			}
		}
	}
}

function number_format(num){
    var num_str = num.toString();
    var result = "";
 
    for(var i=0; i<num_str.length; i++){
        var tmp = num_str.length - (i+1);
 
        if(((i%3)==0) && (i!=0))    result = ',' + result;
        result = num_str.charAt(tmp) + result;
    }
 
    return result;
}