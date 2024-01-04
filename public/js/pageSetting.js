/*
 * copyright 2022 Tomasz Leszczyński tomi0001@gmail.com
 */




function setFunction() {
    selectMenu();
    switch (sessionStorage.getItem('settingType')) {
        
        case 'addActionNew': addActionNew();
            break;
        case 'levelMood': levelMood();
            break;
        case 'changeNameAction': changeNameAction();
            break;
        case 'changeDateAction': changeDateAction();
            break;
        case 'addNewGroup': addNewGroup();
            break;
        case 'addNewSubstance': addNewSubstance();
            break;
        case 'addNewProduct': addNewProduct();
            break;
        case 'editGroupSet': editGroup();
            break;
        case 'editSubstanceSet': editSubstance();
            break;
        case 'editProductSet': editProduct();
            break;
        case 'planedDose': planedDose();
            break;
        case 'addNewDoctor': addDoctorNew();
            break;
      
    }
}
    
$(document).ready(function(){

        $(".mainHref").click( function() {
        
            resetSession();
        });

});
function resetSession() {
    sessionStorage.removeItem('settingType');
}
function selectMenu() {
    if (sessionStorage.getItem('settingType') == 'addActionNew' || sessionStorage.getItem('settingType') == 'levelMood' || sessionStorage.getItem('settingType') == 'changeNameAction' || sessionStorage.getItem('settingType') == 'changeDateAction') {
        loadPageMood();
    }
    if (sessionStorage.getItem('settingType') == 'addNewGroup' ||  sessionStorage.getItem('settingType') == 'addNewSubstance' || sessionStorage.getItem('settingType') == 'addNewProduct' || sessionStorage.getItem('settingType') == 'editGroupSet' || sessionStorage.getItem('settingType') == 'editSubstanceSet' || sessionStorage.getItem('settingType') == 'editProductSet' || sessionStorage.getItem('settingType') == 'planedDose' ) {
        loadPageDrugs();
    }
     if (sessionStorage.getItem('settingType') == 'addNewDoctor' ) {
        loadPageUser();
    }
}

function checkError(i) {

    if (i == 10) {
        if ((parseFloat($("input[name='valueMood" + i + "From']").val()) >= 20 ) || (parseFloat($("input[name='valueMood" + i + "From']").val())  <= parseFloat($("input[name='valueMood" + (i-1) + "From']").val()) )  ) {
            $("input[name='valueMood" + i + "From']").addClass("errorForm");
        }
        else {
            $("input[name='valueMood" + i + "From']").removeClass("errorForm");
        }
        return;
    }
    
        if ((parseFloat($("input[name='valueMood" + i + "From']").val())  > parseFloat($("input[name='valueMood" + (i-1) + "From']").val()) )  && ( parseFloat($("input[name='valueMood" + i + "From']").val()) < parseFloat($("input[name='valueMood" + (i+1) + "From']").val()) )) {
            $("input[name='valueMood" + i + "From']").removeClass("errorForm");
        }
        else {
            $("input[name='valueMood" + i + "From']").addClass("errorForm");
        }

    
}

function loadValue(valueInputsave,valueInputread,i) {

        checkError(i);

    $("input[name='" +valueInputsave +  "']").val($("input[name='" +valueInputread +  "']").val());
    
}

function loadPageMood() {
    $(".titleSettingsMood").addClass("selectedMenu");
    $(".titleSettingsDrugs").removeClass("selectedMenu");
    $(".titleSettingsUser").removeClass("selectedMenu");
    $(".MenuPageMood").css("display","block");
    $(".MenuPageDrugs").css("display","none");
    
    $(".pagePageDrugs").css("display","none");
    
    $(".pagePageUser").css("display","none");
    $(".MenuPageUser").css("display","none");
    
}
function loadPageUser() {
    $(".titleSettingsMood").removeClass("selectedMenu");
    $(".titleSettingsDrugs").removeClass("selectedMenu");
    $(".titleSettingsUser").addClass("selectedMenu");
    $(".MenuPageUser").css("display","block");
    $(".MenuPageDrugs").css("display","none");
    
    $(".pagePageDrugs").css("display","none");
    $(".MenuPageMood").css("display","none");
    
    $(".pagePageMood").css("display","none");
}
function loadPageDrugs() {
    
    $(".titleSettingsMood").removeClass("selectedMenu");
    $(".titleSettingsDrugs").addClass("selectedMenu");
    $(".titleSettingsUser").removeClass("selectedMenu");    
    $(".MenuPageDrugs").css("display","block");
    $(".MenuPageMood").css("display","none");
    
    $(".pagePageMood").css("display","none");
    
    $(".pagePageUser").css("display","none");
    $(".MenuPageUser").css("display","none");
}

//function loadPageUser() {
//    $(".titleSettingsMood").removeClass("selectedMenu");
//    $(".titleSettingsDrugs").removeClass("selectedMenu");
//    $(".titleSettingsUser").addClass("selectedMenu");    
//}

