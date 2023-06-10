<?php

namespace NiceModules\Core\Lang;

use NiceModules\CoreModule\CoreModule;

class Locales
{
    protected string $file;
    protected array $localeLang;

    public function __construct()
    {
        $this->file = CoreModule::instance()->getDataDir() .
            DIRECTORY_SEPARATOR . 'static' . DIRECTORY_SEPARATOR . 'locale-lang.json';
        $this->localeLang = json_decode(file_get_contents($this->file), true);
    }


    /**
     * Returns DeepL language shortcut for given WordPress locale
     * @param string $locale
     * @return string|null
     */
    public function getLocaleLang(string $locale): ?string
    {
        if (isset($this->localeLang[$locale])) {
            return $this->localeLang[$locale];
        }

        return null;
    }

    protected function getLangs(): array
    {
        return [
            'BG' => 'Bulgarian',
            'CS' => 'Czech',
            'DA' => 'Danish',
            'DE' => 'German',
            'EL' => 'Greek',
            'EN' => 'English (unspecified variant for backward compatibility; please select EN-GB or EN-US instead)',
            'EN-GB' => 'English (British)',
            'EN-US' => 'English (American)',
            'ES' => 'Spanish',
            'ET' => 'Estonian',
            'FI' => 'Finnish',
            'FR' => 'French',
            'HU' => 'Hungarian',
            'ID' => 'Indonesian',
            'IT' => 'Italian',
            'JA' => 'Japanese',
            'KO' => 'Korean',
            'LT' => 'Lithuanian',
            'LV' => 'Latvian',
            'NB' => 'Norwegian (Bokmål)',
            'NL' => 'Dutch',
            'PL' => 'Polish',
            'PT' => 'Portuguese (unspecified variant for backward compatibility; please select PT-BR or PT-PT instead)',
            'PT-BR' => 'Portuguese (Brazilian)',
            'PT-PT' => 'Portuguese (all Portuguese varieties excluding Brazilian Portuguese)',
            'RO' => 'Romanian',
            'RU' => 'Russian',
            'SK' => 'Slovak',
            'SL' => 'Slovenian',
            'SV' => 'Swedish',
            'TR' => 'Turkish',
            'UK' => 'Ukrainian',
            'ZH' => 'Chinese (simplified)',
        ];
    }

