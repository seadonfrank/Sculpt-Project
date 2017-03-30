@extends('layouts.frame')

@section('title', 'Text')

@section('css')
@endsection

@section('content')
    <div class="ms-bgColor-themePrimary">
        <div class="ms-tab-bar__header--left">
            <div style="width: 50%" class="ms-SearchBox">
                <input onkeydown="if (event.keyCode == 13 || event.which == 13) {search(this.value);} else{$('#results').html(''); $('#placeholders').show(); $('#message').show(); $('#spinner').hide();}" style="width:100%" class="ms-SearchBox-field" type="text" value="">
                <label class="ms-SearchBox-label">
                    <i class="ms-SearchBox-icon ms-Icon ms-Icon--Search"></i>
                    <span id="search" class="ms-SearchBox-text">Search Anything...</span>
                </label>
                <div class="ms-CommandButton ms-SearchBox-clear ms-CommandButton--noLabel">
                    <button class="ms-CommandButton-button">
                        <span class="ms-CommandButton-icon"><i class="ms-Icon ms-Icon--Clear"></i></span>
                        <span class="ms-CommandButton-label"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="ms-tab-bar__content">
        <main id="placeholders" class="ms-tab-bar__content ms-font-m ms-fontColor-neutralPrimary">
            <article class="demo-placeholder">
                <div class="demo-placeholder__text"></div>
                <div class="demo-placeholder__text"></div>
                <div class="demo-placeholder__text"></div>
                <div class="demo-placeholder__text demo-placeholder__text--half"></div>
            </article>
            <div id="spinner" style="display: none; margin: 0 auto; padding-bottom: 20px;">
                <div class="ms-Spinner ms-Spinner--large">
                    <div class="ms-Spinner-label">
                        Loading Search results...
                    </div>
                </div>
            </div>
            <div id="message">
                <div class="ms-MessageBanner">
                    <div class="ms-MessageBanner-content">
                        <div class="ms-MessageBanner-text">
                            <div class="ms-MessageBanner-clipper">
                                You may search any intents such as "companies from china", "companies from india"
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <article class="demo-placeholder">
                <div class="demo-placeholder__text"></div>
                <div class="demo-placeholder__text"></div>
                <div class="demo-placeholder__text"></div>
                <div class="demo-placeholder__text demo-placeholder__text--half"></div>
            </article>
            <article class="demo-placeholder">
                <div class="demo-placeholder__text demo-placeholder__text--half"></div>
                <div class="demo-placeholder__text demo-placeholder__text--para"></div>
            </article>
            <article class="demo-placeholder">
                <div class="demo-placeholder__text"></div>
                <div class="demo-placeholder__text demo-placeholder__text--half"></div>
                <div class="demo-placeholder__text"></div>
                <div class="demo-placeholder__text"></div>
            </article>
        </main>

        <ul class="ms-List" id="results">

        </ul>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            var SpinnerElements = document.querySelectorAll(".ms-Spinner");
            for (var i = 0; i < SpinnerElements.length; i++) {
                new fabric['Spinner'](SpinnerElements[i]);
            }
        });

        function search(value) {
            if(value != '') {
                $("#search").html('');
            } else {
                $("#search").html('Search Anything...');
            }

            $("#placeholders").show();
            $("#spinner").show();
            $("#message").hide();
            $("#results").html('');

            $.ajax({
                type: 'GET',
                url: '/search',
                data: 'keyword='+value,
                success:function(result){
                    $.each( result, function( key, value ) {
                       var item = '<li class="ms-ListItem ms-ListItem--image" tabindex="0"> ' +
                           '<div style="background-color: #FFFFFF; text-align:center" class="ms-ListItem-image">' +
                           //'<img style="height: auto; max-width: 100%; max-height: 24px;" src="'+value._source.profile_image_url+'"> ' +
                           '</div> ' +
                           '<span class="ms-ListItem-primaryText">'+value._source.company+'</span>' +
                           ' <span class="ms-ListItem-secondaryText">'+value._source.description+'</span> ' +
                           '<span class="ms-ListItem-tertiaryText">' +
                           value._source.city+','+value._source.state+','+value._source.country
                           + '  |  <b>INDUSTRY : </b>'+value._source.industry+
                           '</span> ' +
                           '<span class="ms-ListItem-metaText">2:42p</span> ' +
                           '<div class="ms-ListItem-selectionTarget"></div> ' +
                           '<div class="ms-ListItem-actions"> ' +
                           '<div class="ms-ListItem-action"> ' +
                           '<i class="ms-Icon ms-Icon--Mail"></i> ' +
                           '</div> ' +
                           '<div class="ms-ListItem-action"> ' +
                           '<i class="ms-Icon ms-Icon--Delete"></i> ' +
                           '</div> ' +
                           '<div class="ms-ListItem-action"> ' +
                           '<i class="ms-Icon ms-Icon--Flag"></i> ' +
                           '</div> ' +
                           '<div class="ms-ListItem-action"> ' +
                           '<i class="ms-Icon ms-Icon--Pinned"></i> ' +
                           '</div> ' +
                           '</div> ' +
                           '</li>';

                       $("#results").append(item);
                    });

                    $("#placeholders").hide();
                }
            });
        }
    </script>
@endsection
