/*
 * copyright 2021 Tomasz Leszczyński tomi0001@gmail.com
 */
var nameClass=  "";
function calendarOn(id) {
    nameClass = $("#" + id).attr('class');
    $("#" + id).removeClass(nameClass).addClass("cell_selected");
}
function calendarOff(id) {
    $("#" + id).removeClass("cell_selected").addClass(nameClass);
}
function LoadPage(url) {
    window.location.replace(url);
}

function submitEnter(e,url,nameFunction) {
    if (e.keyCode == 13) {
        translateFunction(nameFunction,url);

        return false;
    }
}



function translateFunction(string,url) {
    switch (string) {
        case 'addMood': addMood(url);
            break;
        case 'addDrugs': addDrugs(url);
            break;
        case 'addActionDay': addActionDay(url);
            break;
        case 'addSleep': addSleep(url);
            break;
    }
    return;
}

var arrayAction = [];
var arrayActionAction = [];

function selectedActionMain(id,index) {

    if ($("#divAction_" + id + ":first").hasClass("actionMainAll")) {
        $("#divAction_" + id).removeClass("actionMainAll").addClass("actionMainselected");
        $("#divActionPercent_" + id).removeClass("hiddenPercentExecuting").addClass('active');
        arrayAction.push(id);

    }
    else {
        var i = arrayAction.indexOf(id);
        arrayAction.splice(i,1);
        $("#divActionPercent_" + id).addClass("hiddenPercentExecuting").removeClass('active');
        $("#divAction_" + id).removeClass("actionMainselected").addClass("actionMainAll");

    }
    
}

function selectedActionAction(id,index) {

    if ($("#divActionAction_" + id + ":first").hasClass("actionMainAllAction")) {
        $("#divActionAction_" + id).removeClass("actionMainAllAction").addClass("actionMainselected");
        arrayActionAction.push(id);
    }
    else {
        var i = arrayActionAction.indexOf(id);
        arrayActionAction.splice(i,1);
        $("#divActionAction_" + id).removeClass("actionMainselected").addClass("actionMainAllAction");

    }
    
}
var arrayActionMulti = [];

function selectedActionMainValue(id,index,idMood) {
    if ($("#divAction_" + id  + "_" + idMood + ":first").hasClass("actionMain" + idMood)) {
        $("#divAction_" + id + "_" + idMood).removeClass("actionMain"+ idMood).addClass("actionMainselected");
        $("#divActionPercent_" + id + "_" + idMood).removeClass("hiddenPercentExecuting").addClass('active');

        arrayActionMulti.push(id+ ',' + idMood);

    }
    else {

        
        
        var i = arrayActionMulti.indexOf(id+ ',' + idMood);

        arrayActionMulti.splice(i,1);
        //$("#idAction").eq(index).val('NULL');
        $("#divActionPercent_" + id + "_" + idMood).addClass("hiddenPercentExecuting").removeClass('active');
        $("#divAction_" + id + "_" + idMood).removeClass("actionMainselected").addClass("actionMain"+ idMood);

    }
}



function updateActionForMood(url,id) {

    
     changeArrayAtHiddenAddMoodId(id);

    $.ajax({
        url : url,
            method : "get",
            data : 
              $("#formUpdateAction2" + id).serialize() + "&idMood=" + id
            ,
            dataType : "html",

    })
    .done(function(response) {
        $("#formResult" + id).html(response);
        if (response == "") {
            setInterval("reload();",50000);
            $("#formResult" + id).html("<div class='ajaxSucces'>Pomyślnie dodano</div>");
        }
        $("#formUpdateAction" + id).find(":hidden").filter(".typeMood").remove();

    })

    .fail(function() {
        $("#formResult" + id).html( "<div class='ajaxError'>Wystąpił błąd</div>" );
    })
    

}


function selectedActionMainSetValue(data,lenght) {

    for (var i = 0;i < lenght;i++) {
        if ($("#divAction_" + data.idList[i] + "_" + data.idMood[i]).length==1) {
            
            $("#divAction_" + data.idList[i] + "_" + data.idMood[i]).removeClass("actionMain" + data.idMood[i]).addClass("actionMainselected");
            $("#divActionPercent_" + data.idList[i] + "_" + data.idMood[i]).removeClass("hiddenPercentExecuting").addClass('active');

            arrayActionMulti.push(data.idList[i] + ',' + data.idMood[i]);
            $("#percentExe_" + data.index[i]+ "_" + data.idMood[i]).val(data.percent[i]);
            $("#minute_exe_" + data.index[i]+ "_" + data.idMood[i]).val(data.minute[i]);

        }
    }
 
}




