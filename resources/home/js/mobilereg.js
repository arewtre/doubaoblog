function pre_verify(obj){
	var xinrui_mi1 = xinrui_mi ;
	obj.html(xinrui_mi+_G.login_pc_mobile19);
	obj.prop({disabled: true});
	
	var timer = setInterval(function(){
		xinrui_mi1--;
		if(xinrui_mi1 < 1){
			clearInterval(timer);	
			obj.html(_G.reg_pc_mobile2);
			obj.prop({disabled: false});
		}else{
			obj.html(xinrui_mi1+_G.login_pc_mobile19);	
		}
		
	},1000);
}

