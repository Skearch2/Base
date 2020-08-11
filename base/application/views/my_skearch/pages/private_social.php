<?php

// Set DocType and declare HTML protocol
$this->load->view('my_skearch/templates/start_html');

// Load default head (metadata & linking).
$this->load->view('my_skearch/templates/head');

// Start body element
$this->load->view('my_skearch/templates/start_body');

// Start page section
$this->load->view('my_skearch/templates/start_page');

// Load header and menu
$this->load->view('my_skearch/templates/header_menu');

// Start page body
$this->load->view('my_skearch/templates/start_pagebody');

?>

<div class="m-content">
	<div class="row">
		<div class="col-md-3">
			<div class="panel panel-default" style="height: 550px; overflow-y: scroll;">
				<div class="panel-heading">
					<h5>Chats</h5>
				</div>
				<div class="panel-body" id="chat_user_area"></div>
				<input type="hidden" name="hidden_receiver_id_array" id="hidden_receiver_id_array" />
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-default" style="height: 550px;">
				<div class="panel-heading">
					<h5>Conversation<span id="dynamic_title"></span></h5>
				</div>
				<div class="panel-body">
					<div id="chat_body" style="height:380px; overflow-y: scroll;">No chats selected</div>
					<div id="chat_footer">
						<hr />
						<div class="form-group">
							<div id="chat_message_area" contenteditable class="form-control"></div>
						</div>
						<div class="form-group" align="right">
							<button type="button" name="send_chat" id="send_chat" class="btn btn-success btn-xs" disabled>Send</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel panel-default" style="height: 200px;">
				<div class="panel-heading">
					<h6>Search User</h6>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-8">
							<input type="text" name="search_user" id="search_user" class="form-control input-sm" placeholder="Username" />
						</div>
						<div class="col-md-4">
							<button type="button" name="search_button" id="search_button" class="btn btn-primary btn-sm">Search</button>
						</div>
					</div>
					<div id="search_user_area"></div>
				</div>
			</div>
			<div class="panel panel-default" style="height: 350px; overflow-y: scroll;">
				<div class="panel-heading">
					<h6>Message Requests</h6>
				</div>
				<div class="panel-body" id="notification_area"></div>
			</div>
		</div>
	</div>
</div>


<?php

// End page body
$this->load->view('my_skearch/templates/end_pagebody');

// Load footer
$this->load->view('my_skearch/templates/footer');

// End page section
$this->load->view('my_skearch/templates/end_page');

// Load quick sidebar
$this->load->view('my_skearch/templates/quick_sidebar');

// Load global JS files
$this->load->view('my_skearch/templates/js_global');

?>