function deleteMood(url,id) {
    var bool = confirm("Czy na pewno");
    if (bool == true) {
        
        $.ajax({
           url : url,
               method : "get",
               data : 
                 "id=" + id
               ,
               dataType : "html",
       })
       .done(function(response) {
          
           $(".moodClass" + id).remove();


       })
       .fail(function() {
           alert("Wystąpił błąd");
       })    
        
    }
}


function deleteSleep(url,id) {
    var bool = confirm("Czy na pewno");
    if (bool == true) {
        
        $.ajax({
           url : url,
               method : "get",
               data : 
                 "id=" + id
               ,
               dataType : "html",
       })
       .done(function(response) {
          
           $(".moodClass" + id).remove();


       })
       .fail(function() {
           alert("Wystąpił błąd");
       })    
        
    }
}

function deleteDrugs(url,id) {
    var bool = confirm("Czy na pewno");
    if (bool == true) {
        
        $.ajax({
           url : url,
               method : "get",
               data : 
                 "id=" + id
               ,
               dataType : "html",
       })
       .done(function(response) {
           $(".drugsClass" + id).remove();


       })
       .fail(function() {
           alert("Wystąpił błąd");
       })    
        
    }  
}

$(document).ready(function(){

        $(".mainHref").click( function() {
        
            resetSession();
        });

});

$(document).ready(function(){

     jQuery.expr[':'].contains = function(a, i, m) {
  return jQuery(a).text().toUpperCase()
      .indexOf(m[3].toUpperCase()) >= 0;
};
    $("#hideActions").keyup( function(e) {
        
      if ($("#hideActions").val() == "") {
          $('.actionMainAll').show();
          return;
      }
        $('.actionMainAll').hide();
        var val = $.trim($("#hideActions").val());
        val = ".actionMainAll:contains("+val+")";
        $( val ).show();
      
    });
    $( ".message" ).prop( "disabled", true );
});


$(document).ready(function(){

     jQuery.expr[':'].contains = function(a, i, m) {
  return jQuery(a).text().toUpperCase()
      .indexOf(m[3].toUpperCase()) >= 0;
};
    $("#hideActionsAction").keyup( function(e) {
        
      if ($("#hideActionsAction").val() == "") {
          $('.actionMainAllAction').show();
          return;
      }
        $('.actionMainAllAction').hide();
        var val = $.trim($("#hideActionsAction").val());
        val = ".actionMainAllAction:contains("+val+")";
        $( val ).show();
      
    });
    $( ".message" ).prop( "disabled", true );
});

function ifExistArrayIdMood(id) {
    return id == 1;
}


function changeArrayAtHiddenAddActionPlaned() {
        for (var i=0;i < arrayActionAction.length;i++) {
 
          $("#formAddActionPlaned").append("<input type=\'hidden\' name=\'idAction[]\' value='" +  arrayActionAction[i]  + "' class=\'form-control typeMood\'>");

            }
}






function changeArrayAtHiddenAddMood() {

    let array = document.querySelectorAll('input[name^="percentExe"]');

    for (var i=0;i < array.length;i++) {
        var id = $('input[name^="idActionss"]').eq(i).val();
        if (arrayAction.find(element => element == id )) {

          $("#formAddMood").append("<input type=\'hidden\' name=\'idAction[]\' value='" +  $('input[name^="idActionss"]').eq(i).val()  + "' class=\'form-control typeMood\'>");
          $("#formAddMood").append("<input type=\'hidden\' name=\'idActions[]\' value='" + $('input[name^="percentExe"]').eq(i).val() + "' class=\'form-control typeMood\'>");
          $("#formAddMood").append("<input type=\'hidden\' name=\'idActionMinute[]\' value='" + $('input[name^="minuteExe"]').eq(i).val() + "' class=\'form-control typeMood\'>");
        }

            }

}




function changeArrayAtHiddenAddMoodId(id) {
    //$("#formUpdateAction" + id).empty();
    let array = document.querySelectorAll("input[name^='percentExe" + id +  "']");
    
    for (var i=0;i < array.length;i++) {
        var idindex = $("input[name^='idActionss" + id + "']").eq(i).val();
        
        if (arrayActionMulti.find(element => element == idindex )) {
           
          $("#formUpdateAction2" + id).append("<input type=\'hidden\' name=\'idAction[]\' value='" +  $("input[name^='idActionss" + id + "']").eq(i).val()  + "' class=\'form-control typeMood\'>");
          $("#formUpdateAction2" + id).append("<input type=\'hidden\' name=\'idActions[]\' value='" + $("input[name^='percentExe" + id + "']").eq(i).val() + "' class=\'form-control typeMood\'>");
          $("#formUpdateAction2" + id).append("<input type=\'hidden\' name=\'idActionMinute[]\' value='" + $("input[name^='minute_exe" + id + "']").eq(i).val() + "' class=\'form-control typeMood\'>");
        }

}
}



