window.history.forward();
var map={};
var isNS = (navigator.appName == "Netscape") ? 1 : 0;
if (navigator.appName == "Netscape") document.captureEvents(Event.MOUSEDOWN || Event.MOUSEUP);

function mischandler() {
    return false;
}
function mousehandler(e) {
    var myevent = (isNS) ? e : event;
    var eventbutton = (isNS) ? myevent.which : myevent.button;
    if ((eventbutton == 2) || (eventbutton == 3)) return false;
}

document.oncontextmenu = mischandler;
document.onmousedown = mousehandler;
document.onmouseup = mousehandler;

onkeydown = onkeyup = function(e){
    e = e || event; // to deal with IE
    map[e.keyCode] = e.type == 'keydown';
    
	if(map[17] && map[16] && map[65]){ // CTRL+SHIFT+A
		return false;
	}
	else if(map[17] && map[16] && map[66]){ // CTRL+SHIFT+B
		return false;
	}
	else if(map[17] && map[16] && map[67]){ // CTRL+SHIFT+C
		return false;
	}
	else if(map[16]){ // SHIFT+F10
		//return false;
	}
	else if(map[121]){ // SHIFT+F10
		return false;
	}
	//else if(map[112] || map[113] || map[114] || map[115] || map[117] || map[118] || map[119] || map[120] || map[121] || map[122] || map[123]){ // F10
		//return false;
	//}
	else if(map[27]){ // ESC
		return false;
	}
	else if(map[35]){ // End
		//return false;
	}
	else if(map[36]){ // Home
		//return false;
	}
	else if(map[46]){ // Delete
		//return false;
	}
}
document.onkeydown = function (e) {
	if(e.which == 44){
		return false;
	}
}

function disableCtrlKeyCombination(e)
{
	var forbiddenKeys = new Array("a", "s", "c", "x", "u", "p", "d");
	var key;
	var isCtrl;
	/****************** F5 Key ***********************/
	/*if (e.keyCode == 116) {
	//return false;
	  }*/
  
	if(window.event)
	{
		key = window.event.keyCode;     //IE
		if(window.event.ctrlKey)
			isCtrl = true;
		else
			isCtrl = false;
	}
	else
	{
		key = e.which;     //firefox
		if(e.ctrlKey)
			isCtrl = true;
		else
			isCtrl = false;
	}

	if(isCtrl)
	{
		for (i = 0; i < forbiddenKeys.length; i++)
		{
		   //case-insensitive comparation
		   if (forbiddenKeys[i].toLowerCase() == String.fromCharCode(key).toLowerCase())
		   {
		   return false;
		   }
		}
	}
	return true;
}

function mobileNumber(id){
	var MobNo = document.getElementById(id).value;
	var IndNum = /^[0]?[6789]\d{9}$/;
	
	if (MobNo.length != 10) {
		$('.div_'+id).html("Fill 10 digit mobile number.");
		$('.div_'+id).show();
        return false;
    }
	else if(!IndNum.test(MobNo) && MobNo != ''){
		$('.div_'+id).html("Please enter valid mobile number.");
		$('.div_'+id).show();
		return false;
	}			 
	else{
		$('.div_'+id).html("");
		$('.div_'+id).hide();
		return true;
	}
}

function emailAdd(id){
	var email = document.getElementById(id).value;			 
	var IndNum = /^[_A-za-z0-9-]+(\.[_A-za-z0-9-]+)*@[A-za-z0-9-]+(\.[A-za-z0-9-]+)*(\.[A-za-z]{2,})$/;
	
	if(!IndNum.test(email) && email != ''){
		$('.div_'+id).text("Please enter valid email address.");
		$('.div_'+id).show();
		return false;
	}			 
	else{
		$('.div_'+id).text("");
		$('.div_'+id).hide();
		return true;
	}
}

