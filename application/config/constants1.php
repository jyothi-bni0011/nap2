<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


/*Constants for the table name and there fields*/

defined('CREATED_ON')    OR define('CREATED_ON', 'created_on');  // Common field for all tables
defined('UPDATED_ON')    OR define('UPDATED_ON', 'updated_on');  // Common field for all tables
defined('STATUS')        OR define('STATUS', 'status');  		 // Common field for all tables

/*----------------------------------------------------------------------*/

defined('CATEGORY')        		OR define('CATEGORY', 'category');  // Table name 
defined('CATEGORY_ID')        	OR define('CATEGORY_ID', 'category_id');  //field name
defined('CATEGORY_NAME')        OR define('CATEGORY_NAME', 'category_name');  //field name
defined('CATEGORY_DESCRIPTION') OR define('CATEGORY_DESCRIPTION', 'category_description');  //field name

/*----------------------------------------------------------------------*/

defined('DEPARTMENT')        		OR define('DEPARTMENT', 'department');  // Table name 
defined('DEPARTMENT_ID')        	OR define('DEPARTMENT_ID', 'department_id');  //field name
defined('DEPARTMENT_NAME')        	OR define('DEPARTMENT_NAME', 'department_name');  //field name 
defined('DEPARTMENT_DESCRIPTION')   OR define('DEPARTMENT_DESCRIPTION', 'department_description');  //field name

/*----------------------------------------------------------------------*/

defined('DOCUMENT_CATEGORY')        		OR define('DOCUMENT_CATEGORY', 'document_category');  // Table name 
defined('DOCUMENT_CATEGORY_ID')        		OR define('DOCUMENT_CATEGORY_ID', 'doc_category_id');  //field name
defined('DOCUMENT_CATEGORY_NAME')        	OR define('DOCUMENT_CATEGORY_NAME', 'doc_category_name');  //field name
defined('DOCUMENT_CATEGORY_DESCRIPTION')    OR define('DOCUMENT_CATEGORY_DESCRIPTION', 'doc_category_description');  //field name

/*----------------------------------------------------------------------*/

defined('DOCUMENT_FOLDER')        		OR define('DOCUMENT_FOLDER', 'document_folder');  // Table name 
defined('DOCUMENT_FOLDER_ID')        	OR define('DOCUMENT_FOLDER_ID', 'doc_folder_id');  //field name
defined('DOCUMENT_FOLDER_NAME')        	OR define('DOCUMENT_FOLDER_NAME', 'doc_folder_name');  //field name
defined('DOCUMENT_FOLDER_DESCRIPTION')  OR define('DOCUMENT_FOLDER_DESCRIPTION', 'doc_folder_description');  //field name

/*----------------------------------------------------------------------*/

defined('FUNCTIONAL_AREA')        		OR define('FUNCTIONAL_AREA', 'functional_area');  // Table name
defined('FUNCTIONAL_AREA_ID')        	OR define('FUNCTIONAL_AREA_ID', 'fun_area_id');  //field name
defined('FUNCTIONAL_AREA_NAME')        	OR define('FUNCTIONAL_AREA_NAME', 'fun_area_name');  //field name
defined('FUNCTIONAL_AREA_DESCRIPTION')  OR define('FUNCTIONAL_AREA_DESCRIPTION', 'fun_area_description');  //field name

/*----------------------------------------------------------------------*/

defined('JOB_POSITION')        		OR define('JOB_POSITION', 'job_position');  // Table name
defined('JOB_POSITION_ID')        	OR define('JOB_POSITION_ID', 'position_id');  //field name
defined('JOB_POSITION_CODE')        OR define('JOB_POSITION_CODE', 'position_code');  //field name
defined('JOB_POSITION_DESCRIPTION') OR define('JOB_POSITION_DESCRIPTION', 'position_description');  //field name

/*----------------------------------------------------------------------*/

defined('NEW_ASSOCIATE')        				OR define('NEW_ASSOCIATE', 'new_associate');  // Table name
defined('NEW_ASSOCIATE_ID')        				OR define('NEW_ASSOCIATE_ID', 'associate_id');  //field name
defined('NEW_ASSOCIATE_USERNAME')        		OR define('NEW_ASSOCIATE_USERNAME', 'associate_username');  //field name
defined('NEW_ASSOCIATE_EMAIL')        			OR define('NEW_ASSOCIATE_EMAIL', 'associate_email');  //field name
defined('NEW_ASSOCIATE_FIRST_NAME')        		OR define('NEW_ASSOCIATE_FIRST_NAME', 'associate_first_name');  //field name
defined('NEW_ASSOCIATE_MIDDLE_NAME')        	OR define('NEW_ASSOCIATE_MIDDLE_NAME', 'associate_middle_name');  //field name
defined('NEW_ASSOCIATE_LAST_NAME')        		OR define('NEW_ASSOCIATE_LAST_NAME', 'associate_last_name');  //field name
defined('NEW_ASSOCIATE_START_DATE')        		OR define('NEW_ASSOCIATE_START_DATE', 'associate_start_date');  //field name
defined('NEW_ASSOCIATE_STATUS')        			OR define('NEW_ASSOCIATE_STATUS', 'associate_status');  //field name
defined('NEW_ASSOCIATE_CONTACT_INFO')        	OR define('NEW_ASSOCIATE_CONTACT_INFO', 'associate_contact_info');  //field name
defined('NEW_ASSOCIATE_ADDRESS')        		OR define('NEW_ASSOCIATE_ADDRESS', 'associate_address');  //field name