function addActionDay(url) {
        $.ajax({
        url : url,
        method : "get",
        data : 
          $("#formAddAction").serialize()
        ,
        dataType : "html",
               beforeSend: function() { $('#buttonActionAdd').addClass("spinner-border"); },

        complete: function() { $('#buttonActionAdd').removeClass("spinner-border"); }
        })
        .done(function(response) {
            $("#formResultAction").html(response);
            if (response == "") {
                setInterval("reload();",50000);
                $("#formResultAction").html("<div class='ajaxSucces'>Pomyślnie dodano</div>");
            }

        })
        .fail(function() {
            $("#formResultAction").html( "<div class='ajaxError'>Wystąpił błąd</div>" );
        })
}


function addMood(url) {
//alert(url);

    changeArrayAtHiddenAddMood();
    $.ajax({
        url : url,
            method : "get",
            data : 
              $("#formAddMood").serialize()
            ,
            dataType : "html",
            beforeSend: function() { $('#buttonMoodAdd').addClass("spinner-border"); },

        complete: function() { $('#buttonMoodAdd').removeClass("spinner-border"); }
    })
    .done(function(response) {
        $("#formResult").html(response);
        if (response == "") {
            setInterval("reload();",50000);
            $("#formResult").html("<div class='ajaxSucces'>Pomyślnie dodano</div>");
        }
    

    })

    .fail(function() {
        $("#formResult").html( "<div class='ajaxError'>Wystąpił błąd</div>" );
    })
    
     $("#formAddMood").find(":hidden").filter(".typeMood").remove();
     $("#formAddMood").find(":hidden").filter(".typeMood").remove();
     
 
}

function addActionPlaned(url) {
        changeArrayAtHiddenAddActionPlaned();
    $.ajax({
        url : url,
            method : "get",
            data : 
              $("#formAddActionPlaned").serialize()
            ,
            dataType : "html",
            beforeSend: function() { $('#buttonActionAddPlaned').addClass("spinner-border"); },

        complete: function() { $('#buttonActionAddPlaned').removeClass("spinner-border"); }
    })
    .done(function(response) {
        $("#formResultActionPlaned").html(response);
        if (response == "") {
            setInterval("reload();",50000);
            $("#formResultActionPlaned").html("<div class='ajaxSucces'>Pomyślnie dodano</div>");
        }
    

    })

    .fail(function() {
        $("#formResultActionPlaned").html( "<div class='ajaxError'>Wystąpił błąd</div>" );
    })
    
     $("#formAddActionPlaned").find(":hidden").filter(".typeMood").remove();
     $("#formAddActionPlaned").find(":hidden").filter(".typeMood").remove();
}
function loadSesson() {
    loadMenuSession();
    loadMenuSessionShow();
}
function loadMenuSessionShow() {
    switch (sessionStorage.getItem('mainShow')) {
        case 'moodShow': 
            
            $("#showmood").css("display","block");
            $("#moodShowSelected").addClass("linkSelected");
            schitchMenuMoodShowDezactiveShow(['drugs',"action"]);
            sessionSetShow("moodShow");
            
            break;
        case 'drugsShow':
            $("#showdrugs").css("display","block");
            $("#drugsShowSelected").addClass("linkSelected");
            schitchMenuMoodShowDezactivedShow(['mood',"action"]);
            sessionSetShow("drugsShow");
            break;
        case 'actionShow':
            $("#showaction").css("display","block");
            $("#actionShowSelected").addClass("linkSelected");
            schitchMenuMoodShowDezactivedShow(['mood',"drugs"]);
            sessionSetShow("actionShow");
            break;
        
    }
}
function schitchMenuMoodShowDezactivedShow(type) {
    for (var i = 0;i < type.length;i++) {
        $("#show" + type[i]).css("display","none");
        $("#" + type[i] + "ShowSelected").removeClass("linkSelected");
    }  
}
function loadMenuSession() {
    switch (sessionStorage.getItem('main')) {
        case 'mood': 
            
            $("#mood").css("display","block");
            $("#moodSelected").addClass("moodSelected");
            schitchMenuMoodDezactived(['drugs',"action","sleep","actionPlaned"]);
            break;
        case 'drugs':
            $("#drugs").css("display","block");
            $("#drugsSelected").addClass("moodSelected");
            schitchMenuMoodDezactived(['mood',"action","sleep","actionPlaned"]);
            break;
        case 'sleep':
            $("#sleep").css("display","block");
            $("#sleepSelected").addClass("moodSelected");
            schitchMenuMoodDezactived(['mood',"action","drugs","actionPlaned"]);
            break;
        case 'action':
            $("#action").css("display","block");
            $("#actionSelected").addClass("moodSelected");
            schitchMenuMoodDezactived(['mood',"drugs","sleep","actionPlaned"]);
            break;
        case 'actionPlaned':
            $("#actionPlaned").css("display","block");
            $("#actionPlanedSelected").addClass("moodSelected");
            schitchMenuMoodDezactived(['mood',"drugs","sleep","action"]);
            break;
        
    }
}

