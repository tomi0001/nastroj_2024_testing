/*
 * copyright 2022 Tomasz Leszczyński tomi0001@gmail.com
 */
/*
$(document).ready(function(){
        var array = [];


//
//          $arrayList->appends(['sort'=>Request::get('sort')])
//                        ->appends(['moodFrom'=>Request::get("moodFrom")])
//                        ->appends(['moodTo'=>Request::get("moodTo")])
//                        ->appends(['anxietyFrom'=>Request::get("anxietyFrom")])
//                        ->appends(['anxietyTo'=>Request::get("anxietyTo")])
//                        ->appends(['voltageFrom'=>Request::get("voltageFrom")])
//                        ->appends(['voltageTo'=>Request::get("voltageTo")])
//                        ->appends(['stimulationFrom'=>Request::get("stimulationFrom")])
//                        ->appends(['stimulationTo'=>Request::get("stimulationTo")])
//                        ->appends(['dateFrom'=>Request::get("dateFrom")])
//                        ->appends(['dateTo'=>Request::get("dateTo")])
//                        ->appends(['timeFrom'=>Request::get("timeFrom")])
//                        ->appends(['timeTo'=>Request::get("timeTo")])
//                        ->appends(['longMoodFromHour'=>Request::get("longMoodFromHour")])
//                        ->appends(['longMoodFromMinutes'=>Request::get("longMoodFromMinutes")])
//                        ->appends(['longMoodToHour'=>Request::get("longMoodToHour")])
//                        ->appends(['longMoodToMinutes'=>Request::get("longMoodToMinutes")])
//                        ->appends(["actions" => Request::get("actions")])
//                        ->appends(["actionsNumberFrom" => Request::get("actionsNumberFrom")])
//                        ->appends(["actionsNumberTo" => Request::get("actionsNumberTo")])
//                        ->appends(["descriptions" => Request::get("descriptions")])
//                        ->appends(['epizodesFrom'=>Request::get("epizodesFrom")])
//                        ->appends(['epizodesTo'=>Request::get("epizodesTo")])
//                        ->appends(['ifDescriptions'=>Request::get("ifDescriptions")])
//                        ->appends(['ifactions'=>Request::get("ifactions")])


        $(".pagination a").click( function(event) {
            event.preventDefault();

               $.ajax({
                url : urlArray[0] + "?page=" + $(this).attr('href').split("page=")[1]
                        + "&moodFrom=" + $(this).attr('href').split("moodFrom=")[1]
                        + "&sort=" + $(this).attr('href').split("sort=")[1] +
                        "&moodTo=" +  $(this).attr('href').split("moodTo=")[1] +
                        "&anxietyFrom=" +  $(this).attr('href').split("anxietyFrom=")[1]+
                        "&anxietyTo=" +  $(this).attr('href').split("anxietyTo=")[1]+
                        "&voltageFrom=" +  $(this).attr('href').split("voltageFrom=")[1]+
                        "&voltageTo=" +  $(this).attr('href').split("voltageTo=")[1] +
                        "&stimulationFrom=" +  $(this).attr('href').split("stimulationFrom=")[1] +
                        "&stimulationTo=" +  $(this).attr('href').split("stimulationTo=")[1]+
                        "&dateFrom=" +  $(this).attr('href').split("dateFrom=")[1] +
                        "&dateTo=" +  $(this).attr('href').split("dateTo=")[1] +
                        "&timeFrom=" +  $(this).attr('href').split("timeFrom=")[1] +
                        "&timeTo=" +  $(this).attr('href').split("timeTo=")[1] +
                        "&longMoodFromHour=" +  $(this).attr('href').split("longMoodFromHour=")[1] +
                        "&longMoodFromMinutes=" +  $(this).attr('href').split("longMoodFromMinutes=")[1] +
                        "&longMoodHourTo=" +  $(this).attr('href').split("longMoodHourTo=")[1] +
                        "&longMoodToMinutes=" +  $(this).attr('href').split("longMoodToMinutes=")[1] +
                        "&action=" +  $(this).attr('href').split("action=")[1] +
                        "&actionsNumberFrom=" +  $(this).attr('href').split("actionsNumberFrom=")[1] +
                        "&actionsNumberTo=" +  $(this).attr('href').split("actionsNumberTo=")[1] +
                        "&descriptions=" +  $(this).attr('href').split("descriptions=")[1] +
                        "&epizodesFrom=" +  $(this).attr('href').split("epizodesFrom=")[1] +
                        "&epizodesTo=" +  $(this).attr('href').split("epizodesTo=")[1] +
                        "&ifDescriptions=" +  $(this).attr('href').split("ifDescriptions=")[1] +
                        "&ifactions=" +  $(this).attr('href').split("ifactions=")[1] +
                        "&sort2=" +  $(this).attr('href').split("sort2=")[1]

                        ,
                    method : "get",

                    dataType : "html",
            })
            .done(function(response) {




                  //$("#addNewAction").css("display","block");
                  $("#ajaxData").html(response);


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })
            //alert(moodFrom);
            //fetch_data(array);

        });

});


function fetch_data(page) {

}



 **/



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