function urlValidate(id){
	var url = document.getElementById(id).value;			 
	var IndNum = /(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
	
	if(!IndNum.test(url)){
		$('.div_'+id).text("Please enter valid URL.");
		$('.div_'+id).show();
		return false;
	}			 
	else{
		$('.div_'+id).text("");
		$('.div_'+id).hide();
		return true;
	}
}

function chkPAN(id){
	var gstin = document.getElementById(id).value;			 
	var regex = /^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/;;
	
	if (gstin.length != 15) {
		$('.div_'+id).text("Please enter valid PAN Number. e.g. AAAAA1234A");
		$('.div_'+id).show();
        return false;
    }
	else if(!regex.test(gstin)){
		$('.div_'+id).text("Please enter valid PAN Number. e.g. AAAAA1234A");
		$('.div_'+id).show();
		return false;
	}			 
	else{
		$('.div_'+id).text("");
		$('.div_'+id).hide();
		return true;
	}
}

function chkGSTIN(id){
	var gstin = document.getElementById(id).value;			 
	var regex = /^([0-9]){2}([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}([0-9]){1}([a-zA-Z]){1}([a-zA-Z0-9]){1}?$/;;
	
	if (gstin.length != 15) {
		$('.div_'+id).text("Please enter valid GSTIN. e.g. 00AAAAA1234A0Z1");
		$('.div_'+id).show();
        return false;
    }
	else if(!regex.test(gstin)){
		$('.div_'+id).text("Please enter valid GSTIN. e.g. 00AAAAA1234A0Z1");
		$('.div_'+id).show();
		return false;
	}			 
	else{
		$('.div_'+id).text("");
		$('.div_'+id).hide();
		return true;
	}
}


// captcha js
var a = Math.ceil(Math.random() * 10);
var b = Math.ceil(Math.random() * 10);
var c = a + b;
function DrawBotBoot() {
    document.write("What is " + a + " + " + b + "? ");
    document.write("&nbsp;&nbsp;<input id='BotBootInput' type='text' maxlength='2' size='2'/>");
}

function ValidBotBoot() {
    var d = document.getElementById('BotBootInput').value;
    if (d == c) { return true; }
    else { return false; }
}

function percentage(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    else {
        return true;
    }
}

function checkdatecharacter(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode != 47 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    else {
        return true;
    }
}

function chktimepicker(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode != 77 && charCode != 80 && charCode != 65 && (charCode < 48 || charCode > 58)) {
        return false;
    }
    else {
        return true;
    }
}

function AllowAlphabet(e) {
    isIE = document.all ? 1 : 0
    keyEntry = !isIE ? e.which : event.keyCode;
    if (((keyEntry >= 65) && (keyEntry <= 90)) || ((keyEntry >= 97) && (keyEntry <= 122)) || (keyEntry == 46) || (keyEntry == 32) || keyEntry == 45 || keyEntry == 0 || keyEntry == 8) {
        return true;
    }
    else {
        return false;
    }
}

function onlyNumbers(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    else {
        return true;
    }
}

function isAlphaNumericCharater(evt) {
    var cc = (evt.which) ? evt.which : event.keyCode;
    if ((cc > 47 && cc < 58) || (cc > 64 && cc < 91) || (cc > 96 && cc < 123) || (cc == 32)) {
        return true;
    }
    else {
        return false;
    }
}

function addressValidation(e) {
    isIE = document.all ? 1 : 0
    keyEntry = !isIE ? e.which : event.keyCode;
    if (((keyEntry >= 65) && (keyEntry <= 90)) || ((keyEntry >= 97) && (keyEntry <= 122)) || (keyEntry == 46) || (keyEntry == 32) || keyEntry == 44 || keyEntry == 45 || keyEntry == 47 || keyEntry == 0 || keyEntry == 8 || keyEntry == 64 || keyEntry == 40  || keyEntry == 41 || ((keyEntry >= 48) && (keyEntry <= 57))) {
        return true;
    }
    else {
        return false;
    }
}

function StrModelChar(evt) {		
	var cc = (evt.which) ? evt.which : event.keyCode;
	//alert(cc);
	var cc = (evt.which) ? evt.which : event.keyCode;
    if ((cc > 47 && cc < 58) || (cc > 64 && cc < 91) || (cc > 96 && cc < 123) || cc == 32 || cc == 37 || cc == 45 || cc == 47 || cc == 40 || cc == 41 || cc == 91 || cc == 93) {
        return true;
    }
    else {
        return false;
    }
}

function StrValdSomeSpeclChar(evt) {		
	var cc = (evt.which) ? evt.which : event.keyCode;
	//alert(cc);
	if (cc == 40 || cc == 41 || cc == 44 || cc == 46  || cc == 47 || cc == 45 || cc == 39 ||  cc == 32 || (cc > 64 && cc < 91) || (cc > 96 && cc < 123) || (cc > 47 && cc < 58)) {
		return true;
	}
	else {
		return false;
	}
}

function ValidateFullNamePaste(obj) {
    var totalCharacterCount = window.clipboardData.getData('Text');
    var strValidChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ";
    var strChar;
    var FilteredChars = "";
    for (i = 0; i < totalCharacterCount.length; i++) {
        strChar = totalCharacterCount.charAt(i);
        if (strValidChars.indexOf(strChar) != -1) {
            FilteredChars = FilteredChars + strChar;
        }
    }
    obj.value = FilteredChars;
    return false;
}

function isDate(DateTextBox_Value, DateMessageBox, MinDate, MaxDate) {
    try {
        var OK = true;
        var value = DateTextBox_Value;
        if (MinDate == '' && value != '') {
            OK = false;
        }

        if (value.length != 10 && value != '') {
            OK = false;
        }
        var DayIndex = 0;
        var MonthIndex = 1;
        var YearIndex = 2;

        var SplitValue = value.split("/");
        if (value != '') {
            if (!(SplitValue[DayIndex].length == 1 || SplitValue[DayIndex].length == 2)) {
                OK = false;
            }
            if (OK && !(SplitValue[MonthIndex].length == 1 || SplitValue[MonthIndex].length == 2)) {
                OK = false;
            }
            if (OK && SplitValue[YearIndex].length != 4) {
                OK = false;
            }
            if (OK) {
                var Day = parseInt(SplitValue[DayIndex], 10);
                var Month = parseInt(SplitValue[MonthIndex], 10);
                var Year = parseInt(SplitValue[YearIndex], 10);

                if (OK = ((Year > 1900) && (Year - 1 < new Date().getFullYear()))) {
                    if (OK = (Month <= 12 && Month > 0)) {

                        var LeapYear = (((Year % 4) == 0) && ((Year % 100) != 0) || ((Year % 400) == 0));

                        if (OK = Day > 0) {
                            if (Month == 2) {
                                OK = LeapYear ? Day <= 29 : Day <= 28;
                            }
                            else {
                                if ((Month == 4) || (Month == 6) || (Month == 9) || (Month == 11)) {
                                    OK = Day <= 30;
                                }
                                else {
                                    OK = Day <= 31;
                                }
                            }
                        }
                    }
                }
            }
        }

        //here check date after today
        /////////////////////////////////////////////////////
        if (OK == true && value != '') {
            var x = new Date();
            x.setFullYear(Year, Month - 1, Day);

            var today = new Date();
            if (MaxDate != undefined) {
                var SplitValue1 = MaxDate.split("/");
                var CurrentDay = parseInt(SplitValue1[DayIndex], 10);
                var CurrentMonth = parseInt(SplitValue1[MonthIndex], 10);
                var CurrentYear = parseInt(SplitValue1[YearIndex], 10);
                today.setFullYear(CurrentYear, CurrentMonth - 1, CurrentDay);
            }
            if (x > today) {
                OK = false;
                //alert(OK);
            }
        }
        /////////////////////////////////////////////////////

        //here check minimum date
        /////////////////////////////////////////////////////

        if (OK == true && value != '') {
            var SplitValue2 = MinDate.split("/");
            var MinDay = parseInt(SplitValue2[0], 10);
            var MinMonth = parseInt(SplitValue2[1], 10);
            var MinYear = parseInt(SplitValue2[2], 10);

            var x1 = new Date();
            x1.setFullYear(Year, Month - 1, Day);

            var MinDate1 = new Date();
            MinDate1.setFullYear(MinYear, MinMonth - 1, MinDay);

            if (x1 < MinDate1) {
                OK = false;
            }
        }

        if (OK == false) {			
            $('#'+DateMessageBox).text('Enter Correct Date');
        }
        else {
            $('#'+DateMessageBox).text('');
        }
        return OK;
    }
    catch (e) {
        return false;
    }
}

function isDate1(DateMessageBox) {
    document.getElementById(DateMessageBox).innerHTML = "";
}


function readURL(input, img_prev_object) {
    img_prev = document.getElementById(img_prev_object);
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(img_prev)
                    .attr('src', e.target.result)
            ;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
//Code Starts
var isIE = navigator.userAgent.toLowerCase().indexOf("msie");

function SetWidthToAuto(drpLst) {
    if (isIE > -1) {
        drpLst.style.width = 'auto';
    }
}

function ResetWidth(drpLst) {
    if (isIE > -1) {
        drpLst.style.width = '150px';
    }
}


function validatePassword() 
{
	var newPassword = document.getElementById('txtNewPassword').value;
	var ConfPassword = document.getElementById('txtConfirmPassword').value;
	var minNumberofChars = 7;
	var maxNumberofChars = 20;
	var regularExpression  = /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/;
	//alertify.alert(newPassword); 
	if(newPassword != ConfPassword)
	{
		alertify.alert("Please Check Password & Confirm Password are not matching");
		return false; 
	}
	else if(newPassword == ConfPassword)
	{
		if(newPassword.length < minNumberofChars || newPassword.length > maxNumberofChars)
		{
			alertify.alert("Password Length in 7-20");
			return false;
		}
		else if(!regularExpression.test(newPassword)) 
		{
			alertify.alert("1. Password Length must be greater than 7 <br> 2. Password must use a combination of Lower case letters (a &#8211; z).<br> 3. Password must use a combination of Atleast 1 upper case letters (A &#8211; Z). <br> 4. Password must use a combination of Atleast 1 number (0 &#8211; 9). <br> 5. Must use a combination of At least one Special Characters: like (# $ % & ( ) * +  , - . / : ; < = > ? @ [ \ ]). <br><br> Please note down your password to login in future.");
			return false;
		}
	}
}

function ageVailidate(ageValidatorId) 
{
	var age = parseInt($('#'+ageValidatorId).val());
	
    if (age > 150 || age <= 0) 
	{
		alert("Invalid Age !!. Age should be greater than 0 or less than 150.");
		$('#'+ageValidatorId).val('');
		$('#'+ageValidatorId).focus();
        return false;
    }
    else 
	{
        return true;
    }
}


function yearVailidate(yearValidatorId) 
{
	var Cdate = new Date();
	var currentYear = parseInt(Cdate.getFullYear());
	var Year = parseInt($('#'+yearValidatorId).val());
    if ((currentYear < Year && Year >= 1950) || Year <1950 ) 
	{
		alert("Invalid Year !!. It should be greater than or equal to 1950 or less than or equal to "+currentYear+".");
		$('#'+yearValidatorId).val('');
		$('#'+yearValidatorId).focus();
        return false;
    }

    else 
	{
        return true;
    }
}