function selectMenuUsers(menu) {
     $("#" + menu).addClass("selectedMenuUsersHref");
}

function unSelectMenuUsers(menu) {
    $("#" + menu).removeClass("selectedMenuUsersHref");
}
function selectMenuMood(menu) {
    $("#" + menu).addClass("selectedMenuMoodHref");
    
}

function unSelectMenuMood(menu) {
    $("#" + menu).removeClass("selectedMenuMoodHref");
}

function addActionNew() {
    sessionStorage.setItem('settingType', "addActionNew");
    if ($("#addNewAction").css("display") == "none" ) {
        
        $.ajax({
                url : urlArray[0],
                    method : "get",

                    dataType : "html",
            })
            .done(function(response) {




                  $("#addNewAction").css("display","block");
                  $("#addNewAction").html(response);


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })    
            $("#levelMoodAdd").css("display","none");
            $("#changeNameActionChange").css("display","none");
            $("#changeDateActionChange").css("display","none");
    }
    else {
        
        $("#addNewAction").css("display","none");
    }
    
}



function levelMoodSubmit() {
    var arrayError = "";

    if (arrayError != "") {
        $("#levelMoodSubmit").addClass("ajaxError");
        $("#levelMoodSubmit").html(arrayError);
        return;
    }
    else {
         $.ajax({
                url : urlArraySubmit[1],
                    method : "get",
                    data : 
              $("#formlevelMoodSubmit").serialize(),
                    dataType : "html",
            })
            .done(function(response) {


                $("#levelMoodSubmit").html(response);
            


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })    
    }
}




function levelMood() {
    
    sessionStorage.setItem('settingType', "levelMood");
    if ($("#levelMoodAdd").css("display") == "none" ) {
        
        $.ajax({
                url : urlArray[1],
                    method : "get",

                    dataType : "html",
            })
            .done(function(response) {




                  $("#levelMoodAdd").css("display","block");
                  $("#levelMoodAdd").html(response);


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })    
            $("#addNewAction").css("display","none");
            $("#changeNameActionChange").css("display","none");
            $("#changeDateActionChange").css("display","none");
    }
    else {
        
        $("#levelMoodAdd").css("display","none");
    }    
}

function changeDateAction() {
    sessionStorage.setItem('settingType', "changeDateAction");
    if ($("#changeDateActionChange").css("display") == "none" ) {
        
        $.ajax({
                url : urlArray[3],
                    method : "get",

                    dataType : "html",
            })
            .done(function(response) {




                  $("#changeDateActionChange").css("display","block");
                  $("#changeDateActionChange").html(response);


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })    
            $("#addNewAction").css("display","none");
            $("#changeNameActionChange").css("display","none");
            $("#levelMoodAdd").css("display","none");
    }
    else {
        
        $("#changeDateActionChange").css("display","none");
    }   
}


function changeNameAction() {
    
    sessionStorage.setItem('settingType', "changeNameAction");
    if ($("#changeNameActionChange").css("display") == "none" ) {
        
        $.ajax({
                url : urlArray[2],
                    method : "get",

                    dataType : "html",
            })
            .done(function(response) {




                  $("#changeNameActionChange").css("display","block");
                  $("#changeNameActionChange").html(response);


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })    
            $("#addNewAction").css("display","none");
            $("#levelMoodAdd").css("display","none");
            $("#changeDateActionChange").css("display","none");
    }
    else {
        
        $("#changeNameActionChange").css("display","none");
    }        
}
function addActionNewSubmit() {
    var arrayError = "";
    if ($("input[name='nameAction']").val() == "") {
        arrayError += "Uzupełnij nazwe akcji<br>";

    }
    if ($("input[name='levelPleasure']").val() == "" || ($("input[name='levelPleasure']").val() > 20 || $("input[name='levelPleasure']").val() < -20) || isNaN($("input[name='levelPleasure']").val()) ) {
            arrayError += "Zła wartość przyjemności musi być od -20 do +20";

    }
    if (arrayError != "") {
        $("#addNewActionSubmit").addClass("ajaxError");
        $("#addNewActionSubmit").html(arrayError);
        return;
    }
    else {
         $.ajax({
                url : urlArraySubmit[0],
                    method : "get",
                    data : 
              $("#formaddActionNew").serialize(),
                    dataType : "json",
            })
            .done(function(response) {

            if (response['error'] != "") {
        $("#addNewActionSubmit").addClass("ajaxError").removeClass("ajaxSucces");
        $("#addNewActionSubmit").html("Już jest taka akcja o takiej nazwie");
            }
            else {
                $("#addNewActionSubmit").addClass("ajaxSucces");
                $("#addNewActionSubmit").html(response["succes"]);
            }


                  


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })    
    }
}

