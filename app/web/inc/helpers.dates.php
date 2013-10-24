<?php

function current_month_start_date(){
	$month_start = strtotime('first day of this month', time());
	return date('Y-m-d', $month_start);
}

function current_month_end_date(){
	$month_end = strtotime('last day of this month', time());
	return date('Y-m-d', $month_end);
}

function previous_month_start_date(){
	$month_start = strtotime('first day of last month', time());
	return date('Y-m-d', $month_start);
}

function previous_month_end_date(){
	$month_end = strtotime('last day of last month', time());
	return date('Y-m-d', $month_end);
}

function current_year_start_date(){
	$year_start = strtotime('first day of January', time());
	return date('Y-m-d', $year_start);
}

function current_year_end_date(){
	$year_end = strtotime('last day of December', time());
	return date('Y-m-d', $year_end);
}

function previous_year_start_date(){
	$year_start = strtotime('first day of last year January', time());
	return date('Y-m-d', $year_start);
}

function previous_year_end_date(){
	$year_end = strtotime('last day of last year December', time());
	return date('Y-m-d', $year_end);
}

function current_year(){
	$year_start = strtotime('first day of January', time());
	return date('Y', $year_start);
}

function previous_year(){
	$year_start = strtotime('first day of last year January', time());
	return date('Y', $year_start);
}

function current_month_name(){
	$month_start = strtotime('first day of this month', time());
	return date('M', $month_start);
}

function previous_month_name(){
	$month_start = strtotime('first day of last month', time());
	return date('M', $month_start);
}