<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="profile" href="https://gmpg.org/xfn/11">
<meta name="robots" content="noindex, nofollow">

<link rel="profile" href="http://gmpg.org/xfn/11">
<title>Designedly - Contact form</title>

<!-- Jquery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">

<link rel="icon" href="https://designedly.ie/wp-content/uploads/2021/11/cropped-Designedly_Red_Symbol_RGB.png" sizes="32x32">

<script src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

<link href="/public/inc/style.css" rel="stylesheet">
<link rel="stylesheet" href="https://use.typekit.net/xvf4kwq.css">

<style>
  body {
    background-color:#f8f9fa;
  }

h1 {
  font-weight: 900;
}

.nav-link {
        color: white!important; 
        background-color: #686b6d;
        font-weight: 900!important;
}

 .nav-link.active {
        background-color: #eeeeee!important; 
        color: black!important;
        font-weight: 900!important;
}

.nav-link {
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
    border-bottom: none!important;
    border:1px solid #dee2e6;
    height: 50px;
}

.nav-tabs {
    border-bottom: none!important; /* Elimina el borde inferior */
}

.tabS {
      margin-left:10px;
    }

@media (min-width: 601px) {
  .tabS {
      margin-left:20px;
  }

  .nav-link {
    width: 250px;
    height: 60px;
    }

}

@media (max-width: 600px) {
  .nav-link {
    font-size:  0.9em;
    white-space: normal; /* Permitir el salto de línea */
    text-align: center;  /* Alinear el texto al centro, opcional */
    width: 100%;
    padding: 10px;
  }

  .quadre {
    background-color: #ffffff;
    padding: 10px;
    margin-top: 20px;
    border-radius: 0px!important;
  }

  .navbar-toggler {
    color: rgb(255 255 255);
    background-color: white;
  }

}


hr {
  border: none; /* Elimina el borde predeterminado */
  border-top: 3px solid #000; /* Agrega un borde sólido de 2px de grosor en la parte superior */
  color: #000000!important;
  opacity: 1; 
  margin-top: 40px!important;
  margin-bottom: 40px;
}

.nextBtn {
  background-color: #f8aeaa;
  color:#000;
  font-weight: 700;
  border-color: #f8aeaa;
}

.backBtn {
  background-color: #4e5356;
  color:white;
  font-weight: 700;
  border-color: #4e5356;
}

.section {
  border-bottom: 3px solid #c53f3e;
}

.red {
  color:#ee352b;
}

.link-header {
  text-decoration: none;
  color: white;
}

.form-check-input:checked {
background-color: #c53f3f;
border-color: #c53f3f;
}

.tab-content  {
  border-top-right-radius: 15px!important;  /* Ajusta el valor a tus necesidades */
  border-bottom-left-radius: 15px;
  border-bottom-right-radius: 15px;
  background-color: #eeeeee;
  border:1px solid #dee2e6;
  border-top:none;
}

.quadre4 {
  padding: 30px;
}

.responsive-image {
    max-width: 100%; /* La imagen no será más ancha que su contenedor */
    height: auto;   /* Mantiene la proporción de la imagen */
    max-height: 60px; 
    display: block; /* Elimina el espacio en línea inferior en algunos navegadores */
}

</style>

</head>
<body>

<!-- HEADER -->
<header>
    <nav class="navbar navbar-expand-lg navbar-lightt" style="background-color: #2d2f31!important;">
      <div class="container">
        <!-- Designedly logo -->
        <a class="navbar-brand" href="#">
          <img src="<?php echo APP_WEB;?>/public/inc/img/logo.png" alt="Logo" class="logo">
        </a>

        <!-- mobile responsive button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- NavMenu -->
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="bold">
              <a class="link-header" href="https://designedly.ie" target="_blank">Visit our Website</a><span class="red"> >>> </span>
            </li>
          </ul>
        </div>
      </div>
    </nav>
</header>

