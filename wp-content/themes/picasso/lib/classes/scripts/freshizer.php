<?php
/**
 * FRESHIZER 
 * =========
 * 
 * Image resizing class, 100% working in all cases at all servers
 * 
 * @author freshface
 * @version 1.21
 * @link http://www.freshface.net
 * @link http://github.com/boobslover/freshizer
 * @license GNU version 2
 */

class fImg {
// #############################################################################################################################################
// ## EDIT THIS
// #############################################################################################################################################
/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/
/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/	
	private static function customUserSettings() {
		// caching interval -> basically tells when the image is expiring
		self::$caching_interval = 86400; // [seconds] = 24 hr
		// enable / disable caching
		self::$enable_caching = true; 	// is caching enabled ?
		// If you leave null, it will automatically use freshizer directory in wp-content/uploads
		// but if you dont want to use this plugin with wordpress, just specify the directory path here
		//self::$upload_dir['basedir'] = /yourserver/documentroot/domain/data/image_store;
		//self::$upload_dir['baseurl'] = http://www.domain.com/data/image_store;
		self::$upload_dir = null;
		
	}
/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/
// #############################################################################################################################################
// ## VARIABLES AND CONSTANTS
// #############################################################################################################################################
	protected static $caching_interval = 86400;				// [seconds] 86400 sec = 24hr
	protected static $enable_caching = true;				// allow caching	
		
	protected static $upload_dir = null;					// upload directory, here we store all resized images
// #############################################################################################################################################
// ## INITIALIZATION
// #############################################################################################################################################		
	/**
	 * Initialization of all functions for proper work of this class
	 */
	public static function init() {
		self::customUserSettings();							// load custom user settings
		self::getUploadDir();								// load upload directory ( WP or script url )
		self::createDir();									// create that directory
	} 	
	
	/**
	 * Get upload dir, if has been not defined. If we are in wordpress, then use the wp-content directory. If not, use script path and url
	 */
	private static function getUploadDir() {
		if( self::$upload_dir == null && function_exists('wp_upload_dir') ) {
			self::$upload_dir = wp_upload_dir();
			self::$upload_dir['basedir'] .= '/freshizer';
			self::$upload_dir['baseurl'] .='/freshizer';		
		} else if ( self::$upload_dir == null && !function_exists('wp_upload_dir') ) {
			$script_dir = realpath(dirname(__FILE__));
			$script_url = 'http://'.$_SERVER['SERVER_NAME'] . str_replace(realpath($_SERVER['DOCUMENT_ROOT']), '', $script_dir);
			self::$upload_dir['basedir'] = $script_dir.'/freshizer';
			self::$upload_dir['baseurl'] = $script_url.'/freshizer';
		}	
	}
	
// #############################################################################################################################################
// ## RESIZING
// #############################################################################################################################################
	/**
	 * Resize image and save it to the upload directory
	 * @param string url Link to the source image
	 * @param int width Wanted width
	 * @param int height Wanted height
	 * @param int crop Do we want crop ( fixed height )
	 * 
	 * @return string Resized Image url
	 */
	public static function resize( $url, $width, $height = false, $crop = false) {
		$img_old_relative_path = self::getRelativePath( $url );			// here we get relative path to better resizing 
		$img_old_size = self::getImageSize( $img_old_relative_path );	// get image size returned in array
		
		if( $img_old_size == false ) {
			echo 'Image does not exists';
			return false;
		}
		
		$dim = self::calculateNewDimensions($img_old_size['width'], $img_old_size['height'], $width, $height, $crop);		// calculate new dimensions
		$img_new_hash = self::getImgHash( $img_old_relative_path, $img_old_size);											// get image hash for unique identification
 		$img_new_path = self::getNewImagePath($img_old_relative_path, $img_new_hash, $dim['dst']['w'], $dim['dst']['h']);	// create new img path ( in upload dir)
		$img_new_url =  self::getNewImageUrl($img_old_relative_path, $img_new_hash, $dim['dst']['w'], $dim['dst']['h']);	// create new img url
		
		// if the image does not exists ( == it's not cached ) then create it
		if( !file_exists( $img_new_path ) ) {
			self::resizeImage($img_old_relative_path, $img_new_path, $dim);
		}
		return $img_new_url;
	}
	