function SwitchMenuMoodAdd(type) {
    switch(type) {
        case 'mood': 
            $("#mood").css("display","block");
            $("#moodSelected").addClass("moodSelected");
            schitchMenuMoodDezactived(['drugs',"action","sleep","actionPlaned"]);
            sessionSet("mood");
            break;
        case 'drugs':
            $("#drugs").css("display","block");
            $("#drugsSelected").addClass("moodSelected");
            schitchMenuMoodDezactived(['mood',"action","sleep","actionPlaned"]);
            sessionSet("drugs");
            break;
        case 'sleep':
            $("#sleep").css("display","block");
            $("#sleepSelected").addClass("moodSelected");
            schitchMenuMoodDezactived(['mood',"action","drugs","actionPlaned"]);
            sessionSet("sleep");
            break;
        case 'action':
            $("#action").css("display","block");
            $("#actionSelected").addClass("moodSelected");
            schitchMenuMoodDezactived(['mood',"drugs","sleep","actionPlaned"]);
            sessionSet("action");
            break;
        case 'actionPlaned':
            $("#actionPlaned").css("display","block");
            $("#actionPlanedSelected").addClass("moodSelected");
            schitchMenuMoodDezactived(['mood',"drugs","sleep","action"]);
            sessionSet("actionPlaned");
            break;
    }
}


function SwitchMenuMoodShow(type,bool = true) {
    switch(type) {
        case 'mood': 
            $("#showmood").css("display","block");
            $("#moodShowSelected").addClass("linkSelected");
            schitchMenuMoodShowDezactived(['drugs',"action"]);
            if (bool == true) {
                sessionSetShow("moodShow");
            }
            
            break;
        case 'drugs':
            $("#showdrugs").css("display","block");
            $("#drugsShowSelected").addClass("linkSelected");
            schitchMenuMoodShowDezactived(['mood',"action"]);
            if (bool == true) {
                sessionSetShow("drugsShow");
            }
            break;
        case 'action':
            $("#showaction").css("display","block");
            $("#actionShowSelected").addClass("linkSelected");
            schitchMenuMoodShowDezactived(['mood',"drugs"]);
            if (bool == true) {
                sessionSetShow("actionShow");
            }
            break;
    }    
}

function valueDose(int) {
    if ($("select[name='namePlaned']").val() != "") {
        $("input[name='dose']").val('1');
    }
    else {
       $("input[name='dose']").val('');
    }
    
}

function DisableDose() {
    if ($("select[name='namePlaned']").val() != "") {
        $("input[name='dose']").prop('disabled',true);
    }
    else {
        $("input[name='dose']").prop('disabled',false);
    }
}

function loadTypePortion(url) {

      if ($("select[name='nameProduct']").val() == "")  {
          $("#typePortion").html('');
          return;
      }
      
      
        $.ajax({
           url : url,
               method : "get",
               data : 
                 $("select[name='nameProduct']").serialize(),
               
               dataType : "html",
       })
       .done(function(response) {
           $("#typePortion").html(response);


       })
       .fail(function() {
           alert("Wystąpił błąd");
       })    
        
    
}

function schitchMenuMoodShowDezactived(type) {
    for (var i = 0;i < type.length;i++) {
        $("#show" + type[i]).css("display","none");
        $("#" + type[i] + "ShowSelected").removeClass("linkSelected");
    }    
}
function schitchMenuMoodDezactived(type) {
    for (var i = 0;i < type.length;i++) {
        $("#" + type[i]).css("display","none");
        $("#" + type[i] + "Selected").removeClass("moodSelected");
    }
}


