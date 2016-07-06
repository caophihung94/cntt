<head>
    <base href="<?php echo base_url(); ?>">
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo !empty($meta_description) ? htmlentities(stripslashes($meta_description)) : ''; ?>">
    <meta name="keyword" content="<?php echo !empty($meta_keyword) ? htmlentities(stripslashes($meta_keyword)) : ''; ?>">
    <meta name="author" content="<?php echo !empty($meta_author) ? htmlentities(stripslashes($meta_author)) : ''; ?>">
    <meta name="google-site-verification" content="" />

    <title><?php echo !empty($meta_title) ? htmlentities(stripslashes($meta_title)): $setting['title_website']; ?></title>
    <!--[if lt IE 9]>
      <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->


    <!-- Fav Icon -->
    <link rel="icon" href="template/frontend/images/thanh-do-icon.png" />

    <!-- Bootstrap Core CSS -->
    <link href="template/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!-- Fonts -->
    <link href="template/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Custom CSS -->
    <link href="template/frontend/css/my-style.css" rel="stylesheet" type="text/css">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="template/js/jquery.min.js"></script>

</head>   