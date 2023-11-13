// JavaScript Document
/*eslint-env es6*/
/*eslint-disable no-console*/
/*global window*/

(function($) {
	'use strict';
	
	$(function(){
		
		var cfg = {
			waitingForAnswer: false,
			minimized: false
		};
		
		var plugin = 'wpsTelegramChat';
		var pluginCfg = 'wpsTelegramChatCfg';
		
		var $chat = $('#wps-telegram-chat');
		var $textarea = $('#wps-telegram-chat-textarea textarea', $chat);
		var $contentBox = $('#wps-telegram-chat-content', $chat);
		var $content = $('.contentWrapper', $chat);
		var $inputBox = $('#wps-telegram-chat-input', $chat);
		var $updateBtn = $('#wps-telegram-chat-update', $chat);
		var $sendBtn = $('#wps-telegram-chat-send', $chat);
		var $closeBtn = $('#wps-telegram-chat-close', $chat);
		
		var chatUpdateTime = 5000;
		var chatAutoUpdate = true;
		var offlineTimeout = 60000;
		
		var url = location.href;
//
//===== check Cookie
//
		var cookie = JSON.parse( getCookie($chat.attr('id')) );
		if(!cookie){
			localStorage.removeItem(plugin);
			localStorage.removeItem(pluginCfg);
		}else{
			if(!cookie.user){
				localStorage.removeItem(plugin);
				localStorage.removeItem(pluginCfg);
			}
			if(!window[plugin].cookie){ window[plugin].cookie = cookie; }
		}
		
		getCfg();
		
		function getCookie(name){
			let matches = document.cookie.match(
				new RegExp('(?:^|; )' + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + '=([^;]*)')
			);
			return matches ? decodeURIComponent(matches[1]) : undefined;
		}
		
		console.log(window[plugin]);
//
//===== check specificPages
//
		var canShow = false;
		
		if(window[plugin].specificPages == true){
			
			if(window[plugin].chatOnByClass){
				let list = window[plugin].chatOnByClass.split(',');
				$.each( list, function(){
					if( $('body').hasClass(this.trim()) ){
						canShow = true;
						return;
					}
				});
			}
			
			if(window[plugin].chatOnByUrl){
				let list = window[plugin].chatOnByUrl.split(',');
				$.each( list, function(){
					if( url.indexOf(this.trim()) != -1 ){
						canShow = true;
						return;
					}
				});
			}
			
		}else{ canShow = true; }
		
		if(!canShow){
			$chat.addClass('onlySpecificPages');
			console.log('Show chat only on specific pages');
			return;
		}
//
//===== hide or show chat
//
		$chat
			.data('height', $chat.height())
			.data('width', $chat.width())
			.attr('class', 'init hide')
			.data('minHeight', $chat.height())
			.data('minWidth', $chat.width())
			.css({ width: $chat.data('minWidth'), height: $chat.data('minHeight') })
			.attr('class', 'hide');
		
		var hoverTimeOut;
		
		$closeBtn
		.on('click', chatVisibility)
		.hover( // hover animation
			function(){
				if($chat.hasClass('hide')){
					clearTimeout(hoverTimeOut);
					hoverTimeOut = setTimeout(function(){ $chat.addClass('hover'); }, 90);
				}
			},
			function(){
				if($chat.hasClass('hide')){
					clearTimeout(hoverTimeOut);
					hoverTimeOut = setTimeout(function(){ $chat.removeClass('hover'); }, 90);
				}
			}
		);
		
		$(document).on('keydown', function(e){ // "Esc" - Closes the chat
			if(e.keyCode == 27 && !$chat.hasClass('hide')){ chatVisibility(); }
		});
		
		function chatVisibility(){
			
			if(!$chat.hasClass('hide')){
				$chat.attr('class', 'blurry');
				$chat.animate({ width: $chat.data('minWidth'), height: $chat.data('minHeight') }, 'fast', function(){
					$chat.attr('class', 'hide');
				});
				setCfg('minimized', 'yes');
			}else{
				$chat.attr('class', 'blurry');
				$chat.animate({ width: $chat.data('width'), height: $chat.data('height') }, 'fast', function(){
					$chat.removeAttr('style').attr('class', 'show');
					autoUpdate(chatUpdateTime);
					isOnline();
					scrollDown(0);
				});
				setCfg('minimized', 'no');
			}
		}
//
//===== check Schedule
//
		function isOnline(){
			if(window[plugin].alwaysOnline == false){ checkSchedule(); }
		}
		
		function checkSchedule(){
			var obj = window[plugin];
			var srvTime = obj.srvTime;
			var day = srvTime.slice(0, 3).toLowerCase();
			var current = Number( srvTime.slice(4, 6) + srvTime.slice(7, 9) );
			var start, end, offLine = false;
			
			if(obj[day]){
				start = Number( obj[day].slice(0, 2) + obj[day].slice(3, 5) );
				end = Number( obj[day].slice(6, 8) + obj[day].slice(9, 11) );
				if(current < start || current > end){
					offLine = true;
				}
			}else{
				offLine = true;
			}
			
			if(offLine){
				if(!$('.content.info', $content).length){
					serviceMessage('OFFLINE');
				}
			}
		}
//
//===== is tab Active
//
		$(window).on('blur focus', function(e) {
			
			var prevType = $(this).data('prevType');

			if(prevType != e.type){ // reduce double fire issues
				
				if(e.type === 'blur'){
					chatAutoUpdate = false;
					autoUpdate(chatUpdateTime);
					
				}else if(e.type === 'focus'){
					$content.html('');
					getLocalData();
					isOnline();
					chatAutoUpdate = true;
					autoUpdate(chatUpdateTime);
				}
			}

			$(this).data('prevType', e.type);
		})
		
		autoUpdate(chatUpdateTime);
		
		var timeOutId;
		function autoUpdate(time){
			
			clearTimeout(timeOutId);
			if(!chatAutoUpdate || !cfg.waitingForAnswer){ return; }
			
			timeOutId = setTimeout(function(){
				
				getUpdates();
				
				if(!$chat.hasClass('hide')){ autoUpdate(time); }
				else{ autoUpdate(chatUpdateTime * 2); }
				
			}, time);
		}
		
		var timeoutOfflineId;
		function isNoResponse(){
			clearTimeout(timeoutOfflineId);
			
			timeoutOfflineId = setTimeout(function(){
				if(!$('.content.info', $content).length){
					serviceMessage('OFFLINE');
				}
			}, offlineTimeout);
		}
//
//===== send message
//
		$sendBtn.on('click', sendMessage);
		$textarea.on('keydown', function(e){ // "Ctrl+Enter" - Sends a message
			if(e.ctrlKey && e.keyCode == 13){ sendMessage(); }
		});
		
		function sendMessage(){
			
			var message = $textarea.val();
			if(!message){ return; }
			
			$inputBox.addClass('disabled');
			
			setTimeout(function(){
				$inputBox.removeClass('disabled');
				$textarea.val('');
			}, chatUpdateTime);
			
			sendPost({ mode: 'sendMessage', text: message }, function(obj){
				var body = obj.result.body;
				
				$textarea.val('Wait to send next message. Spam protection...');
				
				if(body.ok){
					var date = body.result.date;
					var text = body.result.text;
					var type = 'outgoingMessage';
					
					setCfg('waitingForAnswer', true);
					
					autoUpdate(chatUpdateTime);
					saveAndShow( {date, text, type} );
					isNoResponse();
				}
			});
		}
//
//===== get updates
//
		//$updateBtn.on('click', getUpdates);
		
		function getUpdates(){
			
			sendPost({ mode: 'getUpdates' }, function(obj){
				$.each(obj.reply.toMessage, function(key, message){
					var date = message.date;
					var text = message.text;
					var type = 'incomingMessage';
					
					setCfg('minimized', 'no');
					saveAndShow( {date, text, type} );
					clearTimeout(timeoutOfflineId);
				});
			});
		}
		
		function sendPost(data, callback){
			
			data.action = 'telegramHandler';
			data.nonce = cookie.nonce;
			
			$updateBtn.attr('class', 'ping');
			
			autoUpdate(chatUpdateTime);
			
			$.post( window[plugin]['ajaxUrl'], data, function(response){
				var obj;
				
				$updateBtn.attr('class', 'error');
				
				try { obj = JSON.parse(response); }catch(e){ /* error */ }
				
				try { obj.result.body = JSON.parse(obj.result.body); }catch(e){ /* error */ }
				
				try { if( !obj.result.body.ok ){ console.log( 'ERROR: ', obj ); } }
				catch(e){
					console.log( 'ERROR: ', response );
					serviceMessage(response);
				}
				
				if(typeof obj === 'object'){
					if(obj.debug){ console.log( 'Response: ', obj ); }
					
					$updateBtn.attr('class', 'empty');
					
					callback(obj);
				}
			});
		}
//
//===== serviceMessage
//
		function serviceMessage(notice){
			var date = new Date() / 1000;
			var text = notice;
			var type = 'error';

			if(text === 'SPAM'){
				type = 'error spam';
				text = 'Spam protection<br> Too frequent requests...';
				/*
				setTimeout(function(){
					$('.spam', $content).fadeOut('fast', function(){ $(this).remove(); });
				}, 3999);
				*/
				
			}else if(text === '!NONSE'){
				text = 'Session has been updated<br> Please refresh a web page...';
				chatAutoUpdate = false;
				autoUpdate(chatUpdateTime);
			
			}else if(text === 'OFFLINE'){
				type = 'info offLine incomingMessage';
				text = window[plugin].chatOfflineTxt;
				autoUpdate(chatUpdateTime * 2);
			}
			
			saveAndShow( {date, text, type} );
		}
//
//===== Message template
//
		function htmlMessage(obj){
			
			obj.date = new Date(obj.date * 1000);
			obj.date = obj.date.toLocaleString('en-GB');
			obj.date = '<p class="date">' + obj.date + '</p>';
            
			obj.text = '<p class="message">' + obj.text + '</p>';
            obj.text = obj.text.replace(/#.+\n/, '');
			obj.text = obj.text.replace(/\n/g, '<br>');
			
			var html = '<div class="content ' + obj.type + '">';
				html += '<div><p class="icon"></p>' + obj.date + obj.text + '</div>';
				html += '</div>'

            return html;
        }
//
//===== Message append
//
		function appendData(html){
			if(html){
				$content.append(html);
				if($chat.hasClass('hide') && cfg.minimized !== 'yes'){ $closeBtn.trigger('click'); }
				scrollDown(400);
			}
		}
		
		function scrollDown(duration){ $contentBox.animate({ scrollTop: $content.height() }, duration); }
//
//===== saveLocalData
//
		function saveAndShow(item){
			
			if(item.type.indexOf('error') < 0 && item.type.indexOf('info') < 0){
				var obj = JSON.parse( localStorage.getItem(plugin) );
				obj = obj ? obj : [];
				obj.push(item);
				localStorage.setItem( plugin, JSON.stringify(obj) );
			}
			
			appendData( htmlMessage(item) );
		}
//
//===== getLocalData
//
		getLocalData();
		function getLocalData(){
			var html = '';
			var obj = JSON.parse( localStorage.getItem(plugin) );
			
			$.each(obj, function(key, item){ html += htmlMessage(item); });
			appendData(html);
		}
//
//===== set cfg
//
		function setCfg(prop, val){
			cfg[prop] = val;
			localStorage.setItem( pluginCfg, JSON.stringify(cfg) );
			console.log('Set Cfg:', cfg);
		}
//
//===== get cfg
//
		function getCfg(){
			var tmpCfg;
			tmpCfg = JSON.parse( localStorage.getItem( pluginCfg ) );
			if(tmpCfg){ cfg = tmpCfg; }
			console.log('Get Cfg:', cfg);
		}
		
	}); // end functions
})( jQuery );