<!-- PAGE CONTENT STARTS HERE -->
<div class="container mt-5 quadre">
  <div style="padding-top:20px;padding-bottom:30px">
    <h1>Let's get to know you</h1>
      <p>To ensure we create the best possible design solutions tailored to your needs, we ask that you take your time and fill out the relevant questionnaire/s thoroughly. Your detailed answers will provide us with invaluable insights into your vision, preferences, and goals, allowing us to deliver exceptional brand design, web design, and/or social media strategies. The more information you share, the better we can align our creative process with your expectations.</p>
  </div>

  <div class="alert alert-success" id="creaOk" style="display:none" role="alert">
    <h4 class="alert-heading"><strong>New form submit whithout errors!</strong></h4>
    <h6>Thank you for submit to us all the information.</h6>
  </div>
          
  <div class="alert alert-danger" id="creaErr" style="display:none" role="alert">
  <h4 class="alert-heading"><strong>Error</strong></h4>
  <h6>Some data is not correct.</h6>
  </div>

    <!-- Form tabs -->
    <div class="d-flex flex-row">
      <div>
        <button class="nav-link active" id="tab1-tab">General information</button>
      </div>
      <div>
        <button class="nav-link tabS" id="tab2-tab">Your requirements</button>
      </div>
    </div>


  <!-- TAB CONTENT STARTS HERE -->
  <div class="tab-content" id="myTabContent">

    <form method="POST" id="newForm">

      <!-- TAB 1 - Client data-->
      <?php include APP_ROOT . '/public/form_list/public_website/form_1_general_tab.php'; ?>
   
      <!-- TAB 2 - HERE WE SHOW ALL QUESTIONS AND ANSWERS-->
      <div id="tab2" style="display:none">
        <div class="container quadre4">
          
            <h3 class="bold">Now, for the important part</h3>
            <p>Click on the questionnaire/s below that relate to you and fill out the forms the best you can</p>

            <div style="margin-bottom:10px;margin-top:20px">
              <div class="row">
                  <div class="col-12 col-lg-8">
                      <div class="row justify-content-start">
                          <div class="col-12 col-md-4 mb-2">
                            <button type="button" class="btn btn-secondary btnBrand nextBtn w-100" id="brandBtn">Brand Questionnaire</button>
                          </div>
                          <div class="col-12 col-md-4 mb-2">
                            <button type="button" class="btn btn-secondary btnWebsite nextBtn w-100" id="websiteBtn">Website Questionnaire</button>
                          </div>
                          <div class="col-12 col-md-4 mb-2">
                            <button type="button" class="btn btn-secondary btnSocialMedia nextBtn w-100" id="socialMediaBtn">Social Media Questionnaire</button>
                          </div>
                      </div>
                  </div>
                </div>
            </div>

          <hr>

          <!-- TAB 2a) - BRAND QUESTIONNAIRE-->
          <?php include APP_ROOT . '/public/form_list/public_website/form_2_brand.php'; ?>

          <!-- TAB 2b) - WEBSITE QUESTIONNAIRE-->
          <?php include APP_ROOT . '/public/form_list/public_website/form_3_website.php'; ?>

          <!-- TAB 2c) - SOCIAL MEDIA QUESTIONNAIRE-->
          <?php include APP_ROOT . '/public/form_list/public_website/form_4_social.php'; ?>

          <input type="hidden" id="idClient" name="idClient" value="">

          <!-- FORM BUTTONS ACTIONS -->

          <div class="alert alert-success" id="creaOk-2" style="display:none" role="alert">
                    <h4 class="alert-heading"><strong>New form submit whithout errors!</strong></h4>
                    <h6>Thank you for submit to us all the information.</h6>
          </div>
                            
          <div class="alert alert-danger" id="creaErr-2" style="display:none" role="alert">
                    <h4 class="alert-heading"><strong>Error</strong></h4>
                    <h6>Some data is not correct.</h6>
          </div>

          <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
            <div class="btn-group me-2" role="group" aria-label="First group">
              <button type="button" class="btn btn-secondary backBtn" id="btnBack">Back</button>
            </div>

            <div class="btn-group me-2" role="group" aria-label="Second group">
              <button type="submit" id="btnSend" class="btn btn-secondary nextBtn" style="display:none">Submit</button>
            </div>
          </div>
        
        </div>
      </div>
    </form>
  </div>
