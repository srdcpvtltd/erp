<!DOCTYPE html>
<?php
    // $logo=asset(Storage::url('uploads/logo/'));
  $logo=\App\Models\Utility::get_file('uploads/logo/');
  $company_logo=Utility::getValByName('company_logo_dark');
  $company_logos=Utility::getValByName('company_logo_light');
  $company_favicon=Utility::getValByName('company_favicon');
  $setting = \App\Models\Utility::settings();
  $color = (!empty($setting['color'])) ? $setting['color'] : 'theme-3';
  $company_logo = \App\Models\Utility::GetLogo();
  $SITE_RTL= isset($setting['SITE_RTL'])?$setting['SITE_RTL']:'off';
  $lang = \App::getLocale('lang');
        if($lang == 'ar' || $lang == 'he'){
               $setting['SITE_RTL']= 'on';
        }
        elseif($setting['SITE_RTL'] == 'on')
        {
            $setting['SITE_RTL']= 'on';
        }
        else {
            $setting['SITE_RTL']= 'off';
        }

  $getseo= App\Models\Utility::getSeoSetting();
  $metatitle =  isset($getseo['meta_title']) ? $getseo['meta_title'] :'';
  $metsdesc= isset($getseo['meta_desc'])?$getseo['meta_desc']:'';
  $meta_image = \App\Models\Utility::get_file('uploads/meta/');
  $meta_logo = isset($getseo['meta_image'])?$getseo['meta_image']:'';

