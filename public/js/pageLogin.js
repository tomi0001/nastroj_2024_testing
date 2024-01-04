/*
 * copyright 2022 Tomasz Leszczyński tomi0001@gmail.com
 */
function changeClassLoginUp(id) {
    //nameClass = $("#" + id).attr('class');

    $("#" + id).removeClass("menuMainColorUp").addClass("menuMainColorDown");
}
function changeClassLoginDown(id) {
    $("#" + id).removeClass("menuMainColorDown").addClass("menuMainColorUp");
}