    protected function getLocaleLangs(): array
    {
        return [
            'af' => 'af',
            'sq' => 'sq',
            'arq' => 'arq',
            'ak' => 'ak',
            'am' => 'am',
            'ar' => 'ar',
            'hy' => 'hy',
            'rup_MK' => 'rup',
            'frp' => 'frp',
            'as' => 'as',
            'ast' => 'ast',
            'az' => 'az',
            'az_TR' => 'az-tr',
            'bcc' => 'bcc',
            'ba' => 'ba',
            'eu' => 'eu',
            'bel' => 'bel',
            'bn_BD' => 'bn',
            'bn_IN' => 'bn-in',
            'bho' => 'bho',
            'brx' => 'brx',
            'gax' => 'gax',
            'bs_BA' => 'bs',
            'bre' => 'br',
            'bg_BG' => 'bg',
            'ca' => 'ca',
            'bal' => 'bal',
            'ceb' => 'ceb',
            'zh_CN' => 'zh-cn',
            'zh_HK' => 'zh-hk',
            'zh_SG' => 'zh-sg',
            'zh_TW' => 'zh-tw',
            'cor' => 'cor',
            'co' => 'co',
            'hr' => 'hr',
            'cs_CZ' => 'cs',
            'da_DK' => 'da',
            'dv' => 'dv',
            'nl_NL' => 'nl',
            'nl_BE' => 'nl-be',
            'dzo' => 'dzo',
            'art-xemoji' => 'art-xemoji',
            'en_US' => 'en',
            'en_AU' => 'en-au',
            'en_CA' => 'en-ca',
            'en_NZ' => 'en-nz',
            'art_xpirate' => 'art_xpirate',
            'en_SA' => 'en-sa',
            'en_GB' => 'en-gb',
            'eo' => 'eo',
            'et' => 'et',
            'ewe' => 'ewe',
            'fo' => 'fo',
            'fi' => 'fi',
            'fon' => 'fon',
            'fr_BE' => 'fr-be',
            'fr_CA' => 'fr-ca',
            'fr_FR' => 'fr',
            'fy' => 'fy',
            'fur' => 'fur',
            'fuc' => 'fuc',
            'gl_ES' => 'gl',
            'ka_GE' => 'ka',
            'de_DE' => 'de',
            'de_AT' => 'de-AT',
            'de_CH' => 'de-ch',
            'el' => 'el',
            'kal' => 'kal',
            'gn' => 'gn',
            'gu_IN' => 'gu',
            'haw_US' => 'haw',
            'hat' => 'hat',
            'hau' => 'hau',
            'haz' => 'haz',
            'he_IL' => 'he',
            'hi_IN' => 'hi',
            'hu_HU' => 'hu',
            'is_IS' => 'is',
            'ido' => 'ido',
            'ibo' => 'ibo',
            'id_ID' => 'id',
            'ga' => 'ga',
            'it_IT' => 'it',
            'ja' => 'ja',
            'jv_ID' => 'jv',
            'kab' => 'kab',
            'kn' => 'kn',
            'kaa' => 'kaa',
            'kk' => 'kk',
            'km' => 'km',
            'kin' => 'kin',
            'ky_KY' => 'ky',
            'ko_KR' => 'ko',
            'ckb' => 'ckb',
            'kmr' => 'kmr',
            'kir' => 'kir',
            'lo' => 'lo',
            'lv' => 'lv',
            'la' => 'la',
            'lij' => 'lij',
            'li' => 'li',
            'lin' => 'lin',
            'lt_LT' => 'lt',
            'lmo' => 'lmo',
            'dsb' => 'dsb',
            'lug' => 'lug',
            'lb_LU' => 'lb',
            'mk_MK' => 'mk',
            'mai' => 'mai',
            'mg_MG' => 'mg',
            'mlt' => 'mlt',
            'ms_MY' => 'ms',
            'ml_IN' => 'ml',
            'mri' => 'mri',
            'mfe' => 'mfe',
            'mr' => 'mr',
            'xmf' => 'xmf',
            'mn' => 'mn',
            'me_ME' => 'me',
            'ary' => 'ary',
            'my_MM' => 'mya',
            'ne_NP' => 'ne',
            'pcm' => 'pcm',
            'nqo' => 'nqo',
            'nb_NO' => 'nb',
            'nn_NO' => 'nn',
            'oci' => 'oci',
            'ory' => 'ory',
            'os' => 'os',
            'ps' => 'ps',
            'pa_IN' => 'pa',
            'pap_AW' => 'pap-AW',
            'pap_CW' => 'pap-CW',
            'fa_IR' => 'fa',
            'fa_AF' => 'fa-af',
            'pl_PL' => 'pl',
            'pt_AO' => 'pt-AO',
            'pt_BR' => 'pt-br',
            'pt_PT' => 'pt',
            'rhg' => 'rhg',
            'ro_RO' => 'ro',
            'roh' => 'roh',
            'ru_RU' => 'ru',
            'ru_UA' => 'ru-ua',
            'rue' => 'rue',
            'sah' => 'sah',
            'sa_IN' => 'sa-in',
            'skr' => 'skr',
            'srd' => 'srd',
            'gd' => 'gd',
            'sr_RS' => 'sr',
            'sna' => 'sna',
            'sq_XK' => 'sq',
            'scn' => 'scn',
            'sd_PK' => 'sd',
            'si_LK' => 'si',
            'szl' => 'szl',
            'sk_SK' => 'sk',
            'sl_SI' => 'sl',
            'so_SO' => 'so',
            'azb' => 'azb',
            'es_AR' => 'es-ar',
            'es_CL' => 'es-cl',
            'es_CR' => 'es-CR',
            'es_CO' => 'es-co',
            'es_DO' => 'es-DO',
            'es_EC' => 'es-EC',
            'es_GT' => 'es-gt',
            'es_HN' => 'es-HN',
            'es_MX' => 'es-mx',
            'es_PE' => 'es-pe',
            'es_PR' => 'es-pr',
            'es_ES' => 'es',
            'es_UY' => 'es-UY',
            'es_VE' => 'es-ve',
            'su_ID' => 'su',
            'ssw' => 'ssw',
            'sw' => 'sw',
            'sv_SE' => 'sv',
            'gsw' => 'gsw',
            'syr' => 'syr',
            'tl' => 'tl',
            'tah' => 'tah',
            'tg' => 'tg',
            'tzm' => 'tzm',
            'zgh' => 'zgh',
            'ta_IN' => 'ta',
            'ta_LK' => 'ta-lk',
            'tt_RU' => 'tt',
            'te' => 'te',
            'th' => 'th',
            'bo' => 'bo',
            'tir' => 'tir',
            'tr_TR' => 'tr',
            'tuk' => 'tuk',
            'twd' => 'twd',
            'ug_CN' => 'ug',
            'uk' => 'uk',
            'hsb' => 'hsb',
            'ur' => 'ur',
            'uz_UZ' => 'uz',
            'vec' => 'vec',
            'vi' => 'vi',
            'wa' => 'wa',
            'cy' => 'cy',
            'wol' => 'wol',
            'xho' => 'xho',
            'yor' => 'yor',
            'zul' => 'zul',
        ];
    }

    protected function matchLocaleLang($locale): ?string
    {
        $localeLangs = $this->getLocaleLangs();

        $langs = $this->getLangs();

        if (isset($localeLangs[$locale])) {
            $localeLang = strtoupper($localeLangs[$locale]);

            if (isset($langs[$localeLang])) {
                return $localeLang;
            } else {
                $localeLangParts = explode('-', $localeLang);
                $localeLang = $localeLangParts[0];

                if (isset($langs[$localeLang])) {
                    return $localeLang;
                }
            }
        }

        return null;
    }

    public function matchLocales()
    {
        $matched = [];

        foreach ($this->getLocaleLangs() as $locale => $localeLang) {
            $lang = $this->matchLocaleLang($locale);

            if ($lang) {
                $matched[$locale] = $lang;
            }
        }

        file_put_contents($this->file, json_encode($matched, JSON_PRETTY_PRINT));
    }

}