	/** 
	 * Image resizing, the core. This function load the original image, resize it and save as a new iamge
	 * @param string $img_old_path Path to the old image
	 * @param string $img_new_path Path to the new image
	 * @param array  $dimensions   Dimensions of the old and new images
	 */
	protected static function resizeImage( $img_old_path, $img_new_path, $dimensions ) {
		// load image and in case of failure echo error and return
		$img_old = self::loadImage( $img_old_path );			
		if( !is_resource($img_old) ) {
			echo 'Error loading image';
			return false;
		}
		
		$img_new = self::createImage( $dimensions['dst']['w'], $dimensions['dst']['h']);	// create new true color image
		
		// copy original image to new one
		imagecopyresampled($img_new, $img_old, $dimensions['dst']['x'], $dimensions['dst']['y'], $dimensions['src']['x'], $dimensions['src']['y'], $dimensions['dst']['w'], $dimensions['dst']['h'], $dimensions['src']['w'], $dimensions['src']['h']);
		// save the image
		self::saveImage($img_new, $img_new_path);
		// destroi the images
		imagedestroy($img_new);
		imagedestroy($img_old);
		
	}
// #############################################################################################################################################
// ## IMAGE DIMENSIONS - TAKEN OVER FROM WORDPRESS CORE
// #############################################################################################################################################	
	/**
	 * Taken Over from Wordpress Core. This function calculates the best dimension, if we want to crop or not.
	 */
	protected static function calculateNewDimensions($orig_w, $orig_h, $dest_w, $dest_h, $crop = false) {
		
	    if ( $crop ) {
	    	
	        // crop the largest possible portion of the original image that we can size to $dest_w x $dest_h
	        $aspect_ratio = $orig_w / $orig_h;
	        $new_w =$dest_w;// min($dest_w, $orig_w);
	        $new_h =$dest_h;// min($dest_h, $orig_h);
	
	        if ( !$new_w ) {
	            $new_w = intval($new_h * $aspect_ratio);
	        }
	
	        if ( !$new_h ) {
	            $new_h = intval($new_w / $aspect_ratio);
	        }
	
	        $size_ratio = max($new_w / $orig_w, $new_h / $orig_h);
	
	        $crop_w = round($new_w / $size_ratio);
	        $crop_h = round($new_h / $size_ratio);
	
	        $s_x = floor( ($orig_w - $crop_w) / 2 );
	        $s_y = floor( ($orig_h - $crop_h) / 2 );
	    } else {
	        // don't crop, just resize using $dest_w x $dest_h as a maximum bounding box
	        $crop_w = $orig_w;
	        $crop_h = $orig_h;
	
	        $s_x = 0;
	        $s_y = 0;
	
		
	        list( $new_w, $new_h ) = self::constrainNewDimensions( $orig_w, $orig_h, $dest_w, $dest_h );
	    }
	    $to_return = array();
		$to_return['src']['x'] = (int)$s_x;
		$to_return['src']['y'] = (int)$s_y;
		$to_return['src']['w'] = (int)$crop_w;
		$to_return['src']['h'] = (int)$crop_h;
		
		$to_return['dst']['x'] = 0;
		$to_return['dst']['y'] = 0;
		$to_return['dst']['w'] = (int)$new_w;
		$to_return['dst']['h'] = (int)$new_h;		
	    
		return $to_return;
	}

	/**
	 * This function has been take over from wordpress core. It calculate the best proportion to uncropped image
	 */
	protected static function constrainNewDimensions( $current_width, $current_height, $max_width=0, $max_height=0 ) {
		
	    if ( !$max_width and !$max_height )
	        return array( $current_width, $current_height );
	
	    $width_ratio = $height_ratio = 1.0;
	    $did_width = $did_height = false;
	
	    if ( $max_width > 0 && $current_width > 0 ) 
	    {
	        $width_ratio = $max_width / $current_width;
	        $did_width = true;
	    }
	
	    if ( $max_height > 0 && $current_height > 0 ) 
	    {
	        $height_ratio = $max_height / $current_height;
	        $did_height = true;
	    }
	
	    // Calculate the larger/smaller ratios
	    $smaller_ratio = min( $width_ratio, $height_ratio );
	    $larger_ratio  = max( $width_ratio, $height_ratio );
	
	    if ( intval( $current_width * $larger_ratio ) > $max_width || intval( $current_height * $larger_ratio ) > $max_height )
	         // The larger ratio is too big. It would result in an overflow.
	        $ratio = $smaller_ratio;
	    else
	        // The larger ratio fits, and is likely to be a more "snug" fit.
	        $ratio = $larger_ratio;
	
	    $w = intval( $current_width  * $ratio );
	    $h = intval( $current_height * $ratio );
	
	    // Sometimes, due to rounding, we'll end up with a result like this: 465x700 in a 177x177 box is 117x176... a pixel short
	    // We also have issues with recursive calls resulting in an ever-changing result. Constraining to the result of a constraint should yield the original result.
	    // Thus we look for dimensions that are one pixel shy of the max value and bump them up
	    if ( $did_width && $w == $max_width - 1 )
	        $w = $max_width; // Round it up
	    if ( $did_height && $h == $max_height - 1 )
	        $h = $max_height; // Round it up
	
	    return array( $w, $h );
	}

