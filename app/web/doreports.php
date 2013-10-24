<?php

$app->get('/doreports', function () use ($configuration) {
	if(!is_logged_in())
		return 'Please provide correct credentials.';

	$analytics_service = get_analytics_service();

	$current_month_visits = get_analytics_visits($analytics_service, current_month_start_date(), current_month_end_date());
	$previous_month_visits = get_analytics_visits($analytics_service, previous_month_start_date(), previous_month_end_date());

	$current_year_visits = get_analytics_visits($analytics_service, current_year_start_date(), current_year_end_date());
	$previous_year_visits = get_analytics_visits($analytics_service, previous_year_start_date(), previous_year_end_date());

	$report = array(
		current_month_name() . ' ' . current_year() . ' Visits (In Progress)'		=>	number_format($current_month_visits),
		previous_month_name() . ' ' . current_year() . ' Visits'					=>	number_format($previous_month_visits),
		current_year() . ' Total Visits (In Progress)'								=>	number_format($current_year_visits),
		previous_year() . ' Total Visits'											=>	number_format($previous_year_visits),
	);

	$email = create_report_email($report);
	send_report_emails($email);
    return '';
});

function create_report_email($report){
	if(valid_report_numbers($report)){
		$text = get_report_html($report);
	}else{
		$text = get_error_html($report);
	}
	return $text;
}

function valid_report_numbers($numbers){
	foreach($numbers as $number){
		if($number <= 0){
			return false;
		}
	}
	return true;
}

function get_report_html($report){
	$html = 
		"<html><body><p>Here are the reported analytics numbers you requested:</p>";
	$html .= "<ul>";
	foreach($report as $stat=>$number){
		$html .= "<li>" . $stat . ": " . $number . "</li>";
	}
	$html .= "</ul></body></html>";
	return array('Reported Statistics Update', $html);
}

function get_error_html($report){
	$html = 
		"<html><body><p>There are some problems with these numbers that you'll want to fix.</p>";
	$html .= "<ul>";
	foreach($report as $stat=>$number){
		$html .= "<li>" . $stat . ": " . $number . "</li>";
	}
	$html .= "</ul></body></html>";
	return array('Error During Reporting', $html);
}

function send_report_emails($email){
	global $configuration;
	$subject = $email[0];
	$message = $email[1];

	foreach($configuration['report_to'] as $recipient){
		$to = $recipient;
		$headers =  "From: " . $configuration['email_from'] . "\r\n";
		$headers .= "Reply-To: ". $configuration['email_from'] . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		mail($to, $subject, $message, $headers);
	}
}

function get_analytics_service(){
	global $configuration;
	$client = new Google_Client();
	$client->setApplicationName($configuration['analytics_report']['app_name']);
	$client->setAssertionCredentials(
	  new Google_AssertionCredentials(
	    $configuration['analytics_report']['email'],
	    array($configuration['urls']['analytics_api']),
	    file_get_contents($configuration['analytics_report']['keyfile'])
	));
	$client->setClientId($configuration['analytics_report']['client_id']);
	$client->setAccessType($configuration['analytics_report']['access_type']);
	$service = new Google_AnalyticsService($client);
	return $service;
}

function get_analytics_visits($service, $start_date, $end_date){
	global $configuration;
	$query = $service->data_ga->get($configuration['analytics_report']['view_id'], $start_date, $end_date, $configuration['analytics_report']['visit_string']);
	$visits = $query['totalsForAllResults'][$configuration['analytics_report']['visit_string']];
	return $visits;
}