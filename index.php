<?php
// Optional: Error checking
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Load Cloudinary Library and Cloudinary Environmental Variables
require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/includes/cloudinary.env.php";

// Start the session. Use it to store some info, like a session timer.
session_start();
$_SESSION['cloudinary_timer_start']=time();
?>

<title>Clip Generator</title>
<link rel="stylesheet" href="/assets/style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="og:title" content="Clip Generator">
<meta name="og:type" content="website">

<script 
    src="https://code.jquery.com/jquery-3.7.1.min.js" 
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
    crossorigin="anonymous">
</script>

<header>
    <nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark" style="position:fixed; width:100%; top:0; padding-left:20px; padding-right:20px;">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            Cloudinary: Clip Competition Demo
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            </ul>
            <li class="d-flex">
            </li>
        </div>
    </div>
</header>

<body>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <link href="https://unpkg.com/cloudinary-video-player@1.10.4/dist/cld-video-player.min.css" 
      rel="stylesheet">
  <script src="https://unpkg.com/cloudinary-video-player@1.10.4/dist/cld-video-player.min.js" 
      type="text/javascript"></script>
  <script src="https://upload-widget.cloudinary.com/global/all.js" type="text/javascript"></script>  
  
  <div class="container body-container">
    <h1 class="text-center">Clip Generator</h1>

    <div style="display: span">
      <span id="upload-box-span" style="display: none"><button id="upload-box" class="cloudinary-button"> ... </button></span>
      <span id="download-button-span"></span>
    </div>

    <div id="cloudinary-upload-widget-span" style="display: span">
      
    </div>

    <hr />
    <div id="results-div" class="alert alert-dark" style="display: none">
      <h3> Results </h3>
      <div id="video-player-div">
        <video id="video-player-media"></video>
      </div> 
    </div>

    <div class="alert alert-dark">
      <p><strong>Upload your best clip and post it 
      on social media!</strong> Then, you'll get 
      to see how cool it is to be in my event!</p>
      <ul>
        <li>Upload your best clip:</li>
        <ul>
          <li>Max length: 30 sec. (longer clips will be trimmed)</li>
          <li>Max file size: 100 MB.</li>
          <li>Aspect Ratio: 16:9</li>
        </ul>
        <li>Once the video is uploaded, wait a minute or two for it to generate.</li>
        <li>Once it's done generating, you can download it and post it on social media.</li>
        <li>If there is an error, please refresh the page and try again.</li>
      </ul>
    </div>
  </div>
  <footer class="d-flex flex-wrap justify-content-center align-items-center border-top bg-light" style="position:fixed;width:100%;bottom:0;padding: 10px;z-index:2">
      <div class="col-md-12 d-flex align-items-center">
        Cloudinary Clip Competition Demo by Arthur T.
      </div>
  </footer>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<script type="text/javascript"> 
  /**
   * Cloudinary Video Player
   */
  const player = cloudinary.videoPlayer('video-player-media', {
    cloudName: "<?= $CLOUDINARY_CLOUD_NAME ?>",
    fluid: true,
    controls: true,
    muted: false,
    colors: {
      accent: '#af0303'
    },
    hideContextMenu: true,
    autoplay: true,
  });
  
  /**
   * Function to call a server-side endpoint to generate a signature
   * based on the Cloudinary API key and secret, and upload preset
   */
  var generateSignature = function(callback, params_to_sign){
      $.ajax({
        url     : "/cloudinarysign.php",
        type    : "GET",
        dataType: "text",
        data    : {data: params_to_sign},
        complete: function() {
        },
        success : function(signature, textStatus, xhr) { callback(signature); },
        error   : function(xhr, status, error) {
          alert(xhr.status + ": " + xhr.responseText);
        }
      });
  }

  /**
   * Function to allow downloading of the uploaded, edited file
   * from the Cloudinary servers
   */
  var downloadSignedVideo = function(link, filename) {
    axios({
        url: link,
        method: 'GET',
        responseType: 'blob'
    })
        .then((response) => {
            const url = window.URL
                .createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', filename+'.mp4');
            document.body.appendChild(link);
            link.click();
        })
  }
  
  /**
   * A variable representing the upload widget, which we will define
   * its properties here, assign it to a div, and open it on page load.
   */
  var myWidget = cloudinary.applyUploadWidget(document.getElementById("upload-box"),
    { 
      /**
       * Properties of Upload Widget
       */
      api_key : "<?= $CLOUDINARY_API_KEY ?>",
      cloudName: "<?= $CLOUDINARY_CLOUD_NAME ?>",
      buttonCaption: "Upload Video",
      uploadPreset: "<?= $CLOUDINARY_UPLOAD_PRESET ?>",
      context: {
        upload_from: "cloudinary_demo"
      },
      uploadSignature: generateSignature,
      sources: [
        "local",
        "google_drive"
      ],
      text: {
        "en": {
          "queue": {
            "title_uploading_with_counter": "Uploading video...",
            "title_processing_with_counter": "Adding overlays to video (est: 1 min)"
          },
          "local": {
            "dd_title_single": "Drag and Drop Your Video Here",
            "browse": "Browse..."
          },
          "google_drive": {
            "no_auth_title": "Upload a video from your Google Drive."
          }
        }
      },
      showAdvancedOptions: false,
      cropping: false,
      multiple: false,
      defaultSource: "local",
      clientAllowedFormats: "mp4,mkv,mov",
      resourceType: "video",
      maxFileSize: "104857600",
      thumbnails: false,
      autoMinimize: true,
      inlineContainer: document.getElementById('cloudinary-upload-widget-span'),
      styles: {
        palette: {
          window: "#5D005D",
          sourceBg: "#3A0A3A",
          windowBorder: "#AD5BA3",
          tabIcon: "#ffffcc",
          inactiveTabIcon: "#FFD1D1",
          menuIcons: "#FFD1D1",
          link: "#ffcc33",
          action: "#ffcc33",
          inProgress: "#00e6b3",
          complete: "#a6ff6f",
          error: "#ff1765",
          textDark: "#3c0d68",
          textLight: "#fcfffd"
        },
        fonts: {
          default: null,
          "sans-serif": {
            url: null,
            active: true
          }
        }
      }
    },
    (error, result) => {
      /**
       * If there is no error, display the video in the Cloudinary Video Player
       * and enable the video downloader button. Also hide the upload widget.
       */
      if (!error && result && result.event === "success") {
        player.source(result.info.secure_url);
        document.getElementById("cloudinary-upload-widget-span").style.display = "none";
        document.getElementById("results-div").style.display = "block";
        document.getElementById("download-button-span").innerHTML = '\
          <button id="upload-box" class="cloudinary-button" \
          onclick=downloadSignedVideo("'+ result.info.secure_url + '","' + (result.info.public_id).split("/").slice(-1) + '_edited")>\
          Download Processed Video</button></a>';
        myWidget.close({ quiet: true });
      } else if (!error && result) {
        /**
         * Theoretically, you can handle other types of events here.
         */
      } else {
        /**
         * If there's an error, you can display it here and follow up with other code.
         */
        alert("Error: " + error["statusText"] + "\nPlease refresh this page and try again.");
        myWidget.close();
        myWidget.open();
      }
    });
  /**
   * Open the widget on page load
   */
  myWidget.open();
</script>