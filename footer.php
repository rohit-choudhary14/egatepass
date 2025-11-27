
	<div id="modalSetEstablishment" class="modal fade" role="dialog">
		<div class="modal-dialog modal-md">		
			<div class="modal-content modal-content">
				<form class="form-horizontal">
					<div class="modal-header text-center">
						<span class="caption" style="font-size:15px; font-weight:bold; color:#373cd8;">Select Establishment</span>
					</div>
					<div class="modal-body">
						<div class="row" >
							<div class="form-group">
								<div class="col-md-12 text-center">
									<label class="radio-inline">
										<input type="radio" name="estttype" class="estttype" value="P"> Principal Seat at Jodhpur
									</label>
									<label class="radio-inline">
										<input type="radio" name="estttype" class="estttype" value="B"> Bench at Jaipur
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<div class="form-group text-center">
							<button type="button" onclick="SetUserEstt();" class="btn btn-primary">Continue</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php if(!isset($_SESSION['lawyer']['connection']) && isset($_SESSION['lawyer']['user_id']) && $_SESSION['lawyer']['user_id'] != '' && $showEsttDialog != 'No'){ ?>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#modalSetEstablishment').modal({
					backdrop:'static',
					keyboard:false
				});
				$('#modalSetEstablishment').modal('show');
			});
		</script>
	<?php } ?>

	<script type="text/javascript">
		function changeEstablishment(){
			$('#modalSetEstablishment').modal({
				backdrop:'static',
				keyboard:false
			});
			$('#modalSetEstablishment').modal('show');
		}
		
		function SetUserEstt(){
			var estt = $.trim($('.estttype:checked').val());
			if($('.estttype').is(':checked') == false){
				alert('Please select establishment.');
			}
			else{
				$('#loading').show();
				ajaxRequest = $.ajax ({
					type: 'post',
					evalScripts: true,
					url:"ajax-responce.php",
					dataType:"JSON",
					data:"estt="+btoa(estt)+"&csrftoken="+$('#csrftoken').val()+"&QueryType=setestt",
					success:function(data){
						var dataArr = data.split('##');
						$('#csrftoken').val(dataArr[1]);
						if(dataArr[0] == 'OK'){
							if(estt == 'P'){
								$('#lblestt').text(' (Jodhpur)');
							}
							else if(estt == 'B'){
								$('#lblestt').text(' (Jaipur)');
							}
							
							/*setTimeout(function(){
								getcasetype();
							}, 100);*/
							
							alert('Establishment set successfully.');
							$('#modalSetEstablishment').modal('hide');
							
							location.reload();
						}
						else if(dataArr[0] == 'CSRF'){
							alert('Authentication Failed !!.');
						}
						else{
							alert('Something went wrong !!.');
						}
						$('#loading').hide();
					}
				});
			}
		}
		
		$('.dropdown').on('mouseenter mouseleave click tap', function() {
			$(this).toggleClass("open");
		});
	</script>
	  
	<script type="text/javascript">
		$(document).ready(function(){
			function ValidateEmail(email) {
				var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
				return expr.test(email);
			};
			  
		   $(".email_validation").blur(function () {
				if (!ValidateEmail($(this).val())) {
			   $(this).val("");
				}
				else {
							   
					return  true;
				}
			});
			
			$(document).on('keyup','.regExpForEnrNo',function(){
				var regexp = /[`~!@#$%^&*|+\=?;:'",.<>\{\}\[\]\\\/]/gi;
				var valueOfField = $(this).val();
				if(regexp.test(valueOfField))
				{
					var no_spl_char = valueOfField.replace(/[`~!@#$%^&*|+\=?;:'",.<>\{\}\[\]\\\/]/gi, '');
					$(this).val(no_spl_char);
				}
			});
			
			$(document).on('keyup','.regExpForTextField',function(){
				var regexp = /[`~!@#$%^&*()|+\=?;:'",.<>\{\}\[\]\\\/]/gi;
				var valueOfField = $(this).val();
				if(regexp.test(valueOfField))
				{
					var no_spl_char = valueOfField.replace(/[`~!@#$%^&*()|+\=?;:'",.<>\{\}\[\]\\\/]/gi, '');
					$(this).val(no_spl_char);
				}
			});
			
			$(document).on('keyup','.regExpForPassField',function(){
				var regexp = /[`~()|+\=?;:'",.<>\{\}\[\]\\\/]/gi;
				var valueOfField = $(this).val();
				if(regexp.test(valueOfField))
				{
					var no_spl_char = valueOfField.replace(/[`~()|+\=?;:'",.<>\{\}\[\]\\\/]/gi, '');
					$(this).val(no_spl_char);
				}
			});
			
			$(document).on('keyup','.regExpForEmailField',function(){
				var regexp = /[`~!#$%^&*()|+\=?;:'",<>\{\}\[\]\\\/]/gi;
				var valueOfField = $(this).val();
				if(regexp.test(valueOfField))
				{
					var no_spl_char = valueOfField.replace(/[`~!#$%^&*()|+\=?;:'",<>\{\}\[\]\\\/]/gi, '');
					$(this).val(no_spl_char);
				}
			});
			
			$(document).on('keyup','.regExpForEnrollnumberLogin',function(){
				var regexp = /[`~!#$%^&*|+\=?;:'",<>\{\}\[\]\\\/]/gi;
				var valueOfField = $(this).val();
				if(regexp.test(valueOfField))
				{
					var no_spl_char = valueOfField.replace(/[`~!#$%^&*|+\=?;:'",<>\{\}\[\]\\\/]/gi, '');
					$(this).val(no_spl_char);
				}
			});
			
			$(document).on('keydown', '.name_validation', function(e) {
			
			if (e.which === 32 &&  e.target.selectionStart === 0) {return false;}  });
			
			 $(".number_validation").keydown(function (e) {
				if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
					(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
					(e.keyCode >= 35 && e.keyCode <= 40)) {
						 return;
				}
				if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
					e.preventDefault();
				}
			});
			
		});
	</script>

	<footer class="container-fluid text-center" id="FooterDivHeight">
	<h5 id="footerHeading">Copyright &copy; Computer Cell - Rajasthan High Court</h5>
	</footer>
	<script>
		$(document).ready(function() {
		   var docHeight = $(window).height();
		   var footerHeight = $('#FooterDivHeight').height();
		   var footerTop = $('#FooterDivHeight').position().top + footerHeight;

		   if (footerTop < docHeight){
			   $('#FooterDivHeight').css('margin-top', (docHeight - footerTop)-2 + 'px');
		   }
		});
	 </script>
	 
