var phppath = "/test/views/includes/ajax.php";
document.getElementById('apostolh').addEventListener("click", () => {
    var titlos = document.getElementById('titlos').value.replace(/\s/g, '__');
    var keimeno = document.getElementById('keimeno').value.replace(/\s/g, '__');
	$.get(phppath + '?titlos=' + titlos + '&keimeno=' + keimeno);
	setTimeout(function(){
	   window.location.reload(1);
	}, 1000);
});
document.getElementById('filter').addEventListener("change", () => {
    let index2 = 3;
	var regexsearch = new RegExp(document.getElementById('filter').value, 'g');
	while (index2 < 20) {
    	if ("Όλα τα άρθρα" == document.getElementById('filter').value || (document.querySelector("#box > div:nth-child(" + index2 + ") > div.table > p:nth-child(7)").innerText.replace(/^.+: /, '').match(regexsearch) ? true : false) == true){
    		document.querySelector("#box > div:nth-child(" + index2 + ")").style.display="flex";
    		if (document.getElementById('filter').value !== "Νέα Άρθρα" || document.querySelector("#box > div:nth-child(3) > div.table > p:nth-child(7)").innerText.replace(/^.+: /, '') == "Νέα Άρθρα"){
            	document.getElementsByClassName('articles')[0].style.display="none";
            } else {
            	document.getElementsByClassName('articles')[0].style.display="flex";
            }
        }
    	else {
		  document.querySelector("#box > div:nth-child(" + index2 + ")").style.display="none"
		}
    index2 += 2;
	}
});
