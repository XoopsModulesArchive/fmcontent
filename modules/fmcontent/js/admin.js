/**
 * Administration function
 *
 * LICENSE
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package     system
 * @version     $Id$
 */

$(document).ready(function() {
    $('input[id=content_title]').change(fmcontent_setAlias);
    $('input[id=content_title]').change(fmcontent_setMenu);
    $('input[id=content_title]').change(fmcontent_setWords);
    $('input[id=content_title]').change(fmcontent_setDesc);
    $('input[id=topic_title]').change(fmcontent_setTopicAlias);
});

/**
 * Change the status of an item (avatar, userrank, smilies) ajax post request
 *
 * @author   MusS
 *
 * @array   data    store of data
 * @string  img     id of image
 * @file    file    file to call
 */
function fmcontent_setStatus(data, img, file) {
    // Post request
    $.post(file, data,
            function(reponse, textStatus) {
                if (textStatus == 'success') {
                    // Change image src
                    if ($('img#' + img).attr("src") == "../images/icons/ok.png") {
                        $('img#' + img).attr("src", "../images/icons/cancel.png");
                    } else {
                        $('img#' + img).attr("src", "../images/icons/ok.png");
                    }
                }
            });
}

function fmcontent_setDefault(data, img, file) {
    // Post request
    $.post(file, data,
            function(reponse, textStatus) {
                if (textStatus == 'success') {
                    $('.xo-defaultimg').attr("src", "../images/icons/cancel.png");
                    // Change image src
                    if ($('img#' + img).attr("src") == "../images/icons/ok.png") {
                        $('img#' + img).attr("src", "../images/icons/cancel.png");
                    } else {
                        $('img#' + img).attr("src", "../images/icons/ok.png");
                    }
                }
            });
}

function fmcontent_setDisplay(data, img, file) {
    // Post request
    $.post(file, data,
            function(reponse, textStatus) {
                if (textStatus == 'success') {
                    // Change image src
                    if ($('img#' + img).attr("src") == "../images/icons/ok.png") {
                        $('img#' + img).attr("src", "../images/icons/cancel.png");
                    } else {
                        $('img#' + img).attr("src", "../images/icons/ok.png");
                    }
                }
            });
}

function fmcontent_setAlias() {
    var text = $(this).val().toLowerCase();
    //alert($(this).id);
    $.post('ajax.php', { type:'filter', value:text },
            function(reponse, textStatus) {
                if (textStatus == 'success') {
                    $('input[id^=content_alias]').val(reponse);
                }
            });

}

function fmcontent_setTopicAlias() {
    var text = $(this).val().toLowerCase();
    //alert($(this).id);
    $.post('ajax.php', { type:'filter', value:text },
            function(reponse, textStatus) {
                if (textStatus == 'success') {
                    $('input[id^=topic_alias]').val(reponse);
                }
            });

}

function fmcontent_setMenu() {
    var text = $(this).val();
    //alert($(this).id);
    $.post('ajax.php', { type:'menu', value:text },
            function(reponse, textStatus) {
                if (textStatus == 'success') {
                    $('input[id^=content_menu]').val(reponse);
                }
            });

}

function fmcontent_setWords() {
    var text = $(this).val().toLowerCase();
    //alert($(this).id);
    $.post('ajax.php', { type:'words', value:text },
            function(reponse, textStatus) {
                if (textStatus == 'success') {
                    $('textarea[id^=content_words]').val(reponse);
                }
            });

}

function fmcontent_setDesc() {
    var text = $(this).val().toLowerCase();
    //alert($(this).id);
    $.post('ajax.php', { type:'desc', value:text },
            function(reponse, textStatus) {
                if (textStatus == 'success') {
                    $('textarea[id^=content_desc]').val(reponse);
                }
            });

}

function fmcontent_setAsmenu(data, img, file) {
    // Post request
    $.post(file, data,
            function(reponse, textStatus) {
                if (textStatus == 'success') {
                    // Change image src
                    if ($('img#' + img).attr("src") == "../images/icons/ok.png") {
                        $('img#' + img).attr("src", "../images/icons/cancel.png");
                    } else {
                        $('img#' + img).attr("src", "../images/icons/ok.png");
                    }
                }
            });
}

function fmcontent_setOnline(data, img, file) {
    // Post request
    $.post(file, data,
            function(reponse, textStatus) {
                if (textStatus == 'success') {
                    // Change image src
                    if ($('img#' + img).attr("src") == "../images/icons/ok.png") {
                        $('img#' + img).attr("src", "../images/icons/cancel.png");
                    } else {
                        $('img#' + img).attr("src", "../images/icons/ok.png");
                    }
                }
            });
}

function fmcontent_setShow(data, img, file) {
    // Post request
    $.post(file, data,
            function(reponse, textStatus) {
                if (textStatus == 'success') {
                    // Change image src
                    if ($('img#' + img).attr("src") == "../images/icons/ok.png") {
                        $('img#' + img).attr("src", "../images/icons/cancel.png");
                    } else {
                        $('img#' + img).attr("src", "../images/icons/ok.png");
                    }
                }
            });
}

function display_dialog(id, bgiframe, modal, hide, show, height, width) {
    $(document).ready(function() {
        $("#dialog" + id).dialog({
            bgiframe: bgiframe,
            modal: modal,
            hide: hide,
            show: show,
            height: height,
            width: width,
            autoOpen: false
        });
        $("#dialog" + id).dialog("open");
    });
}