</div>


<!-- JAVASCRIPT STARTS HERE -->
<script>

document.addEventListener('DOMContentLoaded', function() {
// FUNCTION TO SHOW A DIFFERENT TAB
document.getElementById('tab1-tab').addEventListener('click', function(event) {
    event.preventDefault(); // disallow form action
    document.getElementById('tab1').style.display = "block"; // Show the selected div
    document.getElementById('tab2').style.display = "none"; // Show the selected div
    document.getElementById('tab1-tab').classList.add('active'); // Add active class to tab1 button
    document.getElementById('tab2-tab').classList.remove('active'); // Remove active class from tab2 button
});

document.getElementById('tab2-tab').addEventListener('click', function(event) {
    event.preventDefault(); // disallow form action
    document.getElementById('tab2').style.display = "block"; // Show the selected div
    document.getElementById('tab1').style.display = "none"; // Show the selected div
    document.getElementById('tab1-tab').classList.remove('active'); // Add active class to tab1 button
    document.getElementById('tab2-tab').classList.add('active'); // Remove active class from tab2 button
});

document.getElementById('btnNext').addEventListener('click', function(event) {
    event.preventDefault(); // disallow form action
    document.getElementById('tab2').style.display = "block"; // Show the selected div
    document.getElementById('tab1').style.display = "none"; // Show the selected div
    document.getElementById('tab1-tab').classList.remove('active'); // Add active class to tab1 button
    document.getElementById('tab2-tab').classList.add('active'); // Remove active class from tab2 button

    // Scroll to the top of the page
    window.scrollTo({
        top: 0,
        behavior: "smooth" // Smooth scrolling
    });
});

document.getElementById('btnBack').addEventListener('click', function(event) {
    event.preventDefault(); // disallow form action
    document.getElementById('tab2').style.display = "none"; // Show the selected div
    document.getElementById('tab1').style.display = "block"; // Show the selected div
    document.getElementById('tab1-tab').classList.add('active'); // Add active class to tab1 button
    document.getElementById('tab2-tab').classList.remove('active'); // Remove active class from tab2 button

    // Scroll to the top of the page
    window.scrollTo({
        top: 0,
        behavior: "smooth" // Smooth scrolling
    });
});

document.getElementById('brandBtn').addEventListener('click', function(event) {
    event.preventDefault(); // disallow form action
    document.getElementById('brandDiv').style.display = "block"; 
    document.getElementById('websiteDiv').style.display = "none"; 
    document.getElementById('socialMediaDiv').style.display = "none"; 
    document.getElementById('brandBtn').style.backgroundColor = "#c53f3f"; // active color
    document.getElementById('brandBtn').style.color = "white"; //

    document.getElementById('websiteBtn').style.backgroundColor = "#f8aeaa";
    document.getElementById('websiteBtn').style.color = "black";
    document.getElementById('socialMediaBtn').style.backgroundColor = "#f8aeaa";
    document.getElementById('socialMediaBtn').style.color = "black";

    document.getElementById('btnSend').style.display = "block"; 
});

document.getElementById('websiteBtn').addEventListener('click', function(event) {
    event.preventDefault(); // disallow form action
    document.getElementById('websiteDiv').style.display = "block"; // Show the selected div
    document.getElementById('brandDiv').style.display = "none"; 
    document.getElementById('socialMediaDiv').style.display = "none"; 
    document.getElementById('websiteBtn').style.backgroundColor = "#c53f3f";
    document.getElementById('websiteBtn').style.color = "white";

    document.getElementById('brandBtn').style.backgroundColor = "#f8aeaa";
    document.getElementById('brandBtn').style.color = "black";
    document.getElementById('socialMediaBtn').style.backgroundColor = "#f8aeaa";
    document.getElementById('socialMediaBtn').style.color = "black";

    document.getElementById('btnSend').style.display = "block"; 
});

document.getElementById('socialMediaBtn').addEventListener('click', function(event) {
    event.preventDefault(); // disallow form action
    document.getElementById('websiteDiv').style.display = "none"; 
    document.getElementById('brandDiv').style.display = "none"; 
    document.getElementById('socialMediaDiv').style.display = "block";
    document.getElementById('socialMediaBtn').style.backgroundColor = "#c53f3f";
    document.getElementById('socialMediaBtn').style.color = "white";

    document.getElementById('brandBtn').style.backgroundColor = "#f8aeaa";
    document.getElementById('brandBtn').style.color = "black";
    document.getElementById('websiteBtn').style.backgroundColor = "#f8aeaa";
    document.getElementById('websiteBtn').style.color = "black";

    document.getElementById('btnSend').style.display = "block"; 
});

document.getElementById('wq1-link').addEventListener('click', function(event) {
    event.preventDefault(); // disallow form action
    document.getElementById('wq1-link').style.display = "none"; // Show the selected div
    document.getElementById('websiteDiv').style.display = "none"; // Show the selected div
    document.getElementById('brandDiv').style.display = "block"; 

    document.getElementById('brandBtn').style.backgroundColor = "#c53f3f"; // active
    document.getElementById('brandBtn').style.color = "white"; // active
    document.getElementById('websiteBtn').style.backgroundColor = "#f8aeaa";
    document.getElementById('websiteBtn').style.color = "black";
    document.getElementById('socialMediaBtn').style.backgroundColor = "#f8aeaa";
    document.getElementById('socialMediaBtn').style.color = "black";

    // Scroll to the top of the page
    window.scrollTo({
        top: 0,
        behavior: "smooth" // Smooth scrolling
    });
});

document.getElementById('wq2-link').addEventListener('click', function(event) {
    event.preventDefault(); // disallow form action
    document.getElementById('wq2-link').style.display = "none"; // Show the selected div
    document.getElementById('websiteDiv').style.display = "none"; // Show the selected div
    document.getElementById('socialMediaDiv').style.display = "block"; 

    document.getElementById('socialMediaBtn').style.backgroundColor = "#c53f3f"; // active
    document.getElementById('socialMediaBtn').style.color = "white"; // active
    document.getElementById('websiteBtn').style.backgroundColor = "#f8aeaa";
    document.getElementById('websiteBtn').style.color = "black";
    document.getElementById('brandBtn').style.backgroundColor = "#f8aeaa";
    document.getElementById('brandBtn').style.color = "black";

    // Scroll to the top of the page
    window.scrollTo({
        top: 0,
        behavior: "smooth" // Smooth scrolling
    });
});

document.getElementById('bq2-link').addEventListener('click', function(event) {
    event.preventDefault(); // disallow form action
    document.getElementById('bq2-link').style.display = "none"; // Show the selected div
    document.getElementById('brandDiv').style.display = "none"; // Show the selected div
    document.getElementById('socialMediaDiv').style.display = "block"; 

    document.getElementById('socialMediaBtn').style.backgroundColor = "#c53f3f"; // active
    document.getElementById('socialMediaBtn').style.color = "white"; // active
    document.getElementById('websiteBtn').style.backgroundColor = "#f8aeaa";
    document.getElementById('websiteBtn').style.color = "black";
    document.getElementById('brandBtn').style.backgroundColor = "#f8aeaa";
    document.getElementById('brandBtn').style.color = "black";

    // Scroll to the top of the page
    window.scrollTo({
        top: 0,
        behavior: "smooth" // Smooth scrolling
    });
});


document.getElementById('bq1-link').addEventListener('click', function(event) {
    event.preventDefault(); // disallow form action
    document.getElementById('bq1-link').style.display = "none"; // Show the selected div
    document.getElementById('brandDiv').style.display = "none"; // Show the selected div
    document.getElementById('websiteDiv').style.display = "block"; 

    document.getElementById('websiteBtn').style.backgroundColor = "#c53f3f"; // active
    document.getElementById('websiteBtn').style.color = "white"; // active
    document.getElementById('socialMediaBtn').style.backgroundColor = "#f8aeaa";
    document.getElementById('socialMediaBtn').style.color = "black";
    document.getElementById('brandBtn').style.backgroundColor = "#f8aeaa";
    document.getElementById('brandBtn').style.color = "black";

    // Scroll to the top of the page
    window.scrollTo({
        top: 0,
        behavior: "smooth" // Smooth scrolling
    });
});

         // Variables for each box of questions
          let question1 = document.getElementById('wq1');
          let question1Link = document.getElementById('wq1-link');
          let question1_1 = document.getElementById('wq1_1');
          let question2 = document.getElementById('wq2');
          let question2_1 = document.getElementById('wq2_1');
          let question2_2 = document.getElementById('wq2_2');
          let question3 = document.getElementById('wq3');
          let question4 = document.getElementById('wq4');
          let question5 = document.getElementById('wq5');
          let question6 = document.getElementById('wq6');
          let question7 = document.getElementById('wq7');
          let question8 = document.getElementById('wq8');
          let question9 = document.getElementById('wq9');
          let question10 = document.getElementById('wq10');
          let question11 = document.getElementById('wq11');
          let question12 = document.getElementById('wq12');

        // if you click on question 1 website questionnaire....
        document.querySelectorAll('input[name="wq1"]').forEach(function(input) {
        input.addEventListener('change', function() {
        // if answer its yes, show others questions
        if (this.value === '1') {
            question1_1.style.display = 'block';
            question1Link.style.display = 'none';
        } else {
            question1_1.style.display = 'none';
            question1Link.style.display = 'block';

             document.querySelectorAll('input[name="wq1_1"]').forEach(function(checkbox) {
                checkbox.checked = false;
            });
        }
    });
});

           // if you click on question 2 website questionnaire ...
           let question2_3 = document.getElementById('wq13');
           document.querySelectorAll('input[name="wq2"]').forEach(function(input) {
            input.addEventListener('change', function() {
          
              if (this.value === '1') {
                question2_1.style.display = 'block';
                question2_2.style.display = 'block';
              } else {
                question2_3.style.display = 'block';
                question2_1.style.display = 'none';
                question2_2.style.display = 'none';

                document.querySelectorAll('input[name="wq2_1"]').forEach(function(checkbox) {
                    checkbox.checked = false;
                  });
                document.querySelectorAll('input[name="wq2_2"]').forEach(function(checkbox) {
                    checkbox.checked = false;
                  });

              }
            });
          });

           // if you click on question 2 website questionnaire ...
           let question20_1 = document.getElementById('wq20_1');
           document.querySelectorAll('input[name="wq20"]').forEach(function(input) {
            input.addEventListener('change', function() {
          
              if (this.value === '1') {
                question20_1.style.display = 'block';
              } else {
                question20_1.style.display = 'none';

                document.querySelectorAll('input[name="wq20_1"]').forEach(function(checkbox) {
                    checkbox.checked = false;
                  });

              }
            });
          });

          let questionEcommerce = document.getElementById('ecommerce');
           // if you click on question 21 website questionnaire...
           document.querySelectorAll('input[name="wq21"]').forEach(function(input) {
            input.addEventListener('change', function() {
          
              if (this.value === '1') {
                questionEcommerce.style.display = 'block';
              } else {
                questionEcommerce.style.display = 'none';

              }
            });
          });

           // if you click on question 2 general information tab ...
           let question_gi_tab_2 = document.getElementById('cq2');
           let question_gi_tab_2_1 = document.getElementById('cq2_1');
           let question_gi_tab_2_1f = document.getElementById('cq2_1f');
           document.querySelectorAll('input[name="cq2"]').forEach(function(input) {
            input.addEventListener('change', function() {
          
              if (this.value === '1') {
                question_gi_tab_2_1.style.display = 'block';
              } else {
                question_gi_tab_2_1.style.display = 'none';

                question_gi_tab_2_1f.value = ''; // Clear the text in the textarea
              }
            });
          });


           // BRAND QUESTION 10 IF YES ...
           let question_bq10 = document.getElementById('bq10');
           let question_bq10_1 = document.getElementById('bq10_1');
           let question_bq10_2 = document.getElementById('bq10_2');
           let question_bq10_3 = document.getElementById('bq10_3');
           let question_bq10_4 = document.getElementById('bq10_4');
           document.querySelectorAll('input[name="bq10"]').forEach(function(input) {
            input.addEventListener('change', function() {
          
              if (this.value === '1') {
                question_bq10_1.style.display = 'block';
                question_bq10_2.style.display = 'block';
                question_bq10_3.style.display = 'block';
                question_bq10_4.style.display = 'block';
              } else {
                question_bq10_1.style.display = 'none';
                question_bq10_2.style.display = 'none';
                question_bq10_3.style.display = 'none';
                question_bq10_4.style.display = 'none';

                question_bq10.value = ''; // Clear the text in the textarea
              }
            });
          });

          let question_bq12 = document.getElementById('bq12');
           let question_bq12_1 = document.getElementById('bq12_1');
           document.querySelectorAll('input[name="bq12"]').forEach(function(input) {
            input.addEventListener('change', function() {
          
              if (this.value === '1') {
                question_bq12_1.style.display = 'block';
              } else {
                question_bq12_1.style.display = 'none';

                question_bq12_1.value = ''; // Clear the text in the textarea
              }
            });
          });

          let question_bq23 = document.getElementById('bq23');
           let question_bq23_1 = document.getElementById('bq23_1');
           let question_bq23_2 = document.getElementById('bq23_2');
           let question_bq24 = document.getElementById('bq24');
           let question_bq1Link = document.getElementById('bq1-link');
           document.querySelectorAll('input[name="bq23"]').forEach(function(input) {
            input.addEventListener('change', function() {
          
              if (this.value === '1') {
                question_bq24.style.display = 'block';
              } else {
                question_bq24.style.display = 'none';
                question_bq1Link.style.display = 'block';

                question_bq24.value = ''; // Clear the text in the textarea
              }
            });
          });

          let question_bq25 = document.getElementById('bq25');
           let question_bq25_1 = document.getElementById('bq25_1');
           let question_bq25_2 = document.getElementById('bq25_2');
           let question_bq26 = document.getElementById('bq26');
           let question_bq2Link = document.getElementById('bq2-link');
           document.querySelectorAll('input[name="bq25"]').forEach(function(input) {
            input.addEventListener('change', function() {
          
              if (this.value === '1') {
                question_bq26.style.display = 'block';
              } else {
                question_bq26.style.display = 'none';
                question_bq2Link.style.display = 'block';

                question_bq26.value = ''; // Clear the text in the textarea
              }
            });
          });


          let question_bq20 = document.getElementById('bq20');
           let question_bq20_1 = document.getElementById('wq20_1');
           document.querySelectorAll('input[name="bq20"]').forEach(function(input) {
            input.addEventListener('change', function() {
          
              if (this.value === '1') {
                question_bq20_1.style.display = 'block';
              } else {
                question_bq20_1.style.display = 'none';

                question_bq20_1.value = ''; // Clear the text in the textarea
              }
            });
          });

          let question_bq28 = document.getElementById('wq28');
           let question_wq2_link = document.getElementById('wq2-link');
           document.querySelectorAll('input[name="wq28"]').forEach(function(input) {
            input.addEventListener('change', function() {
          
              if (this.value === '2') {
                question_wq2_link.style.display = 'block';
              } else {
                question_wq2_link.style.display = 'none';

                question_wq2_link.value = ''; // Clear the text in the textarea
              }
            });
          });

          let question_sq1 = document.getElementById('sq1');
           let question_sq1_1 = document.getElementById('sq1_1');
           document.querySelectorAll('input[name="sq1"]').forEach(function(input) {
            input.addEventListener('change', function() {
          
              if (this.value === '1') {
                question_sq1_1.style.display = 'block';
              } else {
                question_sq1_1.style.display = 'none';

                question_sq1_1.value = ''; // Clear the text in the textarea
              }
            });
          });

  class AutoResizeTextarea {
    constructor(textarea) {
        this.textarea = textarea;
        this.init();
    }

    init() {
        this.textarea.addEventListener('input', () => {
            this.adjustHeight();
        });
    }

    adjustHeight() {
        this.textarea.style.height = 'auto'; // Restablecer la altura a auto para recalcular la altura según el contenido
        this.textarea.style.height = this.textarea.scrollHeight + 'px'; // Ajustar la altura del textarea según la altura del contenido
    }
  }

  // Inicializar los textarea con la clase 'auto-resize'
  document.querySelectorAll('.auto-resize').forEach(textarea => {
      new AutoResizeTextarea(textarea);
  });


});