	/**
	 * Get Image size, if the image does not exists, return false
	 * 
	 * @param string Relative path to the image
	 * @return bool / string When fail false, other image dimensions
	 */
	protected static function getImageSize( $relative_image_path ) {
		// does the file exists ? If no, return false
		if( !file_exists($relative_image_path) ) {
			return false;
		}
		
		// get image sizes
		$image_size = getimagesize($relative_image_path);
		$image["path"] = $relative_image_path;
		$image['width'] = $image_size[0];
		$image['height'] = $image_size[1];
		
		return $image;
	}	
// #############################################################################################################################################
// ## IMAGE LOADING AND SAVING
// #############################################################################################################################################		
	/**
	 * Decide which image type it is and load it -> TAKEN OVER FROM WORDPRESS
	 * 
	 * @param string path Path to the image
	 * @return resource Image Resource ID
	 */
	protected static function loadImage( $file ) {
		   if ( is_numeric( $file ) )
		        $file = get_attached_file( $file );
		
		    if ( ! file_exists( $file ) )
		        return false;
		
		    if ( ! function_exists('imagecreatefromstring') )
		        return false;
		
		    // Set artificially high because GD uses uncompressed images in memory
		    @ini_set( 'memory_limit', '256M' );
		    $image = imagecreatefromstring( file_get_contents( $file ) );
		
		    if ( !is_resource( $image ) )
		        return false;
		
		    return $image;		
	}	
	/**
	 * Create image truecolor -> TAKEN OVER FROM WORDPRESS
	 */
	protected static function createImage ($width, $height) {
		$img = imagecreatetruecolor($width, $height);
    	if ( is_resource($img) && function_exists('imagealphablending') && function_exists('imagesavealpha') ) {
        	imagealphablending($img, false);
        	imagesavealpha($img, true);
    	}
    	return $img;
	}
	
	/**
	 * Decide which image type it is and save it
	 * 
	 * @param resource $image Image resource
	 * @param string $path Path to the image
	 */
	protected static function saveImage( $image, $path ) {
		$pinfo = pathinfo( $path );
		$ext = $pinfo['extension'];
		$return = null;
		
		switch( $ext ) {
			case 'jpg':
				$return = imagejpeg($image, $path );
				break;
			case 'jpeg':
				$return = imagejpeg($image, $path );
				break;	
			case 'png':
				$return = imagepng( $image, $path );
				break;
			
			case 'gif':
				$return = imagegif( $image, $path );
				break;
		}		

		return $return;
		
	}	
// #############################################################################################################################################
// ## PATH HUSTLE
// #############################################################################################################################################	
	/**
	 * Get relative image path, important for PHP opening functions
	 * @param string Url = image url
	 * @return string Relative Image Path;
	 */
	protected static function getRelativePath( $url ) {
		// WP MU settings - decide if its multisite or not
		global $blog_id;
		if (isset($blog_id) && $blog_id > 0 && defined('WP_ALLOW_MULTISITE') && is_multisite() ) {
			$start_url = network_site_url();
			// if we are resizing theme parts, we need one type of url
			if( strpos($url, '/themes/') !== false ) {
				$url_cleaned = str_replace( site_url() .'/', $start_url, $url);
				$url = $url_cleaned;

			}
			// if we are resizing images in upload dir, we need another type of url
			else {
				$imageParts = explode('/files/', $url);
				if (isset($imageParts[1])) {
					$theImageSrc = 'wp-content/blogs.dir/' . $blog_id . '/files/' . $imageParts[1];
				}
				
				$url = $start_url.$theImageSrc;
			}
		}
		// if its relative path, then return it 
		if( strpos($url, $_SERVER['HTTP_HOST']) === false  ) return $url;
		
		// then return real path
		$rel_path = str_replace( $_SERVER['HTTP_HOST'], $_SERVER['DOCUMENT_ROOT'], $url);
		$rel_path = str_replace( 'http://','', $rel_path);
	
		return $rel_path;
		 
	}	
	/** 
	 * Get simple hash created from first and last letters from each folder of the image location - for unique identify every image
	 * 
	 * @return int Hash
	 */
	protected static function getImgHash( $path, $img_size ) {
		$file_size = filesize( $path );
		$hash = $file_size + $img_size['width'] + $img_size['height'];
		return $hash;
	}
	