function changeNameActionSubmit() {
             $.ajax({
                url : urlArraySubmit[2],
                    method : "get",
                    data : 
              $("#formchangeNameAction").serialize(),
                    dataType : "html",
            })
            .done(function(response) {


          
                $("#changeNameActionSubmit").html(response);


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })    
}

function changeDateActionSubmit() {
             $.ajax({
                url : urlArraySubmit[3],
                    method : "get",
                    data : 
              $("#formchangeDateAction").serialize(),
                    dataType : "html",
            })
            .done(function(response) {


          
                $("#changeDateActionSubmit").html(response);


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })        
}

function deleteAction(url) {
   var bool = confirm("Czy na pewno");
   if (bool == true) {
     $.ajax({
                url : url,
                    method : "get",
                    data : 'id=' + $("select[name='nameActionChange']").val(),
              
                    dataType : "html",
            })
            .done(function(response) {


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })    
   }
}


function loadPleasure(url) {
    if ($("select[name='nameAction']").val() != "") { 
        $("input[name='pleasure']").prop("disabled",false);
            $.ajax({
                url : url,
                    method : "get",
                    data : 
                        "id=" + $("select[name='nameAction']").val(),
                    dataType : "json",
            })
            .done(function(response) {

                
            

                  $("input[name='pleasure']").val(response["level_pleasure"]);
                  
                  $("#newName").css("visibility","visible");
                  $("textarea[name='newName']").val(response["name"])

            })
            .fail(function() {
                alert("Wystąpił błąd");
            })    
        }
        else {
            $("input[name='pleasure']").prop("disabled",true);
            $("#newName").css("visibility","hidden");
        }
}

function createListAction(id,list) {
    var string = "";
    for (var i = 0; i < list.actionList.length; i++) {
        if (list.actionList[i].id == id) {
            string += "<option value='" + list.actionList[i].id + "' selected>"  + list.actionList[i].name + "</option>";
        }
        else {
            string += "<option value='" + list.actionList[i].id + "'>"  + list.actionList[i].name + "</option>";
        }
    }
    return string;
}
function loadChangeAction(url) {
    var bool = true;
    if ($("select[name='nameActionChange']").val() != "") { 
        $("#changeActionHidden").css("display","block");
        
            $.ajax({
                url : url,
                    method : "get",
                    data : 
                        "id=" + $("select[name='nameActionChange']").val(),
                    dataType : "json",
            })
            .done(function(response) {
                var regex = /<br\s*[\/]?>/gi;
        
                var str = response["actionPlan"]["what_work"];
               var string =  createListAction(response["actionPlan"]["id_actions"],response);
                $("select[name='changeAction']").html(string);
                $("textarea[name='description']").html(str.replace(regex, "\n"));
                $("input[name='long']").val(response["actionPlan"]["longer"]);
                $("input[name='date']").val(response["actionPlan"]["date"]);
                $("input[name='time']").val(response["actionPlan"]["time"]);

                
                if (response["bool"] == true) {
                    bool = true;

                }
                else {
                    bool = false;
                    
                }
                    $("select[name='changeAction']").prop("disabled",bool);
                    $("textarea[name='description']").prop("disabled",bool);
                    $("input[name='long']").prop("disabled",bool);
                    $("input[name='date']").prop("disabled",bool);
                    $("input[name='time']").prop("disabled",bool);
                    $("#changeButton").prop("disabled",bool);
                    $("#buttonDelete").prop("disabled",bool);


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })    
        }
        else {
            $("input[name='pleasure']").prop("disabled",true);
            $("#newName").css("visibility","hidden");
        }    
         
    
    
}



function addNewGroup() {
    sessionStorage.setItem('settingType', "addNewGroup");
    if ($("#addNewGroup").css("display") == "none" ) {
        
        $.ajax({
                url : urlArray[4],
                    method : "get",

                    dataType : "html",
            })
            .done(function(response) {




                  $("#addNewGroup").css("display","block");
                  $("#addNewGroup").html(response);


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })    
             $("#addNewSubstance").css("display","none");
             $("#addNewProduct").css("display","none");
             $("#editGroupSet").css("display","none");
             $("#editSubstanceSet").css("display","none");
             $("#editProductSet").css("display","none");
             $("#planedDoseSet").css("display","none");

    }
    else {
        
        $("#addNewGroup").css("display","none");
    }    
}

function addNewSubstance() {
    sessionStorage.setItem('settingType', "addNewSubstance");
    if ($("#addNewSubstance").css("display") == "none" ) {
        
        $.ajax({
                url : urlArray[5],
                    method : "get",

                    dataType : "html",
            })
            .done(function(response) {




                  $("#addNewSubstance").css("display","block");
                  $("#addNewSubstance").html(response);


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })    
            $("#addNewGroup").css("display","none");
            $("#addNewProduct").css("display","none");
            $("#editGroupSet").css("display","none");
            $("#editSubstanceSet").css("display","none");
            $("#editProductSet").css("display","none");
            $("#planedDoseSet").css("display","none");
    }
    else {
        
        $("#addNewSubstance").css("display","none");
    }    
}

