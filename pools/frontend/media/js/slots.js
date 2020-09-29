
//note parseInt
//note stop


var opts = ['1','2','3','4','5','6','7','8','9','0'];

function go(){
	addSlots($("#slots_a .wrapper"));
	moveSlots($("#slots_a .wrapper"));
	addSlots($("#slots_b .wrapper"));
	moveSlots($("#slots_b .wrapper"));
	addSlots($("#slots_c .wrapper"));
	moveSlots($("#slots_c .wrapper"));
    addSlots($("#slots_d .wrapper"));
	moveSlots($("#slots_d .wrapper"));
	addSlots($("#slots_e .wrapper"));
	moveSlots($("#slots_e .wrapper"));
	addSlots($("#slots_f .wrapper"));
	moveSlots($("#slots_f .wrapper"));
}

$(document).ready(function(){
		addSlots($("#slots_a .wrapper"));
		addSlots($("#slots_b .wrapper"));
		addSlots($("#slots_c .wrapper"));
		addSlots($("#slots_d .wrapper"));	
		addSlots($("#slots_e .wrapper"));
		addSlots($("#slots_f .wrapper"));
	});


function addSlots(jqo){
	for(var i = 0; i < 10; i++){
		var ctr = Math.floor(Math.random()*opts.length);
		jqo.append("<div class='slot'>"+opts[ctr]+"</div>");
	}
}

function moveSlots(jqo){
		var time = 300;
		time += Math.round(Math.random()*1000);
		jqo.stop(true,true);

		var marginTop = parseInt(jqo.css("margin-top"), 10)
		
		marginTop -= (9 * 54)
		
		jqo.animate(
		{"margin-top":marginTop+"px"},
		{'duration' : time});

}
