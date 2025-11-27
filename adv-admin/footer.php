<script>
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
</body>
</html>