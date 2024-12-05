<?php
defined('BASEPATH') OR exit('No direct script access allowed');


defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);


defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');


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


$root=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https://' : 'http://' ).$_SERVER['HTTP_HOST'];
////$root=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'];
$root.= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
define('BASE_URL', $root);
////echo $root;

//Date format for daily episode update
define('DATE_FORMAT', 'd.m.y');
define('DATE_FORMAT_TITLE', 'M d, Y');


//front area
define('DEFAULT_THEME', 'frontend/');
define('DEFAULT_ASSETS', BASE_URL . 'assets/ums/');
define('DEFAULT_ASSETS_NEW', BASE_URL . 'theme/');


define('DEFAULT_ASSETS_CUSTOMER_NEW', BASE_URL . 'assets/customer/');


//front area
define('CUSTOMER_THEME', getenv('CUSTOMER_THEME'));
define('SITE_IMS_HOST', getenv('SITE_IMS_HOST'));


//CDN LOGIN
define('CDN_FTP_HOST', getenv('CDN_FTP_HOST'));
define('CDN_FTP_USERNAME', getenv('CDN_FTP_USERNAME'));
define('CDN_FTP_PASSWORD', getenv('CDN_FTP_PASSWORD'));
define('CDN_FOLDER', getenv('CDN_FOLDER'));

//FTP FOR CDN_Prefix cloudtv03
define('CDN_PREFIX_FTP_HOST', getenv('CDN_PREFIX_FTP_HOST'));
define('CDN_PREFIX_FTP_USERNAME', getenv('CDN_PREFIX_FTP_USERNAME'));
define('CDN_PREFIX_FTP_PASSWORD', getenv('CDN_PREFIX_FTP_PASSWORD'));
define('CDN_PREFIX_FOLDER', getenv('CDN_PREFIX_FOLDER'));

//set 1 for encrypting the  json files
define('ENCRYPT_JSON',getenv('ENCRYPT_JSON'));
define('IMS_CLIENT',getenv('IMS_CLIENT'));
define('IMS',getenv('IMS'));
define('CRM',getenv('CRM'));
define('CMS',getenv('CMS'));

//Classic VOD Loacation 
define('CLASSIC_IMS_VOD_LOCATION',  './'.IMS.'/classic_vod_location/');

define('AKAMAI_KEY',getenv('AKAMAI_KEY'));
define('AKAMAI_TOKEN_MIX_KEY',getenv('AKAMAI_TOKEN_MIX_KEY')); //Use to mix garbage text --only add 10 Character other wise it will not work
define('FLUSSONIC_KEY',getenv('FLUSSONIC_KEY'));
define('FLUSSONIC_TOKEN_MIX_KEY',getenv('FLUSSONIC_TOKEN_MIX_KEY')); //Use to mix garbage text --only add 10 Character other wise it will not work
//this used for tags.json
define('CDN_LOCATION_FOR_IMAGE',getenv('CDN_LOCATION_FOR_IMAGE').IMS.'/images/'.CMS.'/');



define('IMDB_KEY',getenv('IMDB_KEY')); //k_s8yo2lvs
define('CHANNEL_EXT',getenv('CHANNEL_EXT'));
define('INTERACTIVE_CHANNEL_EXT',getenv('INTERACTIVE_CHANNEL_EXT'));
define('DAYS_TO_CREATE_EPG_FILES_FROM_TODAY',getenv('DAYS_TO_CREATE_EPG_FILES_FROM_TODAY')); //1 TODAY , 2 TODAY AND TOMORROW, IF 

define('BACKDROP_IMAGES_MOVIE',getenv('BACKDROP_IMAGES_MOVIE'));

