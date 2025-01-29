<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ in_array(app()->getLocale(), ['fa', 'aii', 'ar', 'he']) ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css"
        integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous">
    <!-- Scripts -->
    @if (in_array(app()->getLocale(), ['fa', 'aii', 'ar', 'he']))
        @vite(['resources/css/app-rtl.css', 'resources/js/app.js'])
    @else
        @vite(['resources/css/app-ltr.css', 'resources/js/app.js'])
    @endif

    <style>
        body,
        html {
            height: 100%;
            margin: 0;
        }

        .svg-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50vh;

        }

        .svg-responsive {
            width: 50%;
            height: auto;
        }

        .svg-caption {
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>

<body class="">
    <div class="navbar navbar-dark shadow-sm">
        <div class="container">
            <a href="#" class="navbar-brand d-flex align-items-center">
                <img src="{{ asset('storage') }}/images/logo.svg" width="300"/>
            </a>
            <ul class="nav col-md-4 justify-content-end">
                @if (Route::has('login'))
                    @auth
                        <li class="nav-item"><a href="{{ url('/dashboard') }}"
                                class="nav-link px-2 text-body-secondary">{{ __('auth.Dashboard') }}</a></li>
                    @else
                        <li class="nav-item"><a href="{{ route('login') }}"
                                class="nav-link px-2 text-body-secondary">{{ __('auth.login.Sign In') }}</a></li>
                        @if (Route::has('register'))
                            <li class="nav-item"><a href="{{ route('register') }}"
                                    class="nav-link px-2 text-body-secondary">{{ __('auth.Register') }}</a></li>
                        @endif
                    @endauth
                @endif
                {{-- <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Plans</a></li> --}}
            </ul>
        </div>
    </div>

    <div class="container d-flex justify-content-center pt-5 mt-5">
        <div class="svg-container">
            <svg
   width="136mm"
   height="129mm"
   viewBox="0 0 136 129"
   version="1.1"
   id="svg1"
   inkscape:version="1.3.1 (9b9bdc1480, 2023-11-25, custom)"
   sodipodi:docname="welcome-background"
   xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
   xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
   xmlns="http://www.w3.org/2000/svg"
   xmlns:svg="http://www.w3.org/2000/svg">
  <sodipodi:namedview
     id="namedview1"
     pagecolor="#ffffff"
     bordercolor="#000000"
     borderopacity="0.25"
     inkscape:showpageshadow="2"
     inkscape:pageopacity="0.0"
     inkscape:pagecheckerboard="0"
     inkscape:deskcolor="#d1d1d1"
     inkscape:document-units="mm"
     inkscape:zoom="1.0179639"
     inkscape:cx="186.64708"
     inkscape:cy="152.26473"
     inkscape:window-width="1920"
     inkscape:window-height="1011"
     inkscape:window-x="0"
     inkscape:window-y="0"
     inkscape:window-maximized="1"
     inkscape:current-layer="layer1" />
  <defs
     id="defs1">
    <clipPath
       clipPathUnits="userSpaceOnUse"
       id="clipPath3">
      <path
         d="M 203.498,198.501 H 588.502 V 481.5 H 203.498 Z"
         transform="translate(-351.99761,-271.2871)"
         id="path3" />
    </clipPath>
    <clipPath
       clipPathUnits="userSpaceOnUse"
       id="clipPath5">
      <path
         d="M 203.498,198.501 H 588.502 V 481.5 H 203.498 Z"
         transform="translate(-410.66021,-291.2305)"
         id="path5" />
    </clipPath>
    <clipPath
       clipPathUnits="userSpaceOnUse"
       id="clipPath7">
      <path
         d="M 203.498,198.501 H 588.502 V 481.5 H 203.498 Z"
         transform="translate(-400.46881,-300.18261)"
         id="path7" />
    </clipPath>
    <clipPath
       clipPathUnits="userSpaceOnUse"
       id="clipPath9">
      <path
         d="M 203.498,198.501 H 588.502 V 481.5 H 203.498 Z"
         transform="translate(-413.06841,-329.42091)"
         id="path9" />
    </clipPath>
    <clipPath
       clipPathUnits="userSpaceOnUse"
       id="clipPath11">
      <path
         d="M 203.498,198.501 H 588.502 V 481.5 H 203.498 Z"
         transform="translate(-431.63091,-351.24661)"
         id="path11" />
    </clipPath>
    <clipPath
       clipPathUnits="userSpaceOnUse"
       id="clipPath13">
      <path
         d="M 203.498,198.501 H 588.502 V 481.5 H 203.498 Z"
         transform="translate(-473.85161,-270.02341)"
         id="path13" />
    </clipPath>
    <clipPath
       clipPathUnits="userSpaceOnUse"
       id="clipPath15">
      <path
         d="M 203.498,198.501 H 588.502 V 481.5 H 203.498 Z"
         transform="translate(-473.53711,-342.07711)"
         id="path15" />
    </clipPath>
    <clipPath
       clipPathUnits="userSpaceOnUse"
       id="clipPath17">
      <path
         d="M 203.498,198.501 H 588.502 V 481.5 H 203.498 Z"
         transform="translate(-350.08891,-335.71481)"
         id="path17" />
    </clipPath>
    <clipPath
       clipPathUnits="userSpaceOnUse"
       id="clipPath19">
      <path
         d="M 203.498,198.501 H 588.502 V 481.5 H 203.498 Z"
         transform="translate(-212.8252,-258.8926)"
         id="path19" />
    </clipPath>
    <clipPath
       clipPathUnits="userSpaceOnUse"
       id="clipPath21">
      <path
         d="M 203.498,198.501 H 588.502 V 481.5 H 203.498 Z"
         transform="translate(-212.8252,-331.89791)"
         id="path21" />
    </clipPath>
    <clipPath
       clipPathUnits="userSpaceOnUse"
       id="clipPath23">
      <path
         d="M 203.498,198.501 H 588.502 V 481.5 H 203.498 Z"
         transform="translate(-512.53522,-455.90331)"
         id="path23" />
    </clipPath>
    <clipPath
       clipPathUnits="userSpaceOnUse"
       id="clipPath25">
      <path
         d="M 203.498,198.501 H 588.502 V 481.5 H 203.498 Z"
         transform="translate(-329.88961,-206.11621)"
         id="path25" />
    </clipPath>
    <clipPath
       clipPathUnits="userSpaceOnUse"
       id="clipPath27">
      <path
         d="M 203.498,198.501 H 588.502 V 481.5 H 203.498 Z"
         transform="translate(-329.57321,-387.33981)"
         id="path27" />
    </clipPath>
    <clipPath
       clipPathUnits="userSpaceOnUse"
       id="clipPath29">
      <path
         d="M 203.498,198.501 H 588.502 V 481.5 H 203.498 Z"
         transform="translate(-335.21781,-252.01461)"
         id="path29" />
    </clipPath>
    <clipPath
       clipPathUnits="userSpaceOnUse"
       id="clipPath31">
      <path
         d="M 0,612 H 792 V 0 H 0 Z"
         transform="translate(-209.15431,-483.51561)"
         id="path31" />
    </clipPath>
    <clipPath
       clipPathUnits="userSpaceOnUse"
       id="clipPath33">
      <path
         d="M 0,612 H 792 V 0 H 0 Z"
         transform="translate(-337.16211,-515.95702)"
         id="path33" />
    </clipPath>
    <clipPath
       clipPathUnits="userSpaceOnUse"
       id="clipPath35">
      <path
         d="M 0,612 H 792 V 0 H 0 Z"
         transform="translate(-437.00591,-483.14451)"
         id="path35" />
    </clipPath>
    <clipPath
       clipPathUnits="userSpaceOnUse"
       id="clipPath37">
      <path
         d="M 0,612 H 792 V 0 H 0 Z"
         transform="translate(-562.37701,-485.87891)"
         id="path37" />
    </clipPath>
    <clipPath
       clipPathUnits="userSpaceOnUse"
       id="clipPath39">
      <path
         d="M 0,612 H 792 V 0 H 0 Z"
         transform="translate(-217.47511,-204.4453)"
         id="path39" />
    </clipPath>
    <clipPath
       clipPathUnits="userSpaceOnUse"
       id="clipPath41">
      <path
         d="M 0,612 H 792 V 0 H 0 Z"
         transform="translate(-329.58401,-196.3008)"
         id="path41" />
    </clipPath>
    <clipPath
       clipPathUnits="userSpaceOnUse"
       id="clipPath43">
      <path
         d="M 0,612 H 792 V 0 H 0 Z"
         transform="translate(-456.33981,-183.0781)"
         id="path43" />
    </clipPath>
    <clipPath
       clipPathUnits="userSpaceOnUse"
       id="clipPath45">
      <path
         d="M 0,612 H 792 V 0 H 0 Z"
         transform="translate(-561.16312,-187.41411)"
         id="path45" />
    </clipPath>
  </defs>
  <g
     inkscape:label="Layer 1"
     inkscape:groupmode="layer"
     id="layer1">
    <path
       id="path2"
       d="M 0,0 C 23.109,29.656 23.109,49.735 0,80.307 27.8,51.577 20.764,44.711 57.042,39.694 21.233,34.673 27.943,27.81 0,0"
       style="fill:#b11f28;fill-opacity:1;fill-rule:evenodd;stroke:none"
       transform="matrix(0.35277768,0,0,-0.35277776,52.387357,87.340686)"
       clip-path="url(#clipPath3)" />
    <path
       id="path4"
       d="M 0,0 C 38.45,-3.608 50.366,9.618 47.66,52.905 55.692,6.131 41.454,12.891 71.215,-26.755 35.926,5.807 41.714,-9.67 0,0"
       style="fill:#b11f28;fill-opacity:1;fill-rule:evenodd;stroke:none"
       transform="matrix(0.35277768,0,0,-0.35277776,73.082212,80.305096)"
       clip-path="url(#clipPath5)" />
    <path
       id="path6"
       d="M 0,0 C 19.691,4.925 23.224,13.699 14.129,35.11 26.486,12.871 18.226,13.791 40.059,-1.036 16.754,9.239 22.397,2.425 0,0"
       style="fill:#b11f28;fill-opacity:1;fill-rule:evenodd;stroke:none"
       transform="matrix(0.35277768,0,0,-0.35277776,69.486917,77.146996)"
       clip-path="url(#clipPath7)" />
    <path
       id="path8"
       d="M 0,0 C 19.631,0.708 24.791,8.044 20.661,29.346 27.705,6.662 20.091,9.093 37.638,-8.645 17.755,5.217 21.665,-2.087 0,0"
       style="fill:#b11f28;fill-opacity:1;fill-rule:evenodd;stroke:none"
       transform="matrix(0.35277768,0,0,-0.35277776,73.931783,66.832373)"
       clip-path="url(#clipPath9)" />
    <path
       id="path10"
       d="M 0,0 C 19.809,0.166 25.119,7.9 21.257,30.924 28.039,6.322 20.394,9.166 37.838,-10.433 17.981,5.068 21.821,-2.901 0,0"
       style="fill:#b11f28;fill-opacity:1;fill-rule:evenodd;stroke:none"
       transform="matrix(0.35277768,0,0,-0.35277776,80.480216,59.132752)"
       clip-path="url(#clipPath11)" />
    <path
       id="path12"
       d="m 0,0 c 21.654,26.132 21.654,43.828 0,70.766 17.387,-20.541 25.117,-33.81 49.868,-33.81 10.375,0 30.592,0.069 40.212,-2.21 -9.618,-2.29 -29.837,-2.21 -40.212,-2.21 C 25.117,32.536 17.076,19.911 0,0"
       style="fill:#b11f28;fill-opacity:1;fill-rule:evenodd;stroke:none"
       transform="matrix(0.35277768,0,0,-0.35277776,95.374739,87.786496)"
       clip-path="url(#clipPath13)" />
    <path
       id="path14"
       d="M 0,0 C 22.035,24.84 22.035,41.658 0,67.266 17.691,47.74 25.562,35.128 50.747,35.128 c 10.556,0 31.135,0.065 40.92,-2.101 C 81.883,30.85 61.303,30.926 50.747,30.926 25.562,30.926 17.377,18.926 0,0"
       style="fill:#b11f28;fill-opacity:1;fill-rule:evenodd;stroke:none"
       transform="matrix(0.35277768,0,0,-0.35277776,95.263793,62.367548)"
       clip-path="url(#clipPath15)" />
    <path
       id="path16"
       d="M 0,0 C 19.608,29.775 19.608,49.931 0,80.625 15.744,57.22 22.742,42.104 45.149,42.104 c 9.396,0 46.98,0.079 55.688,-2.517 C 92.131,36.975 54.545,37.067 45.149,37.067 22.742,37.067 15.461,22.686 0,0"
       style="fill:#b11f28;fill-opacity:1;fill-rule:evenodd;stroke:none"
       transform="matrix(0.35277768,0,0,-0.35277776,51.714016,64.612026)"
       clip-path="url(#clipPath17)" />
    <path
       id="path18"
       d="m 0,0 c 17.566,32.824 17.566,55.058 0,88.894 14.103,-25.8 20.375,-42.471 40.45,-42.471 8.418,0 24.821,0.086 32.623,-2.777 C 65.271,40.771 48.868,40.868 40.45,40.868 20.375,40.868 13.853,25.008 0,0"
       style="fill:#b11f28;fill-opacity:1;fill-rule:evenodd;stroke:none"
       transform="matrix(0.35277768,0,0,-0.35277776,3.2904301,91.713196)"
       clip-path="url(#clipPath19)" />
    <path
       id="path20"
       d="M 0,0 C 17.566,32.829 17.566,55.055 0,88.895 14.103,63.09 20.375,46.423 40.45,46.423 c 8.418,0 24.821,0.086 32.623,-2.776 C 65.271,40.771 48.868,40.868 40.45,40.868 20.375,40.868 13.853,25.012 0,0"
       style="fill:#b11f28;fill-opacity:1;fill-rule:evenodd;stroke:none"
       transform="matrix(0.35277768,0,0,-0.35277776,3.2904301,65.958544)"
       clip-path="url(#clipPath21)" />
    <path
       id="path22"
       d="M 0,0 C 27.164,-26.424 45.547,-26.424 73.55,0 52.197,-21.216 38.408,-30.651 38.408,-60.854 c 0,-12.662 0.318,-149.37 -2.052,-161.106 -2.384,11.734 -2.543,148.444 -2.543,161.106 C 33.813,-30.651 20.697,-20.837 0,0"
       style="fill:#b11f28;fill-opacity:1;fill-rule:evenodd;stroke:none"
       transform="matrix(0.35277768,0,0,-0.35277776,109.02139,22.212193)"
       clip-path="url(#clipPath23)" />
    <path
       id="path24"
       d="M 0,0 C 18.908,36.822 18.908,61.749 0,99.705 15.181,70.764 21.93,52.068 43.536,52.068 c 9.061,0 183.062,0.429 191.46,-2.786 C 226.6,46.053 52.597,45.84 43.536,45.84 21.93,45.84 14.91,28.052 0,0"
       style="fill:#b11f28;fill-opacity:1;fill-rule:evenodd;stroke:none"
       transform="matrix(0.35277768,0,0,-0.35277776,44.588145,110.33154)"
       clip-path="url(#clipPath25)" />
    <path
       id="path26"
       d="M 0,0 C 19.594,34.354 19.594,57.612 0,93.03 15.732,66.023 22.726,48.585 45.116,48.585 c 9.389,0 178.95,0.397 187.653,-2.601 C 224.07,42.969 54.505,42.769 45.116,42.769 22.726,42.769 15.449,26.176 0,0"
       style="fill:#b11f28;fill-opacity:1;fill-rule:evenodd;stroke:none"
       transform="matrix(0.35277768,0,0,-0.35277776,44.476541,46.399872)"
       clip-path="url(#clipPath27)" />
    <path
       id="path28"
       d="M 0,0 -69.298,87.345 0,174.907 C -31.739,87.345 -31.739,87.345 0,0"
       style="fill:#b11f28;fill-opacity:1;fill-rule:evenodd;stroke:none"
       transform="matrix(0.35277768,0,0,-0.35277776,46.467812,94.139596)"
       clip-path="url(#clipPath29)" />
    <path
       id="path30"
       d="m 0,0 -0.078,17.598 c -0.17,1.276 -0.73,2.115 -1.68,2.519 l 0.078,0.156 h 9.082 c 2.396,0 4.317,-0.553 5.762,-1.66 1.614,-1.224 2.383,-3.001 2.305,-5.332 C 15.417,11.784 14.733,10.442 13.418,9.258 12.324,8.255 10.97,7.513 9.355,7.031 l 5.977,-7.519 c 0.521,-0.652 1.224,-1.381 2.109,-2.188 0.313,-0.286 1.061,-0.859 2.247,-1.719 0.325,-0.247 0.833,-0.625 1.523,-1.132 h -3.965 c -1.628,0 -3.066,0.774 -4.316,2.324 L 8.398,2.441 4.844,7.871 c 2.591,0.403 4.511,1.38 5.761,2.93 0.665,0.833 0.997,1.816 0.997,2.949 0,1.367 -0.541,2.415 -1.622,3.145 -0.924,0.625 -2.103,0.937 -3.535,0.937 -0.833,0 -1.667,-0.104 -2.5,-0.312 L 4.043,-2.891 c 0,-1.107 0.534,-1.96 1.602,-2.558 L -1.68,-5.527 v 0.156 c 0.847,0.364 1.374,1.145 1.582,2.344 C -0.02,-2.598 0.013,-1.589 0,0"
       style="fill:#231f20;fill-opacity:1;fill-rule:nonzero;stroke:none"
       transform="matrix(0.35277768,0,0,-0.35277776,1.9954179,12.471188)"
       clip-path="url(#clipPath31)" />
    <path
       id="path32"
       d="m 0,0 -10.547,-3.203 8.379,6.113 z m -10.803,-25.332 h 7.632 l -3.762,9.889 z m -5.584,-7.031 6.621,16.914 c 0.182,0.456 0.319,1.015 0.411,1.679 0,0.782 -0.385,1.29 -1.153,1.524 l 6.133,0.078 8.573,-21.348 c 0.899,-2.239 2.019,-3.672 3.361,-4.297 v -0.156 h -7.95 v 0.156 c 0.899,0.378 1.348,0.809 1.348,1.291 0,0.26 -0.154,0.808 -0.462,1.642 l -2.511,6.618 h -9.782 l -2.284,-6.347 c -0.052,-0.144 -0.169,-0.652 -0.352,-1.524 0.079,-0.82 0.547,-1.38 1.407,-1.68 l -0.02,-0.156 h -7.07 v 0.156 c 1.002,0.56 1.777,1.309 2.324,2.247 0.117,0.208 0.371,0.768 0.762,1.679 z"
       style="fill:#231f20;fill-opacity:1;fill-rule:nonzero;stroke:none"
       transform="matrix(0.35277768,0,0,-0.35277776,47.153721,1.0265833)"
       clip-path="url(#clipPath33)" />
    <path
       id="path34"
       d="m 0,0 2.44,18.457 c 0,0.95 -0.455,1.653 -1.366,2.109 l 6.798,0.079 c 0.117,-0.704 0.267,-1.263 0.449,-1.68 l 7.367,-17.382 6.605,16.988 c 0.248,0.639 0.403,1.33 0.469,2.074 h 6.711 C 28.679,20.28 28.281,19.518 28.281,18.359 l 0.078,-0.781 2.754,-20.488 c 0.208,-0.86 0.794,-1.582 1.758,-2.168 l -0.078,-0.078 h -7.48 V -5 c 1.067,0.338 1.575,1.126 1.523,2.364 l -0.037,0.918 -0.036,0.683 -2.072,17.901 -8.696,-22.51 c -0.456,0.338 -0.801,0.638 -1.034,0.898 -0.326,0.287 -0.593,0.579 -0.801,0.879 -0.234,0.247 -0.463,0.579 -0.683,0.996 -0.13,0.234 -0.359,0.703 -0.684,1.406 L 5.123,16.841 2.792,-1.68 c 0,-0.208 -0.026,-0.417 -0.077,-0.625 0,-0.807 0.149,-1.393 0.449,-1.758 C 3.347,-4.414 3.679,-4.727 4.16,-5 V -5.156 H -2.129 V -5 c 1.081,0.781 1.79,2.448 2.129,5"
       style="fill:#231f20;fill-opacity:1;fill-rule:nonzero;stroke:none"
       transform="matrix(0.35277768,0,0,-0.35277776,82.376391,12.602103)"
       clip-path="url(#clipPath35)" />
    <path
       id="path36"
       d="m 0,0 v 13.145 c 0,1.015 -0.039,1.803 -0.117,2.363 -0.13,0.559 -0.3,1.002 -0.508,1.328 -0.247,0.312 -0.625,0.644 -1.133,0.996 L 5.723,17.91 C 4.89,17.441 4.362,16.745 4.141,15.82 4.023,15.352 3.965,14.434 3.965,13.066 V 1.602 c 0,-2.11 0.43,-3.796 1.289,-5.059 1.016,-1.459 2.532,-2.188 4.551,-2.188 2.604,0 4.563,0.84 5.879,2.52 0.612,0.781 0.918,1.712 0.918,2.793 v 13.809 c 0,2.5 -0.56,3.951 -1.68,4.355 l 7.402,0.078 C 21.152,17.454 20.566,16.081 20.566,13.789 V -3.77 c 0,-2.239 0.586,-3.561 1.758,-3.964 v -0.157 h -5.722 v 2.559 c -1.732,-2.136 -4.434,-3.203 -8.106,-3.203 -1.497,0 -2.981,0.39 -4.453,1.172 C 1.348,-5.931 0,-3.477 0,0"
       style="fill:#231f20;fill-opacity:1;fill-rule:nonzero;stroke:none"
       transform="matrix(0.35277768,0,0,-0.35277776,126.60464,11.63747)"
       clip-path="url(#clipPath37)" />
    <path
       id="path38"
       d="M 0,0 C 0,1.328 -0.052,2.239 -0.156,2.734 -0.391,3.763 -0.912,4.44 -1.719,4.766 L 5.684,4.844 C 4.996,4.519 4.537,4.023 4.308,3.359 4.014,2.513 3.887,1.687 3.926,0.879 V 0 -17.793 l 3.164,-0.195 2.48,-0.117 c 2.175,-0.105 4.375,0.696 6.602,2.402 l 0.078,-0.098 -2.012,-5.156 H -1.719 v 0.156 C -0.573,-20.397 0,-19.089 0,-16.875 Z"
       style="fill:#231f20;fill-opacity:1;fill-rule:nonzero;stroke:none"
       transform="matrix(0.35277768,0,0,-0.35277776,4.9308112,110.92099)"
       clip-path="url(#clipPath39)" />
    <path
       id="path40"
       d="m 0,0 c 0,-1.875 0.488,-3.652 1.465,-5.332 0.924,-1.602 2.19,-2.874 3.799,-3.818 1.608,-0.945 3.33,-1.416 5.166,-1.416 1.354,0 2.74,0.364 4.16,1.093 2.226,1.146 3.723,3.021 4.492,5.625 0.43,1.446 0.612,2.657 0.547,3.633 l -0.078,1.289 c -0.092,1.511 -0.613,3.125 -1.563,4.844 -1.823,3.294 -4.609,4.941 -8.359,4.941 -1.745,0 -3.412,-0.462 -5,-1.386 C 1.543,7.676 0,4.519 0,0 m -4.453,-0.176 c 0,2.943 0.827,5.613 2.48,8.008 0.977,1.406 2.259,2.617 3.848,3.633 0.677,0.43 1.465,0.82 2.363,1.172 1.836,0.716 3.633,1.074 5.391,1.074 1.888,0 3.717,-0.306 5.488,-0.918 0.989,-0.339 1.817,-0.696 2.481,-1.074 0.455,-0.261 1.132,-0.781 2.031,-1.563 1.367,-1.198 2.409,-2.571 3.125,-4.121 0.846,-1.836 1.269,-3.626 1.269,-5.371 0,-2.448 -0.573,-4.733 -1.718,-6.855 -1.159,-2.162 -2.767,-3.874 -4.825,-5.137 -2.292,-1.419 -4.694,-2.129 -7.207,-2.129 -2.669,0 -5.117,0.573 -7.343,1.719 -2.344,1.198 -4.187,2.897 -5.528,5.097 -1.263,2.071 -1.894,4.173 -1.894,6.309 z"
       style="fill:#231f20;fill-opacity:1;fill-rule:nonzero;stroke:none"
       transform="matrix(0.35277768,0,0,-0.35277776,44.480342,113.79419)"
       clip-path="url(#clipPath41)" />
    <path
       id="path42"
       d="M 0,0 C -1.042,0.651 -1.804,1.296 -2.285,1.934 -2.754,2.52 -3.203,3.411 -3.633,4.609 l -6.37,17.48 c -0.091,0.273 -0.258,0.743 -0.503,1.408 -0.117,0.234 -0.294,0.578 -0.53,1.034 -0.338,0.533 -0.819,1.041 -1.444,1.524 v 0.156 h 5.722 L -6.836,25.703 C -6.719,24.87 -6.49,23.984 -6.15,23.048 L 0.368,5 6.373,20.936 c 0.451,1.21 0.678,2.181 0.678,2.911 0,1.172 -0.456,1.908 -1.367,2.208 v 0.156 h 5.761 L 1.211,-0.762 Z"
       style="fill:#231f20;fill-opacity:1;fill-rule:nonzero;stroke:none"
       transform="matrix(0.35277768,0,0,-0.35277776,89.196958,118.45887)"
       clip-path="url(#clipPath43)" />
    <path
       id="path44"
       d="m 0,0 v 17.207 c 0,1.25 -0.059,2.129 -0.176,2.637 -0.221,0.976 -0.735,1.628 -1.543,1.953 l 12.442,0.078 c 0.299,0 0.501,-0.026 0.605,-0.078 0.664,0.13 1.062,0.234 1.192,0.312 l 0.078,-4.55 c -0.872,0.781 -1.921,1.243 -3.145,1.386 -0.442,0.052 -1.015,0.078 -1.719,0.078 H 6.016 L 5,18.945 4.414,18.887 3.926,18.809 v -7.325 h 3.672 c 0.456,0 0.768,-0.026 0.937,-0.078 0.847,0.105 1.419,0.222 1.719,0.352 L 10.371,7.559 C 9.812,8.327 8.691,8.711 7.012,8.711 H 3.926 v -9.316 l 6.113,-0.547 c 2.175,0 4.192,0.794 6.055,2.382 l -1.68,-5.156 H -1.719 V -3.77 C -0.573,-3.366 0,-2.109 0,0"
       style="fill:#231f20;fill-opacity:1;fill-rule:nonzero;stroke:none"
       transform="matrix(0.35277768,0,0,-0.35277776,126.17626,116.92922)"
       clip-path="url(#clipPath45)" />
  </g>
</svg>
        </div>

    </div>
    <div class="svg-caption" style="direction:ltr">
        <div class="text-center">
            <h4 class="text-black-50 mx-auto mt-5 mb-5">Find a life partner that respects and loves you
                unconditionally.
                <br>Seek a soulmate with the same cultural background, who is willing <br>
                to preserve what you value today, tomorrow, and for the next generation to come.
            </h4>
            <div class="container p-4 px-lg-5">Copyright © Dooshalah {{\Carbon\carbon::now()->year + 1}}</div>
        </div>

    </div>

</body>

</html>
