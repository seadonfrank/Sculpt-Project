<!-- Copyright (c) Microsoft. All rights reserved. Licensed under the MIT license. See full license in root of repo. -->
<!--
    This file shows a recommended design for the start page of the add-in; which is the first page
    the user sees after the first-run experience and usually the first page the user sees on subsquent
    executions of the add-in..
    -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <title>Sculpt Project - @yield('title')</title>

    <!-- For the Office UI Fabric, go to http://aka.ms/office-ui-fabric to learn more. -->
    <link rel="stylesheet" href="https://static2.sharepointonline.com/files/fabric/office-ui-fabric-js/1.2.0/css/fabric.min.css" />
    <link rel="stylesheet" href="https://static2.sharepointonline.com/files/fabric/office-ui-fabric-js/1.2.0/css/fabric.components.min.css" />
    <script src="https://static2.sharepointonline.com/files/fabric/office-ui-fabric-js/1.2.0/js/fabric.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.2.0.min.js" integrity="sha256-JAW99MJVpJBGcbzEuXk4Az05s/XyDdBomFqNlM3ic+I=" crossorigin="anonymous"></script>

    <link href="{{asset('css/frame.css')}}" rel="stylesheet" type="text/css" />

    @yield('css')

    @yield('js')
</head>
<body class="ms-font-l ms-tab-bar">
    <nav class="ms-tab-bar__header ms-bgColor-themeLighter">
        <div class="ms-tab-bar__header--center ms-font-m ms-fontWeight-light ms-fontColor-themePrimary">
            <div class="ms-tab-bar__header--center"></div>
            <button class="ms-tab-bar__header--centeritems ms-font-m ms-fontWeight-light ms-fontColor-themePrimary">
                <i class="ms-font-xl ms-Icon ms-Icon--home ms-fontColor-themePrimary"></i>
                <div class="ms-tab-bar__header--centeritemstext">
                    TEXT SEARCH
                </div>
            </button>
            <button class="ms-tab-bar__header--centeritems ms-font-m ms-fontWeight-light ms-fontColor-themePrimary">
                <i class="ms-font-xl ms-Icon ms-Icon--gear ms-fontColor-themePrimary"></i>
                <div class="ms-tab-bar__header--centeritemstext">
                    GEO SEARCH
                </div>
            </button>
            <button class="ms-tab-bar__header--centeritems ms-font-m ms-fontWeight-light ms-fontColor-themePrimary">
                <i class="ms-font-xl ms-Icon ms-Icon--star ms-fontColor-themePrimary"></i>
                <div class="ms-tab-bar__header--centeritemstext">
                    CONVERSATION
                </div>
            </button>
            <div class="ms-tab-bar__header--center"></div>
        </div>
    </nav>

    @yield('content')
</body>
</html>
