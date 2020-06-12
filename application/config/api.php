<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * API Key Header Name
 */
$config['api_key_header_name'] = 'X-PPC-KEY';


/**
 * API Key GET Request Parameter Name
 */
$config['api_key_get_name'] = 'key';


/**
 * API Key POST Request Parameter Name
 */
$config['api_key_post_name'] = 'key';


/**
 * Set API Timezone 
 */
$config['api_timezone'] = 'America/Sao_Paulo';


/**
 * API Limit database table name
 */
$config['api_limit_table_name'] = getenv('API_LIMIT_TBL_NAME');

/**
 * API keys database table name 
 */
$config['api_keys_table_name'] = getenv('API_KEYS_TBL_NAME');