<?php

class Hoosk_page_model extends CI_Model {

  protected $hooskDB;

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->hooskDB = $this->load->database('hoosk', TRUE);
    }


	/*     * *************************** */
    /*     * ** Page Querys ************ */
    /*     * *************************** */
	/*function getSiteName() {
        // Get Theme
        $this->hooskDB->select("*");
       	$this->hooskDB->where("siteID", 0);
		$query = $this->hooskDB->get('hoosk_settings');
        if ($query->num_rows() > 0) {
            $results = $query->result_array();
        	foreach ($results as $u):
				return $u['siteTitle'];
			endforeach;
		}
        return array();
    }

	function getTheme() {
        // Get Theme
        $this->hooskDB->select("*");
       	$this->hooskDB->where("siteID", 0);
		$query = $this->hooskDB->get('hoosk_settings');
        if ($query->num_rows() > 0) {
            $results = $query->result_array();
        	foreach ($results as $u):
				return $u['siteTheme'];
			endforeach;
		}
        return array();
    }*/

    function getPage($pageURL) {
        // Get page
        $this->hooskDB->select("*");
        $this->hooskDB->join('hoosk_page_content', 'hoosk_page_content.pageID = hoosk_page_attributes.pageID');
        $this->hooskDB->join('hoosk_page_meta', 'hoosk_page_meta.pageID = hoosk_page_attributes.pageID');
		$this->hooskDB->where("pagePublished", 1);
		$this->hooskDB->where("pageURL", $pageURL);
        $query = $this->hooskDB->get('hoosk_page_attributes');
        if ($query->num_rows() > 0) {
            $results = $query->result_array();
        	foreach ($results as $u):
				$page = array(
	   	   				'pageID'    			=> $u['pageID'],
	   	   				'pageTitle' 			=> $u['pageTitle'],
						'pageKeywords' 			=> $u['pageKeywords'],
						'pageDescription' 		=> $u['pageDescription'],
	   	   				'pageContentHTML'   	=> $u['pageContentHTML'],
						'pageTemplate'    		=> $u['pageTemplate'],
						'enableJumbotron'   	=> $u['enableJumbotron'],
						'enableSlider'   		=> $u['enableSlider'],
						'jumbotronHTML'    		=> $u['jumbotronHTML'],
                     );
			endforeach;
			return $page;

		}
        return array('pageID' => "",'pageTemplate' => "");
    }
	function getCategory($catSlug) {
        // Get category
        $this->hooskDB->select("*");
		$this->hooskDB->where("categorySlug", $catSlug);
        $query = $this->hooskDB->get('hoosk_post_category');
        if ($query->num_rows() > 0) {
            $results = $query->result_array();
        	foreach ($results as $u):
				$category = array(
	   	   				'pageID'    			=> $u['categoryID'],
						'categoryID'    		=> $u['categoryID'],
	   	   				'pageTitle' 			=> $u['categoryTitle'],
						'pageKeywords' 			=> '',
						'pageDescription' 		=> $u['categoryDescription'],
                     );
			endforeach;
			return $category;

		}
        return array('categoryID' => "");
    }

	function getArticle($postURL) {
        // Get article
        $this->hooskDB->select("*");
		$this->hooskDB->where("postURL", $postURL);
        $this->hooskDB->where("published", 1);
        $this->hooskDB->join('hoosk_post_category', 'hoosk_post_category.categoryID = hoosk_post.categoryID');
        $query = $this->hooskDB->get('hoosk_post');
        if ($query->num_rows() > 0) {
            $results = $query->result_array();
        	foreach ($results as $u):
				$category = array(
	   	   				'pageID'    			=> $u['postID'],
						'postID'    			=> $u['postID'],
	   	   				'pageTitle' 			=> $u['postTitle'],
						'pageKeywords' 			=> '',
						'pageDescription' 		=> $u['postExcerpt'],
						'postContent' 			=> $u['postContentHTML'],
						'datePosted' 			=> $u['datePosted'],
						'categoryTitle' 		=> $u['categoryTitle'],
						'categorySlug' 			=> $u['categorySlug'],
                     );
			endforeach;
			return $category;

		}
        return array('postID' => "");
    }


   function getSettings() {
        // Get settings
        $this->hooskDB->select("*");
		$this->hooskDB->where("siteID", 0);
        $query = $this->hooskDB->get('hoosk_settings');
        //print_r($query->result()); die("end");
        if ($query->num_rows() > 0) {
            $results = $query->result_array();
        	foreach ($results as $u):
				$page = array(
						'siteLogo'    				=> $u['siteLogo'],
						'siteFavicon'    			=> $u['siteFavicon'],
						'siteTitle'    				=> $u['siteTitle'],
						'siteTheme'    				=> $u['siteTheme'],
						'siteFooter'    			=> $u['siteFooter'],
						'siteMaintenanceHeading'    => $u['siteMaintenanceHeading'],
						'siteMaintenanceMeta'	    => $u['siteMaintenanceMeta'],
						'siteMaintenanceContent'    => $u['siteMaintenanceContent'],
						'siteMaintenance'    		=> $u['siteMaintenance'],
						'siteAdditionalJS'    		=> $u['siteAdditionalJS'],
                     );
			endforeach;

			return $page;

		}
        return array();
    }

}

?>