//LOCAL PATH 
define('LOCAL_PATH_CRM', './'.IMS.'/jsons/'. CRM.'/');
define('LOCAL_PATH_CMS', './'.IMS.'/jsons/'. CMS.'/');
define('LOCAL_PATH_IMAGES_CMS', './'.IMS.'/images/'. CMS.'/');
define('LOCAL_PATH_CUSTOMER', './'.IMS.'/customers/');
//this is for message to all devices
define('LOCAL_PATH_CRMD', LOCAL_PATH_CRM);
define('LOCAL_PATH_IMAGES_CRMD', CDN_LOCATION_FOR_IMAGE.'messagedevice/');
define('LOCAL_PATH_IMAGES_CRMD_UPL0AD', './'.IMS.'/images/'. CMS.'/'.'messagedevice/');


//FTP OR RSYNC == true mean ftp is false and only rsync will worke
define('ACTIVE_RSYNC',true);
//define('ACTIVE_RSYNC_BASH_SCRIPT',"sprintf('%s > /dev/null 2>&1 & ', '/root/xims.cdnnext.com_RSYNC.sh' )");
//define('ACTIVE_RSYNC_BASH_SCRIPT',"/root/xims.cdnnext.com_RSYNC.sh");
define('ACTIVE_RSYNC_SETTINGS',"rsync -av --password-file=/home/".SITE_IMS_HOST."/public_html/rsync_password.txt /home/".SITE_IMS_HOST."/public_html/" . IMS . " xserver@xms-json-image.rsync.upload.akamai.com::xserver/");

define('TWILLO_URL', getenv('TWILLO_URL'));
define('TWILLO_ID', getenv('TWILLO_ID'));
define('TWILLO_TOKEN', getenv('TWILLO_TOKEN'));
define('TWILLO_PHONE_FROM', getenv('TWILLO_PHONE_FROM'));

define('SENDGRID_URL', getenv('SENDGRID_URL'));
define('SENDGRID_APIKEY', getenv('SENDGRID_APIKEY'));

define('MSG_TO_CUSTOMER', getenv('MSG_TO_CUSTOMER'));

define('OTP_VAL_TIME',getenv('OTP_VAL_TIME'));
//RECENT MOVIE GENRE name and limit 
define('RECENT_MOVIE_LIMIT',getenv('RECENT_MOVIE_LIMIT'));
define('RECENT_MOVIE_GENRE_NAME',getenv('RECENT_MOVIE_GENRE_NAME'));


define('LATEST_RELEASE_MOVIE_LIMIT',getenv('LATEST_RELEASE_MOVIE_LIMIT'));
define('LATEST_RELEASE_MOVIE_GENRE_NAME',getenv('LATEST_RELEASE_MOVIE_GENRE_NAME'));

define('ADMIN_EMAIL',getenv('ADMIN_EMAIL'));

define('AKAMAI_VERIFICATION_KEY',getenv('AKAMAI_VERIFICATION_KEY'));


// TMDB Constants
define('TMDB_API_BASE_URL', getenv('TMDB_API_BASE_URL'));
define('TMDB_API_MOVIE', TMDB_API_BASE_URL.'/movie/');
define('TMDB_API_TV', TMDB_API_BASE_URL.'/tv/');
define('TMDB_API_SEARCH_MOVIE', TMDB_API_BASE_URL.'/search/movie');
define('TMDB_API_SEARCH_TV', TMDB_API_BASE_URL.'/search/tv');

define('TMDB_IMAGE_BASE_URL', getenv('TMDB_IMAGE_BASE_URL'));
define('TMDB_IMAGE_ORIGINAL', TMDB_IMAGE_BASE_URL.'/original');
define('TMDB_IMAGE_W342', TMDB_IMAGE_BASE_URL.'/w342');
define('TMDB_IMAGE_W1280', TMDB_IMAGE_BASE_URL.'/w1280');
define('TMDB_IMAGE_PROFILE', TMDB_IMAGE_BASE_URL.'/w138_and_h175_bestv2');

