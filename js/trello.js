$(function(){
	//card拖拉
	$(".list").sortable({
		item:".list-box",
		cancel: ".new-list-box",
		//axis:"x"
	})
	$(".list-cards").sortable({
		connectWith:".list-cards",
	});
	
	//新增card功能
	$(document).on("click",".list-card-add",function(){
		$(this).hide().parent().children("div.list-add-msg").show().children(".list-input").focus()
	})
	$(document).on("click",".add-card",function(){
		var txt = $(this).parent().children("input")
		if(txt.val()!==""){
			var html = "<div id="+add_new_card($(this).parents("div.list-box").attr("id"),txt.val())+" class='list-card'>"+txt.val()+"</div>"
			var me = $(this).parent()
			me.hide()
			me.parent().children(".list-cards").append(html)
			me.parent().children("div.list-card-add").show()
			txt.val("")
		}		
	})
	$(document).on("click",".cancle-card",function(){
		$(this).parent().hide().children("input").val("")
		$(this).parent().parent().children("div.list-card-add").show()
	})
	$(document).on("keydown",".list-input",function(event){
		if(event.which==13){
			var txt = $(this).parent().children("input")
			if(txt.val()!==""){
				var html = "<div id='"+add_new_card($(this).parents("div.list-box").attr("id"),txt.val())+"' class='list-card'>"+txt.val()+"</div>"
				var me = $(this).parent()
				me.hide()
				me.parent().children(".list-cards").append(html)
				me.parent().children("div.list-card-add").show()
				txt.val("")
			}
		}
	})
	
	//新增list功能
	$(".new-list-box").click(function(){
		$(this).hide()
		$(".bg-box").show().children(".new-list-title").focus()
	})
	$(".cancle-list").click(function(){
		$(this).parent().hide().children("input").val("")
		$(".new-list-box").show()
	})
	$(".add-list").click(function(){
		var txt = $(this).parent().children("input")
		if(txt.val()!==""){
			let html=create_new_list_box($("#board_title").val(),txt.val())
			txt.val("")
			$(this).parent().hide()
			$(this).parent().parent().children(".list").append(html)
			$(this).parent().parent().children(".new-list-box").show()
		}
	})
	$(".new-list-title").keydown(function(event){
		if(event.which==13){
			var txt = $(this).parent().children("input")
			if(txt.val()!==""){
				let html=create_new_list_box($("#board_title").val(),txt.val())
				txt.val("")
				$(this).parent().hide()
				$(this).parent().parent().children(".list").append(html)
				$(this).parent().parent().children(".new-list-box").show()
			}
		}
	})
	function create_new_list_box(board_id,txt){
		return "<div class='list-box'>"+
					"<div id='"+add_new_list(board_id,txt)+"' class='list-title'>"+txt+"</div>"+
					"<input type='text' class='list-title' style='display:none;'>"+
					"<div class='list-cards'></div>"+
					"<div class='list-card-add'>+新增另一張卡片</div>"+
					"<div class='list-add-msg' style='display:none;'>"+
						"<input type='text' class='list-input' placeholder='為這張卡片輸入標題...'>"+
						"<button type='button' class='add-card'>輸入</button>"+
						"<button type='button' class='cancle-card'>取消</button>"+
					"</div>"+
				"</div>"
	}
	//修改標題
	$(document).on("click","div.list-title",function(){
		$(this).hide().next().show().val($(this).text()).focus()
	})
	$(document).on("keydown","input.list-title",function(event){
		if(event.which==13){
			if($(this).val()!==""){
				$(this).prev().text($(this).val())}
				$(this).text("").hide().prev().show()
				edit_list_title($(this).parent().attr("id"),$(this).val())
		}
	})
	//card觸發事件
	$(document).on("click",".list-card",function(){
		$(".bg").show()
		$(".list-card-window").show()
		$(".list-card-window").attr("id",$(this).attr("id"))
		$.get("change_trello.php?thing=get_val&id="+$(this).attr("id"),function(data){
			data = JSON.parse(data)
			$("#list-card-name").text(data['name'])
			$(".description").text(data['description'])
		})
		$.get("change_trello.php?thing=get_cart_active&card_id="+$(this).attr("id"),function(data){
			$(".list-card-active").empty()
			for(let i of JSON.parse(data)){
				var html = "<div id='"+i['id']+"'>"+i['name']+": "+i['text']+"</div>"
				$(".list-card-active").append(html)
			}
		})
	})
	$(".bg").click(function(){
		$(this).hide()
		$(".list-card-window").hide()
	})
	$("#list-card-name").click(function(){
		$(this).hide()
		$("#hidden-list-card-name").show().val($(this).text()).focus()
	})
	$("#hidden-list-card-name").keydown(function(event){
		if(event.which==13){
			$.get("change_trello.php?thing=list-card-name&name="+$(this).val()+"&id="+$(".list-card-window").attr("id"))
			$(this).hide()
			$("#list-card-name").text($(this).val()).show()
		}
	})
	$(".description").click(function(){
		$(this).hide()
		$(".hidden-description").val($(this).text()).show().focus()
		$(".description-save").show()
		$(".description-cancle").show()
	})
	$(".hidden-description").keydown(function(event){
		if(event.which==13){
			$.ajax({
				url:"change_trello.php",
				type:"GET",
				data:{
					thing:"description-save",
					description:$(".hidden-description").val(),
					id:$(".list-card-window").attr("id")
				},
				success:function(){
					$(".description").text($(".hidden-description").val())
				}
			})
			$(this).hide()
			$(".description-save").hide()
			$(".description-cancle").hide()
			$(".description").show()
		}
	})
	$(".description-save").click(function(){
		$.ajax({
			url:"change_trello.php",
			type:"GET",
			data:{
				thing:"description-save",
				description:$(".hidden-description").val(),
				id:$(".list-card-window").attr("id")
			},
			success:function(){
				$(".description").text($(".hidden-description").val())
			}
		})
		$(this).hide()
		$(".description-cancle").hide()
		$(".hidden-description").hide()
		$(".description").show()
	})
	$(".description-cancle").click(function(){
		$(this).hide()
		$(".description-save").hide()
		$(".hidden-description").hide()
		$(".description").show()
	})
	//ajax
	function add_new_card(list_id,name){
		var response = null;
		$.ajax({
			url:"change_trello.php",
			type:"GET",
			async: false,
			data:{
				thing:"add_new_card",
				list_id:list_id,
				name:name,
			},
			success:function(res){
				response=res
			}
		})
		return response
	}
	function edit_list_title(list_id,list_title){
		$.ajax({
			url:"change_trello.php",
			type:"GET",
			data:{
				thing:"edit_list_title",
				list_id:list_id,
				list_title:list_title,
			}
		})
	}
	function add_new_list(board_id,title){
		var response = null;
		$.ajax({
			url:"change_trello.php",
			type:"GET",
			async: false,
			data:{
				thing:"add_new_list",
				board_id:board_id,
				title:title,
			},
			success:function(res){
				response = res
			}
		})
		return response
	}
	//變更看板
	$(".select-borders").click(function(){
		if($(this).attr("id")==='1'){
			$(".hidden-select-borders").hide()
			$(this).attr("id",'0')
		}else{
			$(this).attr("id",'1')
			$(".hidden-select-borders").show()
			var html = ""
			$.get("change_trello.php?thing=get-all-boards",function(data){
				for(let i of JSON.parse(data)){
					html += "<a href='trello.php?id="+i['id']+"'><div>"+i['title']+"</div></a>"
				}
				$(".my-board").empty().append(html).show()
			})
		}		
	})
	//card留言功能
	$(".comment").keydown(function(event){
		if(event.which==13 && $(this).val() !=""){
			var txt = $(this).val()
			$.ajax({
				url:"change_trello.php",
				type:"GET",
				data:{
					thing:"insert-cart-comment",
					card_id:$(this).parent().parent().attr("id"),
					user_id:$("#board_title").val(),
					comment:txt
				},
				success:function(data){
					$(".comment").val("")
					data = JSON.parse(data)
					var html = "<div id='"+data['id']+"'>"+data['name']+": "+data['text']+"</div>"
					$(".list-card-active").append(html)
				}
			})
		}
	})
	//共享功能
	$(".share_button").click(function(){
		if($(this).attr("id")==='1'){
			$(this).attr("id",'0')
			$(".share-msg").show()
			$(".email-or-name").val("")
			$(".share").show()
			$(".hidden-share").hide()
		}else{
			$(this).attr("id",'1')
			$(".share-msg").hide()
		}		
	})
	$(".email-or-name").keyup(function(){
		if($(this).val()===""){
			$(".share").show()
			$(".hidden-share").hide()
		}else{
			$(".share").hide()
			$(".hidden-share").show()
		}			
	})
	$(".hidden-share").click(function(){
		$.ajax({
			url:"change_trello.php",
			type:"GET",
			data:{
				thing:"share",
				user:$(".email-or-name").val(),
				board_id:$("#board_title").val()
			},
			success:function(msg){
				alert(msg);
			}
		})
	})
})