README.txt
----------

Creation Date: 21 June 2012
Author: Ian O'Keeffe

Modification History:
--------------------------
21-06-2012
Creation

This collection is for creating a Soundtrack Emotional Modification component to interact with the locConnect server in the Solas architecture.

Demo file to be used when browsing for HTML file: SolasC_MusicEmotion/resources/ME_Example_HTML_file.htm

Note: A folder is required at root level called uploads:
C:\uploads

Either create this, or the first file write will do so. If you get a chmod 777 error, you will have to create the folder manually and set the correct write permissions.

Contents:
---------
index.html
ME_pollingSolas.html
ME_manualStandalone.html
ME_solas_api.php
SolasAPI.class.php
ME_upload.php
checkME.php


Structure:
----------

index.html______________
|						|
ME_pollingSolas.html		ME_manualStandalone.html
|						|
ME_solas_api.php			ME_upload.php
|	|					|
|	SolasAPI.class.php	|
|						|
|						|
checkME.php



index.html
--------------------------
This is the top-level index.html entry point for creating a Solas Component.
It permits branching to either a LocConnect-controlled workflow (pollingSolas.html)
or a standalone instantiation (manualStandalone.html) which processes a file directly via an embedded form

S_pollingSolas.html
--------------------------
This page controls calling LocConnect to see if a job is available, and if so, to process it.
pollingSolas.html -> solas_api.php (API to the Project Management User Interface of LocConnect)
It polls LocConnect every second

S_manualStandalone.html
--------------------------
This page controls a standalone instantiation of a component:
manualStandalone.html -> upload.php (uploads required files manually rather than via HTTP messaging)
This processes a file directly via an embedded form

S_solas_api.php
--------------------------
This page is a template for creating new components that interact with locConnect via PEAR and the locConnect API.
LocConnect uses Pear for its calls, so you need to include it: require_once 'HTTP\Request2.php';
If Request2.php is not found, and you get:
Warning: require_once(HTTP/Request2.php) [function.require-once]: failed to open stream: No such file or directory in E:\www\ct\1.php on line 2
Fatal error: require_once() [function.require]: Failed opening required 'HTTP/Request2.php' (include_path='.;C:\php5\pear') in E:\www\ct\1.php on line 2
you should type:
  pear install http_request2
at the # prompt.

solas_api.php performs the following:
* Sets IP address for LocConnect
* Sets Component Name
* First step, call LocConnect to fetch a list of available jobs for this component, ComponentName
		$jobs = $solasApi->solas_fetch_jobs($componentName, $locConnect);
* Parse returned XML/XLIFF list for status, and possible jobs
* Any error messages?
* Any jobs?
* If yes, Tell locConnect I will process this jobId
		$response = $solasApi->solas_set_status_processing($componentName, $jobId, $locConnect);
* 	Get job
		$file = $solasApi->solas_get_job($componentName, $jobId, $locConnect);
* 	Do stuff to the XLIFF file
* 	Send the updated XLIFF file back to locConnect
		$response = $solasApi->solas_send_output($componentName, $jobId, $data, $locConnect);
* 	Say what you did to the XLIFF file
		$response = $solasApi->solas_send_feedback($componentName, $jobId, 'did stuff to XLIFF file', $locConnect);
* If no, jobId is not set, so wait until called again

SolasAPI.class.php
--------------------------
This is a locConnect Solas API Class
It wraps the API calls to make component creation easier

S_upload.php
--------------------------
This code is written for MS Windows (see paths defined below)
It uploads a file for processing manually, rather than using locConnect, for testing purposes

checkS.php
--------------------------
This code 'does stuff' to the received HTML file. 


--------------------------
