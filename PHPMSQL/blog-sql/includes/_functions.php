<?php 

	function addEmoticons($txt)
	{
		$thisEmoticon = "<img src=\"emoticons/icon_biggrin.gif\">";
		$txt = str_replace(":D",$thisEmoticon,$txt);

		$thisEmoticon = "<img src=\"emoticons/icon_cool.gif\">";
		$txt = str_replace("B-)",$thisEmoticon,$txt);

		$thisEmoticon = "<img src=\"emoticons/icon_sad.gif\">";
		$txt = str_replace(":(",$thisEmoticon,$txt);

		$thisEmoticon = "<img src=\"emoticons/icon_surprised.gif\">";
		$txt = str_replace(":O",$thisEmoticon,$txt);

		$thisEmoticon = "<img src=\"emoticons/icon_wink.gif\">";
		$txt = str_replace(";)",$thisEmoticon,$txt);

		$thisEmoticon = "<img src=\"emoticons/icon_smile.gif\">";
		$txt = str_replace(":)",$thisEmoticon,$txt);

		$thisEmoticon = "<img src=\"emoticons/icon_confused.gif\">";
		$txt = str_replace(":S",$thisEmoticon,$txt);


		return $txt;


	}
 ?>