$("input").keyup(function(){
	var TF = true
	$("input").each(function(){
		if($(this).val()===""){
			TF = false
		}
	})
	if(TF){
		$(".register-disabled").hide()
		$(".register").show()
	}else{
		$(".register-disabled").show()
		$(".register").hide()
	}
})