<script>
    	$(document).ready(function() {
			var request = '';
			var divtxt = $('#fontdiv');
			$('#btnincfont').click(function() {
			var curSize = divtxt.css('fontSize');
			var newSize = parseInt(curSize.replace("px", "")) + 2;
			$(divtxt).css("fontSize", newSize + "px");
			});
			$('#btndecfont').click(function() {
			var curSize = divtxt.css('fontSize');
			var newSize = parseInt(curSize.replace("px", "")) - 2;
			$(divtxt).css("fontSize", newSize + "px");
			})
			
			var divtxt1 = $('.fontdiv1');
			var divtxt2 = $('.dropdown-menu-s');
			var divtxt3 = $('.domains-slider');
			var divtxt4 = $('.fontdiv2');
			var divtxt5 = $('.fontdiv3_1');
			var divtxt6 = $('.fontdiv3_2');
			var divtxt7 = $('.fontdiv1_1');
			var divtxt8 = $('.caption');
			$('#btnresetfont').click(function() {
					$(divtxt).css("font-size", "14px");
					$(divtxt1).css("font-size", "16px");
					$(divtxt2).css("font-size", "14px");
					$(divtxt3).css("font-size", "14px");
					$(divtxt4).css("font-size", "22px");
					$(divtxt5).css("font-size", "20px");
					$(divtxt6).css("font-size", "16px");
			})
			
			//for high contrast
		
		$('.blacklink1').click(function (){
				$('link[href="includes/css/stylesheet1.css"]').attr('href','includes/css/stylesheet1_hc.css');
			    
			});
			$('.whitelink').click(function (){
				$('link[href="includes/css/stylesheet1_hc.css"]').attr('href','includes/css/stylesheet1.css');
				
				});  
			
		});
		
</script>	 
	 
</body>
</html>