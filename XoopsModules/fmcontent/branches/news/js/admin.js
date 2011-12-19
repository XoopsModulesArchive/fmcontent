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
    $('input[id=story_title]').change(news_setAlias);
    $('input[id=story_title]').change(news_setWords);
    $('input[id=story_title]').change(news_setDesc);
    $('input[id=topic_title]').change(news_setTopicAlias);
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
function news_setStatus(data, img, file) {
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

function news_setDefault(data, img, file) {
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

function news_setImportant(data, img, file) {
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

function news_setAlias() {
    var text = $(this).val().toLowerCase();
    //alert($(this).id);
    $.post('ajax.php', { type:'filter', value:text },
            function(reponse, textStatus) {
                if (textStatus == 'success') {
                    $('input[id^=story_alias]').val(reponse);
                }
            });

}

function news_setTopicAlias() {
    var text = $(this).val().toLowerCase();
    //alert($(this).id);
    $.post('ajax.php', { type:'filter', value:text },
            function(reponse, textStatus) {
                if (textStatus == 'success') {
                    $('input[id^=topic_alias]').val(reponse);
                }
            });

}

function news_setMenu() {
    var text = $(this).val();
    //alert($(this).id);
    $.post('ajax.php', { type:'menu', value:text },
            function(reponse, textStatus) {
                if (textStatus == 'success') {
                    $('input[id^=story_menu]').val(reponse);
                }
            });

}

function news_setWords() {
    var text = $(this).val().toLowerCase();
    //alert($(this).id);
    $.post('ajax.php', { type:'words', value:text },
            function(reponse, textStatus) {
                if (textStatus == 'success') {
                    $('textarea[id^=story_words]').val(reponse);
                }
            });

}

function news_setDesc() {
    var text = $(this).val().toLowerCase();
    //alert($(this).id);
    $.post('ajax.php', { type:'desc', value:text },
            function(reponse, textStatus) {
                if (textStatus == 'success') {
                    $('textarea[id^=story_desc]').val(reponse);
                }
            });

}

function news_setAsmenu(data, img, file) {
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

function news_setOnline(data, img, file) {
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

function news_setShow(data, img, file) {
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

function news_setFileOnline(data, img, file) {
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