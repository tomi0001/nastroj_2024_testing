@extends('Doctor.Layout.Search')

@section('content')



    @section ('title')
    Wyszukiwanie
    @endsection

<br>
<div class="titleSearch">WYSZUKIWANIE</div>
<div class="titleAllSettings" style="background-color: red;">
    <a class="hrefSettingCursor" onclick="loadPageMood()"><div class="titleSettingsMood titleSettingsAll" >WYSZUKIWANIE NASTROJU</DIV></a>
    <a class="hrefSettingCursor" onclick="loadPageDrugs()"><div class="titleSettingsDrugs titleSettingsAll" >WYSZKIWANIE PRODUKTÓW</DIV></a>
</div>
<div class="downPage">
    <div class="MenuPageMood pagepagepage pageMood" style="display: none;">


            <div id="searchMood" class="hrefMood hrefSettingCursor" onmouseover="selectMenuMood('searchMood')" onmouseout="unSelectMenuMood('searchMood')" onclick="searchMood()">
               WYSZUKAJ NASTRÓJ
            </div>

            <div id="searchSleep"  class="hrefMood hrefSettingCursor" onmouseover="selectMenuMood('searchSleep')" onmouseout="unSelectMenuMood('searchSleep')" onclick="searchSleep()">
                WYSZUKAJ SEN
            </div>
            <div id="averageMoodSum"  class="hrefMood hrefSettingCursor" onmouseover="selectMenuMood('averageMoodSum')" onmouseout="unSelectMenuMood('averageMoodSum')" onclick="averageMoodSum()">
                OBLICZ ŚREDNIĄ TRWANIA NASTROJU
            </div>
            <div id="sumHowHMood"  class="hrefMood hrefSettingCursor" onmouseover="selectMenuMood('sumHowHMood')" onmouseout="unSelectMenuMood('sumHowHMood')" onclick="changeDateAction()">
                OBLICZ ILE H TRWAŁY NASTROJE
            </div>
            <div id="generatePdfMood"  class="hrefMood hrefSettingCursor" onmouseover="selectMenuMood('generatePdfMood')" onmouseout="unSelectMenuMood('generatePdfMood')" onclick="changeDateAction()">
                WYGENERUJ PDF DLA NASTROJI
            </div>
            <div id="sumActionDay"  class="hrefMood hrefSettingCursor" onmouseover="selectMenuMood('sumActionDay')" onmouseout="unSelectMenuMood('sumActionDay')" onclick="sumActionDay()">
                WYSZUKAJ AKCJE CAŁODNIOWĄ
            </div>




    </div>
    <div  class="MenuPageDrugs pagepagepage pageDrugs" style="display: none;">
            <div id="searchDrugs" class="hrefDrugs hrefSettingCursor" onmouseover="selectMenuMood('searchDrugs')" onmouseout="unSelectMenuMood('searchDrugs')"  onclick="searchDrugs()">
              WYSZUKAJ PRODUKT            </div>


    </div>
    <div id="MenuPageUser" style="display: none;">

    </div>
    <div class="pagePageMood pagepage bodyMoodPage" id="searchMoodDiv" style="display: none;">
        @include ('Doctor.Search.Mood.searchMood')
        </div>
    <div class="pagePageMood pagepage bodyMoodPage" id="searchSleepDiv" style="display: none;">
            @include ('Doctor.Search.Mood.searchSleep')
        </div>
    <div class="pagePageMood pagepage bodyMoodPage" id="averageMoodSumDiv" style="display: none;">
        @include ('Doctor.Search.Mood.averageMoodSum')
        </div>
    <div class="pagePageMood pagepage bodyMoodPage" id="sumHowHMoodDiv" style="display: none;">

        </div>
    <div class="pagePageMood pagepage bodyMoodPage" id="generatePdfMoodDiv" style="display: none;">

        </div>
    <div class="pagePageMood pagepage bodyMoodPage" id="sumActionDayDiv" style="display: none;">
        @include ('Doctor.Search.Mood.searchActionDay')
        </div>


    <div class="pagePageDrugs pagepage bodyDrugsPage" id="searchDrugsDiv" style="display: none;">
        @include ('Doctor.Search.Product.searchDrugs')
        </div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
<script>
window.onload=setFunction();
</script>
@endsection