function addNewProduct() {
    sessionStorage.setItem('settingType', "addNewProduct");
    if ($("#addNewProduct").css("display") == "none" ) {
        
        $.ajax({
                url : urlArray[6],
                    method : "get",

                    dataType : "html",
            })
            .done(function(response) {




                  $("#addNewProduct").css("display","block");
                  $("#addNewProduct").html(response);


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })    

            $("#addNewGroup").css("display","none");
            $("#addNewSubstance").css("display","none");
            $("#editGroupSet").css("display","none");
            $("#editSubstanceSet").css("display","none");
            $("#editProductSet").css("display","none");
            $("#planedDoseSet").css("display","none");
    }
    else {
        
        $("#addNewProduct").css("display","none");
    }        
}

function editGroup() {
    sessionStorage.setItem('settingType', "editGroupSet");
    if ($("#editGroupSet").css("display") == "none" ) {
        
        $.ajax({
                url : urlArray[7],
                    method : "get",

                    dataType : "html",
            })
            .done(function(response) {




                  $("#editGroupSet").css("display","block");
                  $("#editGroupSet").html(response);


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })    

            $("#addNewGroup").css("display","none");
            $("#addNewSubstance").css("display","none");
            $("#addNewProduct").css("display","none");
            $("#editSubstanceSet").css("display","none");
            $("#editProductSet").css("display","none");
            $("#planedDoseSet").css("display","none");
    }
    else {
        
        $("#editGroupSet").css("display","none");
    }     
}
function editSubstance() {
    sessionStorage.setItem('settingType', "editSubstanceSet");
    if ($("#editSubstanceSet").css("display") == "none" ) {
        
        $.ajax({
                url : urlArray[8],
                    method : "get",

                    dataType : "html",
            })
            .done(function(response) {




                  $("#editSubstanceSet").css("display","block");
                  $("#editSubstanceSet").html(response);


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })    
 
            $("#addNewGroup").css("display","none");
            $("#addNewSubstance").css("display","none");
            $("#addNewProduct").css("display","none");
            $("#editGroupSet").css("display","none");
            $("#editProductSet").css("display","none");
            $("#planedDoseSet").css("display","none");
    }
    else {
        
        $("#editSubstanceSet").css("display","none");
    }        
}


function planedDose() {
    sessionStorage.setItem('settingType', "planedDose");
    if ($("#planedDoseSet").css("display") == "none" ) {
        
        $.ajax({
                url : urlArray[10],
                    method : "get",

                    dataType : "html",
            })
            .done(function(response) {




                  $("#planedDoseSet").css("display","block");
                  $("#planedDoseSet").html(response);


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })    
            $("#addNewGroup").css("display","none");
            $("#addNewSubstance").css("display","none");
            $("#addNewProduct").css("display","none");
            $("#editGroupSet").css("display","none");
            $("#editProductSet").css("display","none");
            $("#editSubstanceSet").css("display","none");
    }
    else {
        
        $("#planedDoseSet").css("display","none");
    }       
}

var idPlaned = "";


function changeStatusPlaned(id,minus,plus) {
    if ($("#bool"+id).hasClass("minus") ) {
        $("#trPlanedInput"+id).prop('disabled', true);

        $('#trPlanedSelect' + id)[0].selectize.disable();

        $("#bool"+id).removeClass("minus").addClass("plus");
        $("#bool"+id).attr("src",plus);
        $("#bool2" + id).removeClass("minusButton").addClass("plusButton");
    }
    else {
        $("#trPlanedInput"+id).prop('disabled', false);
        $('#trPlanedSelect' + id)[0].selectize.enable();
        $("#bool"+id).removeClass("plus").addClass("minus");
        $("#bool"+id).attr("src",minus);
        $("#bool2" + id).removeClass("plusButton").addClass("minusButton");
    }
}


function changeStatusPlaned2(id,minus,plus) {

    if ($("#bool"+id).hasClass("minus") ) {

        $("#trPlanedInput"+id).prop('disabled', true);
        $("#trPlanedSelect"+id).prop('disabled', true);

        $('#trPlanedSelect' + id).prop('disabled', true);
        $("#bool"+id).removeClass("minus").addClass("plus");
        $("#bool"+id).attr("src",plus);
        $("#bool2" + id).removeClass("minusButton").addClass("plusButton");
    }
    else {
        $("#trPlanedInput"+id).prop('disabled', false);
        $("#trPlanedSelect"+id).prop('disabled', false);

        $("#bool"+id).removeClass("plus").addClass("minus");
        $("#bool"+id).attr("src",minus);
        $("#bool2" + id).removeClass("plusButton").addClass("minusButton");
    }
}



