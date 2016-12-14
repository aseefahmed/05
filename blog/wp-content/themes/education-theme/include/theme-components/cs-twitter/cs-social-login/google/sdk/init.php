<?php

require_once get_template_directory() . '/include/theme-components/cs-social-login/google/sdk/apiClient.php';
require_once get_template_directory() . '/include/theme-components/cs-social-login/google/sdk/contrib/apiOauth2Service.php';
global $cs_theme_options;
//$cs_theme_options = get_option('cs_theme_options');

$client = new apiClient();
$client->setClientId($cs_theme_options['cs_google_client_id']);
$client->setClientSecret($cs_theme_options['cs_google_client_secret']);
$client->setDeveloperKey($cs_theme_options['cs_google_api_key']);
$client->setRedirectUri(cs_google_login_url());
$client->setApprovalPrompt('auto');

$oauth2 = new apiOauth2Service($client);