// AJAX

    // Escuchar el evento submit del formulario
    $("#newForm").submit(function(event) {
        event.preventDefault(); // Evitar que el formulario se envíe de forma predeterminada
        let formData = $("#newForm").serialize();

        // Realizar la solicitud AJAX para obtener el número de job
        $.ajax({
            url: "https://" + window.location.hostname + "/api/form/post/?type=newClientForm",
            method: "POST",
            dataType: "json",
            beforeSend: function(xhr) {
                // Obtener el token del localStorage
                let token = localStorage.getItem('token');

                // Incluir el token en el encabezado de autorización
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            },
            data: formData,
            success: function (response) {
              if (response.status == "success") {
                $("#creaOk").show();
                $("#creaErr").hide();
                $('#idClient').val(response.clientId);

                // Limpiar los campos del formulario
                //$("#newForm")[0].reset(); // Esto limpia todos los campos del formulario

                // Limpiar los mensajes de error
                $(".invalid-feedback").text(''); // Esto limpia todos los mensajes de error

                // Eliminar el color rojo de los campos de texto
                $("input[type='text']").css("border-color", ""); // Esto elimina el color rojo del borde de todos los campos de texto
                $("select").css("border-color", "");

                    // NEW AJAX CALL TO SAVE ALL THE FORMS
                    let formData2 = $("#newForm").serialize();
                    $.ajax({
                        url: "https://" + window.location.hostname + "/api/form/post/?type=newForm",
                        method: "POST",
                        dataType: "json",
                        beforeSend: function(xhr) {
                            // Obtener el token del localStorage
                            let token = localStorage.getItem('token');

                            // Incluir el token en el encabezado de autorización
                            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                        },
                        data: formData2,
                        success: function (response) {
                          if (response.status == "success") {
                            $("#creaOk").show();
                            $("#creaErr").hide();
                            $("#creaOk-2").show();
                            $("#creaErr-2").hide();
                            //$("#btnSend").hide();

                            // Limpiar los campos del formulario
                            //$("#newForm")[0].reset(); // Esto limpia todos los campos del formulario

                            // Limpiar los mensajes de error
                            $(".invalid-feedback").text(''); // Esto limpia todos los mensajes de error

                            // Eliminar el color rojo de los campos de texto
                            $("input[type='text']").css("border-color", ""); // Esto elimina el color rojo del borde de todos los campos de texto
                            $("select").css("border-color", "");

                          } else {
                            $("#creaErr").show();
                            $("#creaOk").hide();
                            $("#creaOk-2").hide();
                            $("#creaErr-2").show();

                            if (response.errors) {
                              // Recorres el objeto de errores y muestras cada mensaje de error
                              $.each(response.errors, function(key, value) {
                                // Aquí puedes mostrar los mensajes de error en el lugar adecuado en tu página web
                                $("#" + key + "_error").html('<strong>* ' + value + '</strong>');
                                $("#" + key).css("border-color", "red");
                              });
                            } else {
                              // Si no hay errores específicos, puedes mostrar un mensaje genérico de error
                              alert("Error: " + response.message);
                            }
                          }
                        },

                    });

              // ITS SOMETHING FAILS
              } else {
                $("#creaErr").show();
                $("#creaOk").hide();

                $("#creaErr-2").show();
                $("#creaOk-2").hide();               

                if (response.errors) {
                  // Recorres el objeto de errores y muestras cada mensaje de error
                  $.each(response.errors, function(key, value) {
                    // Aquí puedes mostrar los mensajes de error en el lugar adecuado en tu página web
                    $("#" + key + "_error").html('<strong>* ' + value + '</strong>');
                    $("#" + key).css("border-color", "red");
                  });
                } else {
                  // Si no hay errores específicos, puedes mostrar un mensaje genérico de error
                  alert("Error: " + response.message);
                }
              }
            },

    });
});
</script>

</body>
</html>