	/**
	 * Get new image absolute path ( with hash, prefix and other ) to check if the image already exists.
	 * 
	 * @param string $url Url pointing to the image
	 * @param string $hash Hash from custom hashing function
	 * @param int $width Width of the image
	 * @param int $height Height of the image
	 * 
	 * @return string
	 */
	protected static function getNewImagePath ( $url, $hash, $width, $height ) {
		$filename = self::getNewImageName($url, $hash, $width, $height);
		$filepath = self::$upload_dir['basedir']."/{$filename}";
		return $filepath;
	}	
	
	/**
	 * Get new image name ( with hash, prefix and other ) to check if the image already exists.
	 * 
	 * @param string $url Url pointing to the image
	 * @param string $hash Hash from custom hashing function
	 * @param int $width Width of the image
	 * @param int $height Height of the image
	 * 
	 * @return string
	 */	
	protected static function getNewImageName( $url, $hash, $width, $height ) {
		$pinfo = pathinfo( $url );
		
		$filename = $pinfo['filename'];
		$ext = $pinfo['extension'];
		$hash .= '-';

		$suffix = "{$width}x{$height}";
		
		$filepath = "{$hash}{$filename}-{$suffix}.{$ext}";
		return $filepath;
	}
	
	protected static function getNewImageUrl( $path, $hash, $width, $height ) {
		$new_img_name = self::getNewImageName( $path, $hash, $width,$height);
		return( self::$upload_dir['baseurl'] .'/'. $new_img_name );		
	}	
// #############################################################################################################################################
// ## CACHE & DIRECTORY MANAGING
// #############################################################################################################################################	
	/**
	 * Check if upload directory exists, if not, create it. Then load the directories into local variables
	 */
	protected static function createDir() {

		// if this directory does not exists, create it;
		if( !is_dir(self::$upload_dir['basedir']))
			mkdir( self::$upload_dir['basedir']);
	}
	
	/**
	 * List all the images in the cache folder, and delete the expired images.
	 */
	public static function deleteCache() {
		if( self::$enable_caching == false ) return;
		// default timeout is one day :)
		$timeout = self::$caching_interval;
				
		// get all images in the folder and delete the expired images :)		
		$list_of_images = self::readCacheFolder();
		foreach($list_of_images as $one_image ) {
			if ( getimagesize( $one_image['path']) === false )	continue;
			
			$expiring_time = $one_image['time'] + $timeout;
			// we have to delete this shit :)
			if( $expiring_time < time() ) {
				unlink( $one_image['path'] );
			}
		}

	}
	
	/**
	 * Go through the whole img store folder and read all files.
	 */
	protected static function readCacheFolder() {
		$list_of_elements = array();				// we will be returning this
		$path = self::$upload_dir['basedir'] . '/';
		// go through all elements in the folder and store them in the array
		if ( is_dir( $path ) ) {		
		    if ( $dh = opendir( $path ) ) {
		        while ( ( $file = readdir($dh) ) !== false) {
		        	if( $file == '.' || $file == '..')	continue;

		        	$filetype = filetype( $path . $file );
					if( $filetype == 'file' ) {
						// store info about element into array, so we dont need to call filetype function again
						$one_element = array( 'path' => $path.$file, 'type' => $filetype, 'time'=>filemtime($path.$file) );
						$list_of_elements[] = $one_element;
					}
					
		        		
				}
		        closedir($dh);
		    }
		}
		// sort the array A-Z
		sort($list_of_elements);
		// return sorted array
		return $list_of_elements;
	}
}
fImg::init();
// #############################################################################################################################################
// ## WRAPPERS
// #############################################################################################################################################
function fs_resize( $url, $width, $height, $crop = false ) {
	fImg::resize($url, $width, $height, $crop);
}
function fs_cleancache() {
	fImg::clearCache();
}