?>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="<?php echo e(isset($setting['SITE_RTL']) && $setting['SITE_RTL'] == 'on' ? 'rtl' : ''); ?>">
<head>
    <title><?php echo e((Utility::getValByName('title_text')) ? Utility::getValByName('title_text') : config('app.name', 'ERPGO')); ?> - <?php echo $__env->yieldContent('page-title'); ?></title>

    <meta name="title" content="<?php echo e($metatitle); ?>">
    <meta name="description" content="<?php echo e($metsdesc); ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo e(env('APP_URL')); ?>">
    <meta property="og:title" content="<?php echo e($metatitle); ?>">
    <meta property="og:description" content="<?php echo e($metsdesc); ?>">
    <meta property="og:image" content="<?php echo e($meta_image.$meta_logo); ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo e(env('APP_URL')); ?>">
    <meta property="twitter:title" content="<?php echo e($metatitle); ?>">
    <meta property="twitter:description" content="<?php echo e($metsdesc); ?>">
    <meta property="twitter:image" content="<?php echo e($meta_image.$meta_logo); ?>">

    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="description" content="Dashboard Template Description"/>
    <meta name="keywords" content="Dashboard Template"/>
    <meta name="author" content="Rajodiya Infotech"/>

    <!-- Favicon icon -->
    <link rel="icon" href="<?php echo e($logo.'/'.(isset($company_favicon) && !empty($company_favicon)?$company_favicon:'favicon.png')); ?>" type="image/x-icon"/>

    <!-- font css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/tabler-icons.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/feather.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/fontawesome.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/material.css')); ?>">

    <?php if( $setting['SITE_RTL'] == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-rtl.css')); ?>" id="main-style-link">
    <?php endif; ?>
    <?php if($setting['cust_darklayout']=='on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-dark.css')); ?>">
    <?php endif; ?>
    <?php if($setting['SITE_RTL'] != 'on' && $setting['cust_darklayout']!='on' ): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>" id="main-style-link">
    <?php endif; ?>

   
    <?php if(isset($setting['SITE_RTL']) && $setting['SITE_RTL'] == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/custom-auth-rtl.css')); ?>" id="main-style-link">
    <?php else: ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/custom-auth.css')); ?>" id="main-style-link">
    <?php endif; ?>
    <?php if($setting['cust_darklayout'] == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/custom-auth-dark.css')); ?>" id="main-style-link">
    <?php endif; ?>

    
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/customizer.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('css/custom.css')); ?>">

</head>

<body class="<?php echo e($color); ?>">
    <div class="custom-login">
        <div class="login-bg-img">
            <img src="<?php echo e(asset('assets/images/auth/'.$color.'.svg')); ?>" class="login-bg-1">
            <img src="<?php echo e(asset('assets/images/auth/common.svg')); ?>" class="login-bg-2">
        </div>
        <div class="bg-login bg-primary"></div>
        <div class="custom-login-inner">
            <header class="dash-header">
                <nav class="navbar navbar-expand-md default">
                    <div class="container">
                        <div class="navbar-brand">
                           
                        <a class="navbar-brand" href="#">
                            <?php if($setting['cust_darklayout'] == 'on'): ?>
                                <img class="logo"
                                    src="<?php echo e($logo . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-light.png') . '?' . time()); ?>"
                                    alt="" loading="lazy"/>
                            <?php else: ?>
                                <img class="logo"
                                    src="<?php echo e($logo . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png') . '?' . time()); ?>"
                                    alt="" loading="lazy"/>
                            <?php endif; ?>
                        </a>


                        </div>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarlogin">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarlogin">
                            <ul class="navbar-nav align-items-center ms-auto mb-2 mb-lg-0">
                                <?php echo $__env->make('landingpage::layouts.buttons', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php echo $__env->yieldContent('language-bar'); ?>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
            <main class="custom-wrapper">
                <div class="custom-row">
                    <div class="card">
                        <?php echo $__env->yieldContent('content'); ?>
                    </div>
                </div>
            </main>
            <footer>
                <div class="auth-footer">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <span>&copy; <?php echo e(date('Y')); ?>

                                    <?php echo e(App\Models\Utility::getValByName('footer_text') ? App\Models\Utility::getValByName('footer_text') : config('app.name', 'Storego Saas')); ?>

                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

<!-- [ auth-signup ] end -->

<!-- Required Js -->
<script src="<?php echo e(asset('assets/js/vendor-all.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/feather.min.js')); ?>"></script>
<script>
    feather.replace();
</script>

<?php if(\App\Models\Utility::getValByName('cust_darklayout') == 'on'): ?>
    <style>
        .g-recaptcha {
            filter: invert(1) hue-rotate(180deg) !important;
        }
    </style>
<?php endif; ?>


<script>
    feather.replace();
    var pctoggle = document.querySelector("#pct-toggler");
    if (pctoggle) {
        pctoggle.addEventListener("click", function () {
            if (
                !document.querySelector(".pct-customizer").classList.contains("active")
            ) {
                document.querySelector(".pct-customizer").classList.add("active");
            } else {
                document.querySelector(".pct-customizer").classList.remove("active");
            }
        });
    }

    var themescolors = document.querySelectorAll(".themes-color > a");
    for (var h = 0; h < themescolors.length; h++) {
        var c = themescolors[h];

        c.addEventListener("click", function (event) {
            var targetElement = event.target;
            if (targetElement.tagName == "SPAN") {
                targetElement = targetElement.parentNode;
            }
            var temp = targetElement.getAttribute("data-value");
            removeClassByPrefix(document.querySelector("body"), "theme-");
            document.querySelector("body").classList.add(temp);
        });
    }



    function removeClassByPrefix(node, prefix) {
        for (let i = 0; i < node.classList.length; i++) {
            let value = node.classList[i];
            if (value.startsWith(prefix)) {
                node.classList.remove(value);
            }
        }
    }
</script>
<?php echo $__env->yieldPushContent('custom-scripts'); ?>
<?php if($setting['enable_cookie'] == 'on'): ?>
    <?php echo $__env->make('layouts.cookie_consent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
</body>
</html>
<?php /**PATH /home/u910011159/domains/zpsdemo.in/public_html/erp/resources/views/layouts/auth.blade.php ENDPATH**/ ?>