function showDayMood(url,date) {

    if ($("#dayMood" + date).css("display") == "none" ) {

            $.ajax({
                url : url,
                    method : "get",
                    data :
                      "date=" + date
                    ,
                    dataType : "html",

            })
            .done(function(response) {

                $("#dayMood" + date).css("display","block");
                $("#dayMood" + date).html(response);


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })
    }
    else {

        $("#dayMood" + date).css("display","none");
    }
}


function showDaySubstance(url,date) {

    if ($("#daySubstance" + date).css("display") == "none" ) {

            $.ajax({
                url : url,
                    method : "get",
                    data :
                      "date=" + date
                    ,
                    dataType : "html",

            })
            .done(function(response) {

                $("#daySubstance" + date).css("display","block");
                $("#daySubstance" + date).html(response);


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })
    }
    else {

        $("#daySubstance" + date).css("display","none");
    }
}


function showDayAction(url,date) {
    if ($("#dayAction" + date).css("display") == "none" ) {

            $.ajax({
                url : url,
                    method : "get",
                    data :
                      "date=" + date
                    ,
                    dataType : "html",

            })
            .done(function(response) {

                $("#dayAction" + date).css("display","block");
                $("#dayAction" + date).html(response);


            })
            .fail(function() {
                alert("Wystąpił błąd");
            })
    }
    else {

        $("#dayAction" + date).css("display","none");
    }
}



function loadPageMood() {
      $(".titleSettingsMood").addClass("selectedMenu");
      $(".titleSettingsDrugs").removeClass("selectedMenu");
      $(".MenuPageMood").css("display","block");
      $(".MenuPageDrugs").css("display","none");

      $(".pagePageDrugs").css("display","none");
}
function loadPageDrugs() {
      $(".titleSettingsMood").removeClass("selectedMenu");
      $(".titleSettingsDrugs").addClass("selectedMenu");
      $(".MenuPageMood").css("display","none");
      $(".MenuPageDrugs").css("display","block");

      $(".pagePageMood").css("display","none");


}
function selectMenuMood(menu) {
    $("#" + menu).addClass("selectedMenuMoodHref");

}

function unSelectMenuMood(menu) {
    $("#" + menu).removeClass("selectedMenuMoodHref");
}


function searchMood() {
    sessionStorage.setItem('searchType', "searchMood");
    if ($("#searchMoodDiv").css("display") == "none" ) {
        $("#searchMoodDiv").css("display","block");
        $("#averageMoodSumDiv").css("display","none");
        $("#sumActionDayDiv").css("display","none");
        $("#searchSleepDiv").css("display","none");
        $("#differenceDrugsSleepDiv").css("display","none");
    }
    else {

        $("#searchMoodDiv").css("display","none");
    }
}
function searchSleep() {
    sessionStorage.setItem('searchType', "searchSleep");
    if ($("#searchSleepDiv").css("display") == "none" ) {
        $("#searchSleepDiv").css("display","block");
        $("#averageMoodSumDiv").css("display","none");
        $("#sumActionDayDiv").css("display","none");
        $("#searchMoodDiv").css("display","none");
        $("#sumMoodDayDiv").css("display","none");
        $("#differenceDrugsSleepDiv").css("display","none");
    }
    else {

        $("#searchMoodDiv").css("display","none");
    }
}
function averageMoodSum() {
    sessionStorage.setItem('searchType', "averageMoodSum");
    if ($("#averageMoodSumDiv").css("display") == "none" ) {
        $("#averageMoodSumDiv").css("display","block");
        $("#searchMoodDiv").css("display","none");
        $("#sumActionDayDiv").css("display","none");
        $("#searchSleepDiv").css("display","none");
        $("#differenceDrugsSleepDiv").css("display","none");
        //$("#changeNameActionChange").css("display","none");
        //$("#changeDateActionChange").css("display","none");

    }
    else {

        $("#averageMoodSumDiv").css("display","none");
    }
}


function sumActionDay() {
    sessionStorage.setItem('searchType', "sumActionDay");
    if ($("#sumActionDayDiv").css("display") == "none" ) {
        $("#sumActionDayDiv").css("display","block");
        $("#searchMoodDiv").css("display","none");
        $("#averageMoodSumDiv").css("display","none");
        $("#searchSleepDiv").css("display","none");
        $("#differenceDrugsSleepDiv").css("display","none");
        //$("#changeNameActionChange").css("display","none");
        //$("#changeDateActionChange").css("display","none");

    }
    else {

        $("#sumActionDayDiv").css("display","none");
    }    
}

function searchDrugs() {
    sessionStorage.setItem('searchType', "searchDrugs");
    if ($("#searchDrugsDiv").css("display") == "none" ) {
        $("#searchDrugsDiv").css("display","block");
        $("#searchDrugsMoodDiv").css("display","none");


    }
    else {

        $("#searchDrugsDiv").css("display","none");
    }
}

function addFieldWhatWork() {
    $("#idWhatWork").append($("#idWhatWorkCopy").html());
}
function addFieldAction() {
    $("#idAction").append($("#idActionCopy").html());
}
function addFieldDrugsMood() {
    $("#idProductMood").append($("#idProductMoodCopy").html());
}
function addFieldActionDay() {
    //$("#idActionDay").append($("#idActionDayCopy").html());
}

