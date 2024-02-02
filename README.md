# Cloudinary Lab: Clip Competition Demo

![Visitor](https://visitor-badge.laobi.icu/badge?page_id=arthurtham.brownie-cloudinary-lab-clip-competition)

Programming languages: 
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white&style=flat)
![JavaScript](https://img.shields.io/badge/javascript-%23323330.svg?style=for-the-badge&logo=javascript&logoColor=%23F7DF1E&style=flat)

Tested in: 
![Visual Studio Code](https://img.shields.io/badge/Visual%20Studio%20Code-0078d7.svg?style=for-the-badge&logo=visual-studio-code&logoColor=white&style=flat)
![Docker](https://img.shields.io/badge/docker-%230db7ed.svg?style=for-the-badge&logo=docker&logoColor=white&style=flat)

Add-ons:
- VSCode PHP Server: [https://marketplace.visualstudio.com/items?itemName=brapifra.phpserver](https://marketplace.visualstudio.com/items?itemName=brapifra.phpserver)
- Cloudinary API: [https://cloudinary.com](https://cloudinary.com)

![Example](/assets/readme_example.png)

## About
This repository is a simplified, modified version of the Cloudinary web application
that I made on my content-creator website. 

My website uses PHP, so I wanted to make
sure that I can use the Cloudinary PHP library on my web server, as opposed to other
popular frameworks like those involving JavaScript.

This involves the following steps:
- Creating a website with the Cloudinary Upload Widget where the user can upload a video.
- Hosting a backend server that can sign the signature for the upload. 
- Setting up an upload preset to generate a customized clip upon upload.
- Allowing the resulting Cloudinary-generated video to be downloaded by the user.

---

# Installation and Deployment
- Download this repository to a web server.
- Install PHP on the web server.
- Install the Cloudinary PHP Library using PHP Composer.
- Rename `cloudinary.env.php.sample.php` to `cloudinary.env.php` and fill in the Cloudinary
parameters as required, including your cloud name, API Key/Secret, and upload preset.
- Serve the project.

# Expected Behavior
- You will be presented with a screen with the upload widget.
- You will be able to upload a video through the widget based on your upload preset.
- You will be able to download the resulting video by clicking a download button.

---

# Further Thoughts on This Example Project
- You will realize that the Upload Widget bypasses your own web server for video uploads, saving your bandwidth.
Cloudinary does the heavy lifting for you.
- Of course, this entire project doesn't need PHP. This example shows how easy it is to configure
a Cloudinary web app using PHP to fill in recurring variables like the Cloud Name, etc.
- If you don't need to sign your upload, you can get rid of `cloudinarysign.php`. Then,
everything related to PHP can be removed/repurposed from `index.php` and renamed to `index.html`. Once again,
the purpose of this demo is to demonstrate a situation where one might decide to use PHP
to generate this page with custom variables, instead of hardcoding everything in pure HTML/JS.

# Further Cloudinary Readings
- [Cloudinary Upload Widget](https://cloudinary.com/documentation/upload_widget)
- [Cloudinary PHP SDK](https://cloudinary.com/documentation/php_integration)
- [Upload Presets](https://cloudinary.com/documentation/upload_presets)
- [Incoming Transformations](https://cloudinary.com/documentation/transformations_on_upload#incoming_transformations)

---

# Credits
Code by Arthur T.

[https://www.arttham.com](https://www.arttham.com)

<a href="mailto:arttham@arttham.com">![arttham@arttham.com](https://img.shields.io/badge/Gmail-D14836?style=for-the-badge&logo=gmail&logoColor=white)</a>
<a href="https://linkedin.com/in/arttham">![LinkedIn](https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white)</a>