function deletePlanedSubmit(url) {
    var bool = confirm("Czy na pewno");
        if (bool == true) {
         $.ajax({
                     url : url,
                         method : "get",
                         data : 

                             "id=" + idPlaned,
                         dataType : "html",
                 })
                 .done(function(response) {
                       
                       $("#loadChangePlaned").html(response);


                 })
                 .fail(function() {
                     alert("Wystąpił błąd");
                 })   
        }
}


function loadChangePlaned(url) {
    //alert($("select[name='namePlaned']").val());
    if ( $("select[name='namePlaned']").val() != "") {
            $.ajax({
                url : url,
                    method : "get",
                    data : 
                            
                        "id=" + $("select[name='namePlaned']").val(),
                    dataType : "html",
            })
            .done(function(response) {
                  idPlaned = $("select[name='namePlaned']").val();
                  $("#deletePlanedSubmitButton").prop("disabled",false);
                  $("#editPlanedSubmitButton").prop("disabled",false);
                  $(".addPlusButton").css("pointer-events","auto");
                  $(".addPlusButton").css("cursor","pointer");
                  $("#loadChangePlaned").html(response);


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })    
    }
    else {
        $("#deletePlanedSubmitButton").prop("disabled",true);
        $("#editPlanedSubmitButton").prop("disabled",true);
        $(".addPlusButton").css("pointer-events","none");
        $(".addPlusButton").css("cursor","none");
        $("#loadChangePlaned").html("");
    }
}
var editPlanedSubmit = 0;

            


function addNewPosition() {
        
        var td2 = "<td class='tdColorDrugs ' >";
        var td2End = '</td>';
        var td3 = "<td class='tdColorDrugs '><input type='text' name='portion[]' class='form-control' id='trPlanedInput" + (positionPlaned+2) + "'></td>";
        var td3End = "</td>" ;
        var td4 = "<td class='tdColorDrugs ' >";
        var td4End = "</td>" ;
        var selectName = $("#selectHidden").html();
        var selectNameResult = selectName.replaceAll("xxxx","position" + (positionPlaned+2));
        var selectNameResult2= selectNameResult.replaceAll("trPlanedSelect","trPlanedSelect" + (positionPlaned+2));

        var imgPlaned = $("#hiddenTd").html();
        var result = imgPlaned.replaceAll("xxxx",(positionPlaned+2));

                
        $('#tablePlaned').append("<tr> <td  class='tdColorDrugs '> pozycja " + (positionPlaned+2) + "</td>" + td2 + selectNameResult2 + td2End + td3 + td3End   + td4 +  result + td4End + "</tr>");
        positionPlaned++;
}

function addNewPlaned(url) {

        $.ajax({
                url : url,
                    method : "get",
 data : 
                        $("#formaddNewPlaned").serialize(),
                    dataType : "html",
            })
            .done(function(response) {




               
                  $("#planedAddNew").html(response);


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })    


}



function editProduct() {
    sessionStorage.setItem('settingType', "editProductSet");
    if ($("#editProductSet").css("display") == "none" ) {
        
        $.ajax({
                url : urlArray[9],
                    method : "get",

                    dataType : "html",
            })
            .done(function(response) {




                  $("#editProductSet").css("display","block");
                  $("#editProductSet").html(response);


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })    

            $("#addNewGroup").css("display","none");
            $("#addNewSubstance").css("display","none");
            $("#addNewProduct").css("display","none");
            $("#editGroupSet").css("display","none");
            $("#editSubstanceSet").css("display","none");
            $("#planedDoseSet").css("display","none");
    }
    else {
        
        $("#editProductSet").css("display","none");
    }        
}
function addDoctorNew() {
    sessionStorage.setItem('settingType', "addNewDoctor");
    
    if ($("#addNewDoctor").css("display") == "none" ) {
        
        $.ajax({
                url : urlArray[11],
                    method : "get",

                    dataType : "html",
            })
            .done(function(response) {




                  $("#addNewDoctor").css("display","block");
                  $("#addNewDoctor").html(response);


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })    

            
    }
    else {
        
        $("#addNewDoctor").css("display","none");
    }   
}
var arrayGroupSubstance = [];
function selectedGroupSubstance(id,index) {

    if ($("#divGroupGroup_" + id + ":first").hasClass("groupMainAllGroup")) {
        $("#divGroupGroup_" + id).removeClass("groupMainAllGroup").addClass("groupMainselected");
        arrayGroupSubstance.push(id);
    }
    else {
        var i = arrayGroupSubstance.indexOf(id);
        arrayGroupSubstance.splice(i,1);
        $("#divGroupGroup_" + id).removeClass("groupMainselected").addClass("groupMainAllGroup");

    }
    
}