function addFieldnameProduct() {
    $("#idNameProduct").append($("#idNameProductCopy").html());
}
function addFieldnameSubstance() {
    $("#idNameSubstance").append($("#idNameSubstanceCopy").html());
}
function addFieldnameSubstanceMood() {
    $("#idNameSubstanceMood").append($("#idNameSubstanceMoodCopy").html());
}
function addFieldnameGroup() {
    $("#idNameGroup").append($("#idNameGroupCopy").html());
}
function addFieldnameGroupMood() {
    $("#idNameGroupMood").append($("#idNameGroupMoodCopy").html());
}
$(document).ready(function() { //wywołanie funkcji po załadowaniu całej strony
	$("#addNewAction").click(function() {
            //alert('ddd');
            $("#idActionDay").append($("#idActionDayCopy").html());
		//var test = $(this).val(); //przypisanie do zmiennej test wartości pola radio
		//$("div.desc").hide(); //ukrycie wszystkich elementów div klasy .desc
		//$("#"+test).show(); //wyświetlenie konkretnego elementu div dla danego "radio"
	}); 
}); // koniec funkcji ready


function setFunction() {
    selectMenu();
    switch (sessionStorage.getItem('searchType')) {

        case 'searchMood': searchMood();
            break;
        case 'searchDrugs': searchDrugs();
            break;
        case 'averageMoodSum': averageMoodSum();
            break;
        case 'sumActionDay': sumActionDay();
            break;
        case 'searchSleep': searchSleep();
            break;
        case 'searchDrugsMood': searchDrugsMood();
            break;
        case 'differenceDrugsSleep': differenceDrugsSleep();
            break;
    }
}

$(document).ready(function(){

        $(".mainHref").click( function() {

            resetSession();
        });

});
function resetSession() {
    sessionStorage.removeItem('searchType');
}
function selectMenu() {
    if (sessionStorage.getItem('searchType') == 'searchMood' || sessionStorage.getItem('searchType') == 'averageMoodSum'  || sessionStorage.getItem('searchType') == 'sumActionDay' || sessionStorage.getItem('searchType') == 'searchSleep'  || sessionStorage.getItem('searchType') == 'differenceDrugsSleep') {
        loadPageMood();
    }
    else if (sessionStorage.getItem('searchType') == 'searchDrugs' || sessionStorage.getItem('searchType') == 'searchDrugsMood') {
        loadPageDrugs();
    }
    /*
    if (sessionStorage.getItem('searchType') == 'addNewGroup' ||  sessionStorage.getItem('settingType') == 'addNewSubstance' || sessionStorage.getItem('settingType') == 'addNewProduct' || sessionStorage.getItem('settingType') == 'editGroupSet' || sessionStorage.getItem('settingType') == 'editSubstanceSet' || sessionStorage.getItem('settingType') == 'editProductSet' || sessionStorage.getItem('settingType') == 'planedDose' ) {
        loadPageDrugs();
    }
     *
     */
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



function averageMoodSumSubmit(url) {

    $.ajax({
        url : url,
        method : "get",
        data :
            $("#averageSumForm").serialize()
        ,
        dataType : "html",
    })
        .done(function(response) {
            $("#averageSumDiv").css("display","block");
            //$("#messageactionShow"+id).html(response);
            $(".ajaxError").empty();

            $("#averageSumDiv").prepend(response);

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
/*
 * Update may 2023 
 */
function searchDrugsMood() {
    sessionStorage.setItem('searchType', "searchDrugsMood");
    if ($("#searchDrugsMoodDiv").css("display") == "none" ) {
        $("#searchDrugsMoodDiv").css("display","block");
        $("#searchDrugsDiv").css("display","none");


    }
    else {

        $("#searchDrugsMoodDiv").css("display","none");
    }
}

function searchDrugsMoodSubmit(url) {

    $.ajax({
        url : url,
        method : "get",
        data :
            $("#searchDrugsMoodFrom").serialize()
        ,
        dataType : "html",
    })
        .done(function(response) {
            $("#searchDrugsMoodDiv2").css("display","block");
            //$("#messageactionShow"+id).html(response);
            $(".ajaxError").empty();

            $("#searchDrugsMoodDiv2").prepend(response);

        })
        .fail(function() {
            alert("Wystąpił błąd");
        })

}

/*
 * update june 2023 
 */
function differenceDrugsSleep() {
    sessionStorage.setItem('searchType', "differenceDrugsSleep");
    if ($("#differenceDrugsSleepDiv").css("display") == "none" ) {
        $("#differenceDrugsSleepDiv").css("display","block");
        $("#searchMoodDiv").css("display","none");
        $("#averageMoodSumDiv").css("display","none");
        $("#searchSleepDiv").css("display","none");
        $("#sumActionDayDiv").css("display","none");
        //$("#changeNameActionChange").css("display","none");
        //$("#changeDateActionChange").css("display","none");

    }
    else {

        $("#differenceDrugsSleepDiv").css("display","none");
    } 
}