/*----------------------------------------------------------------------*/

defined('ORGANIZATIONAL_UNIT')        		OR define('ORGANIZATIONAL_UNIT', 'organizational_unit');  // Table name
defined('ORGANIZATIONAL_UNIT_ID')        	OR define('ORGANIZATIONAL_UNIT_ID', 'org_unit_id');  //field name
defined('ORGANIZATIONAL_UNIT_NAME')      	OR define('ORGANIZATIONAL_UNIT_NAME', 'org_unit_name');  //field name
defined('ORGANIZATIONAL_UNIT_DESCRIPTION')  OR define('ORGANIZATIONAL_UNIT_DESCRIPTION', 'org_unit_description');  //field name

/*----------------------------------------------------------------------*/

defined('ROLE')        			OR define('ROLE', 'role');  // Table name
defined('ROLE_ID')        		OR define('ROLE_ID', 'role_id');  //field name
defined('ROLE_NAME')        	OR define('ROLE_NAME', 'role_name');  //field name
defined('ROLE_DESCRIPTION')     OR define('ROLE_DESCRIPTION', 'role_description');  //field name

/*----------------------------------------------------------------------*/

defined('USER')        				OR define('USER', 'users');  // Table name
defined('USER_ID')        			OR define('USER_ID', 'user_id');  //field name
defined('USERSNAME')        		OR define('USERNAME', 'username');  //field name
defined('USER_CODE')        		OR define('USER_CODE', 'user_code');  //field name
defined('USER_FIRST_NAME')        	OR define('USER_FIRST_NAME', 'first_name');  //field name
defined('USER_MIDDLE_NAME')        	OR define('USER_MIDDLE_NAME', 'middle_name');  //field name
defined('USER_LAST_NAME')        	OR define('USER_LAST_NAME', 'last_name');  //field name
defined('USER_EMAIL')        		OR define('USER_EMAIL', 'email_id');  //field name
defined('USER_PASSWORD')        	OR define('USER_PASSWORD', 'password');  //field name
defined('USER_PROFILE_PIC')        	OR define('USER_PROFILE_PIC', 'profile_pic');  //field name
defined('USER_SITE_ID')        		OR define('USER_SITE_ID', 'site_id');  //field name
defined('USER_IS_FIRSTTIME')       	OR define('USER_IS_FIRSTTIME', 'is_firsttime');  //field name

/*----------------------------------------------------------------------*/

defined('USER_ROLE_MAPPING')        OR define('USER_ROLE_MAPPING', 'users_role_mapping');  // Table name
defined('USER_ROLE_MAPPING_ID')     OR define('USER_ROLE_MAPPING_ID', 'users_role_mapping_id');

/*----------------------------------------------------------------------*/

defined('HR_GROUP')        				OR define('HR_GROUP', 'hr_group');  // Table name
defined('HR_GROUP_ID')        			OR define('HR_GROUP_ID', 'hr_group_id');
defined('HR_GROUP_NAME')        		OR define('HR_GROUP_NAME', 'hr_group_name');
defined('HR_GROUP_DESCRIPTION')			OR define('HR_GROUP_DESCRIPTION', 'hr_group_description');

/*----------------------------------------------------------------------*/

defined('HR_GROUP_USER_MAPPING')	OR define('HR_GROUP_USER_MAPPING', 'hr_group_user_mapping');  // Table name
defined('HR_GROUP_USER_MAPPING_ID')	OR define('HR_GROUP_USER_MAPPING_ID', 'hr_group_user_mapping_id');

/*----------------------------------------------------------------------*/

defined('DOCUMENT')				OR define('DOCUMENT', 'document');  //Table name
defined('DOCUMENT_ID')			OR define('DOCUMENT_ID', 'document_id');
defined('DOCUMENT_TITLE')		OR define('DOCUMENT_TITLE', 'document_title');
defined('DOCUMENT_TEMPLATE')	OR define('DOCUMENT_TEMPLATE', 'document_template');

/*----------------------------------------------------------------------*/

defined('DOCUMENT_JOB_POSITION_MAPPING')	OR define('DOCUMENT_JOB_POSITION_MAPPING', 'document_job_position_mapping');  // Table name
defined('DOCUMENT_JOB_POSITION_MAPPING_ID')	OR define('DOCUMENT_JOB_POSITION_MAPPING_id', 'document_job_position_mapping_id');

/*----------------------------------------------------------------------*/

defined('USER_DOCUMENT_MAPPING')	OR define('USER_DOCUMENT_MAPPING', 'user_document_mapping'); //Table Name
defined('USER_DOCUMENT_MAPPING_ID')	OR define('USER_DOCUMENT_MAPPING_ID', 'user_document_mapping_id');
defined('ASSIGNED_DATE')			OR define('ASSIGNED_DATE', 'assigned_date');
defined('SUBMITED_DATE')			OR define('SUBMITED_DATE', 'submited_date');