var arrayGroupSubstanceChange = [];
function selectedSubstanceChangeMainSetValue(data,lenght) {

    for (var i = 0;i < lenght;i++) {
        
        if ($("#divSubstanceSubstanceChange_" + data[i].id).length==1) {
            $("#divSubstanceSubstanceChange_" + data[i].id).removeClass("groupMainAllGroup").addClass("groupMainselected");
            arrayGroupSubstanceChange.push(data[i].id);
          
        }
    }
 
}
function selectedProductChangeMainSetValue(data,lenght) {

    for (var i = 0;i < lenght;i++) {
        if ($("#divSubstanceProductChange_" + data[i].id).length==1) {
            
            $("#divSubstanceProductChange_" + data[i].id).removeClass("groupMainAllGroup").addClass("groupMainselected");
            arraySubstanceProductChange.push(data[i].id);
          
        }
    }
 
}
var arraySubstanceProductChange = [];
function selectedProductChangeMainValue(id,index) {
    if ($("#divSubstanceProductChange_" + id + ":first").hasClass("groupMainAllGroup")) {
        $("#divSubstanceProductChange_" + id).removeClass("groupMainAllGroup").addClass("groupMainselected");
        $("#divActionPercent_" + id).removeClass("hiddenPercentExecuting").addClass("showPercentExecuting");
        arraySubstanceProductChange.push(id);
    }
    else {
        var i = arraySubstanceProductChange.indexOf(id);
        arraySubstanceProductChange.splice(i,1);
        $("#divSubstanceProductChange_" + id).removeClass("groupMainselected").addClass("groupMainAllGroup");
        $("#divActionPercent_" + id).removeClass("showPercentExecuting").addClass("hiddenPercentExecuting");

    }   
}
function selectedSubstanceChangeMainValue(id,index) {
    
    if ($("#divSubstanceSubstanceChange_" + id + ":first").hasClass("groupMainAllGroup")) {
        $("#divSubstanceSubstanceChange_" + id).removeClass("groupMainAllGroup").addClass("groupMainselected");
        arrayGroupSubstanceChange.push(id);

    }
    else {
        var i = arrayGroupSubstanceChange.indexOf(id);
        arrayGroupSubstanceChange.splice(i,1);

        $("#divSubstanceSubstanceChange_" + id).removeClass("groupMainselected").addClass("groupMainAllGroup");

    }    
}




function changeNameGroup() {
    if ($("select[name='nameGroupEdit']").val() != "") {
        $("#editGroupButton").prop("disabled",false);
        $("#newName").css("display","block");
        $("input[name='newNameGroup']").val($("select[name='nameGroupEdit']").text());
        $("input[name='newNameGroupHidden']").val($("select[name='nameGroupEdit']").val())
    }
}



function changeArrayFormAddProduct() {

    let array = document.querySelectorAll('input[name^="howMg"]');

    for (var i=0;i < array.length;i++) {
        var id = $('input[name^="idSubstance"]').eq(i).val();
        if (arraySubstanceProduct.find(element => element == id )) {
alert('dddd');
          $("#formaddProductNew").append("<input type=\'hidden\' name=\'idSubstance2[]\' value='" +  $('input[name^="idSubstance"]').eq(i).val()  + "' class=\'form-control typeMood\'>");
          $("#formaddProductNew").append("<input type=\'hidden\' name=\'howMg2[]\' value='" + $('input[name^="howMg"]').eq(i).val() + "' class=\'form-control typeMood\'>");
          $("#formaddProductNew").append("<input type=\'hidden\' name=\'typeMgUg2[]\' value='" + $('select[name^="typeMgUg"]').eq(i).val() + "' class=\'form-control typeMood\'>");
//          alert($('select[name^="typeMgUg"]').eq(i).val());
          
        }
            }

}


function changeArrayFormEditProduct() {
 
    let array = document.querySelectorAll('input[name^="howMg"]');
 
    for (var i=0;i < array.length;i++) {
        var id = $('input[name^="idSubstance"]').eq(i).val();
        if (arraySubstanceProductChange.find(element => element == id )) {
           alert('dddd'); 
          $("#formUpdateProduct2").append("<input type=\'hidden\' name=\'idSubstance2[]\' value='" +  $('input[name^="idSubstance"]').eq(i).val()  + "' class=\'form-control typeMood\'>");
          $("#formUpdateProduct2").append("<input type=\'hidden\' name=\'howMg2[]\' value='" + $('input[name^="howMg"]').eq(i).val() + "' class=\'form-control typeMood\'>");
          $("#formUpdateProduct2").append("<input type=\'hidden\' name=\'typeMgUg2[]\' value='" + $('select[name^="typeMgUg"]').eq(i).val() + "' class=\'form-control typeMood\'>");
        }

            }

}


