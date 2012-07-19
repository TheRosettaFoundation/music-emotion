<?php
/*
Creation Date: 21 June 2012
Author: Ian O'Keeffe

Modification History:
--------------------------
21-06-2012
This code should parse HTML files so that soundtracks can be emotionally adapted

*/

//*************************************************************************************************************
//This function checks HTML-format files for emotion-specific soundtrack data
function checkME_HTM($file, $emotion){

	//Open HTML file using DOMDocument to access the tag information
	$htmlDom = new DOMDocument(); 		//To handle HTML format files 
	$htmlDom->loadHTML($file);		//Open $file as a DOMDocument XML file object
	
	echo $emotion." is the emotion code passed in to checkME.php <br>";

	//Find any <object> tags, search for soundtrack ones (tagged in the 'name' attribute)
	$objectTag = $htmlDom->getElementsByTagName('object');
	foreach ($objectTag as $object) {
		$objectName = $object->getAttribute('name');
		echo '<br>Soundtrack metadata before localisation:';
		
		if(substr($objectName, 0, 2) == 'S_')	{//we have a soundtrack object!
		$objectData = $object->getAttribute('data');
		
		//Now extract the metadata relating to the soundtrack
		$sLocale = substr($objectName, 2, 2);
		$sHour = substr($objectName, 5, 2);
		$sMinute = substr($objectName, 8, 2);
		$sSecond = substr($objectName, 11, 2);
		$sSpatial = substr($objectName, 15, 1);
		$sFileType = substr($objectName, 17, 3);
		$sEmotion = substr($objectName, 23, 4);
		$sGenre = substr($objectName, 30, 4);
		
		//IOK test echo for test purposes
		echo '<br><br>Locale: '.$sLocale;
		echo '<br>Hour: '.$sHour;
		echo '<br>Minute: '.$sMinute;
		echo '<br>Second: '.$sSecond;
		echo '<br>Spatial: '.$sSpatial;
		echo '<br>File Type: '.$sFileType;
		echo '<br>Emotion: '.$sEmotion;
		echo '<br>Genre: '.$sGenre;
		
		echo '<br><br>$objectData: '.$objectData;
		echo '<br>$objectName: '.$objectName;

				
		//Set up temporary array for music data
		$S_array[0][0] = 'http://127.0.0.1/SolasC_Soundtrack/resources/LRC_30s_Viral1_urban_music_orig.mp3';
		$S_array[1][0] = 'http://127.0.0.1/SolasC_Soundtrack/resources/LRC_30s_Viral1_urban_just_the_music_ES.mp3';
		$S_array[2][0] = 'http://127.0.0.1/SolasC_Soundtrack/resources/LRC_30s_Viral1_urban_just_the_music_IE.mp3';
		$S_array[3][0] = 'http://127.0.0.1/SolasC_Soundtrack/resources/LRC_30s_Viral1_urban_just_the_music_JP.mp3';
		$S_array[4][0] = 'http://127.0.0.1/SolasC_Soundtrack/resources/LRC_30s_Viral1_urban_just_the_music_US.mp3';
		$S_array[5][0] = 'http://127.0.0.1/SolasC_Soundtrack/resources/LRC_30s_Viral1_urban_music_angry.mp3';
		$S_array[6][0] = 'http://127.0.0.1/SolasC_Soundtrack/resources/LRC_30s_Viral1_urban_music_fear.mp3';
		$S_array[7][0] = 'http://127.0.0.1/SolasC_Soundtrack/resources/LRC_30s_Viral1_urban_music_joy.mp3';
		$S_array[8][0] = 'http://127.0.0.1/SolasC_Soundtrack/resources/LRC_30s_Viral1_urban_music_noEmotion.mp3';
		$S_array[9][0] = 'http://127.0.0.1/SolasC_Soundtrack/resources/LRC_30s_Viral1_urban_music_sadness.mp3';

		$S_array[0][1] = 'S_00_00h00m30s_S_mp3_E:Null_G:Folk';
		$S_array[1][1] = 'S_ES_00h00m30s_S_mp3_E:Null_G:Folk';
		$S_array[2][1] = 'S_IE_00h00m30s_S_mp3_E:Null_G:Folk';
		$S_array[3][1] = 'S_JP_00h00m30s_S_mp3_E:Null_G:Folk';
		$S_array[4][1] = 'S_US_00h00m30s_S_mp3_E:Null_G:Folk';
		$S_array[5][1] = 'S_00_00h00m30s_S_mp3_E:Ange_G:Null';
		$S_array[6][1] = 'S_00_00h00m30s_S_mp3_E:Fear_G:Null';
		$S_array[7][1] = 'S_00_00h00m30s_S_mp3_E:Joy _G:Null';
		$S_array[8][1] = 'S_00_00h00m30s_S_mp3_E:NoEm_G:Null';
		$S_array[9][1] = 'S_00_00h00m30s_S_mp3_E:Sadn_G:Null';
		
		//Now use the extracted metadata and the requested locale to find a suitable replacement soundtrack file
		for($i = 1; isset($S_array[$i][0]); $i++) {
			if($emotion == substr($S_array[$i][1], 23, 4)) { //only need to check for emotion at this stage. Will add duration etc. later
				//Now update the 'data' and 'name' attributes to match the required target locale
				$object->setAttribute('name',$S_array[$i][1]);
				$object->setAttribute('data',$S_array[$i][0]);
			}
		}
		
		//Now update the 'data' and 'name' attributes to match the required target locale
		//$object->setAttribute('name','S_'.$locale.'_00h00m30s_S_mp3_E:Null_G:Folk');
		//$object->setAttribute('data','http://127.0.0.1/SolasC_Soundtrack/resources/LRC_30s_Viral1_urban_just_the_music_'.$locale.'.mp3');
		
		
		echo '<br><br>Soundtrack metadata after localisation:';
			
		//Refresh metadata to re-display after the update
		$objectName = $object->getAttribute('name');
		$objectData = $object->getAttribute('data');
		
		//Now extract the metadata relating to the soundtrack
		$sLocale = substr($objectName, 2, 2);
		$sHour = substr($objectName, 5, 2);
		$sMinute = substr($objectName, 8, 2);
		$sSecond = substr($objectName, 11, 2);
		$sSpatial = substr($objectName, 15, 1);
		$sFileType = substr($objectName, 17, 3);
		$sEmotion = substr($objectName, 23, 4);
		$sGenre = substr($objectName, 30, 4);
		
		//IOK test echo for test purposes
		echo '<br><br>Locale: '.$sLocale;
		echo '<br>Hour: '.$sHour;
		echo '<br>Minute: '.$sMinute;
		echo '<br>Second: '.$sSecond;
		echo '<br>Spatial: '.$sSpatial;
		echo '<br>File Type: '.$sFileType;
		echo '<br>Emotion: '.$sEmotion;
		echo '<br>Genre: '.$sGenre;
		
		echo '<br><br>$objectData: '.$objectData;
		echo '<br>$objectName: '.$objectName;

		//http://stackoverflow.com/questions/5294691/php-getting-and-setting-tag-attributes
		}
	}

	$results = $htmlDom->saveHTML();

return $results;
}




?>
