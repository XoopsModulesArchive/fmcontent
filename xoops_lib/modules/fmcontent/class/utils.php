<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * FmContent page class
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Hossein Azizabadi (AKA Voltan)
 * @version     $Id:$
 */

class fmcontentUtils {

	function uploadimg($forMods, $type , $obj,$image) {
        include_once XOOPS_ROOT_PATH . "/class/uploader.php";
        $uploader_img = new XoopsMediaUploader(XOOPS_ROOT_PATH . xoops_getModuleOption('img_dir', $forMods->getVar('dirname')), xoops_getModuleOption('img_mime', $forMods->getVar('dirname')), xoops_getModuleOption('img_size', $forMods->getVar('dirname')), xoops_getModuleOption('img_maxwidth', $forMods->getVar('dirname')), xoops_getModuleOption('img_maxheight', $forMods->getVar('dirname')));
        if ($uploader_img->fetchMedia($type)) {
            $uploader_img->setPrefix($type.'_');
            $uploader_img->fetchMedia($type);
            if (!$uploader_img->upload()) {
                $errors = $uploader_img->getErrors();
                redirect_header("javascript:history.go(-1)", 3, $errors);
            } else {
                $obj->setVar($type, $uploader_img->getSavedFileName());
            }
        } else {
            if (isset($image)) {
                $obj->setVar($type, $image);
            }
        }	
	}	
	
	function deleteimg ($forMods , $type , $obj){
			if($obj->getVar($type)) {
				$currentPicture = XOOPS_ROOT_PATH.xoops_getModuleOption('img_dir', $forMods->getVar('dirname')).$obj->getVar($type);
				if(is_file($currentPicture) && file_exists($currentPicture)) {
					if(!unlink($currentPicture)) {
						trigger_error("Error, impossible to delete the picture attached to this article");
					}
				}
			}
			$obj->setVar($type, '');
	}	
	

}
?>