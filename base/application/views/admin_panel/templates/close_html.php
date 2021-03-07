		<!--begin::Global Theme Bundle -->
		<script src="<?= site_url(ASSETS); ?>/admin_panel/vendors/base/vendors.bundle.js" type="text/javascript"></script>
		<script src="<?= site_url(ASSETS); ?>/admin_panel/demo/demo12/base/scripts.bundle.js" type="text/javascript"></script>
		<script src="<?= site_url(ASSETS) ?>/admin_panel/demo/demo12/custom/crud/forms/widgets/bootstrap-select.js" type="text/javascript"></script>
		<!--end::Global Theme Bundle -->

		<!--begin::Page Vendors -->
		<script src="<?= site_url(ASSETS); ?>/admin_panel/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
		<script src="<?= site_url(ASSETS) ?>/admin_panel/demo/demo12/custom/crud/forms/widgets/tagsinput.js" type="text/javascript"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
		<!--end::Page Vendors -->

		<!--begin::Page Scripts -->
		<script>
			// settings for toastr notifications
			toastr.options = {
				"closeButton": false,
				"debug": false,
				"newestOnTop": true,
				"progressBar": false,
				"positionClass": "toast-top-right",
				"preventDuplicates": false,
				"onclick": null,
				"showDuration": "300",
				"hideDuration": "1000",
				"timeOut": "5000",
				"extendedTimeOut": "1000",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut",
			};

			// timeout for bootstrap alert - remove after 5 seconds
			// $(function() {
			// 	setTimeout(function() {
			// 		if ($(".alert").is(":visible")) {
			// 			$(".alert").fadeOut("slow");
			// 		}
			// 	}, 5000)
			// });

			// Ping the server every 10 seconds that the user is active
			setInterval(function() {
				ping();
			}, 10000);

			// Update user activity
			function ping() {
				$.ajax({
					url: "<?= base_url(); ?>admin/messaging/ping",
					method: "GET"
				})
			}
		</script>

		<script>
			$(document).ready(function() {
				var receiver_id;

				get_chats();

				// check for new messages and notifications every second
				setInterval(function() {
					if (receiver_id > 0) {
						get_chat_conversation(receiver_id, 'yes');
					}
					get_chat_notifications(receiver_id);
				}, 1000);

				$(document).on('click', '#m_quick_sidebar_tabs_btn_staff', function() {
					$("#m_quick_sidebar_tabs_staff").show();
					$("#m_quick_sidebar_tabs_messenger").hide();
					receiver_id = 0;
					$(".user_chat_list").removeClass("active");
				});

				$(document).on('click', '.user_chat_list', function() {
					$("#m_quick_sidebar_tabs_btn_staff").removeClass("active");
					$("#m_quick_sidebar_tabs_staff").hide();
					$("#m_quick_sidebar_tabs_messenger").show();
					$('#send_chat').attr('disabled', false);
					receiver_id = $(this).data('receiver_id');
					var receiver_name = $(this).text();
					$('#dynamic_title').text(' with ' + receiver_name);
					$(".user_chat_list").removeClass("active");
					$(this).addClass('active');
					get_chat_conversation(receiver_id, 'yes');
					$('#chat_body').scrollTop($('#chat_body')[0].scrollHeight);
				});

				// send message
				$('#message_area').keypress(function(e) {
					if (e.keyCode == 13 && !e.shiftKey) {
						e.preventDefault();
						$("#send_chat").click();
					}
				});
				$(document).on('click', '#send_chat', function(e) {
					var chat_message = $.trim($('#message_area').val());
					if (chat_message != '') {
						$.ajax({
							url: "<?= base_url(); ?>admin/messaging/message",
							method: "GET",
							data: {
								receiver_id: receiver_id,
								chat_message: chat_message
							},
							beforeSend: function() {
								$('#send_chat').attr('disabled', 'disabled');
							},
							success: function(data) {
								$('#message_area').val('');
								$('#chat_body').animate({
									scrollTop: $('#chat_body')[0].scrollHeight
								});
							}
						});
					}

				});

				// get chat users
				function get_chats() {
					$.ajax({
						url: "<?= base_url(); ?>admin/messaging/get/staff",
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

									output += '<img src="http://localhost/skearch/base/assets/admin_panel/app/media/img/users/user-default.jpg" class="img-circle" width="35" />';

									output += ' ' + data[count].firstname + ' ' + data[count].lastname;

									output += '&nbsp;<span id="chat_notification_' + data[count].receiver_id + '"></span>';

									output += '&nbsp;<span id="type_notifitcation_' + data[count].receiver_id + '"></span>';

									output += ' <i class="offline" id="online_status_' + data[count].receiver_id + '" style="float:right;">&nbsp;</i></li>';

									receiver_id_array += data[count].receiver_id + ',';
								}
								$('#hidden_receiver_id_array').val(receiver_id_array);
							} else {
								output += '<div align="center">No Chats Found</div>';
							}
							output += '</ul>';
							$('#chat_user_area').html(output);
						}
					})
				}

				// get chat conversation
				function get_chat_conversation(receiver_id, update_data) {
					$.ajax({
						url: "<?= base_url(); ?>admin/messaging/get/conversation",
						method: "GET",
						data: {
							receiver_id: receiver_id,
							update_data: update_data
						},
						dataType: "json",
						success: function(data) {
							var html = '';
							for (var count = 0; count < data.length; count++) {
								if (data[count].message_direction == 'left') {
									html += '<div class="m-messenger__wrapper">';
									html += '<div class="m-messenger__message m-messenger__message--in">';
									html += '<div class="m-messenger__message-pic">';
									html += '<img src="<?= site_url(ASSETS); ?>/admin_panel/app/media/img/users/user-default.jpg" alt="" />';
									html += '</div>';
								} else {
									html += '<div class="m-messenger__wrapper">';
									html += '<div class="m-messenger__message m-messenger__message--out">';
								}
								html += '<div class="m-messenger__message-body">';
								html += '<div class="m-messenger__message-arrow"></div>';
								html += '<div class="m-messenger__message-content">';
								html += '<div class="m-messenger__message-username">';
								html += data[count].chat_messages_datetime;
								html += '</div>';
								html += '<div class="m-messenger__message-text">';
								html += data[count].chat_messages_text;
								html += '</div>';
								html += '</div>';
								html += '</div>';
								html += '</div>';
								html += '</div>';
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
					// 	if ($.trim($('#message_area').text()) != '') {
					// 		is_type = 'yes';
					// 	}
					// }

					$.ajax({
						url: "<?= base_url(); ?>admin/messaging/get/notifications",
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
			});
		</script>

		<script src="<?= site_url(ASSETS); ?>/admin_panel/vendors/custom/jquery-ui/jquery-ui.bundle.js" type="text/javascript"></script>
		<script src="<?= site_url(ASSETS); ?>/plugins/easyautocomplete/jquery.easy-autocomplete.min.js"></script>


		<!--end::Page Scripts -->

		</body>

		<!-- end::Body -->

		</html>