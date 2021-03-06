/*globals vsprintf*/
/**
 * Provides language-related functionality
 */
elgg.provide('elgg.config.translations');

// default language - required by unit tests
elgg.config.language = 'en';

/**
 * Analagous to the php version.  Merges translations for a
 * given language into the current translations map.
 */
elgg.add_translation = function(lang, translations) {
	elgg.provide('elgg.config.translations.' + lang);

	elgg.extend(elgg.config.translations[lang], translations);
};

/**
 * Get the current language
 * @return {String}
 */
elgg.get_language = function() {
	var user = elgg.get_logged_in_user_entity();

	// GC change: use toggle language cookie if it is there.
	if ( document.cookie.indexOf("connex_lang") > -1 ){
  		var langcookie = document.cookie.substr(document.cookie.indexOf("connex_lang"));
  		langcookie = langcookie.substr(0, document.cookie.indexOf(";"));
  		langcookie = langcookie.substr(12);
  		return langcookie;
	}
  

  	/*if ( _elgg_services()->session->get('language') )
   		return _elgg_services()->session->get('language');*/

   	// otherwise resort to the default get_language
	if (user && user.language) {
		return user.language;
	}

	return elgg.config.language;
};

/**
 * Translates a string
 *
 * @param {String} key      The string to translate
 * @param {Array}  argv     vsprintf support
 * @param {String} language The language to display it in
 *
 * @return {String} The translation
 */
elgg.echo = function(key, argv, language) {
	//elgg.echo('str', 'en')
	if (elgg.isString(argv)) {
		language = argv;
		argv = [];
	}

	//elgg.echo('str', [...], 'en')
	var translations = elgg.config.translations,
		dlang = elgg.get_language(),
		map;

	language = language || dlang;
	argv = argv || [];

	map = translations[language] || translations[dlang];
	if (map && map[key]) {
		return vsprintf(map[key], argv);
	}

	return key;
};

