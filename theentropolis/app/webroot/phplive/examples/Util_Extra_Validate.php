<?php

	/*****************************************************
	/*
	/* EXAMPLE Util_Extra_Validate.php
	/*
	/* The live file should be placed at the API/ folder.
	/* (API/Util_Extra_Validate.php)
	/*
	/* The $custom_vars_hash variable will contain the Custom Field name and the value in hash array
	/*
	/* In this example, the "Order #" is the custom field name provided at:
	/* 
	/* Setup Admin -> Departments -> Chat Request (department option)
	/*
	/*************************************************************
	/********** VARIABLES to use for validation process **********
	/*************************************************************
	/*
	/* $vemail - visitor email address, if provided
	/*
	/* $custom_vars_hash - variable that contains the custom field name and the value in hash array format
	/*
	/* example: $custom_vars_hash["Order #"] => "111111"
	/*
	/* Utilize the $custom_vars_hash variable to obtain the values to perform your custom validation
	/*
	//*************************************************************
	/*
	/* IMPORTANT:
	/* The $json_data variable MUST be set to signal start the chat session or display a message
	/*
	/* Example (success):
	/* $json_data = "json_data = { \"status\": 1 };" ;
	/*
	/* Example (error):
	/* $json_data = "json_data = { \"status\": 0, \"error\": \"Order # not found.\" };" ;
	/*
	*****************************************************/

	if ( isset( $custom_vars_hash["Order #"] ) && $custom_vars_hash["Order #"] )
	{
		$ordernum = $custom_vars_hash["Order #"] ;

		/* do the validation on $ordernum.  this example simply sets it as valid. */
		$order_is_valid = 1 ;

		if ( $order_is_valid )
			$json_data = "json_data = { \"status\": 1 };" ; // set to status 1 as success to start the chat session
		else
			$json_data = "json_data = { \"status\": 0, \"error\": \"Order # not found.\" };" ;
	}
	else
		$json_data = "json_data = { \"status\": 1 };" ;
?>