// IMDB Constants
define('IMDB_API_BASE_URL', getenv('IMDB_API_BASE_URL'));
define('IMDB_API_TITLE', IMDB_API_BASE_URL.'/Title/');
define('IMDB_API_IMAGES', IMDB_API_BASE_URL.'/Images/');
define('IMDB_API_ADVANCE_SEARCH', IMDB_API_BASE_URL.'/AdvancedSearch/');
define('IMDB_API_SEARCH_SERIES', IMDB_API_BASE_URL.'/SearchSeries/');
define('IMDB_API_SEARCH_MOVIE', IMDB_API_BASE_URL.'/SearchMovie/');
define('IMDB_API_SEARCH_EPISODES', IMDB_API_BASE_URL.'/SeasonEpisodes/');
define('IMDB_RESIZE_API_URL', getenv('IMDB_RESIZE_API_URL'));

define('COUNTRY_MOBILE_CODE',
array(
	'44' => 'UK (+44)',
	'1' => 'USA (+1)',
	'213' => 'Algeria (+213)',
	'376' => 'Andorra (+376)',
	'244' => 'Angola (+244)',
	'1264' => 'Anguilla (+1264)',
	'1268' => 'Antigua & Barbuda (+1268)',
	'54' => 'Argentina (+54)',
	'374' => 'Armenia (+374)',
	'297' => 'Aruba (+297)',
	'61' => 'Australia (+61)',
	'43' => 'Austria (+43)',
	'994' => 'Azerbaijan (+994)',
	'1242' => 'Bahamas (+1242)',
	'973' => 'Bahrain (+973)',
	'880' => 'Bangladesh (+880)',
	'1246' => 'Barbados (+1246)',
	'375' => 'Belarus (+375)',
	'32' => 'Belgium (+32)',
	'501' => 'Belize (+501)',
	'229' => 'Benin (+229)',
	'1441' => 'Bermuda (+1441)',
	'975' => 'Bhutan (+975)',
	'591' => 'Bolivia (+591)',
	'387' => 'Bosnia Herzegovina (+387)',
	'267' => 'Botswana (+267)',
	'55' => 'Brazil (+55)',
	'673' => 'Brunei (+673)',
	'359' => 'Bulgaria (+359)',
	'226' => 'Burkina Faso (+226)',
	'257' => 'Burundi (+257)',
	'855' => 'Cambodia (+855)',
	'237' => 'Cameroon (+237)',
	'1' => 'Canada (+1)',
	'238' => 'Cape Verde Islands (+238)',
	'1345' => 'Cayman Islands (+1345)',
	'236' => 'Central African Republic (+236)',
	'56' => 'Chile (+56)',
	'86' => 'China (+86)',
	'57' => 'Colombia (+57)',
	'269' => 'Comoros (+269)',
	'242' => 'Congo (+242)',
	'682' => 'Cook Islands (+682)',
	'506' => 'Costa Rica (+506)',
	'385' => 'Croatia (+385)',
	'53' => 'Cuba (+53)',
	'90392' => 'Cyprus North (+90392)',
	'357' => 'Cyprus South (+357)',
	'42' => 'Czech Republic (+42)',
	'45' => 'Denmark (+45)',
	'253' => 'Djibouti (+253)',
	'1809' => 'Dominica (+1809)',
	'1809' => 'Dominican Republic (+1809)',
	'593' => 'Ecuador (+593)',
	'20' => 'Egypt (+20)',
	'503' => 'El Salvador (+503)',
	'240' => 'Equatorial Guinea (+240)',
	'291' => 'Eritrea (+291)',
	'372' => 'Estonia (+372)',
	'251' => 'Ethiopia (+251)',
	'500' => 'Falkland Islands (+500)',
	'298' => 'Faroe Islands (+298)',
	'679' => 'Fiji (+679)',
	'358' => 'Finland (+358)',
	'33' => 'France (+33)',
	'594' => 'French Guiana (+594)',
	'689' => 'French Polynesia (+689)',
	'241' => 'Gabon (+241)',
	'220' => 'Gambia (+220)',
	'7880' => 'Georgia (+7880)',
	'49' => 'Germany (+49)',
	'233' => 'Ghana (+233)',
	'350' => 'Gibraltar (+350)',
	'30' => 'Greece (+30)',
	'299' => 'Greenland (+299)',
	'1473' => 'Grenada (+1473)',
	'590' => 'Guadeloupe (+590)',
	'671' => 'Guam (+671)',
	'502' => 'Guatemala (+502)',
	'224' => 'Guinea (+224)',
	'245' => 'Guinea - Bissau (+245)',
	'592' => 'Guyana (+592)',
	'509' => 'Haiti (+509)',
	'504' => 'Honduras (+504)',
	'852' => 'Hong Kong (+852)',
	'36' => 'Hungary (+36)',
	'354' => 'Iceland (+354)',
	'91' => 'India (+91)',
	'62' => 'Indonesia (+62)',
	'98' => 'Iran (+98)',
	'964' => 'Iraq (+964)',
	'353' => 'Ireland (+353)',
	'972' => 'Israel (+972)',
	'39' => 'Italy (+39)',
	'1876' => 'Jamaica (+1876)',
	'81' => 'Japan (+81)',
	'962' => 'Jordan (+962)',
	'7' => 'Kazakhstan (+7)',
	'254' => 'Kenya (+254)',
	'686' => 'Kiribati (+686)',
	'850' => 'Korea North (+850)',
	'82' => 'Korea South (+82)',
	'965' => 'Kuwait (+965)',
	'996' => 'Kyrgyzstan (+996)',
	'856' => 'Laos (+856)',
	'371' => 'Latvia (+371)',
	'961' => 'Lebanon (+961)',
	'266' => 'Lesotho (+266)',
	'231' => 'Liberia (+231)',
	'218' => 'Libya (+218)',
	'417' => 'Liechtenstein (+417)',
	'370' => 'Lithuania (+370)',
	'352' => 'Luxembourg (+352)',
	'853' => 'Macao (+853)',
	'389' => 'Macedonia (+389)',
	'261' => 'Madagascar (+261)',
	'265' => 'Malawi (+265)',
	'60' => 'Malaysia (+60)',
	'960' => 'Maldives (+960)',
	'223' => 'Mali (+223)',
	'356' => 'Malta (+356)',
	'692' => 'Marshall Islands (+692)',
	'596' => 'Martinique (+596)',
	'222' => 'Mauritania (+222)',
	'269' => 'Mayotte (+269)',
	'52' => 'Mexico (+52)',
	'691' => 'Micronesia (+691)',
	'373' => 'Moldova (+373)',
	'377' => 'Monaco (+377)',
	'976' => 'Mongolia (+976)',
	'1664' => 'Montserrat (+1664)',
	'212' => 'Morocco (+212)',
	'258' => 'Mozambique (+258)',
	'95' => 'Myanmar (+95)',
	'264' => 'Namibia (+264)',
	'674' => 'Nauru (+674)',
	'977' => 'Nepal (+977)',
	'31' => 'Netherlands (+31)',
	'687' => 'New Caledonia (+687)',
	'64' => 'New Zealand (+64)',
	'505' => 'Nicaragua (+505)',
	'227' => 'Niger (+227)',
	'234' => 'Nigeria (+234)',
	'683' => 'Niue (+683)',
	'672' => 'Norfolk Islands (+672)',
	'670' => 'Northern Marianas (+670)',
	'47' => 'Norway (+47)',
	'968' => 'Oman (+968)',
	'680' => 'Palau (+680)',
	'507' => 'Panama (+507)',
	'675' => 'Papua New Guinea (+675)',
	'595' => 'Paraguay (+595)',
	'51' => 'Peru (+51)',
	'63' => 'Philippines (+63)',
	'48' => 'Poland (+48)',
	'351' => 'Portugal (+351)',
	'1787' => 'Puerto Rico (+1787)',
	'974' => 'Qatar (+974)',
	'262' => 'Reunion (+262)',
	'40' => 'Romania (+40)',
	'7' => 'Russia (+7)',
	'250' => 'Rwanda (+250)',
	'378' => 'San Marino (+378)',
	'239' => 'Sao Tome & Principe (+239)',
	'966' => 'Saudi Arabia (+966)',
	'221' => 'Senegal (+221)',
	'381' => 'Serbia (+381)',
	'248' => 'Seychelles (+248)',
	'232' => 'Sierra Leone (+232)',
	'65' => 'Singapore (+65)',
	'421' => 'Slovak Republic (+421)',
	'386' => 'Slovenia (+386)',
	'677' => 'Solomon Islands (+677)',
	'252' => 'Somalia (+252)',
	'27' => 'South Africa (+27)',
	'34' => 'Spain (+34)',
	'94' => 'Sri Lanka (+94)',
	'290' => 'St. Helena (+290)',
	'1869' => 'St. Kitts (+1869)',
	'1758' => 'St. Lucia (+1758)',
	'249' => 'Sudan (+249)',
	'597' => 'Suriname (+597)',
	'268' => 'Swaziland (+268)',
	'46' => 'Sweden (+46)',
	'41' => 'Switzerland (+41)',
	'963' => 'Syria (+963)',
	'886' => 'Taiwan (+886)',
	'7' => 'Tajikstan (+7)',
	'66' => 'Thailand (+66)',
	'228' => 'Togo (+228)',
	'676' => 'Tonga (+676)',
	'1868' => 'Trinidad & Tobago (+1868)',
	'216' => 'Tunisia (+216)',
	'90' => 'Turkey (+90)',
	'7' => 'Turkmenistan (+7)',
	'993' => 'Turkmenistan (+993)',
	'1649' => 'Turks & Caicos Islands (+1649)',
	'688' => 'Tuvalu (+688)',
	'256' => 'Uganda (+256)',
	'380' => 'Ukraine (+380)',
	'971' => 'United Arab Emirates (+971)',
	'598' => 'Uruguay (+598)',
	'7' => 'Uzbekistan (+7)',
	'678' => 'Vanuatu (+678)',
	'379' => 'Vatican City (+379)',
	'58' => 'Venezuela (+58)',
	'84' => 'Vietnam (+84)',
	'84' => 'Virgin Islands - British (+1284)',
	'84' => 'Virgin Islands - US (+1340)',
	'681' => 'Wallis & Futuna (+681)',
	'969' => 'Yemen (North)(+969)',
	'967' => 'Yemen (South)(+967)',
	'260' => 'Zambia (+260)',
	'263' => 'Zimbabwe (+263)'
) );
define('COUNTRY_CURRENCY',
array(
    'Albania Lek' => 'ALL',
    'Afghanistan Afghani' => 'AFN',
    'Argentina Peso' => 'ARS',
    'Aruba Guilder' => 'AWG',
    'Australia Dollar' => 'AUD',
    'Azerbaijan New Manat' => 'AZN',
    'Bahamas Dollar' => 'BSD',
    'Barbados Dollar' => 'BBD',
    'Bangladeshi taka' => 'BDT',
    'Belarus Ruble' => 'BYR',
    'Belize Dollar' => 'BZD',
    'Bermuda Dollar' => 'BMD',
    'Bolivia Boliviano' => 'BOB',
    'Bosnia and Herzegovina Convertible Marka' => 'BAM',
    'Botswana Pula' => 'BWP',
    'Bulgaria Lev' => 'BGN',
    'Brazil Real' => 'BRL',
    'Brunei Darussalam Dollar' => 'BND',
    'Cambodia Riel' => 'KHR',
    'Canada Dollar' => 'CAD',
    'Cayman Islands Dollar' => 'KYD',
    'Chile Peso' => 'CLP',
    'China Yuan Renminbi' => 'CNY',
    'Colombia Peso' => 'COP',
    'Costa Rica Colon' => 'CRC',
    'Croatia Kuna' => 'HRK',
    'Cuba Peso' => 'CUP',
    'Czech Republic Koruna' => 'CZK',
    'Denmark Krone' => 'DKK',
    'Dominican Republic Peso' => 'DOP',
    'East Caribbean Dollar' => 'XCD',
    'Egypt Pound' => 'EGP',
    'El Salvador Colon' => 'SVC',
    'Estonia Kroon' => 'EEK',
    'Euro Member Countries' => 'EUR',
    'Falkland Islands (Malvinas) Pound' => 'FKP',
    'Fiji Dollar' => 'FJD',
    'Ghana Cedis' => 'GHC',
    'Gibraltar Pound' => 'GIP',
    'Guatemala Quetzal' => 'GTQ',
    'Guernsey Pound' => 'GGP',
    'Guyana Dollar' => 'GYD',
    'Honduras Lempira' => 'HNL',
    'Hong Kong Dollar' => 'HKD',
    'Hungary Forint' => 'HUF',
    'Iceland Krona' => 'ISK',
    'India Rupee' => 'INR',
    'Indonesia Rupiah' => 'IDR',
    'Iran Rial' => 'IRR',
    'Isle of Man Pound' => 'IMP',
    'Israel Shekel' => 'ILS',
    'Jamaica Dollar' => 'JMD',
    'Japan Yen' => 'JPY',
    'Jersey Pound' => 'JEP',
    'Kazakhstan Tenge' => 'KZT',
    'Korea (North) Won' => 'KPW',
    'Korea (South) Won' => 'KRW',
    'Kyrgyzstan Som' => 'KGS',
    'Laos Kip' => 'LAK',
    'Latvia Lat' => 'LVL',
    'Lebanon Pound' => 'LBP',
    'Liberia Dollar' => 'LRD',
    'Lithuania Litas' => 'LTL',
    'Macedonia Denar' => 'MKD',
    'Malaysia Ringgit' => 'MYR',
    'Mauritius Rupee' => 'MUR',
    'Mexico Peso' => 'MXN',
    'Mongolia Tughrik' => 'MNT',
    'Mozambique Metical' => 'MZN',
    'Namibia Dollar' => 'NAD',
    'Nepal Rupee' => 'NPR',
    'Netherlands Antilles Guilder' => 'ANG',
    'New Zealand Dollar' => 'NZD',
    'Nicaragua Cordoba' => 'NIO',
    'Nigeria Naira' => 'NGN',
    'Norway Krone' => 'NOK',
    'Oman Rial' => 'OMR',
    'Pakistan Rupee' => 'PKR',
    'Panama Balboa' => 'PAB',
    'Paraguay Guarani' => 'PYG',
    'Peru Nuevo Sol' => 'PEN',
    'Philippines Peso' => 'PHP',
    'Poland Zloty' => 'PLN',
    'Qatar Riyal' => 'QAR',
    'Romania New Leu' => 'RON',
    'Russia Ruble' => 'RUB',
    'Saint Helena Pound' => 'SHP',
    'Saudi Arabia Riyal' => 'SAR',
    'Serbia Dinar' => 'RSD',
    'Seychelles Rupee' => 'SCR',
    'Singapore Dollar' => 'SGD',
    'Solomon Islands Dollar' => 'SBD',
    'Somalia Shilling' => 'SOS',
    'South Africa Rand' => 'ZAR',
    'Sri Lanka Rupee' => 'LKR',
    'Sweden Krona' => 'SEK',
    'Switzerland Franc' => 'CHF',
    'Suriname Dollar' => 'SRD',
    'Syria Pound' => 'SYP',
    'Taiwan New Dollar' => 'TWD',
    'Thailand Baht' => 'THB',
    'Trinidad and Tobago Dollar' => 'TTD',
    'Turkey Lira' => 'TRL',
    'Tuvalu Dollar' => 'TVD',
    'Ukraine Hryvna' => 'UAH',
    'United Kingdom Pound' => 'GBP',
    'United States Dollar' => 'USD',
    'Uruguay Peso' => 'UYU',
    'Uzbekistan Som' => 'UZS',
    'Venezuela Bolivar' => 'VEF',
    'Viet Nam Dong' => 'VND',
    'Yemen Rial' => 'YER',
    'Zimbabwe Dollar' => 'ZWD',
));