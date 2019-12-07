<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File:    ~/application/controller/Admin_new.php
 *
 * This is an admin panel controller.
 * @package		Skearch
 * @author		Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright	Copyright (c) 2018
 * @version		2.0
 */
class Categories extends MY_Controller {

	public function __construct() {
		parent::__construct();

		if (!$this->ion_auth->is_admin())
		{
			// redirect them to the login page
			redirect('admin/auth/login', 'refresh');
		}

    $this->load->model('admin_panel/Category_model_admin', 'categoryModel');

	}

	public function get_category_list($status = NULL) {

		$categories = $this->categoryModel->get_categories(NULL, "ASC", $status);
    $total_categories = sizeof($categories);
		$result = array(
										'iTotalRecords' => $total_categories,
										'iTotalDisplayRecords' => $total_categories,
										'sEcho' => 0,
										'sColumns' => "",
										'aaData' => $categories
							);
	for($i = 0; $i < sizeof($result['aaData']); $i++) {
		$subcategories = $this->categoryModel->get_subcategories($result['aaData'][$i]->id);
		$result['aaData'][$i]->totalFields = sizeof($subcategories) ;
	}
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($result));
	}

	public function category_list($status = NULL) {

		if ( ! file_exists(APPPATH.'/views/admin_panel/pages/categories/category_list.php')) {
			show_404();
		}

		$data['title'] = ucfirst("Umbrella Page list");
    $data['subTitle'] = ucfirst("Showing All");
		$data['status'] = $status;

		// Load page content
		$this->load->view('admin_panel/pages/categories/category_list', $data);
	}

	public function get_subcategory_list($categoryid = NULL, $status = NULL) {

	$subcategories = $this->categoryModel->get_subcategories($categoryid, NULL, "ASC", $status);
    $total_subcategories = sizeof($subcategories);

    $result = array(
										'iTotalRecords' => $total_subcategories,
										'iTotalDisplayRecords' => $total_subcategories,
										'sEcho' => 0,
										'sColumns' => "",
										'aaData' => $subcategories
							);

	  for($i = 0; $i < sizeof($result['aaData']); $i++) {
			 	$listings = $this->categoryModel->get_result_listing($result['aaData'][$i]->id);
		 	 	$result['aaData'][$i]->totalResults = sizeof($listings) ;
		}

		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($result));
	}

	public function subcategory_list($categoryid = NULL, $status = NULL) {

    if ( ! file_exists(APPPATH.'/views/admin_panel/pages/categories/subcategory_list.php')) {
			show_404();
		}

    if($categoryid != NULL && is_numeric($categoryid)) {
        $catTitle = $this->categoryModel->get_single_category($categoryid)[0]->title;
		    $data['subTitle'] = ucfirst("Fields under \"".$catTitle."\"");
    } else $data['subTitle'] = ucfirst("Fields List");

    $data['title'] = ucfirst("Field list");
		$data['categoryid'] = $categoryid;
		$data['status'] = $status;
		$this->load->view('admin_panel/pages/categories/subcategory_list', $data);

	}

	public function get_result_list($subcategoryid, $status = NULL) {

		$listings = $this->categoryModel->get_result_listing($subcategoryid, NULL, "ASC", $status);
		$total_listings = sizeof($listings);

			$result = array(
											'iTotalRecords' => $total_listings,
											'iTotalDisplayRecords' => $total_listings,
											'sEcho' => 0,
											'sColumns' => "",
											'aaData' => $listings
								);

			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
  }

  public function result_list($subcategoryid = "all", $status = NULL) {

    if ( ! file_exists(APPPATH.'/views/admin_panel/pages/categories/result_list.php')) {
			show_404();
        }

    $data['title'] = ucfirst("Ad Links List");
    $data['subcategoryid'] = $subcategoryid;
		$data['status'] = $status;

    if($subcategoryid != "all") {
				$subCatTitle = $this->categoryModel->get_single_subcategory($subcategoryid)[0]->title;
        $data['subTitle'] = ucfirst("Ad Links under \"".$subCatTitle."\"");
        $this->load->view('admin_panel/pages/categories/result_list_sub', $data);
    } elseif ($subcategoryid == "all" && ($status == 'active' || $status == 'inactive' )) {
				$this->load->view('admin_panel/pages/categories/result_list', $data);
		} else {
        $data['subTitle'] = ucfirst("Ad Links List");
        $this->load->view('admin_panel/pages/categories/search_ad_links', $data);
    }
  }

	public function search_adlink($title = NULL) {

			$listings = $this->categoryModel->search_adlink($title);
			$total_listings = sizeof($listings);

					$result = array(
																					'iTotalRecords' => $total_listings,
																					'iTotalDisplayRecords' => $total_listings,
																					'sEcho' => 0,
																					'sColumns' => "",
																					'aaData' => $listings
															);

					$this->output
					->set_content_type('application/json')
					->set_output(json_encode($result));
	}

  public function delete_category($id) {

    $this->categoryModel->delete_category($id);

  }

	public function delete_subcategory($id) {

    $this->categoryModel->delete_subcategory($id);

  }

  public function delete_result_listing($id) {

    $this->categoryModel->delete_result_listing($id);

  }


  public function create_category() {

		if ( ! file_exists(APPPATH.'/views/admin_panel/pages/categories/create_category.php')) {
			show_404();
        }

        $this->form_validation->set_rules('title', 'Title', 'required|alpha_numeric_spaces');
        $this->form_validation->set_rules('description', 'Description', 'max_length[500]');
        $this->form_validation->set_rules('description_short', 'Short Description', 'required|max_length[140]');
        $this->form_validation->set_rules('umbrella_name', 'Umbrella Name', 'alpha_numeric_spaces');
        $this->form_validation->set_rules('home_display', 'Home Display', 'alpha_numeric_spaces');
        $this->form_validation->set_rules('keywords', 'Keywords', 'required');
        $this->form_validation->set_rules('featured', 'Featured', 'required|numeric');
        $this->form_validation->set_rules('enabled', 'Enabled', 'required|numeric');


		if ($this->form_validation->run() == true) {

			$data = $this->input->post(NULL, TRUE);
			$this->categoryModel->create_category($data['title'], $data['enabled'], $data['umbrella_name'], $data['home_display'],
			    $data['description_short'], $data['description'], $data['keywords'], $data['featured']);

			// Clear all the input field
			$this->form_validation->clear_field_data();

			// Display success flash message
            $this->session->set_tempdata('success-msg', '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="alert-icon">
                        <p class="flaticon-like"> Success:</p>
                            Umbrella has been successfully added to the database.
                    </div>
                </div>
           ', 1);
        }

        $data['title'] = ucfirst("Add New Umbrella");
		$this->load->view('admin_panel/pages/categories/create_category', $data);

  }

	public function create_subcategory() {

		if ( ! file_exists(APPPATH.'/views/admin_panel/pages/categories/create_subcategory.php')) {
			show_404();
        }

        $this->form_validation->set_rules('title', 'Title', 'required|alpha_numeric_spaces');
        $this->form_validation->set_rules('description', 'Description', 'max_length[500]');
        $this->form_validation->set_rules('description_short', 'Short Description', 'required|max_length[140]');
        $this->form_validation->set_rules('parent_id', 'Umbrella Page', 'required');
        $this->form_validation->set_rules('home_display', 'Home Display', 'alpha_numeric_spaces');
        $this->form_validation->set_rules('keywords', 'Keywords', 'required');
        $this->form_validation->set_rules('featured', 'Featured', 'required|numeric');
        $this->form_validation->set_rules('enabled', 'Enabled', 'required|numeric');

		if ($this->form_validation->run() == true) {
            $data = $this->input->post(NULL, TRUE);
			$this->categoryModel->create_subcategory($data['title'], $data['enabled'], $data['home_display'], $data['description_short'],
		        $data['description'], $data['keywords'], $data['featured'], $data['parent_id']);

			// Clear all the input field
			$this->form_validation->clear_field_data();

			// Display success flash message
			$this->session->set_tempdata('success-msg', '
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-icon">
						<p class="flaticon-like"> Success:</p>
							Field has been successfully added to the database.
					</div>
				</div>
		', 1);
        }

        $data['title'] = ucfirst("Add New Field");
        $data['category_list'] = $this->categoryModel->get_categories();
        $this->load->view('admin_panel/pages/categories/create_subcategory', $data);

  }

	public function create_result() {

		if ( ! file_exists(APPPATH.'/views/admin_panel/pages/categories/create_result.php')) {
			show_404();
        }

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('description_short', 'Short Description', 'required|max_length[140]');
        $this->form_validation->set_rules('sub_id', 'Field', 'required|numeric');
        $this->form_validation->set_rules('priority', 'Priority', 'required|numeric');
        $this->form_validation->set_rules('display_url', 'Home Display');
        $this->form_validation->set_rules('www', 'WWW', 'required|valid_url');
        $this->form_validation->set_rules('enabled', 'Enabled', 'required|numeric');
        $this->form_validation->set_rules('redirect', 'Redirect', 'required|numeric');

		if ($this->form_validation->run() == true) {
			$data = $this->input->post(NULL, TRUE);
			$this->categoryModel->create_result_listing($data['title'], $data['enabled'], $data['description_short'], $data['display_url'], $data['www'], $data['sub_id'], $data['priority'], $data['redirect']);

			// Clear all the input field
			$this->form_validation->clear_field_data();
			
			// Display success flash message
            $this->session->set_tempdata('success-msg', '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="alert-icon">
                        <p class="flaticon-like"> Success:</p>
                            AdLink has been successfully added to the database.
                    </div>
                </div>
            ', 1);
		}

        $data['title'] = ucfirst("Add New Result");
        $data['subcategory_list'] = $this->categoryModel->get_subcategories();

		$prioritiesObject = $this->categoryModel->get_links_priority($data['subcategory_list'][0]->id);
		$priorities = array();
		foreach ($prioritiesObject as $item) {
			array_push($priorities, $item->priority);
		}

		$data['priorities'] = $priorities;

    $this->load->view('admin_panel/pages/categories/create_result', $data);

  }

	public function update_category($id) {

		if ( ! file_exists(APPPATH.'/views/admin_panel/pages/categories/edit_category.php')) {
			show_404();
		}

		$this->form_validation->set_rules('title', 'Title', 'required|alpha_numeric_spaces');
        $this->form_validation->set_rules('description', 'Description', 'max_length[500]');
        $this->form_validation->set_rules('description_short', 'Short Description', 'required|max_length[140]');
        $this->form_validation->set_rules('umbrella_name', 'Umbrella Name', 'alpha_numeric_spaces');
        $this->form_validation->set_rules('home_display', 'Home Display', 'alpha_numeric_spaces');
        $this->form_validation->set_rules('keywords', 'Keywords', 'required');
        $this->form_validation->set_rules('featured', 'Featured', 'required|numeric');
        $this->form_validation->set_rules('enabled', 'Enabled', 'required|numeric');


		if($this->form_validation->run() == true) {
			$data = $this->input->post(NULL, TRUE);

			$this->categoryModel->update_category($id, $data['title'], $data['enabled'], $data['umbrella_name'], $data['home_display'],
			$data['description_short'], $data['description'], $data['keywords'], $data['featured']);

			$this->session->set_tempdata('success-msg', '
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<div class="alert-icon">
							<p class="flaticon-like"> Success:</p>
								Umbrella has been updated successfully.
						</div>
					</div>
			', 1);
		}

    	$data['title'] = ucfirst("Edit Umbrella");
		$data['category'] = $this->categoryModel->get_single_category($id);
		$this->load->view('admin_panel/pages/categories/edit_category', $data);

  }

  public function update_subcategory($id) {

		if ( ! file_exists(APPPATH.'/views/admin_panel/pages/categories/edit_subcategory.php')) {
			show_404();
		}

		$this->form_validation->set_rules('title', 'Title', 'required|alpha_numeric_spaces');
        $this->form_validation->set_rules('description', 'Description', 'max_length[500]');
        $this->form_validation->set_rules('description_short', 'Short Description', 'required|max_length[140]');
        $this->form_validation->set_rules('parent_id', 'Umbrella Page', 'required');
        $this->form_validation->set_rules('home_display', 'Home Display', 'alpha_numeric_spaces');
        $this->form_validation->set_rules('keywords', 'Keywords', 'required');
        $this->form_validation->set_rules('featured', 'Featured', 'required|numeric');
		$this->form_validation->set_rules('enabled', 'Enabled', 'required|numeric');
		
		if($this->form_validation->run() == true) {
			$data = $this->input->post(NULL, TRUE);

			$this->categoryModel->update_subcategory($id, $data['title'], $data['enabled'], $data['home_display'], $data['description_short'],
		  $data['description'], $data['keywords'], $data['featured'], $data['parent_id']);

			// Display success flash message
            $this->session->set_tempdata('success-msg', '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="alert-icon">
                        <p class="flaticon-like"> Success:</p>
                            Field has been updated successfully.
                    </div>
                </div>
		   ', 1);
		}

    $data['title'] = ucfirst("Edit Field");
    $data['subcategory'] =  $this->categoryModel->get_single_subcategory($id)[0];
        // $data['subcategory'] = $subcategory['data'][0];
		// $data['subcategory_parent'] = array();
		// foreach ($subcategory['parent'] as $item) {
		// 	array_push($data['subcategory_parent'], $item->cat_id);
		// }
	$data['category_list'] = $this->categoryModel->get_categories();
    $this->load->view('admin_panel/pages/categories/create_subcategory', $data);

  }

  public function update_result($id) {

		if ( ! file_exists(APPPATH.'/views/admin_panel/pages/categories/edit_result.php')) {
			show_404();
		}

		$this->form_validation->set_rules('title', 'Title', 'required|alpha_numeric_spaces');
        $this->form_validation->set_rules('description_short', 'Short Description', 'required|max_length[140]');
        $this->form_validation->set_rules('sub_id', 'Field', 'required|numeric');
        $this->form_validation->set_rules('priority', 'Priority', 'required|numeric');
        $this->form_validation->set_rules('display_url', 'Home Display', 'alpha_numeric_spaces');
        $this->form_validation->set_rules('www', 'WWW', 'required|valid_url');
        $this->form_validation->set_rules('enabled', 'Enabled', 'required|numeric');
        $this->form_validation->set_rules('redirect', 'Redirect', 'required|numeric');

		if($this->input->server('REQUEST_METHOD') == 'POST') {
			$data = $this->input->post(NULL, TRUE);

			$this->categoryModel->update_result_listing($id, $data['title'], $data['enabled'], $data['description_short'], $data['display_url'], $data['www'], $data['sub_id'], $data['priority'], $data['redirect']);

			$this->session->set_tempdata('success-msg', '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="alert-icon">
                        <p class="flaticon-like"> Success:</p>
                            AdLink has been successfully added to the database.
                    </div>
                </div>
            ', 1);

		}

		$data['title'] = ucfirst("Edit Result");
		$data['result'] = $this->categoryModel->get_single_result($id);
		$data['subcategory_list'] = $this->categoryModel->get_subcategories();

	 	$prioritiesObject = $this->categoryModel->get_links_priority($this->categoryModel->get_result_parent($id));
		$priorities = array();
		foreach ($prioritiesObject as $item) {
			array_push($priorities, $item->priority);
		}

		$data['priorities'] = $priorities;
    	$this->load->view('admin_panel/pages/categories/edit_result', $data);
  }

  public function get_links_priority($fieldid) {
    $prioritiesObj = $this->categoryModel->get_links_priority($fieldid);
    // $priorities = array();
	// 	foreach ($prioritiesObj as $item) {
	// 		array_push($priorities, $item->priority);
	// 	}

    echo json_encode($prioritiesObj);
  }

  public function toggle_category($id) {
    $status = $this->categoryModel->get_single_category($id)[0]->enabled;

    if($status == 0) $status = 1;
    else $status = 0;
    $this->categoryModel->toggle_category($id, $status);

    echo json_encode($status);

  }

	public function toggle_subcategory($id) {
    $status = $this->categoryModel->get_single_subcategory($id)[0]->enabled;

    if($status == 0) $status = 1;
    else $status = 0;
    $this->categoryModel->toggle_subcategory($id, $status);

    echo json_encode($status);

  }

  public function toggle_result($id) {

    $status = $this->categoryModel->get_single_result($id)[0]->enabled;

    if($status == 0) $status = 1;
    else $status = 0;
    $this->categoryModel->toggle_result($id, $status);

    echo json_encode($status);
  }

  public function toggle_redirect($id) {

    $status = $this->categoryModel->get_single_result($id)[0]->redirect;

    if($status == 0) $status = 1;
    else $status = 0;
    $this->categoryModel->toggle_redirect($id, $status);

    echo json_encode($status);
	}

	// public function change_priority($id, $priorityO, $priorityN) {
	// 	$status = $this->categoryModel->change_priority($id, $priorityO, $priorityN);
	// }

	public function change_priority($id, $priority) {
		$status = $this->categoryModel->change_priority($id, $priority);
	}




}