function addSleep(url) {
    $.ajax({
        url : url,
            method : "get",
            data : 
              $("#formAddSleep").serialize()
            ,
            dataType : "html",
                           beforeSend: function() { $('#buttonSleepAdd').addClass("spinner-border"); },

        complete: function() { $('#buttonSleepAdd').removeClass("spinner-border"); }
    })
    .done(function(response) {
        $("#formResultSleep").html(response);
        if (response == "") {
            setInterval("reload();",50000);
            $("#formResultSleep").html("<div class='ajaxSucces'>Pomyślnie dodano</div>");
        }
    

    })
    .fail(function() {
        $("#formResultSleep").html( "<div class='ajaxError'>Wystąpił błąd</div>" );
    })
}


function atHourActonPlan(url,id) {
    $.ajax({
        url : url,
            method : "get",
            data : 
              "id=" + id
            ,
            dataType : "html",
    })
    .done(function(response) {
        $("#actionPlan" + id).html(response);
        
    

    })
    .fail(function() {
        $("#actionPlan" + id).html( "<div class='ajaxError'>Wystąpił błąd</div>" );
    })    
}



function addDrugs(url) {
    $.ajax({
    url : url,
        method : "get",
        data : 
          $("#formAddDrugs").serialize()
        ,
        dataType : "html",
                       beforeSend: function() { $('#buttonDrugsAdd').addClass("spinner-border"); },

        complete: function() { $('#buttonDrugsAdd').removeClass("spinner-border"); }
        })
        .done(function(response) {
            $("#formResultDrugs").html(response);
            if (response == "") {
                setInterval("reload();",50000);
                $("#formResultDrugs").html("<div class='ajaxSucces'>Pomyślnie dodano</div>");
            }

        })
        .fail(function() {
            $("#formResultDrugs").html( "<div class='ajaxError'>Wystąpił błąd</div>" );
        })
}


function editMood(id) {
    $(".showMenuMood" + id).css("display","none");
    $(".showMenuEditMood" + id).css("display","block");
}
function editDrugs(id) {
    $(".showMenuDrugs" + id).css("display","none");
    $(".showMenuEditDrugs" + id).css("display","block");
}
function editMoodSleep(id) {
    $(".showMenuMood" + id).css("display","none");
    $(".showMenuEditMood" + id).css("display","block");
}

function editMoodDescription(url,id) {
    if ($(".description" + id).css("display") == "none" ) {
        
        $.ajax({
                url : url,
                    method : "get",
                    data : 
                      "id=" + id
                    ,
                    dataType : "json",
            })
            .done(function(response) {




                  $(".description" + id).css("display","block");
                  $("#description" + id).html(response["what_work"]);



            })
            .fail(function() {
                alert("Wystąpił błąd");
            })    
    }
    else {
        
        $(".description" + id).css("display","none");
    }
}
function editSleepDescription(url,id) {

    if ($(".descriptionSleep" + id).css("display") == "none" ) {
        
        $.ajax({
                url : url,
                    method : "get",
                    data : 
                      "id=" + id
                    ,
                    dataType : "json",
            })
            .done(function(response) {




                  $(".descriptionSleep" + id).css("display","block");
                  $("#descriptionSleep" + id).html(response["what_work"]);


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })    
    }
    else {
        
        $(".descriptionSleep" + id).css("display","none");
    }
}
function nl2br (str, replaceMode, isXhtml) {

  var breakTag = (isXhtml) ? '<br>' : '<br>';
  var replaceStr = (replaceMode) ? '$1'+ breakTag : '$1'+ breakTag +'$2';
  return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, replaceStr);
}


function showDescritionMood(url,id) {
    if ($(".descriptionShowMood" + id).css("display") == "none" ) {
            $.ajax({
                url : url,
                    method : "get",
                    data : 
                      "id=" + id 
                    ,
                    dataType : "html",
            })
            .done(function(response) {
                //alert(response);
                $(".descriptionShowMood" + id).css("display","block");
                $("#messageDescriptionshowMood"+id).html(response);

                 



            })
            .fail(function() {
                alert("Wystąpił błąd");
            })       
    }
    else {
        
        $(".descriptionShowMood" + id).css("display","none");
    }
}

function showDescritionSleep(url,id) {
    if ($(".descriptionShowSleep" + id).css("display") == "none" ) {
            $.ajax({
                url : url,
                    method : "get",
                    data : 
                      "id=" + id 
                    ,
                    dataType : "html",
            })
            .done(function(response) {
                //alert(response);
                $(".descriptionShowSleep" + id).css("display","block");
                $("#messageDescriptionshowSleep"+id).html(response);

                 


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })       
    }
    else {
        
        $(".descriptionShowSleep" + id).css("display","none");
    }    
}