<!-- Page Scripts -->
<script>
	$(document).ready(function() {
		var receiver_id;

		get_chats();
		get_message_requests();

		//check for new requests every 10 seconds
		setInterval(function() {
			get_message_requests();
		}, 10000);

		// check for new messages and notifications every second
		setInterval(function() {
			if (receiver_id > 0) {
				get_chat_conversation(receiver_id, 'yes');
			}
			get_chat_notifications(receiver_id);
		}, 1000);

		$(document).on('click', '.user_chat_list', function() {
			$('#send_chat').attr('disabled', false);
			receiver_id = $(this).data('receiver_id');
			var receiver_name = $(this).text();
			$('#dynamic_title').text(' with ' + receiver_name);
			$(".user_chat_list").removeClass("active");
			$(this).addClass('active');
			get_chat_conversation(receiver_id, 'yes');
			$('#chat_body').scrollTop($('#chat_body')[0].scrollHeight);
		});

		// search user
		$(document).on('click', '#search_button', function() {
			var search_query = $.trim($('#search_user').val());
			$('#search_user_area').html('');
			if (search_query != '') {
				$.ajax({
					url: "<?= base_url(); ?>myskearch/private_social/search",
					method: "GET",
					data: {
						search_query: search_query
					},
					dataType: "json",
					beforeSend: function() {
						$('#search_user_area').html(loading());
						$('#search_button').attr('disabled', 'disabled');
					},
					success: function(data) {
						$('#search_button').attr('disabled', false);
						var output = '<hr />';
						var send_userid = "<?php echo $this->session->userdata('user_id'); ?>";
						if (data.length > 0) {
							for (var count = 0; count < data.length; count++) {
								output += '<div class="row">';
								output += '<div class="col-md-7"><img src="http://localhost/skearch/base/assets/my_skearch/app/media/img/users/user-default.jpg" class="img-circle" width="40" />' + data[count].first_name + ' ' + data[count].last_name + '</div>';
								if (data[count].is_request_send == 'yes') {
									output += '<div class="col-md-5">Request Sent</div>';
								} else {
									output += '<div class="col-md-5"><button type="button" name="request_button" class="btn btn-success btn-xs request_button" id="request_button' + data[count].user_id + '" data-receiver_userid="' + data[count].user_id + '" data-send_userid="' + send_userid + '">Send Request</button></div>';
								}
								output += '</div><hr />';
							}
						} else {
							output += '<div align="center">No User Found</div>';
						}
						output += '</div>';
						$('#search_user_area').html(output);
					}
				})
			}
		});

		// send message request
		$(document).on('click', '.request_button', function() {
			var id = $(this).attr('id');
			var receiver_userid = $(this).data('receiver_userid');
			var send_userid = $(this).data('send_userid');
			$.ajax({
				url: "<?= base_url(); ?>myskearch/private_social/request/send",
				method: "GET",
				data: {
					receiver_userid: receiver_userid,
					send_userid: send_userid
				},
				beforeSend: function() {
					$('#' + id).attr('disabled', 'disabled');
				},
				success: function(data) {
					$('#' + id).replaceWith('Request Sent');
				}
			})
		})

		// accept message request
		$(document).on('click', '.accept_button', function() {
			var id = $(this).attr('id');
			var chat_request_id = $(this).data('chat_request_id');
			$.ajax({
				url: "<?= base_url(); ?>myskearch/private_social/request/accept",
				method: "GET",
				data: {
					chat_request_id: chat_request_id
				},
				beforeSend: function() {
					$('#' + id).attr('disabled', 'disabled');
				},
				success: function(data) {
					get_message_requests();
					get_chats();
				}
			})
		});

		// send message
		$('#chat_message_area').keypress(function(e) {
			if (e.keyCode == 13 && !e.shiftKey) {
				e.preventDefault();
				$("#send_chat").click();
			}
		});
		$(document).on('click', '#send_chat', function() {
			var chat_message = $.trim($('#chat_message_area').html());
			if (chat_message != '') {
				$.ajax({
					url: "<?php echo base_url(); ?>myskearch/private_social/message",
					method: "GET",
					data: {
						receiver_id: receiver_id,
						chat_message: chat_message
					},
					beforeSend: function() {
						$('#send_chat').attr('disabled', 'disabled');
					},
					success: function(data) {
						$('#send_chat').attr('disabled', false);
						$('#chat_message_area').html('');
						$('#chat_body').stop().animate({
							scrollTop: $('#chat_body')[0].scrollHeight
						});
					}
				});
			}
		});

		// get chat users
		function get_chats() {
			$.ajax({
				url: "<?= base_url(); ?>myskearch/private_social/get/chats",
				method: "GET",
				data: {
					action: 'load_chat_user'
				},
				dataType: 'json',
				success: function(data) {
					var output = '<ul class="list-group list-group-flush">';
					if (data.length) {
						var receiver_id_array = '';
						for (var count = 0; count < data.length; count++) {
							output += '<li class="list-group-item list-group-item-action user_chat_list" data-receiver_id="' + data[count].receiver_id + '">';

							output += '<img src="http://localhost/skearch/base/assets/my_skearch/app/media/img/users/user-default.jpg" class="img-circle" width="35" />';

							output += ' ' + data[count].firstname + ' ' + data[count].lastname;

							output += '&nbsp;<span id="chat_notification_' + data[count].receiver_id + '"></span>';

							output += '&nbsp;<span id="type_notifitcation_' + data[count].receiver_id + '"></span>';

							output += ' <i class="offline" id="online_status_' + data[count].receiver_id + '" style="float:right;">&nbsp;</i></li>';

							receiver_id_array += data[count].receiver_id + ',';
						}
						$('#hidden_receiver_id_array').val(receiver_id_array);
					} else {
						output += '<div align="center"><b>No Chats Found</b></div>';
					}
					output += '</ul>';
					$('#chat_user_area').html(output);
				}
			})
		}

		// get chat conversation
		function get_chat_conversation(receiver_id, update_data) {
			$.ajax({
				url: "<?= base_url(); ?>myskearch/private_social/get/conversation",
				method: "GET",
				data: {
					receiver_id: receiver_id,
					update_data: update_data
				},
				dataType: "json",
				success: function(data) {
					var html = '';
					for (var count = 0; count < data.length; count++) {
						html += '<div style="margin-right:10px">';
						if (data[count].message_direction == 'right') {
							html += '<div align="right">';
							html += '<div><span><small>' + data[count].chat_messages_datetime + '</small></span></div>';
							html += '<div class="alert alert-success" style="display:inline-block;">';
						} else {
							html += '<div align="left">';
							html += '<div><span><small>' + data[count].chat_messages_datetime + '</small></span></div>';
							html += '<div class="alert alert-primary" style="display:inline-block;">';

						}
						html += data[count].chat_messages_text + '</div></div></div>';
					}
					$('#chat_body').html(html);
					// $('#chat_body').stop().animate({
					// 	scrollTop: $('#chat_body')[0].scrollHeight
					// });
				}
			})
		}

		// get message and activity notifications
		function get_chat_notifications(receiver_id) {
			var user_id_array = $('#hidden_receiver_id_array').val();

			// var is_type = 'no';
			// if (receiver_id > 0) {
			// 	if ($.trim($('#chat_message_area').text()) != '') {
			// 		is_type = 'yes';
			// 	}
			// }

			$.ajax({
				url: "<?= base_url(); ?>myskearch/private_social/get/notifications",
				method: "GET",
				data: {
					user_id_array: user_id_array,
					//is_type: is_type,
					receiver_id: receiver_id
				},
				dataType: "json",
				success: function(data) {
					if (data.length > 0) {
						for (var count = 0; count < data.length; count++) {
							var html = '';
							if (data[count].total_notification > 0) {
								if (data[count].user_id != receiver_id) {
									html = '<span class="notification_circle">' + data[count].total_notification + '</span>';
								}
							}
							if (data[count].status == 'online') {
								$('#online_status_' + data[count].user_id).addClass('online').attr('title', 'Online');
								$('#online_status_' + data[count].user_id).removeClass('offline')

								// if (data[count].is_type == 'yes') {
								// 	$('#type_notifitcation_' + data[count].user_id).html('<i><small>Typing</small></i>');
								// } else {
								// 	$('#type_notifitcation_' + data[count].user_id).html('');
								// }
							} else {
								$('#online_status_' + data[count].user_id).addClass('offline').attr('title', 'Offline');
								$('#online_status_' + data[count].user_id).removeClass('online')

								// $('#type_notifitcation_' + data[count].user_id).html('');
							}
							$('#chat_notification_' + data[count].user_id).html(html);
						}
					}
				}
			})
		}

		// get message requests
		function get_message_requests() {
			$.ajax({
				url: "<?= base_url(); ?>myskearch/private_social/get/requests",
				method: "GET",
				data: {
					action: 'load_notification'
				},
				dataType: "json",
				success: function(data) {
					var output = '<hr />';
					if (data.length > 0) {
						for (var count = 0; count < data.length; count++) {
							output += '<div class="row"><div class="col-md-7"><img src="http://localhost/skearch/base/assets/my_skearch/app/media/img/users/user-default.jpg" class="img-circle" width="35" /> ' + data[count].first_name + ' ' + data[count].last_name + '</div>';

							output += '<div class="col-md-5"><button type="button" name="accept_button" class="btn btn-success btn-xs accept_button" id="accept_button' + data[count].user_id + '" data-chat_request_id="' + data[count].chat_request_id + '">Accept</button></div><hr />';
						}
					} else {
						output += '<div align="center">No New Requests</div>';
					}
					$('#notification_area').html(output);
				}
			})
		}

		// show loading icon
		function loading() {
			var output = '<div align="center"><br /><br /><br />';
			output += '<img src="<?= base_url(ASSETS) ?>/my_skearch/demo/demo8/media/img/loading.gif" /> Loading...</div>';
			return output;
		}
	});
</script>
<!--end::Page Scripts -->

<?php
// Close body and html
$this->load->view('my_skearch/templates/close_html');
?>