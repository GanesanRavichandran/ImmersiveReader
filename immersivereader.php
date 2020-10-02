<?php 


/* Azure TENANT ID , CLIENT ID, CLIENT SECRET */
$tenantid="";   // Eg : 0pp1234-2zdf-6568-b23d-sdf545449
$client_id="";  // Eg : 5482bcaf-272f-5454-5454-asdfsdf
$client_secret="";// Eg : ~23sdfsdfds
$subdomain='';                        // Eg : immersivereader
/* Azure TENANT ID , CLIENT ID, CLIENT SECRET */



/* Azure URL */
   $url="https://login.windows.net/".$tenantid."/oauth2/token";
/* Azure URL */

/* Parameters */
    $post_fields=array("grant_type"=>"client_credentials",
    "client_id"=>$client_id ,
    "client_secret"=>$client_secret,
    "resource"=>"https://cognitiveservices.azure.com/");
    $post_fields="grant_type=client_credentials&client_id=".$client_id."&client_secret=".$client_secret."&resource=".urlencode("https://cognitiveservices.azure.com/");
/* Parameters */

/* Headers */
    $httpheader='content-type:application/x-www-form-urlencoded';
/* Headers */
    $method="";
    $result=CurlPostURL($url,"",$post_fields,$method,$httpheader);
   
    $json=json_decode($result,true);

    $token=$json['access_token'];


function CurlPostURL($url, $password, $post_fields, $method,$httpheader){
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_fields);
    curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array($httpheader));
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
	$response = curl_exec($curl); 
	curl_close($curl); 
	
	return $response;
}


?>

<!doctype html>
<html>

<head>
    <meta charset='utf-8'>
    <title>Immersive Reader Example</title>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.min.js"></script>
    <script type='text/javascript' src='https://contentstorage.onenote.office.net/onenoteltir/immersivereadersdk/immersive-reader-sdk.1.0.0.js'></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type='text/javascript'>
        function launchImmersiveReaderFromInlineHtml(elementId, contentLanguage) {
            var element = document.getElementById(elementId);

            if (element && element.parentElement) {
                var html = element.innerHTML;

                const data = {
                    chunks: [{
                        mimeType: 'text/html',
                        content: html
                       // lang: contentLanguage
                    }]
                };

                var aadToken = '<?php echo $token; ?>'; // Your Azure AD token goes here
                var subdomain = '<?php echo $subdomain; ?>'; // Your subdomain goes here

                ImmersiveReader.launchAsync(aadToken, subdomain, data);
            }
        }

    </script>

    <style type='text/css'>
        #ContentArea {
            margin: 0 auto;
            position: relative;
            width: 100%;
        }

        .IRContent {
            margin: 0 100px;
        }
    </style>
</head>

<body>
    <main id='ContentArea'>
        <article class='IRContent'>
        <h1 id='ir-title'>பாபர் மசூதி இடிப்பு வழக்கு: பாஜக மூத்த தலைவர்கள் எல்.கே.அத்வானி, உமாபாரதி, மனோகர் ஜோஷி நீதிமன்றத்தில் ஆஜராக வாயப்பில்லை</h1>
      
            <span id='ir-text-3'>
            <div class='immersive-reader-button' data-button-style="icon" onclick='launchImmersiveReaderFromInlineHtml("check")'></div>          
                <p lang="ta-IN" id="check" >பாபர் மசூதி இடிப்பு வழக்கில் இன்று லக்னோ சிறப்பு நீதிமன்றம் தீர்ப்பு அளிக்க இருக்கும் நிலையில், பாஜக மூத்த தலைவர்கள் எல்.கே.அத்வானி, முரளி மனோகர் ஜோஷி, உமா பாரதி, கல்யாண் சிங் ஆகியோர் நேரில் ஆஜராக வாய்ப்பில்லை என்று தகவல்கள் தெரிவிக்கின்றன.

உத்தரப் பிரதேச மாநிலம் அயோத்தியில் இருந்த பாபர் மசூதி, கடந்த 1992-ம் ஆண்டு டிசம்பர் 6-ம் தேதி கரசேவகர்களால் இடிக்கப்பட்டது. தொடக்கத்தில் மாநில போலீஸார் விசாரித்து வந்த இந்த வழக்கு, பின்னர் சிபிஐயிடம் ஒப்படைக்கப்பட்டது.</p>
            </span>
        </article>
    </main>
</body>

</html>
