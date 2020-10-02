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
         <h1 id='ir-title'>OnePlus 8T will reportedly be taller and wider than the OnePlus 8 despite</h1>
      
            <span id='ir-text-3'>
            <div class='immersive-reader-button' data-button-style="icon" onclick='launchImmersiveReaderFromInlineHtml("check")'></div>          
<p lang="en-IN" id="check" >OnePlus 8T will reportedly be taller and wider than the OnePlus 8 despite having the same screen size of 6.55-inch. As per a tweet by a tipster, the OnePlus 8T will measure 162.8 x 75.5 x 8.4 mm. In comparison, the OnePlus 8 measures 160.20x72.90x8mm. Further, the tipster claims that the upcoming smartphone is 9.3mm thick with the camera bump. The company CEO Pete Lau had already confirmed that the handset will come with a screen-to-body ratio of 91.9 percent.</p>
            </span>
        </article>
    </main>
</body>

</html>