function updateDescription(url,id) {

            $.ajax({
                url : url,
                    method : "get",
                    data : 
                      "id=" + id + "&description=" + nl2br($("#description"+id).val(),"<br>","\n")
                    ,
                    dataType : "html",
            })
            .done(function(response) {


        if (response == "") {
            $("#messageDescription"+id).html("<div class='ajaxSucces'>Pomyślnie dodano</div>");
        }
                 


            })
            .fail(function() {
                $("#messageDescription"+id).html( "<div class='ajaxError'>Wystąpił błąd</div>" );
            })    
}


function cancel(id) {
    $(".showMenuMood" + id).css("display","block");
    $(".showMenuEditMood" + id).css("display","none");
}
function cancelDrugs(id) {
    $(".showMenuDrugs" + id).css("display","block");
    $(".showMenuEditDrugs" + id).css("display","none");
}
function reload() {
    location.reload();
    //deleteArray();
}


function resetSession() {
    sessionStorage.removeItem('main');
    sessionStorage.removeItem('mainShow');
}



function updateMood(url,id) {
     
        if ($("#levelMoodEdit"+id).val() == "" || ($("#levelMoodEdit"+id).val() > 20 || $("#levelMoodEdit"+id).val() < -20) || isNaN($("#levelMoodEdit"+id).val()) ) {
            alert("Zła wartość nastroju musi być od -20 do +20");
            return;
        }
        if ($("#levelAnxietyEdit"+id).val() == "" || ($("#levelAnxietyEdit"+id).val() > 20 || $("#levelAnxietyEdit"+id).val() < -20) || isNaN($("#levelAnxietyEdit"+id).val()) ) {
            alert("Zła wartość lęku musi być od -20 do +20");
            return;
        }
        if ($("#levelNervousnessEdit"+id).val() == "" || ($("#levelNervousnessEdit"+id).val() > 20 || $("#levelNervousnessEdit"+id).val() < -20) || isNaN($("#levelNervousnessEdit"+id).val()) ) {
            alert("Zła wartość rozdrażnienia musi być od -20 do +20");
            return;
        }
        if ($("#levelStimulationEdit"+id).val() == "" || ($("#levelStimulationEdit"+id).val() > 20 || $("#levelStimulationEdit"+id).val() < -20) || isNaN($("#levelStimulationEdit"+id).val()) ) {
            alert("Zła wartość pobudzenia musi być od -20 do +20");
            return;
        }
        if ( !isInt($("#levelEpizodesEdit"+id).val())  || ($("#levelEpizodesEdit"+id).val()) < 0 ) {
            alert("Liczba epizodów psychotycznych musi być dodatnią liczbą całkowitą");
            return;
        }

            $.ajax({
           url : url,
               method : "get",
               data : 
                 "id=" + id + "&levelMood=" + $("#levelMoodEdit"+id).val() + "&levelAnxienty="  + $("#levelAnxietyEdit"+id).val() + "&levelNervousness="  + $("#levelNervousnessEdit"+id).val() + "&levelStimulation="  + $("#levelStimulationEdit"+id).val() + "&levelEpizodes="  + $("#levelEpizodesEdit"+id).val()
               ,
               dataType : "json",
       })
       .done(function(response) {
           $("#levelMood"+id).text(response["level_mood"]);
           $("#levelAnxiety"+id).text(response["level_anxiety"]);
           $("#levelNervousness"+id).text(response["level_nervousness"]);
           $("#levelStimulation"+id).text(response["level_stimulation"]);
           
           if (response["epizodes_psychotik"] > 0 ) {
               $("#levelEpizodes"+id).addClass("MessageError");
               $("#levelEpizodes"+id).text(response["epizodes_psychotik"] + " epizodów psychotycznych");
           }
           else {

               $("#levelEpizodes"+id).removeClass("MessageError");
               $("#levelEpizodes"+id).text(" Brak");
           }

           
           
           $(".showMenuMood" + id).css("display","block");
           $(".showMenuEditMood" + id).css("display","none");


       })
       .fail(function() {
           alert("Wystąpił błąd");
       })    
    
}
function updateDrugs(url,id) {
 
        if ($("#doseEdit"+id).val() == "" || isNaN($("#doseEdit"+id).val()) || ($("#doseEdit"+id).val()) < 0  ) {
            alert("Dawka musi być dodatnią liczbą");
            return;
        }
        



            $.ajax({
           url : url,
               method : "get",
               data : 
                 "id=" + id + "&doseEdit=" + $("#doseEdit"+id).val() + "&idProduct="  + $("#nameProductEdit"+id).val() + "&date="  + $("#dateDrugsEdit"+id).val() + "&time="  + $("#timeDrugsEdit"+id).val() 
               ,
               dataType : "json",
       })
       .done(function(response) {
           if (response["errorDate"] == true) {
                alert("Błędna data");
           }
           $("#nameDrugs"+id).text(response["name"]);
           $("#doseDrugs"+id).text(response["portion"] + " " + response["type"]);
           $("#dateDrugs"+id).text(response["date"]);
           $("#percentDrugs"+id).text(response["price"] + " zł");


           
           $(".showMenuDrugs" + id).css("display","block");
           $(".showMenuEditDrugs" + id).css("display","none");


       })
       .fail(function() {
           alert("Wystąpił błąd");
       })    
 
}
function updateSleep(url,id) {

        if ( !isInt($("#levelEpizodesEdit"+id).val())  || ($("#levelEpizodesEdit"+id).val()) < 0 ) {
            alert("Liczba epizodów psychotycznych musi być dodatnią liczbą całkowitą");
            return;
        }

            $.ajax({
           url : url,
               method : "get",
               data : 
                 "id=" + id +  "&levelEpizodes="  + $("#levelEpizodesEdit"+id).val()
               ,
               dataType : "json",
       })
       .done(function(response) {
           
           if (response["epizodes_psychotik"] > 0 ) {
               $("#levelEpizodes"+id).addClass("MessageError");
               $("#levelEpizodes"+id).text(response["epizodes_psychotik"] + " wybudzeń");
           }
           else {
               
               $("#levelEpizodes"+id).removeClass("MessageError");
               $("#levelEpizodes"+id).text(" Brak");
           }
          
           
           $(".showMenuMood" + id).css("display","block");
           $(".showMenuEditMood" + id).css("display","none");


       })
       .fail(function() {
           alert("Wystąpił błąd");
       })    
}

