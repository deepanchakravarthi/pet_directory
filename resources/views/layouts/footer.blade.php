<!--============================= FOOTER =============================-->
    <footer>
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-2">
                    <div class="foot-box">
                        <h6>{{ trans('words.footer_footer1_header') }}</h6>
                        <ul>
                            <li><a href="#">{{ trans('words.footer_footer1_line1') }}</a></li>
                            <li><a href="#">{{ trans('words.footer_footer1_line2') }}</a></li>
                            <li><a href="#">{{ trans('words.footer_footer1_line3') }}</a></li>
                            <li><a href="#">{{ trans('words.footer_footer1_line4') }}</a></li>
                            <li><a href="#">{{ trans('words.footer_footer1_line5') }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="foot-box">
                        <h6>{{ trans('words.footer_footer2_header') }}</h6>
                        <ul>
                            <li>{{ trans('words.footer_footer2_line1') }}</li>
                            <li>{{ trans('words.footer_footer2_line2') }}</li>
                            <li>{{ trans('words.footer_footer2_line3') }}</li>
                            <li>{{ trans('words.footer_footer2_line4') }}</li>
                            <li>{{ trans('words.footer_footer2_line5') }}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="foot-box">
                        <h6>{{ trans('words.footer_footer3_header') }}</h6>
                        <ul>
                            <li>{{ trans('words.footer_footer3_line1') }}</li>
                            <li>{{ trans('words.footer_footer3_line2') }}</li>
                            <li>{{ trans('words.footer_footer3_line3') }}</li>
                            <li>{{ trans('words.footer_footer3_line4') }}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="subscribe">
                        <h6>{{ trans('words.footer_footer4_header') }}</h6>
                        
                        <div class="social-icons">
                            <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="copyright">
                        <a href="#">&copy; {{ date('Y') }} {{ SITE_NAME }}. {{ trans('words.footer_allrights') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--//END FOOTER -->

    <!-- jQuery, Bootstrap JS. -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ SITE_PATH }}/js/jquery-3.2.1.min.js?v=2"></script>
    <script src="{{ SITE_PATH }}/js/popper.min.js?v=2"></script>
    <script src="{{ SITE_PATH }}/js/bootstrap.min.js?v=2"></script>
    <script src="{{ SITE_PATH }}/js/script.js?v=2"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type="text/javascript" src="{{ SITE_PATH }}/js/jquery.timepicker.js"></script>
	
	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap4.min.js"></script>
</body>

</html>
<script>
	$( function() {
		$( "#date_of_birth" ).datepicker();
		$( ".datepicker" ).datepicker();
		$('.timepicker').timepicker();
	} );
	
	function confirmOffer(id, type) {
		$('#confirm_offer_error_message_'+id+'_'+type).hide();
		$.post('{{ SITE_PATH }}/pet/confirm-offer', {
			pet_id: id,
			'_token' : '{{ csrf_token() }}',
			new_owner_email : $('#new_owner_email_'+id+'_'+type).val()
		}, function(data){
			if($.trim(data) == 0) {
				$('#confirm_offer_error_message_'+id+'_'+type).html('{{ trans("words.footer_script_something_went_wrong") }}');
				$('#confirm_offer_error_message_'+id+'_'+type).css('color', 'red');
				$('#confirm_offer_error_message_'+id+'_'+type).show();
				return false;
			} else if($.trim(data) == 2) {
				$('#confirm_offer_error_message_'+id+'_'+type).html('{{ trans("words.footer_script_you_are_restricted") }}');
				$('#confirm_offer_error_message_'+id+'_'+type).css('color', 'red');
				$('#confirm_offer_error_message_'+id+'_'+type).show();
				return false;
			} else if($.trim(data) == 3) {
				$('#confirm_offer_error_message_'+id+'_'+type).html('{{ trans("words.footer_script_already_done") }}');
				$('#confirm_offer_error_message_'+id+'_'+type).css('color', 'green');
				$('#confirm_offer_error_message_'+id+'_'+type).show();
				if(type == 1) {
					$('#confirm_offer_form_'+id+'_'+type).hide();
				} else {
					$('#assign_offer_form_'+id+'_'+type).hide();
				}
				setTimeout(function(){
				   window.location.reload(1);
				}, 1000);
			} else {
				$('#confirm_offer_error_message_'+id+'_'+type).html('{{ trans("words.footer_script_done") }}');
				$('#confirm_offer_error_message_'+id+'_'+type).css('color', 'green');
				$('#confirm_offer_error_message_'+id+'_'+type).show();
				if(type == 1) {
					$('#confirm_offer_form_'+id+'_'+type).hide();
				} else {
					$('#assign_offer_form_'+id+'_'+type).hide();
				}
				setTimeout(function(){
				   window.location.reload(1);
				}, 1000);
			}
		});
	}
	function confirmVetOffer(id) {
		$('#confirm_vet_offer_error_message_'+id).hide();
		$.post('{{ SITE_PATH }}/pet/confirm-offer', {
			pet_id: id,
			'_token' : '{{ csrf_token() }}',
			new_owner_email : $('#vet_email_'+id).val()
		}, function(data){
			if($.trim(data) == 0) {
				$('#confirm_vet_offer_error_message_'+id).html('{{ trans("words.footer_script_something_went_wrong") }}');
				$('#confirm_vet_offer_error_message_'+id).css('color', 'red');
				$('#confirm_vet_offer_error_message_'+id).show();
				return false;
			} else if($.trim(data) == 2) {
				$('#confirm_vet_offer_error_message_'+id).html('{{ trans("words.footer_script_you_are_restricted") }}');
				$('#confirm_vet_offer_error_message_'+id).css('color', 'red');
				$('#confirm_vet_offer_error_message_'+id).show();
				return false;
			} else if($.trim(data) == 3) {
				$('#confirm_vet_offer_error_message_'+id).html('{{ trans("words.footer_script_already_done") }}');
				$('#confirm_vet_offer_error_message_'+id).css('color', 'green');
				$('#confirm_vet_offer_error_message_'+id).show();
				$('#confirm_vet_offer_form_'+id).hide();
				setTimeout(function(){
				   window.location.reload(1);
				}, 1000);
			} else {
				$('#confirm_vet_offer_error_message_'+id).html('{{ trans("words.footer_script_done") }}');
				$('#confirm_vet_offer_error_message_'+id).css('color', 'green');
				$('#confirm_vet_offer_error_message_'+id).show();
				$('#confirm_vet_offer_form_'+id).hide();
				setTimeout(function(){
				   window.location.reload(1);
				}, 1000);
			}
		});
	}
	function confirmFound(id) {
		$('#confirm_found_error_message_'+id).hide();
		$.post('{{ SITE_PATH }}/pet/confirm-found', {
			pet_id: id,
			'_token' : '{{ csrf_token() }}'
		}, function(data){
			if($.trim(data) == 0) {
				$('#confirm_found_error_message_'+id).html('{{ trans("words.footer_script_something_went_wrong") }}');
				$('#confirm_found_error_message_'+id).css('color', 'red');
				$('#confirm_found_error_message_'+id).show();
				return false;
			} else if($.trim(data) == 2) {
				$('#confirm_found_error_message_'+id).html('{{ trans("words.footer_script_you_are_restricted") }}');
				$('#confirm_found_error_message_'+id).css('color', 'red');
				$('#confirm_found_error_message_'+id).show();
				return false;
			} else {
				$('#confirm_found_error_message_'+id).html('{{ trans("words.footer_script_thank_you_for_confirmation") }}');
				$('#confirm_found_error_message_'+id).css('color', 'green');
				$('#confirm_found_error_message_'+id).show();
				$('#confirm_found_form_'+id).hide();
				setTimeout(function(){
				   window.location.reload(1);
				}, 1000);
			}
		});
	}
	
	function confirmLost(id) {
		$('#confirm_lost_error_message_'+id).hide();
		$.post('{{ SITE_PATH }}/pet/confirm-lost', {
			pet_id: id,
			'_token' : '{{ csrf_token() }}',
			lost_location : $('#lost_location_'+id).val(),
			lost_date : $('#lost_date_'+id).val(),
			lost_time : $('#lost_time_'+id).val()
		}, function(data){
			if($.trim(data) == 0) {
				$('#confirm_lost_error_message_'+id).html('{{ trans("words.footer_script_something_went_wrong") }}');
				$('#confirm_lost_error_message_'+id).css('color', 'red');
				$('#confirm_lost_error_message_'+id).show();
				return false;
			} else if($.trim(data) == 2) {
				$('#confirm_lost_error_message_'+id).html('{{ trans("words.footer_script_you_are_restricted") }}');
				$('#confirm_lost_error_message_'+id).css('color', 'red');
				$('#confirm_lost_error_message_'+id).show();
				return false;
			} else {
				$('#confirm_lost_error_message_'+id).html('{{ trans("words.footer_script_sorry") }}');
				$('#confirm_lost_error_message_'+id).css('color', 'green');
				$('#confirm_lost_error_message_'+id).show();
				$('#confirm_lost_form_'+id).hide();
				//window.open('{{ SITE_PATH }}/create-poster/'+id, '_blank');
				location.href='{{ SITE_PATH }}/create-poster/'+id;
				setTimeout(function(){
					window.location.reload(1);
				}, 2000);
			}
		});
	}
	
	function confirmDeath(id) {
		$('#confirm_death_error_message_'+id).hide();
		$.post('{{ SITE_PATH }}/pet/confirm-death', {
			pet_id: id,
			'_token' : '{{ csrf_token() }}',
			date_of_death: $('#date_of_death_'+id).val(),
			cause_of_death: $('#cause_of_death_'+id).val()
		}, function(data){
			if($.trim(data) == 0) {
				$('#confirm_death_error_message_'+id).html('{{ trans("words.footer_script_something_went_wrong") }}');
				$('#confirm_death_error_message_'+id).css('color', 'red');
				$('#confirm_death_error_message_'+id).show();
				return false;
			} else if($.trim(data) == 2) {
				$('#confirm_death_error_message_'+id).html('{{ trans("words.footer_script_you_are_restricted") }}');
				$('#confirm_death_error_message_'+id).css('color', 'red');
				$('#confirm_death_error_message_'+id).show();
				return false;
			} else {
				$('#confirm_death_error_message_'+id).html('{{ trans("words.footer_script_sorry") }}');
				$('#confirm_death_error_message_'+id).css('color', 'green');
				$('#confirm_death_error_message_'+id).show();
				$('#confirm_death_form_'+id).hide();
				setTimeout(function(){
				   window.location.reload(1);
				}, 1000);
			}
		});
	}
	function confirmAddNote(id) {
		$('#add_note_error_message_'+id).hide();
		$.post('{{ SITE_PATH }}/pet/confirm-addnote', {
			pet_id: id,
			'_token' : '{{ csrf_token() }}',
			notes: $('#notes_'+id).val()
		}, function(data){
			if($.trim(data) == 0) {
				$('#add_note_error_message_'+id).html('{{ trans("words.footer_script_note_required") }}');
				$('#add_note_error_message_'+id).css('color', 'red');
				$('#add_note_error_message_'+id).show();
				return false;
			} else if($.trim(data) == 2) {
				$('#add_note_error_message_'+id).html('{{ trans("words.footer_script_you_are_restricted") }}');
				$('#add_note_error_message_'+id).css('color', 'red');
				$('#add_note_error_message_'+id).show();
				return false;
			} else {
				$('#add_note_error_message_'+id).html('{{ trans("words.footer_script_note_added") }}');
				$('#add_note_error_message_'+id).css('color', 'green');
				$('#add_note_error_message_'+id).show();
				$('#add_note_form_'+id).hide();
				setTimeout(function(){
				   window.location.reload(1);
				}, 1000);
			}
		});
	}
	function validateSearchForm() {
		if($.trim($('#id').val()) != '') {
			return true;
		} else {
			$('#id').focus();
			$('#tooltip').popover('show');
			return false;
		}
	}
	$('[data-toggle="popover"]').popover();
	var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    
	function validateResultForm() {
		$('#search_resut_form').hide();
		if($.trim($('#your_name').val()) == '' || $.trim($('#your_email').val()) == '' || $.trim($('#your_phone').val()) == '' || $.trim($('#location').val()) == '' || $.trim($('#your_message').val()) == '') {
			$('#search_resut_form').html('{{ trans("words.footer_script_all_fields_required") }}');
			$('#search_resut_form').css('color', 'red');
			$('#search_resut_form').show();
		}
		if($.trim($('#your_name').val()) == '') {
			$('#your_name').focus();
			return false;
		} else if($.trim($('#your_email').val()) == '') {
			$('#your_email').focus();
			return false;
		} else if(!pattern.test($('#your_email').val())) {
			$('#search_resut_form').html('{{ trans("words.footer_script_enter_valid_email") }}');
			$('#your_email').focus();
			return false;
		} else if($.trim($('#your_phone').val()) == '') {
			$('#your_phone').focus();
			return false;
		} else if($.trim($('#location').val()) == '') {
			$('#location').focus();
			return false;
		} else if($.trim($('#your_message').val()) == '') {
			$('#your_message').focus();
			return false;
		}
		$.post('{{ SITE_PATH }}/search-result-response', {
			'_token' : '{{ csrf_token() }}',
			pet_id: $('#pet_id').val(),
			your_name: $('#your_name').val(),
			your_email: $('#your_email').val(),
			your_phone: $('#your_phone').val(),
			location: $('#location').val(),
			your_message: $('#your_message').val()
			}, function(data){
				if(data == 1) {
					$('#search-result-form-div').hide();
					$('#search_resut_form').html('{{ trans("words.footer_script_thank_you_pet_will_contact") }}');
					$('#search_resut_form').css('color', 'green');
					$('#search_resut_form').show();
				} else {
					$('#search_resut_form').html('{{ trans("words.footer_script_something_went_wrong") }}');
					$('#search_resut_form').css('color', 'red');
					$('#search_resut_form').show();
				}
		});
	}
	function validateResultFormAuthority() {
		$('#search_resut_form_authority').hide();
		if($.trim($('#your_message').val()) == '') {
			$('#search_resut_form_authority').html('{{ trans("words.footer_script_message_required") }}');
			$('#search_resut_form_authority').css('color', 'red');
			$('#search_resut_form_authority').show();
			$('#your_message').focus();
			return false;
		} else if(!$("#confirm").prop('checked')) {
			$('#search_resut_form_authority').html('{{ trans("words.footer_script_confirmation_required") }}');
			$('#search_resut_form_authority').css('color', 'red');
			$('#search_resut_form_authority').show();
			$('#your_message').focus();
			return false;
		} else {
			$.post('{{ SITE_PATH }}/search-result-response-authority', {
				'_token' : '{{ csrf_token() }}',
				pet_id: $('#pet_id').val(),
				your_message: $('#your_message').val()
				}, function(data){
					if(data == 1) {
						$('#authority_form').hide();
						$('#authority_form2').hide();
						
						$('#search_resut_form_authority').html('{{ trans("words.footer_script_thank_you_pet_will_contact") }}');
						$('#search_resut_form_authority').css('color', 'green');
						$('#search_resut_form_authority').show();
					} else {
						$('#search_resut_form_authority').html('{{ trans("words.footer_script_something_went_wrong") }}');
						$('#search_resut_form_authority').css('color', 'red');
						$('#search_resut_form_authority').show();
					}
			});
		}
	}
	function checkPlan() {
		if($('#plan').val() == 3) {
			$('#voucher_term').show();
			$('#voucher_term_div').show();
		} else {
			$('#voucher_term').hide();
			$('#voucher_term_div').hide();
		}
	}
	$(document).ready(function() {
		$('#datatable').DataTable({
			"language": {
				"decimal":        "",
				"emptyTable":     "No data available in table",
				"info":           "{{ trans('words.showing') }} _START_ {{ trans('words.to') }} _END_ {{ trans('words.of') }} _TOTAL_ {{ trans('words.entries') }}",
				"infoEmpty":      "Showing 0 to 0 of 0 entries",
				"infoFiltered":   "(filtered from _MAX_ total entries)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "{{ trans('words.show') }} _MENU_ {{ trans('words.entries') }}",
				"loadingRecords": "Loading...",
				"processing":     "Processing...",
				"search":         "{{ trans('words.search') }}:",
				"zeroRecords":    "{{ trans('words.notmatch') }}",
				"paginate": {
					"first":      "{{ trans('words.first') }}",
					"last":       "{{ trans('words.last') }}",
					"next":       "{{ trans('words.next') }}",
					"previous":   "{{ trans('words.previous') }}"
				},
				"aria": {
					"sortAscending":  ": activate to sort column ascending",
					"sortDescending": ": activate to sort column descending"
				}
			}
		});
		$('#datatable1').DataTable({
			"language": {
				"decimal":        "",
				"emptyTable":     "No data available in table",
				"info":           "{{ trans('words.showing') }} _START_ {{ trans('words.to') }} _END_ {{ trans('words.of') }} _TOTAL_ {{ trans('words.entries') }}",
				"infoEmpty":      "Showing 0 to 0 of 0 entries",
				"infoFiltered":   "(filtered from _MAX_ total entries)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "{{ trans('words.show') }} _MENU_ {{ trans('words.entries') }}",
				"loadingRecords": "Loading...",
				"processing":     "Processing...",
				"search":         "{{ trans('words.search') }}:",
				"zeroRecords":    "{{ trans('words.notmatch') }}",
				"paginate": {
					"first":      "{{ trans('words.first') }}",
					"last":       "{{ trans('words.last') }}",
					"next":       "{{ trans('words.next') }}",
					"previous":   "{{ trans('words.previous') }}"
				},
				"aria": {
					"sortAscending":  ": activate to sort column ascending",
					"sortDescending": ": activate to sort column descending"
				}
			}
		});
		$('#datatable2').DataTable({
			"language": {
				"decimal":        "",
				"emptyTable":     "No data available in table",
				"info":           "{{ trans('words.showing') }} _START_ {{ trans('words.to') }} _END_ {{ trans('words.of') }} _TOTAL_ {{ trans('words.entries') }}",
				"infoEmpty":      "Showing 0 to 0 of 0 entries",
				"infoFiltered":   "(filtered from _MAX_ total entries)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "{{ trans('words.show') }} _MENU_ {{ trans('words.entries') }}",
				"loadingRecords": "Loading...",
				"processing":     "Processing...",
				"search":         "{{ trans('words.search') }}:",
				"zeroRecords":    "{{ trans('words.notmatch') }}",
				"paginate": {
					"first":      "{{ trans('words.first') }}",
					"last":       "{{ trans('words.last') }}",
					"next":       "{{ trans('words.next') }}",
					"previous":   "{{ trans('words.previous') }}"
				},
				"aria": {
					"sortAscending":  ": activate to sort column ascending",
					"sortDescending": ": activate to sort column descending"
				}
			}
		});
		$('#datatable3').DataTable({
			"language": {
				"decimal":        "",
				"emptyTable":     "No data available in table",
				"info":           "{{ trans('words.showing') }} _START_ {{ trans('words.to') }} _END_ {{ trans('words.of') }} _TOTAL_ {{ trans('words.entries') }}",
				"infoEmpty":      "Showing 0 to 0 of 0 entries",
				"infoFiltered":   "(filtered from _MAX_ total entries)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "{{ trans('words.show') }} _MENU_ {{ trans('words.entries') }}",
				"loadingRecords": "Loading...",
				"processing":     "Processing...",
				"search":         "{{ trans('words.search') }}:",
				"zeroRecords":    "{{ trans('words.notmatch') }}",
				"paginate": {
					"first":      "{{ trans('words.first') }}",
					"last":       "{{ trans('words.last') }}",
					"next":       "{{ trans('words.next') }}",
					"previous":   "{{ trans('words.previous') }}"
				},
				"aria": {
					"sortAscending":  ": activate to sort column ascending",
					"sortDescending": ": activate to sort column descending"
				}
			}
		});
	} );
	function generatePassword() {
		var length = 8,
			charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
			retVal = "";
		for (var i = 0, n = charset.length; i < length; ++i) {
			retVal += charset.charAt(Math.floor(Math.random() * n));
		}
		$('#create_user_password').val(retVal);
		$('#create_user_cpassword').val(retVal);
	}
	generatePassword();
</script>