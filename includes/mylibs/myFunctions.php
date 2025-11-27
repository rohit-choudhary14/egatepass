<?php
// password encryption function
function pencrypt($pass1)
{
	$len = strlen($pass1);
	$x = 21;

	for($i = 0; $i < $len; ++$i)
	{
		$wChar = substr($pass1, $i, 1);           	// 'Start with the character at the 'count' position and go one unit
		$newASCII = ord($wChar) + $x;              	// 'Add the ASCII number to a random number 0-30
		$newString = $newString . chr($newASCII); 	//'Convert to regular character format and add to the new string			
		$x = $x + 1;
	}
	return $newString;
}
?>