function isInt(value) {
  return !isNaN(value) && 
         parseInt(Number(value)) == value && 
         !isNaN(parseInt(value, 10));
}
function deleteActionDay(url,id) {
    var bool = confirm("Czy na pewno");
    if (bool == true) {
        

            $.ajax({
           url : url,
               method : "get",
               data : 
                 "id=" + id
               ,
               dataType : "html",
       })
       .done(function(response) {
           
           $("#tractionId" + id).remove();


       })
       .fail(function() {
           alert("Wystąpił błąd");
       })    
    }
}



function editActionDay(url,id,idAction) {
        $.ajax({
           url : url,
               method : "get",
               data : 
                 "id=" + id
               ,
               dataType : "json",
       })
       .done(function(response) {



           var arrayFormStart = "<select name='formActionEditDay" + id + "' class='form-control' id='select-state'>";
           var arrayForm = "";
           for (var i=0;i < response.length;i++) {
               
               

               
               
               if (response[i]["id"] == idAction) {
                   arrayForm += "<option value='" + response[i]["id"] + "' selected >" + response[i]["name"] + "</option>";
                
               }
               else {
                   arrayForm += "<option value='" + response[i]["id"] + "'  >" + response[i]["name"] + "</option>";
                   
               }
             
           }
             arrayFormEnd = "</select>";
             $("#cancelActionDayButton"+id).css("display","block");
             $("#updateActionDayButton"+id).css("display","block");
             $("#editActionDayButton"+id).css("display","none");
             $("#deleteActionDayButton"+id).css("display","none");
             
            $("#editActionDay" + id).html(arrayFormStart + arrayForm + arrayFormEnd);
           


       })
       .fail(function() {
           alert("Wystąpił błąd");
       })    
}

function cancelActionDay(url,id) {
    
    
    
     $.ajax({
           url : url,
               method : "get",
               data : 
                 "id=" + id
               ,
               dataType : "json",
       })
       .done(function(response) {



             $("#cancelActionDayButton"+id).css("display","none");
             $("#updateActionDayButton"+id).css("display","none");
             $("#editActionDayButton"+id).css("display","block");
             $("#deleteActionDayButton"+id).css("display","block");
             
            $("#editActionDay" + id).html(response["name"]);
           


       })
       .fail(function() {
           alert("Wystąpił błąd");
       })    
    
    
             
}
function updateActionDay(url,id) {

         $.ajax({
           url : url,
               method : "get",
               data : 
                 "id=" +   id + "&idAction=" + $("[name='formActionEditDay" + id + "']").val() 
                
               ,
               dataType : "html",
       })
       .done(function(response) {



             $("#cancelActionDayButton"+id).css("display","none");
             $("#updateActionDayButton"+id).css("display","none");
             $("#editActionDayButton"+id).css("display","block");
             $("#deleteActionDayButton"+id).css("display","block");
             
            $("#editActionDay" + id).html(response);
           


       })
       .fail(function() {
           alert("Wystąpił błąd");
       })    
}