var arraySubstanceProduct = [];
function selectedProductProduct(id,index) {

    if ($("#divSubstanceSubstance_" + id + ":first").hasClass("SubstanceMainAllSubstance")) {
        $("#divSubstanceSubstance_" + id).removeClass("SubstanceMainAllSubstance").addClass("substanceMainselected");
        $("#divSubstanceSubstancePercent_" + id).removeClass("hiddenPercentExecuting").addClass('active');
        arraySubstanceProduct.push(id);
    }
    else {
        var i = arraySubstanceProduct.indexOf(id);
        arraySubstanceProduct.splice(i,1);
        $("#divSubstanceSubstancePercent_" + id).addClass("hiddenPercentExecuting").removeClass('active');
        $("#divSubstanceSubstance_" + id).removeClass("substanceMainselected").addClass("SubstanceMainAllSubstance");

    }
    
}


function changeArrayFormAddSubstance() {
        for (var i=0;i < arrayGroupSubstance.length;i++) {

          $("#formaddSubstanceNew").append("<input type=\'hidden\' name=\'idGroup[]\' value='" +  arrayGroupSubstance[i]  + "' class=\'form-control typeMood\'>");

            }
}
function changeArrayFormEditSubstance() {

        for (var i=0;i < arrayGroupSubstanceChange.length;i++) {

          $("#formUpdateSubstance2").append("<input type=\'hidden\' name=\'idGroup[]\' value='" +  arrayGroupSubstanceChange[i]  + "' class=\'form-control typeMood\'>");

            }
}
function loadChangeSubstance(url) {
    if ($("#nameSubstance").val() != "") {
        
        $("#editSubstanceSubmitButton").prop("disabled",false);
                   $("#formUpdateSubstance2").trigger('reset');
                $("#formUpdateSubstance").trigger('reset');
                   arrayGroupSubstanceChange.length = 0;
            $("#formUpdateSubstance2").find(":hidden").filter(".typeMood").remove();
         $.ajax({
                url : url,
                    method : "get",
                    data : "id=" + $("#nameSubstance").val(),

                    dataType : "html",
            })
            .done(function(response) {
     
        $("#changeSubstanceDiv").html(response);


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })       
        }
}
function loadChangeProduct(url) {
    if ($("#nameProduct").val() != "") {
        
        $("#editProductSubmitButton").prop("disabled",false);
                   $("#formUpdateProduct2").trigger('reset');
                $("#formUpdateProduct").trigger('reset');
                   arraySubstanceProductChange.length = 0;
            $("#formUpdateProduct2").find(":hidden").filter(".typeMood").remove();
         $.ajax({
                url : url,
                    method : "get",
                    data : "id=" + $("#nameProduct").val(),

                    dataType : "html",
            })
            .done(function(response) {
     
        $("#changeProductDiv").html(response);
       

                  


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })       
        }    
}
function addSubstanceNewSubmit() {
 var arrayError = "";

    if ($("input[name='nameSubstance']").val() == "") {
        arrayError += "Uzupełnij nazwe Substancji<br>";

    }

    if (arrayError != "") {
        $("#addNewSubstanceSubmit").addClass("ajaxError");
        $("#addNewSubstanceSubmit").html(arrayError);
        return;
    }
    else {
        changeArrayFormAddSubstance();
         $.ajax({
                url : urlArraySubmit[5],
                    method : "get",
                    data : 
              $("#formaddSubstanceNew").serialize(),
                    dataType : "html",
            })
            .done(function(response) {

          
        $("#addNewSubstanceSubmit").html(response);
       
                //arrayGroupSubstance.length = 0;
            $("#formaddSubstanceNew").find(":hidden").filter(".typeMood").remove();


                  


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })    
    }    
}


function editSubstanceSubmit() {
 var arrayError = "";
    if ($("input[name='newName']").val() == "") {
        arrayError += "Uzupełnij nazwe Substancji<br>";
    }

    if (arrayError != "") {
        $("#updateSubstanceDiv").addClass("ajaxError");
        $("#updateSubstanceDiv").html(arrayError);
        return;
    }
    else {
        changeArrayFormEditSubstance();

         $.ajax({
                url : urlArraySubmit[8],
                    method : "get",
                    data : 
              $("#formUpdateSubstance2").serialize()  + "&" + $("#formUpdateSubstance").serialize(),
                    dataType : "html",
            })
            .done(function(response) {

          
        $("#updateSubstanceDiv").html(response);
       
            $("#formUpdateSubstance2").find(":hidden").filter(".typeMood").remove();


                  


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })    
    }       
}
var checkErrorPlanedInput = "";
var checkErrorPlanedSelect = "";

function checkErrorEdit() {
    for (var i=0;i < positionPlaned+1;i++) {
        if ($("select[name='position[]']").eq(i).val() == "" && !$("select[name='position[]']").eq(i).prop('disabled')) {
            checkErrorPlanedSelect = ("któryś z pół substancji nie jest uzupełnione <br>");
        }
        if (($("input[name='portion[]']").eq(i).val() == "" ||  (  isNaN($("input[name='portion[]']").eq(i).val()) || $("input[name='portion[]']").eq(i).val() <= 0 ) ) && !$("input[name='portion[]']").eq(i).prop('disabled') ) {
            checkErrorPlanedInput = ("pole textowe musi być dodatnią liczbą zmienno przecinkową ");
        }
    }
}

