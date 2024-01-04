@extends('Layout.Settings')

@section('content')



@section ('title') 
 Ustawienia użytkownika
@endsection

<br>
<div class="titleSettings">USTAWIENIA KONTA</div>
<div class="titleAllSettings">
    <a class="hrefSettingCursor" onclick="loadPageMood()"><div class="titleSettingsMood titleSettingsAll">USTAWIENIA NASTROJU</DIV></a>
    <a class="hrefSettingCursor" onclick="loadPageDrugs()"><div class="titleSettingsDrugs titleSettingsAll">USTAWIENIA PRODUKTÓW</DIV></a>
    <a class="hrefSettingCursor" onclick="loadPageUser()"><div class="titleSettingsUser titleSettingsAll">USTAWIENIA UŻYTKOWNIKA</DIV></a>
</div>
<div class="downPage">
    <div class="MenuPageMood pagepagepage pageMood" style="display: none;">
       
           
            <div id="addAction" class="hrefMood hrefSettingCursor" onmouseover="selectMenuMood('addAction')" onmouseout="unSelectMenuMood('addAction')" onclick="addActionNew()">
               DODAJ NOWĄ AKCJE
            </div>
           
            <div id="levelMood"  class=" hrefMood hrefSettingCursor" onmouseover="selectMenuMood('levelMood')" onmouseout="unSelectMenuMood('levelMood')" onclick="levelMood()">
                POZIOMY NASTROJU
            </div>
            <div id="changeNameAction"  class=" hrefMood hrefSettingCursor" onmouseover="selectMenuMood('changeNameAction')" onmouseout="unSelectMenuMood('changeNameAction')" onclick="changeNameAction()">
                ZMIEŃ NAZWY AKCJI
            </div>
            <div id="changeDateAction"  class=" hrefMood hrefSettingCursor" onmouseover="selectMenuMood('changeDateAction')" onmouseout="unSelectMenuMood('changeDateAction')" onclick="changeDateAction()">
                ZMIEŃ DATY AKCJI
            </div>
        
        
        
    </div>
    <div  class="MenuPageDrugs pagepagepage pageDrugs" style="display: none;">
            <div id="newGroup" class="hrefDrugs hrefSettingCursor" onmouseover="selectMenuMood('newGroup')" onmouseout="unSelectMenuMood('newGroup')"  onclick="addNewGroup()">
               DODAJ NOWĄ GRUPĘ
            </div>
           
            <div id="newSubstance"  class=" hrefDrugs hrefSettingCursor" onmouseover="selectMenuMood('newSubstance')" onmouseout="unSelectMenuMood('newSubstance')" onclick="addNewSubstance()">
                DODAJ NOWĄ SUBSTANCJĘ
            </div>
            <div id="newProduct"  class=" hrefDrugs hrefSettingCursor" onmouseover="selectMenuMood('newProduct')" onmouseout="unSelectMenuMood('newProduct')" onclick="addNewProduct()">
                DODAJ NOWY PRODUKT
            </div>
            <div id="editGroup"  class=" hrefDrugs hrefSettingCursor" onmouseover="selectMenuMood('editGroup')" onmouseout="unSelectMenuMood('editGroup')" onclick="editGroup()">
                EDYTUJ GRUPĘ
            </div>
            <div id="editSubstance"  class=" hrefDrugs hrefSettingCursor" onmouseover="selectMenuMood('editSubstance')" onmouseout="unSelectMenuMood('editSubstance')" onclick="editSubstance()">
                EDYTUJ SUBSTANCJĘ
            </div>
            <div id="editProduct"  class=" hrefDrugs hrefSettingCursor" onmouseover="selectMenuMood('editProduct')" onmouseout="unSelectMenuMood('editProduct')" onclick="editProduct()">
                EDYTUJ PRODUKT
            </div>
            <div id="planedDose"  class=" hrefDrugs hrefSettingCursor" onmouseover="selectMenuMood('planedDose')" onmouseout="unSelectMenuMood('planedDose')" onclick="planedDose()">
                ZAPLANUJ DAWKĘ
            </div>
    </div>
    <div class="MenuPageUser pagepagepage pageUser" style="display: none;">
       
           
            <div id="addDoctor" class="hrefUsers hrefSettingCursor" onmouseover="selectMenuUsers('addDoctor')" onmouseout="unSelectMenuUsers('addDoctor')" onclick="addDoctorNew()">
               LOGOWANIE DOCTORA
            </div>
           

        
        
        
    </div>
    <div id="MenuPageUser" style="display: none;">

    </div>
    
    
    <div class="pagePageUser pagepage bodyUserPage" id="addNewDoctor" style="display: none;">

        </div>
    
    
    <div class="pagePageMood pagepage bodyMoodPage" id="addNewAction" style="display: none;">

        </div>
    <div class="pagePageMood pagepage bodyMoodPage" id="levelMoodAdd" style="display: none;">

        </div>
    <div class="pagePageMood pagepage bodyMoodPage" id="changeNameActionChange" style="display: none;">

        </div>
    <div class="pagePageMood pagepage bodyMoodPage" id="changeDateActionChange" style="display: none;">

        </div>
    
    
    <div class="pagePageDrugs pagepage bodyDrugsPage" id="addNewGroup" style="display: none;">

        </div>
     <div class="pagePageDrugs pagepage bodyDrugsPage" id="addNewSubstance" style="display: none;">

        </div>
     <div class="pagePageDrugs pagepage bodyDrugsPage" id="addNewProduct" style="display: none;">

        </div>
     <div class="pagePageDrugs pagepage bodyDrugsPage" id="editGroupSet" style="display: none;">

        </div>
         <div class="pagePageDrugs pagepage bodyDrugsPage" id="editSubstanceSet" style="display: none;">

        </div>
        <div class="pagePageDrugs pagepage bodyDrugsPage" id="editProductSet" style="display: none;">

        </div>
        <div class="pagePageDrugs pagepage bodyDrugsPage" id="planedDoseSet" style="display: none;">

        </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />


<script>
    

    var urlArray = [
        '{{route('settings.addNewAction')}}',
        '{{route('settings.levelMood')}}',
        '{{route('settings.changeNameAction')}}',
        '{{route('settings.changeDateAction')}}',
        '{{route('settings.addNewGroup')}}',
        '{{route('settings.addNewSubstance')}}',
        '{{route('settings.addNewProduct')}}',
        '{{route('settings.editGroup')}}',
        '{{route('settings.editSubstance')}}',
        '{{route('settings.editProduct')}}',
        '{{route('settings.planedDose')}}',
        '{{route('settings.addDoctorNew')}}'
    ];
    var urlArraySubmit = [
        '{{route('settings.addNewActionSubmit')}}',
        '{{route('settings.levelMoodSubmit')}}',
        '{{route('settings.changeNameActionSubmit')}}',
        '{{route('settings.changeDateActionSubmit')}}',
        '{{route('settings.addNewGroupSubmit')}}',
        '{{route('settings.addNewSubstanceSubmit')}}',
        '{{route('settings.addNewProductSubmit')}}',
        '{{route('settings.editGroupSubmit')}}',
        '{{route('settings.editSubstanceSubmit')}}',
        '{{route('settings.editProductSubmit')}}',
        '{{route('settings.planedDoseSubmit')}}',
        '{{route('settings.addDoctorNewSubmit')}}'
    ];
    

window.onload=setFunction();

    </script>
@endsection