function showAction(url,id) {
        if ($(".actionShow" + id).css("display") == "none" ) {
            $.ajax({
                url : url,
                    method : "get",
                    data : 
                      "id=" + id 
                    ,
                    dataType : "html",
            })
            .done(function(response) {
                $(".actionShow" + id).css("display","block");
                $("#messageactionShow"+id).html(response);



            })
            .fail(function() {
                alert("Wystąpił błąd");
            })       
    }
    else {
        
        $(".actionShow" + id).css("display","none");
    }
}



function showDescriptionDrugs(url,id) {

        if ($(".descriptionShowDrugs" + id).css("display") == "none" ) {
            $.ajax({
                url : url,
                    method : "get",
                    data : 
                      "id=" + id 
                    ,
                    dataType : "html",
            })
            .done(function(response) {
                $(".descriptionShowDrugs" + id).css("display","block");
                $("#messageDescriptionshowDrugs"+id).html(response);


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })       
    }
    else {
        
        $(".descriptionShowDrugs" + id).css("display","none");
    }      
}


function showDrugs(url,id) {
        if ($(".drugsShow" + id).css("display") == "none" ) {
            $.ajax({
                url : url,
                    method : "get",
                    data : 
                      "id=" + id 
                    ,
                    dataType : "html",

            })
            .done(function(response) {
                $(".drugsShow" + id).css("display","block");
                $("#messagedrugsShow"+id).html(response);


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })       
    }
    else {
        
        $(".drugsShow" + id).css("display","none");
    }  
}


function editActionMood(url,id) {

        if ($(".actionMoodShow" + id).css("display") == "none" ) {
            $.ajax({
                url : url,
                    method : "get",
                    data : 
                      "id=" + id 
                    ,
                    dataType : "html",
            })
            .done(function(response) {
                $(".actionMoodShow" + id).css("display","block");
                $("#messageactionMoodShow"+id).html(response);



            })
            .fail(function() {
                alert("Wystąpił błąd");
            })       
    }
    else {
        
        $(".actionMoodShow" + id).css("display","none");
    }  
}

function addDescriptionDrugsSubmit(url,id) {

            $.ajax({
                url : url,
                    method : "get",
                    data : 
                      $("#descriptionDrugsForm"+id).serialize()
                    ,
                    dataType : "html",
            })
            .done(function(response) {
                $("#messageDescriptionAddDrugs"+id).html(response);

                 
   
    

            });      
}

function addDescriptionDrugs(id) {
    
         if ($(".descriptionDrugs" + id).css("display") == "none" ) {
                $(".descriptionDrugs" + id).css("display","block");



 
    }
    else {
        
        $(".descriptionDrugs" + id).css("display","none");
    }    
}

function sessionSet(type) {
    
    
    
    sessionStorage.setItem('main', type);
}
function sessionSetShow(type) {

    sessionStorage.setItem('mainShow', type);
}


function showAverage(id,url) {
    if ($(".showAverage" + id).css("display") == "none" ) {
           $.ajax({
                url : url,
                    method : "get",
                    data : 
                      "id=" + id 
                    ,
                    dataType : "html",
            })
            .done(function(response) {
                $(".showAverage" + id).css("display","block");
                $("#messageDescriptionshowAverage"+id).html(response);



            })
            .fail(function() {
                alert("Wystąpił błąd");
            })     
    }
    else {
        
        $(".showAverage" + id).css("display","none");
    } 
}

function loadAverage(url,id) {
         $.ajax({
                url : url,
                    method : "get",
                    data : 
                      "id=" + id + "&averageType=" + $("#averageType" + id).val() + "&hourFrom=" + $("#hourFrom" + id).val() + "&hourTo=" + $("#hourTo" + id).val()
                    ,
                    dataType : "html",
            })
            .done(function(response) {
            
                $("#sumAverage"+id).html(response);



            })
            .fail(function() {
                alert("Wystąpił błąd");
            })    
}