function createFormPlanedSubmit() {
    for (var i=0;i < positionPlaned+1;i++) {
        
        if (!$("input[name='portion[]']").eq(i).prop('disabled')) {

               $("#formupdatePlaned").append("<input type=\'hidden\' name=\'portions[]\' value='" +  $("input[name^='portion[]']").eq(i).val()  + "' class=\'form-control typeMood\'>");
               $("#formupdatePlaned").append("<input type=\'hidden\' name=\'idProducts[]\' value='" + $("select[name^='position[]']").eq(i).val() + "' class=\'form-control typeMood\'>");
          }
  }
}

function editPlanedSubmitFunction(url) {

    checkErrorEdit();
    if (checkErrorPlanedSelect !=  "" || checkErrorPlanedInput !=  "") {
        $("#updatePlanedDiv").addClass("ajaxError");
        $("#updatePlanedDiv").html(checkErrorPlanedSelect  +  checkErrorPlanedInput);
    }

    else {
         createFormPlanedSubmit();
         $.ajax({
                url : url,
                    method : "get",
                    data : 
              $("#formupdatePlaned").serialize() + "&id=" + idPlaned2,
                    dataType : "html",
            })
            .done(function(response) {

          
        $("#updatePlanedDiv").html(response);
       
            $("#formupdatePlaned").find(":hidden").filter(".typeMood").remove();


                  


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })          
    }
    checkErrorPlanedSelect = "";
    checkErrorPlanedInput = "";
}


function editProductSubmit() {
 var arrayError = "";

    if ($("input[name='newName']").val() == "") {
        arrayError += "Uzupełnij nazwe Produktu<br>";
    }

    if (arrayError != "") {
        $("#updateProductDiv").addClass("ajaxError");
        $("#updateProductDiv").html(arrayError);
        return;
    }
    else {
        changeArrayFormEditProduct();
     
         $.ajax({
                url : urlArraySubmit[9],
                    method : "get",
                    data : 
              $("#formUpdateProduct2").serialize() + "&" + $("#formUpdateProduct").serialize(),
                    dataType : "html",
            })
            .done(function(response) {

          
        $("#updateProductDiv").html(response);

            $("#formUpdateProduct2").find(":hidden").filter(".typeMood").remove();


                  


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })    
    }           
}
function editGroupSubmit() {
             $.ajax({
                url : urlArraySubmit[7],
                    method : "get",
                    data : 
              $("#formeditGroup").serialize(),
                    dataType : "html",
            })
            .done(function(response) {


          
                $("#editGroupSubmit").html(response);

            })
            .fail(function() {
                alert("Wystąpił błąd");
            })        
}



function addNewDoctorSubmit() {
                 $.ajax({
                url : urlArraySubmit[11],
                    method : "get",
                    data : 
              $("#formaddNewDoctor").serialize(),
                    dataType : "html",
            })
            .done(function(response) {


          
                $("#addNewDoctorSubmit").html(response);

            })
            .fail(function() {
                alert("Wystąpił błąd");
            })       
}



function addProductNewSubmit() {
 var arrayError = "";
 $("#addNewProductSubmit").removeClass("ajaxError");
    if ($("input[name='nameProduct']").val() == "") {
        arrayError += "Uzupełnij nazwe Produktu<br>";
    }

    if (arrayError != "") {
        $("#addNewProductSubmit").addClass("ajaxError");
        $("#addNewProductSubmit").html(arrayError);
        return;
    }
    else {
        changeArrayFormAddProduct();
         $.ajax({
                url : urlArraySubmit[6],
                    method : "get",
                    data : 
              $("#formaddProductNew").serialize(),
                    dataType : "html",
            })
            .done(function(response) {

          
        $("#addNewProductSubmit").html(response);

            $("#formaddProductNew").find(":hidden").filter(".typeMood").remove();


                  


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })    
    }        
}


function addGroupNewSubmit() {
 var arrayError = "";
    if ($("input[name='nameGroup']").val() == "") {
        arrayError += "Uzupełnij nazwe Grupy<br>";

    }

    if (arrayError != "") {
        $("#addNewGroupSubmit").addClass("ajaxError");
        $("#addNewGroupSubmit").html(arrayError);
        return;
    }
    else {
         $.ajax({
                url : urlArraySubmit[4],
                    method : "get",
                    data : 
              $("#formaddGroupNew").serialize(),
                    dataType : "json",
            })
            .done(function(response) {

            if (response['error'] != "") {
        $("#addNewGroupSubmit").addClass("ajaxError").removeClass("ajaxSucces");
        $("#addNewGroupSubmit").html("Już jest taka grupa o takiej nazwie");
            }
            else {
                $("#addNewGroupSubmit").addClass("ajaxSucces");
                $("#addNewGroupSubmit").html(response["succes"]);
            }


                  


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })    
    }
}