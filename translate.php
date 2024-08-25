<?php
$translated_text = '';
$input_text = '';
$output_lang = 'fr'; // Default language

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_text = isset($_POST['input_text']) ? $_POST['input_text'] : '';
    $output_lang = isset($_POST['output_lang']) ? $_POST['output_lang'] : 'fr';

    // Your Azure Translator API key and endpoint
    $api_key = 'YOUR_API_KEY';
    $endpoint = 'https://api.cognitive.microsofttranslator.com';

    // API URL
    $url = $endpoint . '/translate?api-version=3.0&from=en&to=' . strtoupper($output_lang);

    // Prepare the data for the API request
    $data = array(
        array('text' => $input_text)
    );

    $headers = array(
        'Ocp-Apim-Subscription-Key: ' . $api_key,
        'Ocp-Apim-Subscription-Region: eastasia',
        'Content-Type: application/json',
        'X-ClientTraceId: ' . uniqid()
    );

    // Set up curl
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Execute curl and get the response
    $response = curl_exec($ch);

    // Check for curl errors
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        curl_close($ch);
        die("cURL error: $error_msg");
    }

    curl_close($ch);

    // Decode the response
    $response_data = json_decode($response, true);
    // Check if response is an array and contains translations
    if (is_array($response_data) && isset($response_data[0]['translations'][0]['text'])) {
        $translated_text = $response_data[0]['translations'][0]['text'];
    } else {
        $translated_text = $response_data;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Translator Box</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Text Translator</h2>
        <form action="" method="POST">
            <div class="row">
                <!-- Input Box -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="input_text" class="form-label">Enter Text:</label>
                        <textarea class="form-control" name="input_text" id="input_text" rows="8" placeholder="Type your text here..."><?php echo htmlspecialchars($input_text, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>
                </div>
                <!-- Output Box -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="output_text" class="form-label">Translated Text:</label>
                        <textarea class="form-control" name="output_text" id="output_text" rows="8" readonly><?php echo htmlspecialchars($translated_text, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="output_lang" class="form-label">Output Language:</label>
                        <select class="form-select" name="output_lang" id="output_lang">
                            <option value="af" <?php echo isset($output_lang) && $output_lang == 'af' ? 'selected' : ''; ?>>Afrikaans (AF)</option>
                            <option value="sq" <?php echo isset($output_lang) && $output_lang == 'sq' ? 'selected' : ''; ?>>Albanian (SQ)</option>
                            <option value="am" <?php echo isset($output_lang) && $output_lang == 'am' ? 'selected' : ''; ?>>Amharic (AM)</option>
                            <option value="ar" <?php echo isset($output_lang) && $output_lang == 'ar' ? 'selected' : ''; ?>>Arabic (AR)</option>
                            <option value="hy" <?php echo isset($output_lang) && $output_lang == 'hy' ? 'selected' : ''; ?>>Armenian (HY)</option>
                            <option value="as" <?php echo isset($output_lang) && $output_lang == 'as' ? 'selected' : ''; ?>>Assamese (AS)</option>
                            <option value="az" <?php echo isset($output_lang) && $output_lang == 'az' ? 'selected' : ''; ?>>Azerbaijani (Latin) (AZ)</option>
                            <option value="bn" <?php echo isset($output_lang) && $output_lang == 'bn' ? 'selected' : ''; ?>>Bangla (BN)</option>
                            <option value="ba" <?php echo isset($output_lang) && $output_lang == 'ba' ? 'selected' : ''; ?>>Bashkir (BA)</option>
                            <option value="eu" <?php echo isset($output_lang) && $output_lang == 'eu' ? 'selected' : ''; ?>>Basque (EU)</option>
                            <option value="bho" <?php echo isset($output_lang) && $output_lang == 'bho' ? 'selected' : ''; ?>>Bhojpuri (BHO)</option>
                            <option value="brx" <?php echo isset($output_lang) && $output_lang == 'brx' ? 'selected' : ''; ?>>Bodo (BRX)</option>
                            <option value="bs" <?php echo isset($output_lang) && $output_lang == 'bs' ? 'selected' : ''; ?>>Bosnian (Latin) (BS)</option>
                            <option value="bg" <?php echo isset($output_lang) && $output_lang == 'bg' ? 'selected' : ''; ?>>Bulgarian (BG)</option>
                            <option value="yue" <?php echo isset($output_lang) && $output_lang == 'yue' ? 'selected' : ''; ?>>Cantonese (Traditional) (YUE)</option>
                            <option value="ca" <?php echo isset($output_lang) && $output_lang == 'ca' ? 'selected' : ''; ?>>Catalan (CA)</option>
                            <option value="lzh" <?php echo isset($output_lang) && $output_lang == 'lzh' ? 'selected' : ''; ?>>Chinese (Literary) (LZH)</option>
                            <option value="zh-Hans" <?php echo isset($output_lang) && $output_lang == 'zh-Hans' ? 'selected' : ''; ?>>Chinese Simplified (ZH-Hans)</option>
                            <option value="zh-Hant" <?php echo isset($output_lang) && $output_lang == 'zh-Hant' ? 'selected' : ''; ?>>Chinese Traditional (ZH-Hant)</option>
                            <option value="sn" <?php echo isset($output_lang) && $output_lang == 'sn' ? 'selected' : ''; ?>>chiShona (SN)</option>
                            <option value="hr" <?php echo isset($output_lang) && $output_lang == 'hr' ? 'selected' : ''; ?>>Croatian (HR)</option>
                            <option value="cs" <?php echo isset($output_lang) && $output_lang == 'cs' ? 'selected' : ''; ?>>Czech (CS)</option>
                            <option value="da" <?php echo isset($output_lang) && $output_lang == 'da' ? 'selected' : ''; ?>>Danish (DA)</option>
                            <option value="prs" <?php echo isset($output_lang) && $output_lang == 'prs' ? 'selected' : ''; ?>>Dari (PRS)</option>
                            <option value="dv" <?php echo isset($output_lang) && $output_lang == 'dv' ? 'selected' : ''; ?>>Divehi (DV)</option>
                            <option value="doi" <?php echo isset($output_lang) && $output_lang == 'doi' ? 'selected' : ''; ?>>Dogri (DOI)</option>
                            <option value="nl" <?php echo isset($output_lang) && $output_lang == 'nl' ? 'selected' : ''; ?>>Dutch (NL)</option>
                            <option value="en" <?php echo isset($output_lang) && $output_lang == 'en' ? 'selected' : ''; ?>>English (EN)</option>
                            <option value="et" <?php echo isset($output_lang) && $output_lang == 'et' ? 'selected' : ''; ?>>Estonian (ET)</option>
                            <option value="fo" <?php echo isset($output_lang) && $output_lang == 'fo' ? 'selected' : ''; ?>>Faroese (FO)</option>
                            <option value="fj" <?php echo isset($output_lang) && $output_lang == 'fj' ? 'selected' : ''; ?>>Fijian (FJ)</option>
                            <option value="fil" <?php echo isset($output_lang) && $output_lang == 'fil' ? 'selected' : ''; ?>>Filipino (FIL)</option>
                            <option value="fi" <?php echo isset($output_lang) && $output_lang == 'fi' ? 'selected' : ''; ?>>Finnish (FI)</option>
                            <option value="fr" <?php echo isset($output_lang) && $output_lang == 'fr' ? 'selected' : ''; ?>>French (FR)</option>
                            <option value="fr-ca" <?php echo isset($output_lang) && $output_lang == 'fr-ca' ? 'selected' : ''; ?>>French (Canada) (FR-CA)</option>
                            <option value="gl" <?php echo isset($output_lang) && $output_lang == 'gl' ? 'selected' : ''; ?>>Galician (GL)</option>
                            <option value="ka" <?php echo isset($output_lang) && $output_lang == 'ka' ? 'selected' : ''; ?>>Georgian (KA)</option>
                            <option value="de" <?php echo isset($output_lang) && $output_lang == 'de' ? 'selected' : ''; ?>>German (DE)</option>
                            <option value="el" <?php echo isset($output_lang) && $output_lang == 'el' ? 'selected' : ''; ?>>Greek (EL)</option>
                            <option value="gu" <?php echo isset($output_lang) && $output_lang == 'gu' ? 'selected' : ''; ?>>Gujarati (GU)</option>
                            <option value="ht" <?php echo isset($output_lang) && $output_lang == 'ht' ? 'selected' : ''; ?>>Haitian Creole (HT)</option>
                            <option value="ha" <?php echo isset($output_lang) && $output_lang == 'ha' ? 'selected' : ''; ?>>Hausa (HA)</option>
                            <option value="he" <?php echo isset($output_lang) && $output_lang == 'he' ? 'selected' : ''; ?>>Hebrew (HE)</option>
                            <option value="hi" <?php echo isset($output_lang) && $output_lang == 'hi' ? 'selected' : ''; ?>>Hindi (HI)</option>
                            <option value="mww" <?php echo isset($output_lang) && $output_lang == 'mww' ? 'selected' : ''; ?>>Hmong Daw (Latin) (MWW)</option>
                            <option value="hu" <?php echo isset($output_lang) && $output_lang == 'hu' ? 'selected' : ''; ?>>Hungarian (HU)</option>
                            <option value="is" <?php echo isset($output_lang) && $output_lang == 'is' ? 'selected' : ''; ?>>Icelandic (IS)</option>
                            <option value="ig" <?php echo isset($output_lang) && $output_lang == 'ig' ? 'selected' : ''; ?>>Igbo (IG)</option>
                            <option value="id" <?php echo isset($output_lang) && $output_lang == 'id' ? 'selected' : ''; ?>>Indonesian (ID)</option>
                            <option value="ikt" <?php echo isset($output_lang) && $output_lang == 'ikt' ? 'selected' : ''; ?>>Inuinnaqtun (IKT)</option>
                            <option value="iu" <?php echo isset($output_lang) && $output_lang == 'iu' ? 'selected' : ''; ?>>Inuktitut (IU)</option>
                            <option value="iu-Latn" <?php echo isset($output_lang) && $output_lang == 'iu-Latn' ? 'selected' : ''; ?>>Inuktitut (Latin) (IU-Latn)</option>
                            <option value="ga" <?php echo isset($output_lang) && $output_lang == 'ga' ? 'selected' : ''; ?>>Irish (GA)</option>
                            <option value="it" <?php echo isset($output_lang) && $output_lang == 'it' ? 'selected' : ''; ?>>Italian (IT)</option>
                            <option value="ja" <?php echo isset($output_lang) && $output_lang == 'ja' ? 'selected' : ''; ?>>Japanese (JA)</option>
                            <option value="jv" <?php echo isset($output_lang) && $output_lang == 'jv' ? 'selected' : ''; ?>>Javanese (JV)</option>
                            <option value="kl" <?php echo isset($output_lang) && $output_lang == 'kl' ? 'selected' : ''; ?>>Kalaallisut (KL)</option>
                            <option value="kn" <?php echo isset($output_lang) && $output_lang == 'kn' ? 'selected' : ''; ?>>Kannada (KN)</option>
                            <option value="ks" <?php echo isset($output_lang) && $output_lang == 'ks' ? 'selected' : ''; ?>>Kashmiri (KS)</option>
                            <option value="km" <?php echo isset($output_lang) && $output_lang == 'km' ? 'selected' : ''; ?>>Khmer (KM)</option>
                            <option value="ki" <?php echo isset($output_lang) && $output_lang == 'ki' ? 'selected' : ''; ?>>Kikuyu (KI)</option>
                            <option value="rw" <?php echo isset($output_lang) && $output_lang == 'rw' ? 'selected' : ''; ?>>Kinyarwanda (RW)</option>
                            <option value="ky" <?php echo isset($output_lang) && $output_lang == 'ky' ? 'selected' : ''; ?>>Kirghiz (KY)</option>
                            <option value="kv" <?php echo isset($output_lang) && $output_lang == 'kv' ? 'selected' : ''; ?>>Komi (KV)</option>
                            <option value="kg" <?php echo isset($output_lang) && $output_lang == 'kg' ? 'selected' : ''; ?>>Kongo (KG)</option>
                            <option value="ko" <?php echo isset($output_lang) && $output_lang == 'ko' ? 'selected' : ''; ?>>Korean (KO)</option>
                            <option value="ku" <?php echo isset($output_lang) && $output_lang == 'ku' ? 'selected' : ''; ?>>Kurdish (KU)</option>
                            <option value="ckb" <?php echo isset($output_lang) && $output_lang == 'ckb' ? 'selected' : ''; ?>>Kurdish (Central) (CKB)</option>
                            <option value="ky" <?php echo isset($output_lang) && $output_lang == 'ky' ? 'selected' : ''; ?>>Kyrgyz (KY)</option>
                            <option value="la" <?php echo isset($output_lang) && $output_lang == 'la' ? 'selected' : ''; ?>>Latin (LA)</option>
                            <option value="lv" <?php echo isset($output_lang) && $output_lang == 'lv' ? 'selected' : ''; ?>>Latvian (LV)</option>
                            <option value="ln" <?php echo isset($output_lang) && $output_lang == 'ln' ? 'selected' : ''; ?>>Lingala (LN)</option>
                            <option value="lt" <?php echo isset($output_lang) && $output_lang == 'lt' ? 'selected' : ''; ?>>Lithuanian (LT)</option>
                            <option value="lu" <?php echo isset($output_lang) && $output_lang == 'lu' ? 'selected' : ''; ?>>Luba-Katanga (LU)</option>
                            <option value="lb" <?php echo isset($output_lang) && $output_lang == 'lb' ? 'selected' : ''; ?>>Luxembourgish (LB)</option>
                            <option value="mk" <?php echo isset($output_lang) && $output_lang == 'mk' ? 'selected' : ''; ?>>Macedonian (MK)</option>
                            <option value="mg" <?php echo isset($output_lang) && $output_lang == 'mg' ? 'selected' : ''; ?>>Malagasy (MG)</option>
                            <option value="ml" <?php echo isset($output_lang) && $output_lang == 'ml' ? 'selected' : ''; ?>>Malayalam (ML)</option>
                            <option value="ms" <?php echo isset($output_lang) && $output_lang == 'ms' ? 'selected' : ''; ?>>Malay (MS)</option>
                            <option value="mt" <?php echo isset($output_lang) && $output_lang == 'mt' ? 'selected' : ''; ?>>Maltese (MT)</option>
                            <option value="mi" <?php echo isset($output_lang) && $output_lang == 'mi' ? 'selected' : ''; ?>>Māori (MI)</option>
                            <option value="mr" <?php echo isset($output_lang) && $output_lang == 'mr' ? 'selected' : ''; ?>>Marathi (MR)</option>
                            <option value="mh" <?php echo isset($output_lang) && $output_lang == 'mh' ? 'selected' : ''; ?>>Marshallese (MH)</option>
                            <option value="mfe" <?php echo isset($output_lang) && $output_lang == 'mfe' ? 'selected' : ''; ?>>Morisyen (MFE)</option>
                            <option value="mo" <?php echo isset($output_lang) && $output_lang == 'mo' ? 'selected' : ''; ?>>Moldavian (MO)</option>
                            <option value="mn" <?php echo isset($output_lang) && $output_lang == 'mn' ? 'selected' : ''; ?>>Mongolian (MN)</option>
                            <option value="my" <?php echo isset($output_lang) && $output_lang == 'my' ? 'selected' : ''; ?>>Burmese (MY)</option>
                            <option value="ne" <?php echo isset($output_lang) && $output_lang == 'ne' ? 'selected' : ''; ?>>Nepali (NE)</option>
                            <option value="no" <?php echo isset($output_lang) && $output_lang == 'no' ? 'selected' : ''; ?>>Norwegian (NO)</option>
                            <option value="ny" <?php echo isset($output_lang) && $output_lang == 'ny' ? 'selected' : ''; ?>>Chichewa (NY)</option>
                            <option value="oc" <?php echo isset($output_lang) && $output_lang == 'oc' ? 'selected' : ''; ?>>Occitan (OC)</option>
                            <option value="or" <?php echo isset($output_lang) && $output_lang == 'or' ? 'selected' : ''; ?>>Oriya (OR)</option>
                            <option value="om" <?php echo isset($output_lang) && $output_lang == 'om' ? 'selected' : ''; ?>>Oromo (OM)</option>
                            <option value="os" <?php echo isset($output_lang) && $output_lang == 'os' ? 'selected' : ''; ?>>Ossetian (OS)</option>
                            <option value="pa" <?php echo isset($output_lang) && $output_lang == 'pa' ? 'selected' : ''; ?>>Punjabi (PA)</option>
                            <option value="pl" <?php echo isset($output_lang) && $output_lang == 'pl' ? 'selected' : ''; ?>>Polish (PL)</option>
                            <option value="ps" <?php echo isset($output_lang) && $output_lang == 'ps' ? 'selected' : ''; ?>>Pashto (PS)</option>
                            <option value="pt" <?php echo isset($output_lang) && $output_lang == 'pt' ? 'selected' : ''; ?>>Portuguese (PT)</option>
                            <option value="pa" <?php echo isset($output_lang) && $output_lang == 'pa' ? 'selected' : ''; ?>>Punjabi (PA)</option>
                            <option value="qu" <?php echo isset($output_lang) && $output_lang == 'qu' ? 'selected' : ''; ?>>Quechua (QU)</option>
                            <option value="ro" <?php echo isset($output_lang) && $output_lang == 'ro' ? 'selected' : ''; ?>>Romanian (RO)</option>
                            <option value="ru" <?php echo isset($output_lang) && $output_lang == 'ru' ? 'selected' : ''; ?>>Russian (RU)</option>
                            <option value="sm" <?php echo isset($output_lang) && $output_lang == 'sm' ? 'selected' : ''; ?>>Samoan (SM)</option>
                            <option value="sg" <?php echo isset($output_lang) && $output_lang == 'sg' ? 'selected' : ''; ?>>Sango (SG)</option>
                            <option value="sa" <?php echo isset($output_lang) && $output_lang == 'sa' ? 'selected' : ''; ?>>Sanskrit (SA)</option>
                            <option value="sc" <?php echo isset($output_lang) && $output_lang == 'sc' ? 'selected' : ''; ?>>Sardinian (SC)</option>
                            <option value="sd" <?php echo isset($output_lang) && $output_lang == 'sd' ? 'selected' : ''; ?>>Sindhi (SD)</option>
                            <option value="si" <?php echo isset($output_lang) && $output_lang == 'si' ? 'selected' : ''; ?>>Sinhala (SI)</option>
                            <option value="sk" <?php echo isset($output_lang) && $output_lang == 'sk' ? 'selected' : ''; ?>>Slovak (SK)</option>
                            <option value="sl" <?php echo isset($output_lang) && $output_lang == 'sl' ? 'selected' : ''; ?>>Slovenian (SL)</option>
                            <option value="so" <?php echo isset($output_lang) && $output_lang == 'so' ? 'selected' : ''; ?>>Somali (SO)</option>
                            <option value="st" <?php echo isset($output_lang) && $output_lang == 'st' ? 'selected' : ''; ?>>Sesotho (ST)</option>
                            <option value="es" <?php echo isset($output_lang) && $output_lang == 'es' ? 'selected' : ''; ?>>Spanish (ES)</option>
                            <option value="su" <?php echo isset($output_lang) && $output_lang == 'su' ? 'selected' : ''; ?>>Sundanese (SU)</option>
                            <option value="sw" <?php echo isset($output_lang) && $output_lang == 'sw' ? 'selected' : ''; ?>>Swahili (SW)</option>
                            <option value="ss" <?php echo isset($output_lang) && $output_lang == 'ss' ? 'selected' : ''; ?>>Swati (SS)</option>
                            <option value="sv" <?php echo isset($output_lang) && $output_lang == 'sv' ? 'selected' : ''; ?>>Swedish (SV)</option>
                            <option value="tl" <?php echo isset($output_lang) && $output_lang == 'tl' ? 'selected' : ''; ?>>Tagalog (TL)</option>
                            <option value="ta" <?php echo isset($output_lang) && $output_lang == 'ta' ? 'selected' : ''; ?>>Tamil (TA)</option>
                            <option value="te" <?php echo isset($output_lang) && $output_lang == 'te' ? 'selected' : ''; ?>>Telugu (TE)</option>
                            <option value="th" <?php echo isset($output_lang) && $output_lang == 'th' ? 'selected' : ''; ?>>Thai (TH)</option>
                            <option value="ti" <?php echo isset($output_lang) && $output_lang == 'ti' ? 'selected' : ''; ?>>Tigrinya (TI)</option>
                            <option value="to" <?php echo isset($output_lang) && $output_lang == 'to' ? 'selected' : ''; ?>>Tonga (TO)</option>
                            <option value="tr" <?php echo isset($output_lang) && $output_lang == 'tr' ? 'selected' : ''; ?>>Turkish (TR)</option>
                            <option value="tk" <?php echo isset($output_lang) && $output_lang == 'tk' ? 'selected' : ''; ?>>Turkmen (TK)</option>
                            <option value="tw" <?php echo isset($output_lang) && $output_lang == 'tw' ? 'selected' : ''; ?>>Twi (TW)</option>
                            <option value="uk" <?php echo isset($output_lang) && $output_lang == 'uk' ? 'selected' : ''; ?>>Ukrainian (UK)</option>
                            <option value="ur" <?php echo isset($output_lang) && $output_lang == 'ur' ? 'selected' : ''; ?>>Urdu (UR)</option>
                            <option value="uz" <?php echo isset($output_lang) && $output_lang == 'uz' ? 'selected' : ''; ?>>Uzbek (UZ)</option>
                            <option value="vi" <?php echo isset($output_lang) && $output_lang == 'vi' ? 'selected' : ''; ?>>Vietnamese (VI)</option>
                            <option value="cy" <?php echo isset($output_lang) && $output_lang == 'cy' ? 'selected' : ''; ?>>Welsh (CY)</option>
                            <option value="xh" <?php echo isset($output_lang) && $output_lang == 'xh' ? 'selected' : ''; ?>>Xhosa (XH)</option>
                            <option value="yi" <?php echo isset($output_lang) && $output_lang == 'yi' ? 'selected' : ''; ?>>Yiddish (YI)</option>
                            <option value="yo" <?php echo isset($output_lang) && $output_lang == 'yo' ? 'selected' : ''; ?>>Yoruba (YO)</option>
                            <option value="zu" <?php echo isset($output_lang) && $output_lang == 'zu' ? 'selected' : ''; ?>>Zulu (ZU)</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary mt-4">Translate</button>
            </div>
        </form>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
