<?php
// register PHPRtfLite class loader
		\PHPRtfLite::registerAutoloader();

		$text = 'Name: Roneito';

		$times12	= new \PHPRtfLite_Font(13, 'Times new Roman');
		$arial14	= new \PHPRtfLite_Font(14, 'Arial', '#000066');

		$parFormat	= new \PHPRtfLite_ParFormat();

		//rtf document
		$rtf		= new \PHPRtfLite();

		//borders
		$borderFormatBlue	= new \PHPRtfLite_Border_Format(1, '#0000ff');
		$borderFormatRed	= new \PHPRtfLite_Border_Format(2, '#ff0000');
		$border				= new \PHPRtfLite_Border($rtf, $borderFormatBlue, $borderFormatRed, $borderFormatBlue, $borderFormatRed);
		$rtf->setBorder($border);
		$rtf->setBorderSurroundsHeader();
		$rtf->setBorderSurroundsFooter();

		//section 2
		$sect = $rtf->addSection();
		$sect->setBorderSurroundsHeader();
		$sect->setBorderSurroundsFooter();
		
		$petData	= Pet::find($id);
		
		//Borders overridden: Green border
		$border = \PHPRtfLite_Border::create($rtf, 1, '#00ff00', \PHPRtfLite_Border_Format::TYPE_DASH, 1);
		$sect->setBorder($border);
		$sect->writeText('<b>PLEASE FIND MY PET</b><br>', $arial14, new \PHPRtfLite_ParFormat(\PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER));
		
		$sect->writeText('Pet Information<br>', $arial14, new \PHPRtfLite_ParFormat());
		$sect->writeText('Name: '.$petData->name, $times12, new \PHPRtfLite_ParFormat());
		$sect->writeText('Species: '.$speciesArray[$petData->species], $times12, new \PHPRtfLite_ParFormat());

		if($petData->color != '') {
			$sect->writeText('Color: '.$petData->color, $times12, new \PHPRtfLite_ParFormat());
		}
		if($petData->gender != '') {
			$sect->writeText('Gender: '.$genderArray[$petData->gender], $times12, new \PHPRtfLite_ParFormat());
		}
		if($petData->geld != '') {
			$sect->writeText('Gelded/Doctored: '.$geldArray[$petData->geld], $times12, new \PHPRtfLite_ParFormat());
		}
		if($petData->country_of_birth != '') {
			$sect->writeText('Country Of Birth: '.$countries[$petData->country_of_birth], $times12, new \PHPRtfLite_ParFormat());
		}
		if($petData->date_of_birth != '0000-00-00') {
			$date	= date('m/d/Y', strtotime($petData->date_of_birth));
			$sect->writeText('Date Of Birth: '.$date, $times12, new \PHPRtfLite_ParFormat());
		}
		if($petData->chip_id != '') {
			$sect->writeText('Chip ID: '.$petData->chip_id, $times12, new \PHPRtfLite_ParFormat());
		}
		if($petData->pass_id != '') {
			$sect->writeText('Pass ID: '.$petData->pass_id, $times12, new \PHPRtfLite_ParFormat());
		}
		if($petData->tattoo_id != '') {
			$sect->writeText('Tattoo: '.$petData->tattoo_id, $times12, new \PHPRtfLite_ParFormat());
		}
		if($petData->tattoo_location != '') {
			$sect->writeText('Tattoo Location: '.$petData->tattoo_location, $times12, new \PHPRtfLite_ParFormat());
		}
		if($petData->pet_id != '') {
			$sect->writeText('Pet ID: '.$petData->pet_id, $times12, new \PHPRtfLite_ParFormat());
		}
		if($petData->characteristics != '') {
			$sect->writeText('Characteristics: '.$petData->characteristics, $times12, new \PHPRtfLite_ParFormat());
		}
		$sect->writeText('<br><br>', $times12, new \PHPRtfLite_ParFormat());
		
		$ownerData	= User::find($petData->owner_id);
		$sect->writeText('Owner Information<br>', $arial14, new PHPRtfLite_ParFormat());
		$sect->writeText('Name: '.$salutationArray[$ownerData->salutation].'. '.$ownerData->firstname.' '.$ownerData->lastname, $times12, new \PHPRtfLite_ParFormat());
		$sect->writeText('Email: '.$ownerData->email, $times12, new PHPRtfLite_ParFormat());
		$sect->writeText('Phone: '.$ownerData->phone, $times12, new PHPRtfLite_ParFormat());
		$sect->writeText('Address: '.$ownerData->address, $times12, new PHPRtfLite_ParFormat());
		$sect->writeText('Zip: '.$ownerData->zip, $times12, new PHPRtfLite_ParFormat());
		$sect->writeText('City: '.$ownerData->city, $times12, new PHPRtfLite_ParFormat());
		$sect->writeText('State: '.$ownerData->state, $times12, new PHPRtfLite_ParFormat());
		$sect->writeText('Country: '.$countries[$ownerData->country], $times12, new PHPRtfLite_ParFormat());
		$sect->writeText('Language: '.$countries[$ownerData->language], $times12, new PHPRtfLite_ParFormat());
		if($ownerData->company != '') {
			$sect->writeText('Company: '.$ownerData->company, $times12, new PHPRtfLite_ParFormat());
		}
		$sect->writeText('<br><br>', $times12, new PHPRtfLite_ParFormat());
		$sect->writeText('Lost Information<br>', $arial14, new PHPRtfLite_ParFormat());
		$sect->writeText('Location: '.$petData->lost_location, $times12, new PHPRtfLite_ParFormat());
		$sect->writeText('Date: '.date('m-d-Y', strtotime($ownerData->lost_date)), $times12, new PHPRtfLite_ParFormat());
		$sect->writeText('Time: '.$ownerData->lost_time, $times12, new PHPRtfLite_ParFormat());
		$file	= time().'.rtf';
		// save rtf document
		$rtf->save(getcwd().'/data/posters/' . $file);
		$filepath = getcwd()."/data/posters/" . $file;
		// Process download
		if(file_exists($filepath)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($filepath));
			flush(); // Flush system output buffer
			readfile($filepath);
			exit;
		}
?>